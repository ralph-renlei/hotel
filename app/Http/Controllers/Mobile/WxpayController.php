<?php namespace WxHotel\Http\Controllers\Mobile;

use WxHotel\Http\Requests;
use WxHotel\Http\Controllers\Controller;
use Illuminate\Http\Request;
use WxHotel\Services\Wx;
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
//            'appid'=>env('WECHAT_APPID'),
//            'mch_id'=>env('WXPAY_MCHID'),
//            'device_info'=>'WEB',
//            'nonce_str'=>'',
//            'sign'=>'',
//            'sign_type'=>'MD5',
//            'out_trade_no'=>date("YmdHis").mt_rand(1000,9999),
//            'fee_type'=>'CNY',
//            'ip'=>'182.92.193.55',
//            'time_start'=>date("YmdHis"),
//            'time_expire'=>date("YmdHis")+600,
//            'goods_tag'=>'WXG',
//            'notify_url'=>url('notify'),
//            'trade_type'=>'JSAPI',
//            'openid'=>$openid,
//            'product_id'=>18973,
//            'key'=>env('WXPAY_KEY')
            'appid'=>env('WECHAT_APPID'),
            'mch_id'=>env('WXPAY_MCHID'),
            'device_info'=>'WEB',
            'nonce_str'=>'',
            'sign'=>'',
            'sign_type'=>'MD5',
            'body'=>$request->input('category_name'),//商品描述
            'out_trade_no'=>date("YmdHis").mt_rand(1000,9999),//商品订单号
            'fee_type'=>'CNY',
            'total_fee'=>100*$request->input('order_amount'),//订单总金额 * 100
            'ip'=>'182.92.193.55',
            'time_start'=>date("YmdHis"),
            'time_expire'=>date("YmdHis")+600,
            'goods_tag'=>'WXG',
            'notify_url'=>url('notify'),
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
//                $order = array(
//                    'out_trade_no'=>$config['out_trade_no'],
//                    'order_status'=>0,
//                    'pay_status'=>0,
//                    'uid'=>$User->id,
//                    'uname'=>$User->nickname,
//                    'mobile'=>$User->mobile,
//                    'add_time'=>time(),
//                );
//                $Order =  UsersOrder::create($order);
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
                    'paySign'=>$WxPay->makeSign($params,env('WXPAY_KEY'))
                );
                $result['order_id']= 8;
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

        file_put_contents(storage_path('app/order_'.time().'.txt'),json_encode($result));

        if($result['return_code']=='SUCCESS' ){
            $out_trade_no = $result['out_trade_no'];
            $money_paid = $result['total_fee'];
            $order = UsersOrder::where('out_trade_no',$out_trade_no)->first();

            if(isset($order) && $order->order_status == 0){

                    if($result['result_code']=='SUCCESS'){
                        $order->money_paid = $money_paid/100;
                        $order->pay_status = 1;
                        $order->pay_time = time();
                    }
                    if(isset($result['transaction_id'])){
                        $order->transaction_id = $result['transaction_id'];
                    }
                    $order->order_status = 1;
                    $order->save();

                    if($result['result_code']=='SUCCESS'){
                        $user = User::find($order->uid);
                        $card = Card::find($order->card_id);
                        $Vip = new Vip();
                        $vip = $Vip->startVip($card,$user);
                        if($vip->status==1){
                            $affiliate_total = User::where('pid',$user->id)->count();
                            $months_total = UsersOrder::where('pay_status',1)->where('uid',$user->id)->sum('months');
                            $consume_total = Consume::where('uid',$user->id)->where('status',1)->count();
                            if($consume_total && $months_total && $affiliate_total){
                                $user->point = $affiliate_total*$months_total+$consume_total;
                            }else if( $months_total && $affiliate_total){
                                $user->point = $affiliate_total*$months_total;
                            }else if($consume_total){
                                $user->point = $consume_total;
                            }
                            $user->level = Level::getLevel($user->point);
                            $user->vip = 1;
                            $user->save();
                            //
                            if($user->pid){
                                $parent = User::find($user->pid);
                                $affiliate1 = Config::find('affiliate1');
                                $affiliate2 = Config::find('affiliate2');
                                $grand_parent = NULL;
                                if($parent->pid>0){
                                    $grand_parent = User::find($parent->pid);
                                }

                                if($parent->role == 'sale'){
                                    $money = $order->money_paid*($affiliate1->val/100);
                                    $parent->reward += $money;
                                    $parent->save();
                                    $data = array(
                                        'uid'=>$parent->id,
                                        'uname'=>$parent->nickname,
                                        'money'=>$money,
                                        'type'=>1,
                                        'cate'=>0,
                                        'note'=>'affiliate1'
                                    );
                                    Money::create($data);
                                    if($grand_parent && $grand_parent->role=='sale'){
                                        $money2 = $money*($affiliate2->val/100);
                                        $grand_parent->reward += $money2;
                                        $grand_parent->save();
                                        $data = array(
                                            'uid'=>$grand_parent->id,
                                            'uname'=>$grand_parent->nickname,
                                            'money'=>$money2,
                                            'type'=>1,
                                            'cate'=>0,
                                            'note'=>'affiliate2'
                                        );
                                        Money::create($data);
                                    }

                                }elseif($parent->role == 'member'){
                                    $money = $order->money_paid*($affiliate2->val/100);
                                    $parent->reward += $money;
                                    $parent->save();

                                    $data = array(
                                        'uid'=>$parent->id,
                                        'uname'=>$parent->nickname,
                                        'money'=>$money,
                                        'type'=>1,
                                        'cate'=>0,
                                        'note'=>'affiliate2'
                                    );
                                    Money::create($data);
                                    if($grand_parent && $grand_parent->role=='sale'){
                                        $money2 = $money*($affiliate2->val/100);
                                        $grand_parent->reward += $money2;
                                        $grand_parent->save();
                                        $data = array(
                                            'uid'=>$grand_parent->id,
                                            'uname'=>$grand_parent->nickname,
                                            'money'=>$money2,
                                            'type'=>1,
                                            'cate'=>0,
                                            'note'=>'affiliate2'
                                        );
                                        Money::create($data);
                                    }
                                }
                            }
                        }
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
}
