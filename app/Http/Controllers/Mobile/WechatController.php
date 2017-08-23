<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace Amor\Http\Controllers\Mobile;

use Amor\SmsRecord;
use Amor\User;
use Amor\UserAffilicate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Session;
use Amor\Services\JSSDK;

class WechatController extends MobileBaseController
{
    protected $auto_login = FALSE;

    public function __construct(Request $request){

        $this->auto_login = config('wechat.auto_login');
        $this->appid = config('wechat.app_id');
        $this->appsecret = config('wechat.secret');
        $this->token = config('wechat.token');
        $this->is_wexin = strpos($request->header('user_agent'), 'MicroMessenger') !== false;
        if($this->is_wexin){
            if(empty($this->openid)){
                $code = $request->input('code');
                if (!isset($code)){
                    //触发微信返回code码
                    $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
                    $baseUrl = urlencode($url);
                    $url = $this->__CreateOauthUrlForCode($baseUrl);
                    Header("Location: $url");
                    die();
                } else {
                    //获取code码，以获取openid
                    $openid = $this->GetOpenidFromMp($code);
                    if($openid){
                        $this->openid = $openid;
                        Session::put('openid', $openid);
                        $var['openid'] = $this->openid;
                    }
                }
            }
        }
    }

    public function channel($uid){
        if(!$this->is_weixin){
            $url = url('notlogin');
            Header('Location: '.$url);
            die();
        }
        Session::put('pid',$uid);
        $var = array('is_weixin'=>$this->is_wexin,'openid'=>NULL);
        if($this->is_wexin){
            Session::get('openid');
            $var['openid'] = $this->openid;
            $user = User::where('openid',$var['openid'])->first();
            if(isset($user) && !empty($user->mobile)){
                $url = url('user');
                Header('Location: '.$url);
                die();
            }else if(!isset($user) ){
                $JSSDK = new JSSDK(config('wechat.app_id'),config('wechat.secret'));
                $access = $JSSDK->getAccessToken();

                if(!empty($access)){
                    $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access.'&openid='.$var['openid'].'&lang=zh_CN';
                    $arrContextOptions = array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
                    $response = file_get_contents($url,false, stream_context_create($arrContextOptions));
                    if(!empty($response)){
                        $res = json_decode($response,true);
                        if(is_array($res)&& !empty($res['nickname'])){
                            $pid = Session::get('pid');

                            $data = array(
                                'pid'=>(int)$pid,
                                'openid'=>$res['openid'],
                                'nickname'=>$res['nickname'],
                                'name'=>$res['nickname'],
                                'sex'=> $res['sex'],
                                'city'=> $res['city'],
                                'province'=> $res['province'],
                                'country'=> $res['country'],
                                'avatar'=> $res['headimgurl'],
                                'status'=>1,
                                'role'=>'member'
                            );
                            $User = User::create($data);
                            if($User){
                                Session::put('uid',$User->id);
                                $var['uid'] = $User->id;
                            }
                            Session::put('nickname',$res['nickname']);
                            Session::put('openid',$res['openid']);
                        }else{
                            $url = url('notlogin');
                            Header('Location: '.$url);
                            die();
                        }
                    }else{
                        $url = url('notlogin');
                        Header('Location: '.$url);
                        die();
                    }
                }else{
                    $url = url('notlogin');
                    Header('Location: '.$url);
                    die();
                }
            }
        }else{
            $url = url('notlogin');
            Header('Location: '.$url);
            die();
        }
        $var['uid'] =  Session::get('uid');
        return view('mobile.register',$var);
    }

    public function register(Request $request){
        $var = array('is_weixin'=>$this->is_wexin,'openid'=>NULL);
        if(!$this->is_wexin){
            $url = url('notlogin');
            Header('Location: '.$url);
            die();
        }

        Session::get('openid');
        $var['openid'] = $this->openid;
        $user = User::where('openid',$this->openid)->orderBy('id','asc')->first();

        if(isset($user) && !empty($user->mobile)){
            $url = url('user');
            Header('Location: '.$url);
            die();
        }
        else if(!isset($user) ){
                $JSSDK = new JSSDK(config('wechat.app_id'),config('wechat.secret'));
                $access = $JSSDK->getAccessToken();

                if(!empty($access)){
                    $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access.'&openid='.$var['openid'].'&lang=zh_CN';
                    $arrContextOptions = array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
                    $response = file_get_contents($url,false, stream_context_create($arrContextOptions));
                    if(!empty($response)){
                        $res = json_decode($response,true);
                        if(is_array($res)&& !empty($res['nickname'])){
                            $pid = Session::get('pid');
                            $data = array(
                                'pid'=>(int)$pid,
                                'openid'=>$res['openid'],
                                'nickname'=>$res['nickname'],
                                'name'=>$res['nickname'],
                                'sex'=> $res['sex'],
                                'city'=> $res['city'],
                                'province'=> $res['province'],
                                'country'=> $res['country'],
                                'avatar'=> $res['headimgurl'],
                                'status'=>1,
                                'role'=>'member'
                            );
                            $User = User::create($data);
                            if($User){
                                Session::put('uid',$User->id);
                                $var['uid'] = $User->id;
                            }
                            Session::put('nickname',$res['nickname']);
                            Session::put('openid',$res['openid']);
                        }else{
                            $url = url('notlogin');
                            Header('Location: '.$url);
                            die();
                        }
                    }else{
                        $url = url('notlogin');
                        Header('Location: '.$url);
                        die();
                    }
                }else{
                    $url = url('notlogin');
                    Header('Location: '.$url);
                    die();
                }
        }
        $var['uid'] =  Session::get('uid');
        return view('mobile.register',$var);
    }

