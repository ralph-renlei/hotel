<?php namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use WxHotel\Category;
use WxHotel\Goods;
use WxHotel\Order;
use WxHotel\User;
use WxHotel\UsersOrder;
use DB;

class ReserveController extends Controller {
	public function offlineIndex(Request $request){
		if(is_null(session('user'))){
			session(['goods_id'=>$request->input('goods_id')]);
			return  redirect('/');
		}

		$request->session()->pull('goods_id');

		$goods = \DB::table('goods')->join('goods_category','goods.category_id','=','goods_category.id')->select('goods.*','goods_category.name as category_name')
				->where('goods.goods_id',$request->input('goods_id'))->first();
		//判断此房间 是否入住，是否为此人预定
		//判断房间是否入住
//		$room_status  = \DB::table('room_status')->select('id')->where('goods_name',$goods->name)->get();
//		if($room_status){
//			echo "<script>alert('已有人入住')</script>";
//			return;
//		}

		//判断房间和人是否一致
		$order = Order::where(['openid'=>session('user')['openid'],'order_status'=>1,'pay_status'=>1,'goods_name'=>$goods->name])->first();
		if(is_null($order)){//可以预定
			$flag = 'book';
		}else{
			$flag = 'rest';
		}
		return view('room.index_offline',['goods'=>$goods,'flag'=>$flag]);
	}

