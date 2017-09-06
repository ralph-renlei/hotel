<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Controllers\Console;
use WxHotel\InviteCode;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use WxHotel\User;
use WxHotel\SmsRecord;
use WxHotel\Services\Sms;

class UserController extends Controller
{
    const DEFAULT_PWD = '123456';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $var = array();
        $list = User::orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user');
        $var['users'] = $list;
        return view('admin.user.home',$var);
    }

    public function verify(){
        $list = User::orderBy('id','desc')->paginate(20);
        return view('admin.user.verify',['users'=>$list]);
    }

    public function getImage($id){
        $images = User::where('id',$id)->first();
        $gallery_list = array();
        if(!empty($images->idcard_front)){
            $gallery_list = [$images->idcard_front,$images->idcard_back];
        }

        return view('admin.user.loadimage',['gallery_list'=>$gallery_list,'id'=>$id]);
    }

    public function saveImage(Request $request){
        $images = explode(',',trim($request->input('images'),','));
        $idcard_front = $images[0];
        $idcard_back = $images[1];
        $result = User::where('id',$request->input('id'))->update(['idcard_front'=>$idcard_front,'idcard_back'=>$idcard_back]);
        if($request){
            $return = array('code'=>1,'msg'=>self::SUCCESS_MSG);
        }
        return response()->json($return);
    }

    public function addUser(Request $request){
        return view('admin.user.add');
    }

    public function getUser($id){
        $user =  User::find($id);

        return view('admin.user.user',array('user'=>$user));
    }

    public function postUser(Request $request){
        $id = $request->input('id');
        $role = $request->input('role');
        $name = $request->input('name');
        $openid = $request->input('openid');
        $mobile = $request->input('mobile');
        $idcard_no = $request->input('idcard_no');
        $verify = $request->input('verify');

        $result = User::where('id',$id)->update(['role'=>$role,'name'=>$name,'openid'=>$openid,'mobile'=>$mobile,'idcard_no'=>$idcard_no,'verify'=>$verify]);
        if($result){
            return redirect('/admin/user/verify');
        }else{
            return redirect('/admin/user/verify');
        }
    }

    public function saveUser(Request $request){
        $role = $request->input('role');
        $openid = $request->input('openid');
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $request = User::create(['role'=>$role,'openid'=>$openid,'name'=>$name,'mobile'=>$mobile,'created_at'=>date('Y-m-d H:i:s',time())]);
        return redirect('/admin/user/verify');
    }

    public function delUser(Request $request){
        $id = $request->input('id');
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($id)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $user = User::find($id);
        $flag = $user->delete();
        if($flag){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function admin(){
        $var = array();
        $list = User::where('role','admin')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/admin');
        $var['lists'] = $list;
        return view('admin.user.admin',$var);
    }

    public function member(){
        $var = array();
        $list = User::where('role','member')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/member');
        $var['lists'] = $list;
        return view('admin.user.member',$var);
    }

    public function channel(){
        $var = array();
        $list = User::where('role','channel')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/channel');
        foreach($list as &$i){
            $invitecode = InviteCode::find($i->id);
            if($invitecode){
                $i->invitecode = $invitecode->code;
            }else{
                $code = mt_rand(100000,999999);
                $data = array(
                    'uid'=>$i->id,
                    'code'=>$code,
                );
                $invitecode = InviteCode::create($data);
                $i->invitecode = $invitecode->code;
            }
        }
        $var['lists'] = $list;
        return view('admin.user.channel',$var);
    }

    public function store(){
        $var = [];
        $list = User::where('role','store')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/store');
        $var['lists'] = $list;
        return view('admin.user.store',$var);
    }
    public function inviteCode($uid){
        $var = [];
        $user = User::find($uid);
        $var['user'] = $user;
        $list = InviteCode::where('uid',$uid)->paginate(20);
        $list->setPath('/admin/user/channel/invite/'.$uid);
        $var['lists'] = $list;
        return view('admin.user.invite_code',$var);
    }

    public function postInviteCode(Request $request){
        $uid = $request->input('uid');
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($uid)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $user = User::find($uid);
        if(!isset($user) || $user->role !='channel' || $user->status!=1){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = '用户不存在或者不是渠道';
            return response()->json($return);
        }
        $n = 20;
        while($n>0){
            $code = mt_rand(100000,999999);
            $data = array(
                'uid'=>$user->id,
                'used'=>0,
                'used_uid'=>0,
                'code'=>$code,
            );
            InviteCode::create($data);
            $n--;
        }
        $return = array('code'=>self::CODE_SUCCESS,'data'=>NULL,'msg'=>self::SUCCESS_MSG);
        return response()->json($return);
    }
    public function delInviteCode(Request $request){
        $id = $request->input('id');
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($id)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $code = InviteCode::find($id);
        $flag = $code->delete();
        if($flag){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function risk(){
        $var = array();
        $list = User::where('role','risk')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/risk');
        $var['lists'] = $list;
        return view('admin.user.risk',$var);
    }

    public function finance(){
        $var = array();
        $list = User::where('role','finance')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/finance');
        $var['lists'] = $list;
        return view('admin.user.finance',$var);
    }

    public function sale(){
        $var = array();
        $list = User::where('role','sale')->orderBy('id','DESC')->paginate(20);
        $list->setPath('/admin/user/sale');
        $var['lists'] = $list;
        return view('admin.user.sale',$var);
    }

    public function addSale(){

        return view('admin.user.addsale');
    }

    public function showSale($id){

        $var = array();
        $sale = User::where('id',$id)->where('role','sale')->first();
        $var['item'] = $sale;
        return view('admin.user.showsale',$var);
    }

    //个人账户修改
    public function account(){
        $var = array();
        $user = Auth::user();
        $var['user'] = $user;
        return view('admin.user.account',$var);
    }

    public function saveProfile(Request $request){
        $user = Auth::user();
        $email = $request->input('email');
        $mobile = $request->input('mobile');
        $username=$request->input('username');
        $name = $request->input('name');

        $this->validate($request, [
            'mobile' => 'required|regex:/^1[2-9]\d{9}$/|unique:users,mobile,'.$user->id.'|max:11',
            'email' => 'required|email',
            'username' => 'required|unique:users,name,'.$user->id.'|max:25',
            'name'=> 'max:25'
        ]);

        if(!empty($email)){
            $user->email = $email;
        }
        if(!empty($mobile)){
            $user->mobile = $mobile;
        }
        if(!empty($name)){
            $user->name = $name;
        }
        if(!empty($username)){
            $user->username = $username;
        }

        $response = $user->save();

        if($response){
            return redirect()->back()->with('status', trans($response));
        }
        return redirect()->back()->withErrors(['status' => '失败']);
    }
}