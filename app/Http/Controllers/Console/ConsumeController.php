<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Consume;
use WxHotel\Money;
use WxHotel\Http\Requests;
use WxHotel\User;
use Illuminate\Http\Request;

class ConsumeController extends Controller {

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
		$keyword = $request->input('keyword');
		if(!empty($keyword)){
			$list = Consume::where('store_name','LIKE','%'.$keyword.'%')
				->orWhere('mobile','LIKE','%'.$keyword.'%')
				->orWhere('uname','LIKE','%'.$keyword.'%')
				->orderBy('id','desc')->paginate(20);
			$list->setPath('/admin/shop/consume?keyword='.$keyword);
		}else{
			$list = Consume::orderBy('id','desc')->paginate(20);
			$list->setPath('/admin/shop/consume');
		}

		$var = array(
			'lists'=>$list
		);
		return view('admin.consume.home',$var);
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
		$consume  = Consume::find($id);
		$var['item'] = $consume;
		return view('admin.consume.show',$var);
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
	public function update(Request $request)
	{
		//
        $id = $request->input('id');
        $star = $request->input('star');
        $status = $request->input('status');
        $note = $request->input('note');
        if(!isset($id) || !isset($status)){
            return redirect()->back()->withErrors(array('error'=>'找不到消费记录参数异常'));
        }

        $consumer = Consume::find($id);
        if(empty($consumer)){
            return redirect()->back()->withErrors(array('error'=>'找不到消费记录'));
        }

        $user = User::find($consumer->uid);
        if(empty($user)) {
            return redirect()->back()->withErrors(array('error' => '找不到消费者'));
        }
        if(isset($star)){
            $consumer->star = $star;
        }

        if($status==-1){
            if(empty($note)){
                return redirect()->back()->withErrors(array('error'=>'请输入驳回原因'));
            }
        }

        $consumer->status = $status;
        $consumer->save();
        if($consumer->status==1){
            $user->money += $consumer->cashback;
            $user->save();

            $record = [
                'title'=>'账户提现',
                'money'=>$consumer->cashback,
                'type'=>1,
                'cate'=>1,
                'note'=>$consumer->uname.'返现'.$consumer->cashback.',目前'.$user->money,
                'uid'=>$user->id,
                'uname'=>$user->name,
            ];
            Money::create($record);
        }

        $url = url('admin/shop/consume');
        return redirect($url);



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
