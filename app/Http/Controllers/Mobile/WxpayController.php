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

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

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

    public function notify(Request $request){
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

//        file_put_contents(storage_path('app/order_'.time().'.txt'),json_encode($result));

        if($result['return_code']=='SUCCESS' ){
            $out_trade_no = $result['out_trade_no'];//订单号
            $money_paid = $result['total_fee'];//付款金额
            $order = Order::where('order_sn',$out_trade_no)->first();

            if(isset($order) && $order->pay_status == 0){

                    if($result['result_code']=='SUCCESS'){
                        Order::where('order_sn',$order->order_sn)->update(['order_amount'=>$money_paid/100,'pay_status'=>1]);
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
        if(!empty($order->goods_id)){
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
        $result = $wx->book_success(session('user')['openid'],session('order_sn'),$order->start,$order->order_amount,'');//給预订者发送模板消息
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
}
