<?php namespace WxHotel\Http\Controllers\Mobile;

use WxHotel\Http\Requests;
use WxHotel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use WxHotel\Order;
use WxHotel\Services\Wx;
use WxHotel\Services\WxNotice;
use WxHotel\Services\WxPay;
use WxHotel\Services\Level;

use WxHotel\User;
use WxHotel\Card;
use WxHotel\Promote;
use WxHotel\UsersOrder;
use WxHotel\Vip;
use WxHotel\Consume;
use WxHotel\Config;
use WxHotel\Money;


class WxpayController extends Controller {
    public function unifiedorder(){
        $result = new WxPay(env('WECHAT_APPID'),env('WECHAT_SECRET'),'MD5');
        return $result;
    }

    public function prepay(Request $request){
        $result = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );
        $uid = $request->input('uid');
        $openid = $request->input('openid');

        if(empty($uid)||empty($openid)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = self::PARAM_MSG;
            return response()->json($result);
        }

        $User = User::find($uid);
        if(empty($User) || (int)$User->status==0){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '您的账户不存在或者已经禁用';
            $result['data'] = array('url'=>url('register'));
            return response()->json($result);
        }

        if(empty($User->mobile)){
            $result = array(
                'code'=>self::CODE_PARAM,
                'msg'=>'您还未绑定手机号码',
                'data'=> array('url'=>url('register'))
            );
            return response()->json($result);
        }

        $config=array(
            'appid'=>env('WECHAT_APPID'),
            'mch_id'=>env('WXPAY_MCHID'),
            'device_info'=>'WEB',
            'nonce_str'=>'',
            'sign'=>'',
            'sign_type'=>'MD5',
            'body'=>$request->input('category_name'),//商品描述
            'out_trade_no'=>session('order_sn'),//商品订单号
            'fee_type'=>'CNY',
//            'total_fee'=>$request->input('order_amount'),//订单总金额
            'total_fee'=>0.01,//订单总金额
            'ip'=>'182.92.193.55',
            'time_start'=>date("YmdHis"),
            'time_expire'=>date("YmdHis")+600,
            'goods_tag'=>'WXG',
            'notify_url'=>url('/notify'),
            'trade_type'=>'JSAPI',
            'product_id'=>$request->input('goods_id'),//商品id
            'openid'=>$openid,
            'key'=>env('WXPAY_KEY')
        );

        $WxPay = new WxPay(env('WECHAT_APPID'),env('WECHAT_SECRET'),$config);
        $return['result'] = $WxPay->unifiedOrder();

