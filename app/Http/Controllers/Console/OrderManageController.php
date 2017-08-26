<?php namespace WxHotel\Http\Controllers\Console;

use EasyWeChat\User\User;
use Illuminate\Http\Request;
use DB;
use WxHotel\Category;
use WxHotel\Goods;
use WxHotel\Order;
use WxHotel\Services\WxNotice;

class OrderManageController extends Controller {
	public function index(Request $request){
		$keywords = '';
		if(!empty($request->input('start'))){
			$keywords = $request->input('start');;
		}

		//生成当前时间 前1个月的时间 ，查询近一个月内每天的订单情况
		$time_array = [];
		for($i = 0 ; $i < 30 ; $i++){
			$data_array = explode('-',date('Y-m-d',time() - 3600 * 24 * $i));
			$data_array[1] = (int)$data_array[1];
			$time_array[] = implode('-',$data_array);
		}

		$orderlist = Order::where('start','like','%'.$keywords.'%')->orderBy('order_id','desc')->orderBy('pay_status','desc')->paginate(20);
		return view('admin.order.home',['list'=>$orderlist,'time_array'=>$time_array]);
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
		//将房型名称，房间名返回到分配页面
		$roominfo = Goods::find($id);
		$categorys = Category::all();
		return view('admin.goods.loadarrange',['roominfo'=>$roominfo,'categories'=>$categorys]);
	}

	public function allowarrange($id){
		//将房型名称，房间名返回到分配页面
		$order = Order::find($id);
		$categorys = Category::all();
		return view('admin.goods.allowarrange',['order'=>$order,'categories'=>$categorys]);
	}

	public function room_arrange(Request $request){
		$category = Category::find($request->input('category'));
		$order_id = $request->input('order_id');
		$order = Order::find($order_id);
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

		$this->send_room_success_notice($category,$goods_name,$order->start,$order->end);
	}

	public function loadadd(){
		$categorys = Category::all();
		return view('admin.order.loadadd',['categories'=>$categorys]);
	}

	//分配房间
	public function mobile_room(Request $request){
		$user = \WxHotel\User::where('openid',$request->input('openid'))->first();
		if($user->verify == 0){
			echo "<script>alert('请等待该用户实名认证后，分配房间');window.location.href='/';</script>";
			return;
		}

		//加载该类别下所有 未入住的房间
		$rooms = Goods::where(['category_id'=>$request->input('category_id'),'open'=>1,'status'=>1])->get();
		$userinfo = Order::where('order_sn',$request->input('order_sn'))->first();
		$categorys = Category::all();
		return view('room.admin_assignroom',['rooms'=>$rooms,'userinfo'=>$userinfo,'categorys'=>$categorys,'id'=>$request->input('category_id'),'order_sn'=>$request->input('order_sn')]);
	}

	//同意房间入住
	public function mobile_allow(Request $request){
		$user = \WxHotel\User::where('openid',$request->input('openid'))->first();
		if($user->verify == 0){
			echo "<script>alert('请等待该用户实名认证后，分配房间');window.location.href='/';</script>";
			return;
		}

		$room = \DB::table('goods')->select('goods.*','b.name as category_name')
			->where('goods.goods_id',$request->input('goods_id'))
			->leftJoin('goods_category as b','b.id','=','goods.category_id')
			->get();
		$userinfo = Order::where('order_sn',$request->input('order_sn'))->first();
		return view('room.admin_allow',['room'=>$room,'userinfo'=>$userinfo,'order_sn'=>$request->input('order_sn')]);
	}

	public function mobile_room_arrange(Request $request){
		\DB::transaction(function () use($request){
			\DB::table('goods')->where('goods_id',$request->input('goods_id'))->update(['status'=>0]);//更改房间的状态
			\DB::table('orders')->where('order_sn',session('order_sn'))->update(['goods_id'=>$request->input('goods_id'),'goods_name'=>$request->input('goods_name'),'order_status'=>1]);//订单中加入房间信息，更改订单状态 为已处理
		});

		$order = Order::where('order_sn',session('order_sn'))->first();
		if($order->order_status == 2){//如果订单状态正确，发送模板消息
			$this->send_room_success_notice($request->category_name,$request->input('goods_name'),$order->start,$order->end);
		}
		$return = [
			'code'=>self::CODE_SUCCESS,
			'data'=>$order,
			'msg'=>self::SUCCESS_MSG
		];
		return response()->json($return);
	}

	//发送 入住 消息  开电
	public function send_room_success_notice($category_name,$goods_id,$order_start,$order_end){
		$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
		$wx->room_arrange_notice($category_name,$goods_id,$order_start,$order_end);
	}

}
