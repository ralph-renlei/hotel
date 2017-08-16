<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Card;
use WxHotel\Http\Requests;

use Illuminate\Http\Request;

class CardController extends Controller {

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

		$Card = new Card();
		$page = $request->input('page') > 0 ? $request->input('page') : 1;
		$limit = self::LIMIT;
		$start = ($page-1)*$limit;

		$list = $Card->getCardList($start,$limit);
		$var['lists'] = $list;
		return view('admin.card.home',$var);
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
		$name = $request->input('name');
		$money = $request->input('money');
		$point = $request->input('point');
		$level = $request->input('level');
		$status = $request->input('status');
		$months = $request->input('months');
		$sort = $request->input('sort');
		$id = $request->input('id');

		$this->validate($request,[
			'name'=>'string|required|max:100,min:2',
			'money'=>'numeric|required',
			'point'=>'numeric',
			'level'=>'integer',
			'status'=>'required|in:1,0',
			'months'=>'integer|required|max:120,min:1',
			'sort'=>'integer'
		]);
		$data = array(
			'name'=>$name,
			'money'=>$money,
			'months'=>$months,
			'status'=>$status,
		);
		if(isset($level)){
			$data['level'] = (int)$level;
		}
		if(isset($point)){
			$data['point'] = (int)$point;
		}
		if(isset($sort)){
			$data['sort'] = (int)$sort;
		}
		$card = NULL;
		if($id){
			$card = Card::find($id);
		}
		if(empty($card)){
			$card = Card::create($data);
		}else{
			$card->name = $name;
			$card->money = $money;
			$card->months = $months;
			$card->status = $status;

			if(isset($level)){
				$card->level = $level;
			}
			if(isset($point)){
				$card->point = $point;
			}
			if(isset($sort)){
				$card->sort = $sort;
			}
			$card->save();
		}

		if($card){
			return redirect(url('admin/user/card'));
		}

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
		$card = Card::find($id);
		$var['item'] = $card;
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
		//
		$return = array(
			'code'=>self::CODE_PARAM,
			'msg'=>self::PARAM_MSG
		);

		$id = $request->input('id');
		$status = $request->input('status');
		if(empty($id) || !isset($status)){
			return response()->json($return);
		}

		if(!in_array((int)$status,array(1,0),true )){
			return response()->json($return);
		}

		$card = Card::find($id);
		if(empty($card)){
			return response()->json($return);
		}

		$card->status = $status;
		$card->save();
		$return['code'] = self::CODE_SUCCESS;
		$return['msg'] = self::SUCCESS_MSG;
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

		$id = $request->input('id');
		if(empty($id)) {
			return response()->json($return);
		}
		$card = Card::find($id);
		if(empty($card)){
			return response()->json($return);
		}
		$card->delete();
		$return['code'] = self::CODE_SUCCESS;
		$return['msg'] = self::SUCCESS_MSG;
		return response()->json($return);

	}

}