        if(!empty($return['result']['return_code'])){
            if($return['result']['result_code'] == 'SUCCESS'
                && $return['result']['return_code'] == 'SUCCESS'){
                $params=array(
                    'appId'=>env('WECHAT_APPID'),
                    'timeStamp'=>date("YmdHis"),
                    'nonceStr'=>$WxPay->createNonceStr(),
                    'package'=>'prepay_id='.$return['result']['prepay_id'],
                    'signType'=>'MD5'
                );
                $data=array(
                    'appId'=>$params['appId'],
                    'timeStamp'=>$params['timeStamp'],
                    'nonceStr'=>$params['nonceStr'],
                    'package'=>$params['package'],
                    'signType'=>$params['signType'],
                    'paySign'=>$WxPay->makeSign($params,env('WXPAY_KEY')),
                );
                $result['code'] = self::CODE_SUCCESS;
                $result['msg'] = self::SUCCESS_MSG;
                $result['data'] = $data;
            }
        }else{
            $result['code'] = self::CODE_PARAM;
        }
        return response()->json($result);
    }

    public function refund(Request $request){
        $result = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );

        $order = Order::where('order_id',$request->input('id'))->first();//查询订单
        //将部分信息写入数据库
        $orders_refund_id = \DB::table('orders_refund')->insertGetId(['uid'=>$order->uid,'out_refund_no'=>$order->order_sn,'mch_id'=>env('WXPAY_MCHID'),'order_id'=>$request->input('id'),'transaction_id'=>$order->transaction_id,
            'total_fee'=>1,'refund_fee'=>1]);
        $refund=array(
            'appid'=>env('WECHAT_APPID'),//应用ID，固定
            'mch_id'=>env('WXPAY_MCHID'),//商户号，固定
            'nonce_str'=>'4C2HkiPZwfgho4Pp',//随机字符串
            'out_refund_no'=>$order->order_sn,//商户内部唯一退款单号
            'out_trade_no'=>$order->order_sn,//商户订单号,pay_sn码 1.1二选一,微信生成的订单号，在支付通知中有返回
            // 'transaction_id'=>'4008582001201708309122927539',//微信订单号 1.2二选一,商户侧传给微信的订单号
            'refund_fee'=>$request->input('refund_fee'),//退款金额
            'total_fee'=>$order->amount,//总金额
        );
        ksort($refund);
        $str = '';
        foreach($refund as $key=>$val){
            $str =  $str.'&'.$key.'='.$val;
        }

        $str = trim($str.'&key='.env('WXPAY_KEY'),'&');
        $sign = strtoupper(md5($str));
        $refund['sign'] = $sign;

        $url="https://api.mch.weixin.qq.com/secapi/pay/refund";//微信退款地址，post请求
        $xml=$this->arrayToXml($refund);

        $ch = curl_init();
        $header[] = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT,storage_path().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');//cert
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, storage_path().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');//key
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch, CURLOPT_CAINFO, storage_path().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'rootca.pem');//rootca

        $data=curl_exec($ch);
        if($data){ //返回来的是xml格式需要转换成数组再提取值，用来做更新
            curl_close($ch);
            $data = $this->fromXml($data);
            if(!empty($data['return_code'])){//如果 成功
                if($data['result_code'] == 'SUCCESS'){
                    //将另一部分信息写入数据库
                    $flag = \DB::table('orders_refund')->where('id',$orders_refund_id)->update(['refund_id'=>$data['refund_id']]);
                    if($flag){
                        $this->refundquery($request->input('id'));
                    }
                    $result['code'] = self::CODE_SUCCESS;
                    $result['msg'] = self::SUCCESS_MSG;
                }
            }else{
                $result['code'] = self::CODE_PARAM;
            }
        }else{
            $error=curl_errno($ch);
            curl_close($ch);
            echo "<script>alert('请求失败，请重试');window.history.back();</script>";
            return;
        }
    }

    public function refundquery(Request $request)
    {
        $result = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );

        $order = Order::where('order_id',$request->input('id'))->first();//查询订单
        $orders_refund = \DB::table('orders_refund')->where('order_id',$request->input('id'))->first();
        if(!$orders_refund->refund_id){
            //该笔退款没有成功
            $result = array(
                'code'=>self::CODE_FAIL,
                'msg'=>'该笔退款没有成功',
            );
        }
        //将部分信息写入数据库
        $refund=array(
            'appid'=>env('WECHAT_APPID'),//应用ID，固定
            'mch_id'=>env('WXPAY_MCHID'),//商户号，固定
            'nonce_str'=>'4C2HkiPZwfgho4Pp',//随机字符串
            'transaction_id'=>$order->transaction_id,
            'out_trade_no'=>$order->order_sn,
            'refund_id'=>$orders_refund->refund_id,
        );
        ksort($refund);
        $str = '';
        foreach($refund as $key=>$val){
            $str =  $str.'&'.$key.'='.$val;
        }

        $str = trim($str.'&key='.env('WXPAY_KEY'),'&');
        $sign = strtoupper(md5($str));
        $refund['sign'] = $sign;

        $url="https://api.mch.weixin.qq.com/pay/refundquery";//微信退款地址，post请求
        $xml=$this->arrayToXml($refund);

        $ch = curl_init();
        $header[] = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT,storage_path().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');//cert
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, storage_path().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');//key
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch, CURLOPT_CAINFO, storage_path().DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'rootca.pem');//rootca

        $data=curl_exec($ch);
        if($data){ //返回来的是xml格式需要转换成数组再提取值，用来做更新
            curl_close($ch);
            $data = $this->fromXml($data);
            if(!empty($data['return_code'])){//如果 成功
                if($data['result_code'] == 'SUCCESS'){
                    //将另一部分信息写入数据库
                    \DB::table('orders_refund')->where('id',$orders_refund->id)->update(['refund_count'=>$data['refund_count'],'refund_channel'=>$data['refund_channel_0'],
                        'refund_account'=>$data['refund_account_0'],'refund_recv_account'=>$data['refund_recv_accout_0'],'refund_success_time'=>$data['refund_success_time_0']]);
                    $result['code'] = self::CODE_SUCCESS;
                    $result['msg'] = self::SUCCESS_MSG;
                }
            }else{
                $result['code'] = self::CODE_PARAM;
            }
        }else{
            $error=curl_errno($ch);
            curl_close($ch);
            echo "<script>alert('请求失败，请重试');window.history.back();</script>";
            return;
        }
    }

    public function notify(Request $request,$id){
        $result = array();
        $config = array(
            'appid'=>env('WECHAT_APPID'),
            'mch_id'=>env('WXPAY_MCHID'),
            'key'=>env('WXPAY_KEY'),
            'sign_type'=>'MD5',
            'trade_type'=>'JSAPI',
            'ip'=>'182.92.193.55',
            'notify_url'=>url('notify'),
        );
        $appid = env('WECHAT_APPID');
        $secret = env('WECHAT_SECRET');
        $WxPay = new WxPay($appid,$secret,$config);
        $result = array();
        $return = $WxPay->notify($result);

        file_put_contents(storage_path('app/order_'.time().'.txt'),json_encode($result));

        if($result['return_code']=='SUCCESS' ){
            $out_trade_no = $result['out_trade_no'];//订单号
            $money_paid = $result['total_fee'];//付款金额
            $order = Order::where('order_sn',$out_trade_no)->first();

            if(isset($order) && $order->pay_status == 0){
                if($result['result_code']=='SUCCESS'){
                    Order::where('order_sn',$order->order_sn)->update(['order_amount'=>$money_paid/100,'pay_status'=>1,'transaction_id'=>$result['transaction_id']]);
                }
            }
            $xml_array = array(
                'return_code'=> $return['return_code'],
                'return_msg'=>$return['return_msg']
            );
            $xml = $WxPay->toXml($xml_array);
            $WxPay->replyNotify($xml);
        }
    }

    public function pay_success(){
        $order = Order::where('order_sn',session('order_sn'))->first();
        //订单中有 goods_id 同意 没有分配房间(給管理员发送的模板消息 要跳转的页面)
        if(!$order->goods_id){
            $url = url('/mobile_room?category_id='.$order->category_id.'&order_sn='.$order->order_sn.'&openid='.$order->openid);
        }else{
            $url = url('/mobile_allow?goods_id='.$order->goods_id.'&order_sn='.$order->order_sn.'&openid='.$order->openid);
        }

        //查询这个用户是否实名认证，如果未实名认证，弹窗通知，跳转到认证页面
        $user = User::where('openid',session('user')['openid'])->first();
        if($user->verify == 0){
            $verify = 0;
        }else{
            $verify = 1;
        }

        $wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
        $result = $wx->order_sure(session('user')['openid'],session('order_sn'),$order->start);//給预订者发送模板消息
        $managers = User::where('role','admin')->lists('openid');//查询管理员
        foreach($managers as $openid){
            $wx->room_to_manager($openid,$order->username,$order->order_amount,$order->category_name,$order->goods_name,$order->start,$order->end,$url);//给管理者发送信息
        }

        return view('room.pay_success',['list'=>$order,'verify'=>$verify]);
    }

    public function pay_error(){
        $order = Order::where('order_sn',session('order_sn'))->first();
        return view('room.pay_fail',['list'=>$order]);
    }

    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key=>$val){
            if(is_array($val)){
                $xml.="<".$key.">".arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml ;
    }

    public function fromXml($xml)
    {
        if(!$xml){
            return false;
        }
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

}
