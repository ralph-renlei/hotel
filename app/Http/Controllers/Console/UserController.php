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
        $mobile = $request->input('mobile');
        $name = $request->input('name');
        $status = $request->input('status');
        $openid = $request->input('openid');
        $role = $request->input('role');
        $level = $request->input('level');
        $username = $request->input('username');
        $email = $request->input('email');

        $user = User::find($id);

        if(!empty($user)){
            $user->verify = $request->input('verify');
            $this->validate($request, [
                'mobile' => 'required|regex:/^1[2-9]\d{9}$/|unique:users,mobile,'.$user->id.'|max:11',
                'name'=>'required',
                'status'=>'in:0,1,-1'
            ]);

            $user->mobile = $mobile;
            $user->name = $name;
           if(isset($status) && in_array((int)$status,array(1,0),true)){
               $user->status = (int)$status;
           }
            $user->role = $role;
            if($user->role=='risk'){
                if(isset($level) && in_array((int)$level,array(1,2,3),true)){
                    $user->level = (int)$level;
                }
            }
            if(!empty($username)){
                $user->username = $username;
            }
            if($openid){
                $user->openid = $openid;
            }
            if(!empty($email)){
                $user->email = $email;
            }
            $response = $user->save();
        }else{
            $this->validate($request, [
                'mobile' => 'required|regex:/^1[2-9]\d{9}$/|unique:users,mobile|max:11',
                'name'=>'required',
                'status'=>'in:0,1,-1'
            ]);
            $data = array(
                'username'=>$mobile,
                'name'=>$name,
                'mobile'=>$mobile,
                'status'=>1,
            );
            $data['password'] = bcrypt(substr($mobile,5));
            $user = User::create($data);
            if($user){
                $update_flag = true;
                if($openid){
                    $user->openid = $openid;
                    $update_flag = true;
                }
				$pass = substr($user->mobile,5);
				$user->password  = bcrypt($pass);
                if($user->role=='risk'){
                    if(isset($level) && in_array((int)$level,array(1,2,3),true)){
                        $user->level = (int)$level;
                    }else{
                        $user->level = 1;
                    }
                    $update_flag = true;
                }
                if($update_flag) $user->save();
                $response = TRUE;
            }
        }

        if($response){
            return redirect('/admin/user/verify');
        }
        return redirect()->back()->withErrors(['status' => '失败']);
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