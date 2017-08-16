<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Debt;
use WxHotel\Http\Requests;

use WxHotel\Job;
use WxHotel\Loan;
use WxHotel\LoanRecord;
use WxHotel\RefundRecord;
use WxHotel\User;
use WxHotel\UsersLoan;
use Illuminate\Http\Request;

class LoanController extends Controller {

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
        if(!empty($keyword)){
            $list = Loan::where('mobile',$keyword)->where('status','<>','0')->orderBy('order_id','desc')->paginate(20);
            $list->setPath('/admin/loan?keyword='.$keyword);
        }else{
            $list = Loan::where('status','<>','0')->orderBy('order_id','desc')->paginate(20);
            $list->setPath('/admin/loan');
        }
        $var['lists'] = $list;
		return view('admin.loan.home',$var);
	}

    public function getIdentify(Request $request){
        $var = array();
        $lists = User::where('role','member')->orderBy('id','desc')->paginate(20);
        $lists->setPath('/admin/loan/identify');
        $var['lists'] = $lists;
        return view('admin.loan.users',$var);
    }

    public function getUser($id){
        $var = array();
        $user = User::find($id);
        $var['item'] = $user;
        $debts = Debt::find($id);
        $var['debts'] = $debts;
        $job = Job::find($id);
        $var['job']  = $job;
        $loan = UsersLoan::find($id);
        if(isset($loan))$loan->purpose_list = explode('|',$loan->purpose);
        $var['loan'] = $loan;
        return view('admin.loan.user',$var);
    }


    public function postIdentify(Request $request){

        $id = $request->input('id');

        $verify = $request->input('verify');
        $note = $request->input('note');
        $idcard_no = $request->input('idcard_no');
        $wechatid = $request->input('wechatid');
        $name = $request->input('name');
        $mobile = $request->input('mobile');
        $email = $request->input('email');
        $weight = $request->input('weight');
        $height = $request->input('height');
        $household = $request->input('household');

        $house_loan = $request->input('house_loan');
        $car_loan = $request->input('car_loan');
        $credit_card = $request->input('credit_card');
        $mobile_loan = $request->input('mobile_loan');
        $web_loan = $request->input('web_loan');
        $other_loan = $request->input('other_loan');
        $urgency_contacter = $request->input('urgency_contacter');
        $contacter_tel = $request->input('contacter_tel');
        $contacter_mobile = $request->input('contacter_mobile');
        $job_type = $request->input('job_type');
        $job_name = $request->input('job_name');
        $job_year = $request->input('job_year');
        $job_contacter = $request->input('job_contacter');
        $job_contacter_mobile = $request->input('job_contacter_mobile');
        $salary = $request->input('salary');
        $ranges = $request->input('ranges');
        $purpose = $request->input('purpose');

        $this->validate($request, [
            'name'=>'required|max:255',
            'mobile' => 'required|regex:/^1[2-9]\d{9}$/|max:11',
            'email' => 'required|email',
            'height' => 'required|integer',
            'weight' => 'required|integer',
            'wechatid' => 'required|string|max:255',
            'idcard_no'=>'required|string|max:19',
            'verify'=>'required|in:0,1,-1',
            'note' => 'string||max:255',
        ]);
        if($verify==-1 && empty($note)){
            return redirect()->back()->withErrors(array('error'=>'备注不能为空'));
        }
        $user = User::find($id);
        if(empty($user)){
            return redirect()->back()->withErrors(array('error'=>'用户不存在'));
        }
        $user->name = $name;
        $user->email = $email;
        $user->mobile = $mobile;
        $user->height = $height;
        $user->weight = $weight;
        $user->wechatid = $wechatid;
        $user->idcard_no = $idcard_no;
        if($verify==1 || $verify==-1){
            $user->audited_at = date('Y-m-d H:i:s',time());
        }
        $user->verify = $verify;
        if($household){
            $user->household = $household;
        }
        $user->save();
        $Debts = Debt::find($id);
        if(empty($Debts)){
            $debts = [];
            if($house_loan) {
                $debts['house_loan'] = $house_loan;
            }else{
                $debts['house_loan'] = '无';
            }
            if($car_loan){
                $debts['car_loan'] = $car_loan;
            }else{
                $debts['car_loan'] = '无';
            }
            if($web_loan){
                $debts['web_loan'] = $web_loan;
            }else{
                $debts['web_loan'] = '无';
            }
            if($mobile_loan){
                $debts['mobile_loan'] = $mobile_loan;
            }else{
                $debts['mobile_loan'] = '无';
            }
            if($other_loan){
                $debts['other_loan'] = $other_loan;
            }else{
                $debts['other_loan'] = '无';
            }
            if($credit_card){
                $debts['credit_card'] = $credit_card;
            }else{
                $debts['credit_card'] = '无';
            }
            $debts['uid'] = $user->id;
            Debt::create($debts);
        }else{
            if($house_loan) {
                $Debts->house_loan = $house_loan;
            }else{
                $Debts->house_loan = '无';
            }
            if($car_loan){
                $Debts->car_loan = $car_loan;
            }else{
                $Debts->car_loan  = '无';
            }
            if($web_loan){
                $Debts->web_loan  = $web_loan;
            }else{
                $Debts->web_loan  = '无';
            }
            if($mobile_loan){
                $Debts->mobile_loan  = $mobile_loan;
            }else{
                $Debts->mobile_loan  = '无';
            }
            if($other_loan){
                $Debts->other_loan  = $other_loan;
            }else{
                $Debts->other_loan  = '无';
            }
            if($credit_card){
                $Debts->credit_card  = $credit_card;
            }else{
                $Debts->credit_card  = '无';
            }
            $Debts->save();
        }

        $Job = Job::find($id);
        if(empty($Job)){
            $job = [];
           if($job_name){
               $job['name'] = $job_name;
           }
            if($job_contacter){
                $job['contacter'] = $job_contacter;
            }
            if($job_contacter_mobile){
                $job['contacter_mobile'] = $contacter_mobile;
            }
            if($job_type){
                $job['type'] = $job_type;
            }
            if($job_year){
                $job['year'] = $job_year;
            }
            if(!empty($job)){
                $job['uid'] = $user->id;
                Job::create($job);
            }
        }else{
            if($job_name){
                $Job->name = $job_name;
            }
            if($job_contacter){
                $Job->contacter = $job_contacter;
            }
            if($job_contacter_mobile){
                $Job->contacter_mobile = $contacter_mobile;
            }
            if($job_type){
                $Job->type = $job_type;
            }
            if($job_year){
                $Job->year = $job_year;
            }
            $Job->save();
        }

        $Loan = UsersLoan::find($id);
        if(empty($Loan)){
            $loan = [];
            if($salary){
                $loan['salary'] = $salary;
            }
            if(!empty($purpose)){
                $loan['purpose'] = join('|',$purpose);
            }
            if(!empty($ranges)){
                $loan['ranges'] = $ranges;
            }
            if(!empty($note)){
                $loan['note'] = $note;
            }
            if(!empty($loan)){
                $loan['uid'] = $user->id;
                UsersLoan::create($loan);
            }
        }else{
            if($salary){
                $Loan->salary = $salary;
            }
            if(!empty($purpose)){
                $Loan->purpose = join('|',$purpose);
            }
            if(!empty($ranges)){
                $Loan->ranges = $ranges;
            }
            if(!empty($note)){
                $Loan->note = $note;
            }
            $Loan->save();
        }

        return redirect(url('/admin/loan/identify'));
    }

    public function delIdentify(Request $request){

    }


    public function auditIdentify(Request $request){

    }

    public function getAuditLoan($id){
        $var = [];
        $loan = Loan::find($id);
        $var['item'] = $loan;
        return view('admin.loan.audit',$var);
    }
    public function getLoanItem($id){
        $var = [];
        $loan = Loan::find($id);
        $var['item'] = $loan;
        return view('admin.loan.item',$var);
    }

    public function getLoan(Request $request)
    {
        $var = [];
        $keyword = $request->input('keyword');
        if(!empty($keyword)){
            $lists = LoanRecord::where('mobile',$keyword)->orderBy('id','desc')->paginate(20);
            $lists->setPath('/admin/loan/loan?keyword='.$keyword);
        }else{
            $lists = LoanRecord::orderBy('id','desc')->paginate(20);
            $lists->setPath('/admin/loan/loan');
        }
        $var['lists'] = $lists;
        return view('admin.loan.record',$var);
    }

    public function postLoan(Request $request){

    }

    public function delLoan(Request $request){

    }

    public function auditLoan(Request $request){
        $id = $request->input('id');
        $audit = $request->input('audit');
        $note = $request->input('note');
        if(!isset($id) || !isset($audit)){
            return redirect()->back()->withErrors(array('error'=>'参数异常'));
        }
        if($audit==-1 && empty($note)){
            return redirect()->back()->withErrors(array('error'=>'备注不能为空'));
        }
        $loan = Loan::find($id);
        if(empty($loan)){
            return redirect()->back()->withErrors(array('error'=>'贷款申请不存在'));
        }
        $loan->audit = $audit;
        $loan->audited_at = date('Y-m-d H:i:s',time());
        if(isset($note)){
            $loan->note = $note;
        }
        $loan->save();
        return redirect(url('/admin/loan'));
    }

    public function getRefund(Request $request){
        $var = [];
        $keyword = $request->input('keyword');
        if(!empty($keyword)){
            $list = RefundRecord::where('mobile',$keyword)->orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/loan/refund?keyword='.$keyword);
        }else{
            $list = RefundRecord::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/loan/refund');
        }
        $var['lists'] = $list;
        return view('admin.loan.refund',$var);
    }

    public function postRefund(Request $request){

    }

    public function delRefund(Request $request){

    }

    public function auditRefund(Request $request){

    }


    public function getOverdue(Request $request){

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
