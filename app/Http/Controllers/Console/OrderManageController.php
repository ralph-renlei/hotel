<?php namespace WxHotel\Http\Controllers\Console;



use Illuminate\Http\Request;
use WxHotel\Order;

class OrderManageController extends Controller {
	public function index(){
		$orderlist = Order::orderBy('order_id','desc')->paginate(20);
		return view('admin.order.home',['list'=>$orderlist]);
	}

	public function show($id)
	{
		if(!isset($id) || empty($id)){
			$return = [
				'code'=>self::CODE_PARAM,
				'msg'=>self::PARAM_MSG
			];
			return response()->json($return);
		}
		$order_detail = Order::find($id);

		if(!$order_detail){
			$return = [
				'code'=>self::CODE_PARAM,
				'msg'=>self::PARAM_MSG
			];
			return response()->json($return);
		}
		$return = [
			'code'=>self::CODE_SUCCESS,
			'data'=>$order_detail->toArray(),
			'msg'=>self::SUCCESS_MSG
		];
		return response()->json($return);
	}

	public function orderedit(Request $request){
		$id = $request->input('id');
		if(!isset($id) || empty($id)){
			$return = [
				'code'=>self::CODE_PARAM,
				'msg'=>self::PARAM_MSG
			];
			return response()->json($return);
		}
		$result = Order::where('order_id',$request->input('id'))->update(['pay_status'=>$request->input('pay_status'),'order_status'=>$request->input('order_status')]);
		if($result){
			$return = [
				'code'=>self::CODE_SUCCESS,
				'msg'=>self::SUCCESS_MSG
			];
			return response()->json($return);
		}
	}

	public function room_arrange(Request $request){
		$data = [
			'order_id'=>$request->input('order_id'),
			'name'=>$request->input('name'),
			'order_id'=>$request->input('order_id'),
			'order_id'=>$request->input('order_id'),
			'order_id'=>$request->input('order_id'),
		];
	}

}
