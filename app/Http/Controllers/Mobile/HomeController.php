<?php namespace WxHotel\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use WxHotel\Http\Controllers\Controller;
use WxHotel\Services\JSSDK;
use WxHotel\Services\Wx;
use WxHotel\User;
use DB;

class HomeController extends Controller {
    public function index(Request $request)
    {
		if(session('wx_code')){
			
		}else{
			if($request->input('code')){
				//回调地址 携带code参数，
				$code = $request->input('code');
				//获取access_token
				$access_token = $this->getAccess_token($code);
				//获取登录授权
				$userInfo =  $this->getUserInfo($access_token);
				session(['user'=>$userInfo]);
				//将已授权表示写入session
				session(['wx_code'=>1]);
				//如果数据中没有此用户，创建这个用户
				$user = User::where('openid',$userInfo['openid'])->first();
				if(!$user){
					$uid = \DB::table('users')->insertGetId(['openid'=>$userInfo['openid'],'nickname'=>$userInfo['nickname'],'sex'=>$userInfo['sex'],'avatar'=>$userInfo['headimgurl'],'country'=>$userInfo['country'],
						'province'=>$userInfo['province'],'city'=>$userInfo['city'],'created_at'=>date('Y-m-d H:i:s',time())]);
					session(['uid'=>$uid]);
				}else{
					session(['uid'=>$user->id]);
					session(['mobile'=>trim($user->mobile,' ')]);
					session(['name'=>trim($user->name,' ')]);
					session(['verify'=>$user->verify]);
				}
			}else{
				$goods_id = session('goods_id');
				$request->session()->flush();
                session(['goods_id'=>$goods_id]);
                $this->getCode();
                return;
			}
		}

        if(session('goods_id')){
            return redirect('/goods_id?goods_id='.session('goods_id'));
        }

        return view('room.index_online');
    }

    public function getCode(){
        $appid = env('WECHAT_APPID');
        $redirect_url = urlencode('http://wxhotel.emake.cc');
        $response_type = 'code';
        $cope = 'snsapi_userinfo';
        $state = 123;
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$appid.'&redirect_uri='.$redirect_url.'&response_type='.$response_type.'&scope='.$cope.'&state='.$state.'#wechat_redirect';
        echo "<script>window.location.href='$url'</script>";
    }

    public function getAccess_token($code = NULL)
    {
        $arrContextOptions = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
		
		$appid = env('WECHAT_APPID');
		$secret = env('WECHAT_SECRET');
		$grant_type = 'authorization_code ';
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=' . $grant_type;

		$res = file_get_contents($url,false, stream_context_create($arrContextOptions));//重新获取
		$res = json_decode($res, true); // 对 JSON 格式的字符串进行编码
		$access_token = $res['access_token'];
        return $access_token;
    }

    public function getUserInfo($access_token)
    {
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=" .env('WECHAT_APPID')."&lang=zh_CN";
        $userinfo_json = $this->https_request($userinfo_url);
        $userinfo_array = json_decode($userinfo_json, TRUE);
        return $userinfo_array;
    }


    /**
     * @explain
     * 发送http请求，并返回数据
     **/
    public function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
