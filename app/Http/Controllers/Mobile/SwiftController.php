<?php namespace Amor\Http\Controllers\Mobile;

use Amor\Card;
use Amor\Config;
use Amor\Http\Requests;
use Amor\LoanRecord;
use Amor\RefundRecord;
use Amor\Promote;
use Amor\User;
use Amor\UsersOrder;
use Amor\Loan;
use Illuminate\Http\Request;
use Amor\Services\Swiftpass;
use Amor\Services\Utils;
use Amor\Services\LevelBonus;
use Amor\Services\Level;
use Amor\Services\Affiliate;
use Amor\Vip;
use Amor\Point;
use Amor\UserAffilicate;
use Amor\Consume;
use Amor\Money;
use Illuminate\Support\Facades\Session;

class SwiftController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function notify()
	{
		//
        $Swiftpass = new Swiftpass();
        $xml = file_get_contents('php://input');
        $key = env('SWIFTPASS_KEY');
        $Swiftpass->resHandler->setContent($xml);
        $Swiftpass->resHandler->setKey($key);
        if($Swiftpass->resHandler->isTenpaySign()){
            if($Swiftpass->resHandler->getParameter('status') == 0 && $Swiftpass->resHandler->getParameter('result_code') == 0){
                $out_trade_no = $Swiftpass->resHandler->getParameter('out_trade_no');
                $transaction_id = $Swiftpass->resHandler->getParameter('transaction_id');
                $money_paid = $Swiftpass->resHandler->getParameter('total_fee');
                $openid = $Swiftpass->resHandler->getParameter('openid');
                $pay_result = $Swiftpass->resHandler->getParameter('pay_result');
                $pay_status  = 0;
                $order = UsersOrder::where('out_trade_no',$out_trade_no)->first();
                if(isset($order) && $order->pay_status == 0){
                    if($pay_result==0){
                        $pay_status = 1;
                    }
                    if($pay_status==1){
                        $order->money_paid = $money_paid/100;
                        $order->pay_status = $pay_status;
                        $order->order_status = 1;
                        $order->transaction_id = $transaction_id;
                        $order->openid = $openid;
                        $order->pay_time = date("YmdHis");
                        $order->save();
                        $user = User::find($order->uid);
                        $data = array(
                            'uid'=> $user->id,
                            'channel_id'=>$user->pid,
                            'title'=>'充值-提前还款',
                            'money'=>$order->money_paid,
                            'uname'=>$user->name,
                            'type'=>1,
                            'cate'=>1,
                            'note'=>'充值-提前还款'
                        );
                        if($order->froms=='fee'){//手续费
                            $userLoanId=$order->card_name;
                            $loanRecord=LoanRecord::where('id',$userLoanId)->first();
                            $loanRecord->poundaged_at=date("YmdHis");
                            $loanRecord->save();
                            $data['title']='充值-手续费';
                            $data['note']='充值-手续费';
                            Money::create($data);
                            $data['title']='扣除-手续费';
                            $data['note']='扣除-手续费';
                            $data['type']=0;
                            $data['cate']=2;
                            Money::create($data);
                        }
                        else if($order->from=='refund'){//提前还款
                            $refundIds=$order->card_name;
                            $refundIds = explode('|',$refundIds);
                            foreach($refundIds as $id){
                               $refund=RefundRecord::where('id',$id)->first();
                                $refund->status=1;
                                $refund->is_overdue=0;
                                $refund->overdue=0;
                                $refund->note='已通过微信支付提前还款';
                                $refund->refund_at=date("YmdHis");
                                $refund->save();
                            }
                            $data['title']='充值-提前还款';
                            $data['note']='充值-提前还款';
                            Money::create($data);
                            $data['title']='扣除-提前还款';
                            $data['note']='扣除-提前还款';
                            $data['type']=0;
                            $data['cate']=2;
                            Money::create($data);
                            //渠道奖励
                            $channel=User::where('id',$user->pid)->first();
                            $config=Config::where('code','reward')->where('type','channel')->first();
                            if(!empty($channel)){
                                $channel->money+=round(($config->val)*($order->money_paid),2);
                                $channel->save();
                                $data['uid']=$channel->id;
                                $data['channel_id']=$channel->pid;
                                $data['title']='奖励-下级提前还款';
                                $data['money']=$order->money_paid;
                                $data['uname']=$channel->name;
                                $data['type']=1;
                                $data['cate']=0;
                                $data['note']='奖励-下级'.$user->name.'提前还款';
                                Money::create($data);
                            }
                        }
                        else{//充值
                            $user->money+=$order->money_paid;
                            $user->save();
                            $data['title']='充值-微信支付';
                            $data['note']='充值-微信支付';
                            Money::create($data);
                        }
                    }
                    echo 'success';
                }else{
                    echo 'failure';
                }
            }else{
                echo 'failure';
            }
        }else{
            echo 'failure';
        }
        die();

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function pay(Request $request)
	{
        $return = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );
        $uid=Session::get('uid');
        $money=$request->input('money');
        $type=$request->input('type');
        $orderid=null;
        $loan=null;
        $orderid=$request->input('order_id');
        if(!empty($orderid)){
            $loan=Loan::where('order_id',$orderid)->first();
            $money=($loan->loan_money)*($loan->loan_fee);
        }
        $refundIds=null;
        $refundIds=$request->input('ids');
        if(count($refundIds)>0){
            foreach($refundIds as $id){
                $refund=RefundRecord::where('id',$id)->first();
                $money+=$refund->money;
            }
        }
        $User = User::find($uid);
        $openid=$User->openid;
        if(empty($User) || (int)$User->status==0){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = '您的账户不存在或者已经禁用';
            $return['data'] = array('url'=>url('register'));
            return response()->json($return);
        }
        if(empty($User->mobile)){
            $return = array(
                'code'=>self::CODE_PARAM,
                'msg'=>'您还未绑定手机号码',
                'data'=> array('url'=>url('register'))
            );
            return response()->json($return);
        }
        $notify = url('notify');
        $callback = url('recharged');
        $Swiftpass = new Swiftpass($notify,$callback);
        $out_trade_no = 'wx'.date('YmdHis');
        $param = array(
            'out_trade_no'=>$out_trade_no,
            'sub_openid'=>$openid,
            'body'=>'充值-微信支付',
            'total_fee'=>$money*100,
            'mch_create_ip'=>'182.92.193.55'
        );
        if($type=='fee'){
            $param['body']='充值-手续费';
        }
        if($type=='refund'){
            $param['body']='充值-提前还款';
        }
        $res = $Swiftpass->submitOrderInfo($param);
        if($res['status']==200){
            $order = array(
                'openid'=>$openid,
                'out_trade_no'=>$out_trade_no,
                'order_status'=>0,
                'pay_status'=>0,
                'uid'=>$User->id,
                'uname'=>$User->name,
                'mobile'=>$User->mobile,
                'pay_fee'=>$money,
                'money_paid'=>$money,
                 'add_time'=>date("YmdHis"),
                'affiliate'=>1,
                'froms'=>'charge',
                'channel_id'=>$User->pid
            );
            if($type=='fee'){//交手续费
                $order['card_name']=$loan->order_id;
                $order['froms']='fee';
            }
            if($type=='refund'){//充值-提前还款
                $order['card_name']=implode('|',$refundIds);
                $order['froms']='refund';
            }
            unset($order['channel_id']);
            $order=UsersOrder::create($order);
            if($order){
                $return['code'] = 1;
                $return['data'] = $res;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }else{
            $return['msg'] = $res['msg'];
        }
        return response()->json($return);
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

}