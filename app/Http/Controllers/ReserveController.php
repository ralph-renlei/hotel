<?php namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use WxHotel\Category;
use WxHotel\Goods;
use WxHotel\Order;
use WxHotel\User;
use WxHotel\UsersOrder;
use DB;

class ReserveController extends Controller {
	//获取用户所选时间内上线的房型  获取入住时间，离店时间
	public function index(Request $request){
		$categorys = Category::where('status',1)->get();
		$last = date('z',strtotime($request->input('end'))) - date('z',strtotime($request->input('start')));
		foreach($categorys as $category){
			$result = \DB::select('select count(*) as number from goods where category_id='.$category->id.' and open =1 and status = 1');
			$category->number = $result[0]->number;
		}
		return view('room.reserve_online',['categorys'=>$categorys,'start'=>$request->input('start'),'end'=>$request->input('end'),'last'=>$last]);
	}

	//生成订单
	public function makeOrder(Request $request){
		//未引入会员机制 ，默认值普通价
		$category = Category::where('id',$request->input('id'))->first();
		$order_amount = $category->normalprice;
		$last = date('z',strtotime($request->input('end')))-date('z',strtotime($request->input('start')));

		//判断线上和线下
		if($request->input('forms')==0){//线下
			return view('room.write_order',['category'=>$category,'order_amount'=>$order_amount*$last,'start'=>$request->input('start'),'end'=>$request->input('end'),'last'=>$last,
				'forms'=>$request->input('forms'),'goods_id'=>$request->input('goods_id'),'goods_name'=>$request->input('goods_name')]);
		}

		return view('room.write_order',['category'=>$category,'order_amount'=>$order_amount*$last,'start'=>$request->input('start'),'end'=>$request->input('end'),'last'=>$request->input('last'),
			'forms'=>$request->input('forms'),'goods_id'=>'','goods_name'=>'']);
	}

	//提交订单
	public function orderCommit(Request $request){
		$order_amount = $request->input('order_amount');
		$uid = 1;
		$category_id = $request->input('id');
		$category_name = $request->input('category_name');

		//后台下订单 添加用户，写入订单
		if($request->input('forms')==2){
			$category = Category::where('id',$request->input('category'))->first();
			$order_amount = $category->normalprice;
			$last = date('z',strtotime($request->input('end')))-date('z',strtotime($request->input('start')));
			$order_amount = $last*$order_amount;
			$category_id = $request->input('category');
			$category_name = $category->name;
			$uid = User::create(['name'=>$request->input('username'),'mobile'=>$request->input('phone')]);
		}

		//房型判断
//		$category_number  = \DB::select('select count(*) as number from goods where category_id='.$category_id.' and open =1 and status = 1');
//		if($category_number[0]->number == 0){
//			$return['code'] = 0;
//			$return['msg'] = '该房型客房已满';
//			return response()->json($return);
//		}

		//人员判断
		$member_book = \DB::select('select count(*) as count from orders where openid = "oG3Ulv_z-uJsb-uUmy6m62J5qxc0" and order_status!=2 ');
		if($member_book[0]->count !=0){
			$return['code'] = 0;
			$return['msg'] = '你已经预定过客房';
			return response()->json($return);
		}

		//将数据写入数据库
		$data = [
			'order_sn'=>date('YmdHis',time()).rand(1111,9999),
			'order_status'=>0,//等待审核
			'pay_status'=>0,//未付款
			'openid'=>'oG3Ulv_z-uJsb-uUmy6m62J5qxc0',
			'uid'=>$uid,//从系统中获取
			'goods_id'=>$request->input('goods_id'),
			'goods_name'=>$request->input('goods_name'),
			'goods_price'=>$order_amount,
			'order_amount'=>$order_amount,
			'add_time'=>date("Y-m-d H:i:s",time()) ,
			'forms'=>$request->input('forms'),//在线支付
			'start'=>$request->input('start'),
			'end'=>$request->input('end'),
			'category_id'=>$category_id,
			'category_name'=>$category_name,
			'phone'=>$request->input('phone'),
			'username'=>$request->input('username'),
			'last'=>date('z',strtotime($request->input('end'))) - date('z',strtotime($request->input('start'))),
		];

		$result = Order::create($data);
		if($request->input('forms')==2){
			return redirect('/admin/order/home');
		}
		if($result){
			$return['code'] = self::CODE_SUCCESS;
			$return['msg'] = self::SUCCESS_MSG;
			return response()->json($return);
		}
	}

	//线下预定
	public function orderoffline($id)
	{
		//根据房间id 查询房间的信息 ，种类
		$goodsinfo = Goods::find($id);
		if($goodsinfo->status==0 || $goodsinfo->status ==-1){
			 echo "<script>alert('该房间不能入住，请选择其他房间')</script>";
			return ;
		}

		$category = Category::find($goodsinfo->category_id);
		return view('room.reserve_offline',['goodsinfo'=>$goodsinfo,'category'=>$category]);
	}

}