	//获取用户所选时间内上线的房型  判断用户入住时间内所有的房型，如果是满员的，就返回满员信息
	public function index(Request $request){
		$categorys = Category::where('status',1)->get();
		$start = strtotime($request->input('start'));
		$end = strtotime($request->input('end'));
		$last = date('z',$end) - date('z',$start);

		$book_long = env('BOOK_LONG');
		$book_preset = env('BOOK_PRESET');
		if($last>env('BOOK_LONG')){
			echo "<script>alert('您预定的时间太长');window.history.back();</script>";
			return;
		}
		if(date('z',$start) > (date('z',time())+env('BOOK_PRESER'))){
			echo "<script>alert('您预定的时间太超前');window.history.back();</script>";
			return;
		}

		//获取所有类型 > 房间号  如果有预定，剔除一个房间号   数组为空的，客满
		$room_status_arr = \DB::table('room_status')->get();//获取所有房间状态
		$category_name = \DB::table('goods_category')->select('id','name')->get();//获取所有类别
		$goods_name = \DB::table('goods')->select('category_id','name')->get();//查询所有房间号

		$new_arr = [];//记录所有的房型 房间
		foreach($category_name as $parent){
			$new_arr[$parent->name] = [];
			foreach($goods_name as $son){
				if($parent->id == $son->category_id){
					$new_arr[$parent->name][] = $son->name;
				}
			}
		}

		foreach($room_status_arr as $demo){
				//查询订单的时间状态
				if(!((date('z',$start) < date('z',strtotime($demo->start_time)) && date('z',$end) < date('z',strtotime($demo->start_time))) || (date('z',$start) >= date('z',strtotime($demo->end_time)) && date('z',$end)>date('z',strtotime($demo->end_time))))){
					foreach($new_arr[$demo->category] as $key=>$one){
						if($one == $demo->goods_name){
							unset($new_arr[$demo->category][$key]);//将这个区间内有预定的房间剔除
						}
					}
				}
		}

		foreach($categorys as $category){
			if(count($new_arr[$category->name]) == 0){
				$category->number = 0;
			}
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
		$start = $request->input('start');
		$end = $request->input('end');

		$start_arr = explode('-',$start);
		if(strpos($start_arr[1],'0') == 0){
			$start_arr[1] = str_replace('0','',$start_arr[1]);
		}
		if(strpos($start_arr[2],'0') == 0){
			$start_arr[2] = str_replace('0','',$start_arr[2]);
		}
		$start = implode('-',$start_arr);

		$end_arr = explode('-',$end);
		if(strpos($end_arr[1],'0') == 0){
			$end_arr[1] = str_replace('0','',$end_arr[1]);
		}
		if(strpos($end_arr[2],'0') == 0){
			$end_arr[2] = str_replace('0','',$end_arr[2]);
		}
		$end = implode('-',$end_arr);

		//后台下订单 添加用户，写入订单
		if($request->input('forms')==2){
			$category = Category::where('id',$request->input('category'))->first();
			$order_amount = $category->normalprice;
			$order_amount = $last*$order_amount;
			$category_id = $request->input('category');
			$category_name = $category->name;

			//如果系统中没有这个电话，增加这个用户
			$phone = \DB::table('users')->where('mobile',$request->input('phone'))->first();
			if(!$phone){
				$uid = \DB::table('users')->insertGetId(['name'=>$request->input('username'),'mobile'=>$request->input('phone'),'created_at'=>date('Y-m-d H:i:s',time())]); //创建用户
			}else{
				$uid = \DB::table('users')->where('mobile',$request->input('phone'))->pluck('id');
			}

			$member_book = \DB::select("select count(*) as count from orders where phone = '".$request->input('phone')."' and order_status!=2");
			if($member_book[0]->count !=0){
				if($request->input('forms')==2){
					$return['code'] = 0;
					$return['msg'] = '此客户有未完成的订单';
					return response()->json($return);
				}
			}
		}

		//人员判断
		$member_book = \DB::select("select count(*) as count from orders where openid = '".session('user')['openid']."' and order_status!=2");
		if($member_book[0]->count !=0){
			if($request->input('forms')==2){
				$return['code'] = 0;
				$return['msg'] = '此客户有未完成的订单';
				return response()->json($return);
			}
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
			'start'=>$start,
			'end'=>$end,
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

	public function ordercommit_offline(Request $request)
	{
		$order_amount = $request->input('order_amount');
		$uid = session('uid');//通过 线上，线下，uid就是session中的uid
		$category_id = $request->input('id');
		$category_name = $request->input('category_name');
		$last = date('z',strtotime($request->input('end')))-date('z',strtotime($request->input('start')));
		$start = $request->input('start');
		$end = $request->input('end');

		$start_arr = explode('-',$start);
		if(strpos($start_arr[1],'0') == 0){
			$start_arr[1] = str_replace('0','',$start_arr[1]);
		}
		if(strpos($start_arr[2],'0') == 0){
			$start_arr[2] = str_replace('0','',$start_arr[2]);
		}
		$start = implode('-',$start_arr);

		$end_arr = explode('-',$end);
		if(strpos($end_arr[1],'0') == 0){
			$end_arr[1] = str_replace('0','',$end_arr[1]);
		}
		if(strpos($end_arr[2],'0') == 0){
			$end_arr[2] = str_replace('0','',$end_arr[2]);
		}
		$end = implode('-',$end_arr);

		//人员判断
		$member_book = \DB::select("select count(*) as count from orders where openid = '".session('user')['openid']."' and order_status!=2");
		if($member_book[0]->count !=0){
			if($request->input('forms')==2){
				echo "<script>alert('此客户有未完成的订单!');window.location.href='/admin/order/home'</script>";
				return;
			}
			$return['code'] = 0;
			$return['msg'] = '你已经预定过客房';
			return response()->json($return);
		}

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
			'order_amount'=>0.01,
			'add_time'=>date("Y-m-d H:i:s",time()) ,
			'forms'=>$request->input('forms'),//在线支付
			'start'=>$start,
			'end'=>$end,
			'category_id'=>$category_id,
			'category_name'=>$category_name,
			'phone'=>$request->input('phone'),
			'username'=>$request->input('username'),
			'last'=>$last,
		];
		//将订单号存入session中，支付时调取 ，返回订单号
		session(['order_sn'=>$data['order_sn']]);

		//更新用户的姓名和电话
		User::where('openid',session('user')['openid'])->update(['mobile'=>$request->input('phone'),'name'=>$request->input('username'),'idcard_back'=>$request->input('idcard_back'),'idcard_front'=>$request->input('idcard_front')]);

		$result = Order::create($data);

		if($request->input('forms')==2){
			echo "<script>alert('下单成功!');window.location.href='/admin/order/home'</script>";
			return;
		}
		if($result){
			$return['code'] = self::CODE_SUCCESS;
			$return['msg'] = self::SUCCESS_MSG;
			$return['data'] = ['uid'=>$uid,'openid'=>session('user')['openid']];
			return response()->json($return);
		}
	}

	public function verify_code(Request $request){
		$code = SmsRecord::where('mobile',$request->input('mobile'))->orderBy('id','desc')->pluck('token');
		if($code != $request->input('code')){
			$return['code'] = 1;
			$return['msg'] = '验证码不正确';
			$return['flag'] = 'no';
			return response()->json($return);
		}else{
			$return['code'] = 0;
			$return['flag'] = 'ok';
			return response()->json($return);
		}
	}


	//线下预定
	public function orderoffline(Request $request)
	{
		//根据房间id 查询房间的信息 ，种类
		$goodsinfo = Goods::find($request->input('goods_id'));
		if($goodsinfo->status==0 || $goodsinfo->status ==-1){
			 echo "<script>alert('该房间不能入住，请选择其他房间')</script>";
			return ;
		}

		//未引入会员机制 ，默认值普通价
		$category = Category::where('id',$goodsinfo->category_id)->first();
		$last = date('z',strtotime($request->input('end')))-date('z',strtotime($request->input('start')));

		return view('room.write_order_offline',['category'=>$category,'forms'=>0,'goods_id'=>$request->input('goods_id'),'goods_name'=>$request->input('goods_name')]);
	}

	public function pay(Request $request){
		return view('room.pay',['uid'=>$request->input('uid'),'openid'=>$request->input('openid'),'category_name'=>$request->input('category_name'),'order_amount'=>$request->input('order_amount'),'goods_id'=>$request->input('goods_id')]);
	}

	public function pay_offline(Request $request){
		return view('room.pay_offline',['uid'=>$request->input('uid'),'openid'=>$request->input('openid'),'category_name'=>$request->input('category_name'),'order_amount'=>$request->input('order_amount'),'goods_id'=>$request->input('goods_id')]);
	}

}
