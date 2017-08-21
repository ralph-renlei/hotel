<?php namespace WxHotel\Http\Controllers\Console;

use Illuminate\Http\Request;
use DB;
use WxHotel\Category;
use WxHotel\Goods;
use WxHotel\Order;

class OrderManageController extends Controller {
	public function index(Request $request){
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

	public function loadarrange($id){
		//讲房型名称，房间名返回到分配页面
		$roominfo = Goods::find($id);
		$categorys = Category::all();
		return view('admin.goods.loadarrange',['roominfo'=>$roominfo,'categories'=>$categorys]);
	}

	public function allowarrange($id){
		//讲房型名称，房间名返回到分配页面
		$order = Order::find($id);
		$categorys = Category::all();
		return view('admin.goods.allowarrange',['order'=>$order,'categories'=>$categorys]);
	}

	public function room_arrange(Request $request){
		$category = Category::find($request->input('category'));
		$order_id = $request->input('order_id');
		$goods_name = $request->input('goods_name');
		$category = $category->name;
		$name = $request->input('name');
		$mobile = $request->input('mobile');
		$number = $request->input('number');
		$start = $request->input('start');
		$end = $request->input('end');
		$goods_id = $request->input('goods_id');
		//写入房间表中
		\DB::transaction(function () use($category,$order_id,$goods_name,$name,$mobile,$number,$start,$end,$goods_id){
			\DB::table('room_status')->insert([
				'order_id'=>$order_id,
				'goods_name'=>$goods_name,
				'category'=>$category,
				'name'=>$name,
				'mobile'=>$mobile,
				'number'=>$number,
				'start_time'=>$start,
				'end_time'=>$end,
			]);
			\DB::table('goods')->where('goods_id',$goods_id)->update(['status'=>0]);//更改房间的状态
			\DB::table('orders')->where('order_id',$order_id)->update(['goods_id'=>$goods_id,'goods_name'=>$goods_name,'order_status'=>1]);//订单中加入房间信息，更改审核状态
		});
	}

	public function loadadd(){
		$categorys = Category::all();
		return view('admin.order.loadadd',['categories'=>$categorys]);
	}

}