    public function postRegister(Request $request)
    {
        $return = array(
            'code'=>self::CODE_PARAM,
            'msg'=>self::PARAM_MSG
        );
        $code = $request->input('code');
        $mobile = $request->input('mobile');
        $openid = $request->input('openid');
        $uid = $request->input('uid');
        $pid  = Session::get('pid');
        if(!$openid){
            $openid = Session::get('openid');
        }
        if(empty($code) || empty($mobile) || empty($openid)){
            return response()->json($return);
        }

        $SmsRecord = SmsRecord::where('mobile',$mobile)->where('token',$code)->orderBy('id','desc')->first();
        if(empty($SmsRecord)){
            $return['code'] = self::CODE_FAIL;
            $return['msg'] = self::SMS_CODE_INVALID_MSG;
            return response()->json($return);
        }

        $user = NULL;
        if((int)$uid==0){
            $user = User::where('mobile',$mobile)->where('role','member')->orderBy('id','desc')->first();
            if(!empty($user)){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
                $return['data'] = $user->toArray();
                Session::put('uid',$user->uid);
                Session::put('nickname',$user->nickname);
                return response()->json($return);
            }
        }
        if(!empty($uid)){
            $user = User::find($uid);
        }else if($openid){
            $user = User::where('openid',$openid)->orderBy('id','desc')->first();
        }

        $data = array(
            'pid'=>$pid,
            'openid'=>$openid,
            'mobile'=>$mobile,
            'role'=>'member',
            'username'=>$mobile,
            'status'=>1
        );

        if(empty($user)){
            $user = User::create($data);
            if($user->pid>0){
                $affiliate = array(
                    'uid'=>$user->id,
                    'pid'=>$user->pid,
                    'level'=>1
                );
                UserAffilicate::create($affiliate);
                $parent = User::find($user->pid);
                if($parent->pid>0){
                    $parent_affiliate = array(
                        'uid'=>$user->id,
                        'pid'=>$parent->pid,
                        'level'=>2
                    );
                    UserAffilicate::create($parent_affiliate);
                }
            }
        }else{
            if($user->pid>0){
                $affiliate = array(
                    'uid'=>$user->id,
                    'pid'=>$user->pid,
                    'level'=>1
                );
                UserAffilicate::create($affiliate);
                $parent = User::find($user->pid);
                if($parent->pid>0){
                    $parent_affiliate = array(
                        'uid'=>$user->id,
                        'pid'=>$parent->pid,
                        'level'=>2
                    );
                    UserAffilicate::create($parent_affiliate);
                }
            }
            $user->username = $mobile;
            $user->mobile = $mobile;
            $user->save();
        }

        if($user){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function notLogin(){
        return view('mobile.qrcode');
    }

    public function getMobile(){
        if(!$this->is_weixin){
            $url = url('notlogin');
            Header('Location: '.$url);
            die();
        }
        $var = array();
        $user = $this->getWechatUser();
        $var['user'] = $user;
        return view('mobile.user.mobile',$var);
    }

    public function postMobile(Request $request){
        $mobile = $request->input('mobile');
        $code = $request->input('code');
        $openid = $request->input('openid');
        $uid = $request->input('uid');
        $return = array(
            'code'=>self::CODE_PARAM,
            'msg'=>self::PARAM_MSG
        );
        if(empty($uid) && empty($mobile) || empty($code) || empty($openid)){
            return response()->json($return);
        }
        $sms_record = SmsRecord::where('mobile',$mobile)->where('token',$code)->orderBy('id','desc')->first();
        if(empty($sms_record)){
            $return['code'] = self::CODE_FAIL;
            $return['msg'] = self::SMS_CODE_INVALID_MSG;
            return response()->json($return);
        }
        $user = User::find($uid);
        if(empty($user)){
            $return['code'] = self::CODE_FAIL;
            $return['msg'] = self::USER_ERROR_MSG;
            return response()->json($return);
        }
        $user->mobile = $mobile;
        $user->save();
        $return['code'] = self::CODE_SUCCESS;
        $return['msg'] = self::SUCCESS_MSG;
        $return['data'] = array('url'=>url('mobile'));
        return response()->json($return);
    }
}