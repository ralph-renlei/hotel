<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Card;
use WxHotel\Cash;
use WxHotel\Http\Requests;
use WxHotel\Money;
use WxHotel\User;
use Illuminate\Http\Request;

class CashController extends Controller {

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
            $list = Cash::where('mobile','LIKE','%'.$keyword.'%')->orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/shop/cash?keyword='.$keyword);
        }else{
            $list = Cash::orderBy('id','desc')->paginate(20);
            $list->setPath('/admin/shop/cash');
        }

        $var['lists'] = $list;
        $var['keyword'] = $keyword;
        return view('admin.cash.home',$var);
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
        $var = array();
        $cash = Card::find($id);
        $var['cash'] = $cash;

        return view('admin.cash.show',$var);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		//
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
        }

        $cash->status = $status;
        $cash->save();

        if( $cash->status ==1){
            $user->money -= $cash->money;
            $user->save();

            $record = [
                'title'=>'账户提现',
                'money'=>$cash->money,
                'type'=>3,
                'cate'=>2,
                'note'=>$cash->uname.'提现'.$cash->money.',目前'.$user->money,
            ];
            Money::create($record);
        }
        $url = url('admin/shop/cash');
        return redirect($url);

	}

}
