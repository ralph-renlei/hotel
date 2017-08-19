<?php namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use WxHotel\Category;
use WxHotel\Order;

class ReserveController extends Controller {
	//获取用户所选时间内所有上线的房型  获取入住时间，离店时间
	public function index(Request $request){
		$categorys = Category::where('status',1)->get();
		$last = date('z',strtotime($request->input('end'))) - date('z',strtotime($request->input('start')));
		return view('room.reserve_online',['categorys'=>$categorys,'start'=>$request->input('start'),'end'=>$request->input('end'),'last'=>$last]);
	}

	//生成订单
	public function makeOrder(Request $request){
		//未引入会员机制 ，默认值普通价
		$category = Category::where('id',$request->input('id'))->first();
		$order_amount = $category->normalprice;
		return view('room.write_order',['category'=>$category,'order_amount'=>$order_amount,'start'=>$request->input('start'),'end'=>$request->input('end'),'last'=>$request->input('last')]);
	}

	//提交订单
	public function orderCommit(Request $request){
		//将数据写入数据库
		$data = [
			'order_sn'=>date('YmdHis',time()).rand(1111,9999),
			'order_status'=>0,//等待审核
			'pay_status'=>0,//未付款
			'openid'=>'oG3Ulv_z-uJsb-uUmy6m62J5qxc0',
			'uid'=>1,//从系统中获取
			'goods_price'=>$request->input('order_amount'),
			'order_amount'=>$request->input('order_amount'),
			'add_time'=>date("Y-m-d H:i:s",time()) ,
			'forms'=>1,//在线支付
			'start'=>$request->input('start'),
			'end'=>$request->input('end'),
			'category_id'=>$request->input('id'),
			'category_name'=>$request->input('category_name'),
			'phone'=>$request->input('phone'),
			'username'=>$request->input('username'),
			'last'=>date('z',strtotime($request->input('end'))) - date('z',strtotime($request->input('start'))),
		];

		$result = Order::create($data);
		if($result){
			$return['code'] = self::CODE_SUCCESS;
			$return['msg'] = self::SUCCESS_MSG;
			return response()->json($return);
		}
	}
}
