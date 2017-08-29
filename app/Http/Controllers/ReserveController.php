<?php namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use WxHotel\Category;
use WxHotel\Goods;
use WxHotel\Order;
use WxHotel\User;
use WxHotel\UsersOrder;
use DB;

class ReserveController extends Controller {
	public function offlineIndex($id){
		$goods = \DB::table('goods')->join('goods_category','goods.category_id','=','goods_category.id')->select('goods.*','goods_category.name as category_name')->where('goods.goods_id',$id)->first();
		//判断此房间 是否入住，是否为此人预定
		//判断房间是否入住
		$room_status  = \DB::table('room_status')->select('id')->where('goods_name',$goods->name)->get();
		if($room_status){
			echo "<script>alert('已有人入住')</script>";
			return;
		}

		//判断房间和人是否一致
		$order = Order::where(['openid'=>session('user')['openid'],'order_status'=>1,'pay_status'=>1,'goods_name'=>$goods->name])->first();
		if(is_null($order)){//可以预定
			$flag = 'book';
		}else{
			$flag = 'rest';
		}
		return view('room.index_offline',['goods'=>$goods,'flag'=>$flag]);
	}

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
		$uid = session('uid');//通过 线上，线下，uid就是session中的uid ， 后台添加，就不是
		$category_id = $request->input('id');
		$category_name = $request->input('category_name');
		$last = date('z',strtotime($request->input('end')))-date('z',strtotime($request->input('start')));

		//后台下订单 添加用户，写入订单
		if($request->input('forms')==2){
			$category = Category::where('id',$request->input('category'))->first();
			$order_amount = $category->normalprice;
			$order_amount = $last*$order_amount;
			$category_id = $request->input('category');
			$category_name = $category->name;
			$uid = \DB::table('users')->insertGetId(['name'=>$request->input('username'),'mobile'=>$request->input('phone')]); //创建用户
		}

		//人员判断
		$member_book = \DB::select("select count(*) as count from orders where openid = '".session('user')['openid']."' and order_status!=2");
		if($member_book[0]->count !=0){
			$return['code'] = 0;
			$return['msg'] = '你已经预定过客房';
			return response()->json($return);
		}

//		$uid = \DB::table('users')->where('openid',session('user')['openid'])->pluck('id');
		//将数据写入数据库
		$data = [
			'order_sn'=>date('YmdHis',time()).rand(1111,9999),
			'order_status'=>0,//新订单
			'pay_status'=>0,//未付款
			'openid'=>session('user')['openid'],
			'uid'=>$uid,//从系统中获取
			'goods_id'=>$request->input('goods_id'),
			'goods_name'=>$request->input('goods_name'),
			'goods_price'=>$order_amount/$last,
			'order_amount'=>$order_amount,
			'add_time'=>date("Y-m-d H:i:s",time()) ,
			'forms'=>$request->input('forms'),//在线支付
			'start'=>$request->input('start'),
			'end'=>$request->input('end'),
			'category_id'=>$category_id,
			'category_name'=>$category_name,
			'phone'=>$request->input('phone'),
			'username'=>$request->input('username'),
			'last'=>$last,
		];
		//将订单号存入session中，支付时调取 ，返回订单号
		session(['order_sn'=>$data['order_sn']]);

		//更新用户的姓名和电话
		User::where('openid',session('user')['openid'])->update(['mobile'=>$request->input('phone'),'name'=>$request->input('username')]);

		$result = Order::create($data);
		if($result){
			$return['code'] = self::CODE_SUCCESS;
			$return['msg'] = self::SUCCESS_MSG;
			$return['data'] = ['uid'=>$uid,'openid'=>session('user')['openid']];
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

	public function pay(Request $request){
		return view('room.pay',['uid'=>$request->input('uid'),'openid'=>$request->input('openid'),'category_name'=>$request->input('category_name'),'order_amount'=>$request->input('order_amount'),'goods_id'=>$request->input('goods_id')]);
	}

}
