<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Cash;
use WxHotel\Config;
use WxHotel\Http\Requests;

use WxHotel\Loan;
use WxHotel\LoanRecord;
use WxHotel\Money;
use WxHotel\RefundRecord;
use WxHotel\Services\LoanTool;
use WxHotel\User;
use WxHotel\UsersOrder;
use Illuminate\Http\Request;

class FundController extends Controller {

	const LIMIT = 20;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		//

		$var = array();
		$keyword = $request->input('keyword');

		return view('admin.fund.home',$var);
	}

    public function getCash(Request $request){
        $var = array();
        $list = Cash::orderBy('id','desc')->paginate(20);
        $list->setPath('/admin/fund/cash');
        $var['lists'] = $list;
        return view('admin.fund.cash',$var);
    }

    public function getCashItem($id){
        $var = array();
        $cash = Cash::find($id);

        $var['item'] = $cash;

        if(!empty($cash->images)){
            $gallery_list = explode('|',$cash->images);
            $var['gallery_list'] = $gallery_list;
        }

        return view('admin.fund.cash_item',$var);
    }

    public function postCash(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        $note = $request->input('note');

        if(!isset($id) || !isset($status)){
            return redirect()->back()->withErrors(array('error'=>'参数异常'));
        }

        if($status==-1){
            if(empty($note)){
                return redirect()->back()->withErrors(array('error'=>'请输入驳回原因'));
            }
        }

        $cash = Cash::find($id);
        if(empty($cash)){
            return redirect()->back()->withErrors(array('error'=>'找不到提现记录'));
        }
        $user = User::find($cash->uid);
        if(empty($user)){
            return redirect()->back()->withErrors(array('error'=>'申请者不存在'));
        }


        if($status == 1){
            if((int)$cash->money ==0 || $user->money < $cash->money){
                $cash->status = -1;
                $cash->note = '返现金额不足';
                $cash->save();
                return redirect()->back()->withErrors(array('error'=>'用户返现金额不足，已驳回'));
            }
            $gallery = $request->input('new_gallery');
            $way = $request->input('way');
            if(in_array($way,array(1,2,3),TRUE)){
                return redirect()->back()->withErrors(array('error'=>'付款方式不正确'));
            }
            if((int)$way==3 && empty($gallery)){
                return redirect()->back()->withErrors(array('error'=>'付款凭证不能为空'));
            }
            $cash->way = $way;
            if($way==3){
                $cash->images = join('|',$gallery);
            }
        }

        $cash->status = $status;
        $cash->save();

        if( $cash->status ==1){
            $user->money = $user->money - $cash->money;
            $user->save();
            $record = [
                'title'=>'账户提现',
                'money'=>$cash->money,
                'type'=>0,
                'cate'=>3,
                'uid'=>$user->id,
                'uname'=>$cash->uname,
                'note'=>$cash->uname.'提现'.$cash->money,
            ];
            Money::create($record);
        }
        $url = url('admin/fund/cash');
        return redirect($url);
    }

    public function getFee(Request $request){
        $var = array();
        $keyword = $request->input('keyword');
        if(!empty($keyword)){
            $list = LoanRecord::where('mobile',$keyword)->orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/fee?keyword='.$keyword);
        }else{
            $list = LoanRecord::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/fee');
        }
        $var['lists'] = $list;
        return view('admin.fund.fees',$var);
    }

    public function postFee(Request $request){
        $result = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );

        $id = $request->input('id');
        if(!isset($id)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = self::PARAM_MSG;
            return response()->json($result);
        }
        $loan_record = LoanRecord::find($id);
        if(empty($loan_record)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '贷款记录不存在';
            return response()->json($result);
        }

        if($loan_record->poundage==1){
            $result['msg'] = '手续费已缴';
            return response()->json($result);
        }

        $user = User::find($loan_record->uid);
        if($user->money < $loan_record->fee_money){
            $result['msg'] = '账户余额不足';
            return response()->json($result);
        }

        $user->money = $user->money - $loan_record->fee_money;
        $user->save();
        $loan_record->poundage = 1;
        $loan_record->poundaged_at = date('Y-m-d H:i:s',time());
        $loan_record->save();

        $out_data = array(
            'title'=>'缴手续费',
            'uid'=>$user->id,
            'uname'=>$user->name,
            'money'=>$loan_record->fee_money,
            'type'=>0,
            'cate'=>2
        );
        Money::create($out_data);
        $result['code'] = self::CODE_SUCCESS;
        $result['msg'] = self::SUCCESS_MSG;
        return response()->json($result);
    }

    public function getLoan(Request $request){
        $var = array();
        $keyword = $request->input('keyword');
        if(!empty($keyword)){
            $list = LoanRecord::where('mobile',$keyword)->orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/loan?keyword='.$keyword);
        }else{
            $list = LoanRecord::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/loan');
        }
        $var['lists'] = $list;
        return view('admin.fund.loans',$var);
    }

    public function getRefund(Request $request){
        $var = array();
        $keyword = $request->input('keyword');
        if(!empty($keyword)){
            $list = RefundRecord::where('mobile',$keyword)->orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/refund?keyword='.$keyword);
        }else{
            $list = RefundRecord::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/refund');
        }
        $var['lists'] = $list;
        return view('admin.fund.refunds',$var);
    }

    public function postRefund(Request $request){
        $id = $request->input('id');
        $result = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );


        if(empty($id)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = self::PARAM_MSG;
            return response()->json($result);
        }

        $refund = RefundRecord::find($id);
        if(!isset($refund)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '还款记录不存在';
            return response()->json($result);
        }

        if((int)$refund->status==1){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '已还款';
            return response()->json($result);
        }
        $Loan = Loan::find($refund->loans_id);
        if(!isset($Loan)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '贷款记录不存在';
            return response()->json($result);
        }

        $LoanTool = new LoanTool($Loan->loan_rate,$Loan->loan_fee,$Loan->loan_num,$Loan->loan_money);
        if(!$LoanTool->checkRefundDay()){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '还款日未到';
            return response()->json($result);
        }

        $user = User::find($refund->uid);
        if(!isset($user)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '用户不存在';
            return response()->json($result);
        }
        if($user->money < $refund->money){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '用户余额不足';
            return response()->json($result);
        }

        $date = date('Ymd');

        if( $date > $refund->refund_date ){
            $day = (strtotime($date)-strtotime($refund->refund_date) )/24*3600;
            $days = ceil($day);
            $overdue = $days*0.005*$refund->capital;
            if($days>7){
                $user->level = -1;
                $user->points = 0;
            }

            $refund->overdue = $overdue;

            if($user->money < ($refund->money + $overdue) ){
                $user->save();
                $refund->status = -1;
                $refund->save();
                $result['code'] = self::CODE_PARAM;
                $result['msg'] = '有逾期，用户余额不足';
                return response()->json($result);
            }else{
                $refund->is_overdue = 1;
            }
            $cash = $refund->money + $overdue;
            $user->money = $user->money - $cash;
            $user->save();
            $refund->status = 1;
            $refund->save();

            $out_data = array(
                'title'=>$refund->num.'还款有逾期',
                'money'=>$cash,
                'uid'=>$user->id,
                'uname'=>$user->name,
                'type'=>0,
                'cate'=>2
            );
            Money::create($out_data);

        }else{
            $cash = $user->money -$refund->money;
            $user->money = $cash;
            $user->save();
            $refund->status = 1;
            $refund->save();

            $out_data = array(
                'title'=>$refund->num.'还款',
                'money'=>$cash,
                'uid'=>$user->id,
                'uname'=>$user->name,
                'type'=>0,
                'cate'=>2
            );
            Money::create($out_data);
            if($user->pid>0){
                $channel = User::find($user->pid);
                $config = Config::find('reward');
                if(isset($config) && isset($config->val)){
                    $reward = round($config->val*$cash, 2);
                    $in_data = array(
                        'title'=>$refund->num.'还款奖励',
                        'money'=>$reward,
                        'uid'=>$channel->id,
                        'uname'=>$channel->name,
                        'type'=>1,
                        'cate'=>0
                    );
                    Money::create($in_data);
                }
            }
        }
        $result['code'] = self::CODE_SUCCESS;
        $result['msg'] = self::SUCCESS_MSG;
        return response()->json($result);
    }

    public function getUser(Request $request){
        $var = array();
        $list = User::where('role','member')->orWhere('role','channel')->orderBy('id','desc')->paginate(20);
        $list->setPath('/fund/user');
        $var['lists'] = $list;

        return view('admin.fund.users',$var);
    }

    public function getMoney(Request $request){
        $var = array();
        $keyword = $request->input('keyword');
        if(!empty($keyword)){
            $list = Money::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/money?keyword='.$keyword);
        }else{
            $list = Money::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/fund/money');
        }
        $var['lists'] = $list;
        $var['keyword'] = $keyword;

        return view('admin.fund.money',$var);
    }

    public function getUserMoney($id){
        $var = array();
        $user_money = Money::where('uid',$id)->orderBy('id','desc')->paginate(20);
        $user = User::find($id);
        $user_money->setPath('/admin/fund/money/'.$id);
        $var['lists'] = $user_money;
        $var['user'] = $user;
        return view('admin.fund.user_money',$var);
    }
    public function getCharge(Request $request){
        $var = array();
        $list = UsersOrder::orderBy('order_id','desc')->paginate(20);
        $list->setPath('admin/fund/charge');
        $var['lists'] = $list;
        return view('admin.fund.charges',$var);
    }

    public function delCharge(Request $request){
        $var = array();
        $id = $request->input('id');
        $user_order = UsersOrder::find('id');
        $result = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );
        if(empty($id)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = self::PARAM_MSG;
            return response()->json($result);
        }
        if(empty($user_order)){
            $result['code'] = self::CODE_PARAM;
            $result['msg'] = '订单不存在';
            return response()->json($result);
        }
        $flag = $user_order->delete();
        if($flag){
            $result['code'] = self::CODE_SUCCESS;
            $result['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($result);
    }

    public function postCharge(Request $request){
        $id = $request->input('id');
        $pay_status = $request->input('pay_status');
        $trade_status = $request->input('trade_status');
        if(empty($id) || !isset($pay_status) || !isset($trade_status)){
            return redirect()->back()->withErrors(['error' => '参数异常']);
        }
        $order = UsersOrder::find($id);
        if(empty($order)){
            return redirect()->back()->withErrors(['error'=>'订单不存在']);
        }
        if(!in_array(
            (int)$pay_status,array(0,1),true
        )){
            return redirect()->back()->withErrors(['error' => '支付状态非法']);
        }
        if(!in_array((int)$trade_status,array(0,1,2),true)){
            return redirect()->back()->withErrors(['error' => '状态非法']);
        }
        $data = [
          'pay_status'=>(int)$pay_status, 'order_status'=>(int)$trade_status,
        ];
        if($data['pay_status'] == 1){
            $data['pay_time'] = time();
            $data['money_paid'] = $order->pay_fee;
        }

        if($data['order_status']== 2){
            $data['confirm_time'] = time();
        }
        $order->where(array('id'=>$id))->update($data);
        return redirect(url('admin/fund/charge'));
    }

    public function chargeItem($id){
        $var = array();
        $order = UsersOrder::find($id);
        $var['order'] = $order;
        return view('admin.fund.charge_item',$var);
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('admin.card.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//


		return redirect()->back()->withErrors(array('error'=>'发布失败'));
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
        $var = array();
		return view('admin.card.show',$var);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function audit(Request $request)
	{
        $return = array();
		return response()->json($return);
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
	public function destroy(Request $request)
	{
		//
		$id = $request->input('id');
		$return = array(
			'code'=>self::CODE_PARAM,
			'msg'=>self::PARAM_MSG
		);

		return response()->json($return);

	}

}
