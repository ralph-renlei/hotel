<?php namespace WxHotel\Http\Controllers\Console;

use App\Jobs\ClosePower;
use Illuminate\Http\Request;
use DB;
use WxHotel\Category;
use WxHotel\Goods;
use WxHotel\Order;
use WxHotel\Services\Mantun;
use WxHotel\Services\WxNotice;
use WxHotel\User;

class OrderManageController extends Controller {
	public function index(Request $request){
		$categorys = Category::all();//获取所有分类，添加订单使用
		$keywords = '';
		if(!empty($request->input('start'))){
			$keywords = $request->input('start');
			$time_arr = explode('-',$keywords);
			if(strpos($time_arr[1],'0') == 0){
				$time_arr[1] = str_replace('0','',$time_arr[1]);
			}
			if(strpos($time_arr[2],'0') == 0){
				$time_arr[2] = str_replace('0','',$time_arr[2]);
			}
			$keywords = implode('-',$time_arr);
		}

		if($keywords == ''){
			$orderlist = Order::orderBy('order_id','desc')->orderBy('pay_status','desc')->paginate(20);
		}else{
			$orderlist = Order::where('start','like','%'.$keywords.'%')->orderBy('order_id','desc')->orderBy('pay_status','desc')->paginate(20);
		}
		return view('admin.order.home',['list'=>$orderlist,'keywords'=>$keywords,'categorys'=>$categorys]);
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
		//查看此状态下的房间是否可以分配
		$order = \DB::table('orders')->where('order_id',$id)->first();;
		$room_status_arr = \DB::table('room_status')->where('goods_name',$order->goods_name)->get();
		$start = strtotime($order->start);
		$end = strtotime($order->end);
		foreach($room_status_arr as $demo){
			if(!((date('z',$start) < date('z',strtotime($demo->start_time)) && date('z',$end) < date('z',strtotime($demo->start_time))) || (date('z',$start) >= date('z',strtotime($demo->end_time)) && date('z',$end)>date('z',strtotime($demo->end_time))))){
				echo "<script>alert('此房间近段时间有人预定');window.history.back();</script>";
				return;
			}
		}
		//将房型名称，房间名返回到分配页面
		$order = Order::find($id);
		$categorys = Category::all();
		return view('admin.goods.allowarrange',['order'=>$order,'categories'=>$categorys]);
	}

	//pc端房间分配
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
		\DB::transaction(function () use($category,$order_id,$goods_name,$name,$mobile,$number,$start,$end,$goods_id,$order){
//			\DB::table('goods')->where('goods_id',$goods_id)->update(['status'=>0]);//更改房间的状态
			\DB::table('orders')->where('order_id',$order_id)->update(['goods_id'=>$goods_id,'goods_name'=>$goods_name,'order_status'=>1]);//订单中加入房间信息，更改审核状态
			\DB::table('room_status')->insert(['order_id'=>$order_id,'name'=>$order->username,'mobile'=>$order->phone,'start_time'=>$order->start,'end_time'=>$order->end,'goods_name'=>$goods_name,'category'=>$category]);//添加到临时表中
		});

		$this->send_room_success_notice($order->openid,$category,$goods_name,$order->start,$order->end);
		echo "<script>alert('成功');window.location.href='/admin/order/home'</script>";
	}

	public function loadadd(){
		$categorys = Category::all();
		return view('admin.order.loadadd',['categories'=>$categorys]);
	}

	//给房型分配房间（线上）
	public function mobile_room(Request $request){
		//查看此类型下是否有房间分配 如果没放可分，发送模板消息 有房分，将未预定的房间返回
		$category_name = \DB::table('goods_category')->where('id',$request->input('category_id'))->pluck('name');
		$rooms = \DB::table('goods')->where('category_id',$request->input('category_id'))->get();//获取所有房间
		$room_status_arr = \DB::table('room_status')->where('category',$category_name)->get();//获取所有数据
		$order = \DB::table('orders')->where('order_sn',$request->input('order_sn'))->first();//获取当前订单
		$start = strtotime($order->start);
		$end = strtotime($order->end);
		foreach($room_status_arr as $demo){
			if(!((date('z',$start) < date('z',strtotime($demo->start_time)) && date('z',$end) < date('z',strtotime($demo->start_time))) || (date('z',$start) >= date('z',strtotime($demo->end_time)) && date('z',$end)>date('z',strtotime($demo->end_time))))){
				foreach($rooms as $key=>$room){
					if($room->name == $demo->goods_name){
						unset($rooms[$key]);
					}
					continue;
				}
			}
		}

		//加载该类别下所有 未入住的房间 ,没有房间可分配
 		if(!$rooms){
			$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
			$wx->room_arrange_error($order->openid);
			echo "<script>alert('该房型已饱满,已提醒客户');window.history.back();</script>";
			return;
		}
		$userinfo = Order::where('order_sn',$request->input('order_sn'))->first();
		$categorys = Category::all();
		return view('room.admin_assignroom',['rooms'=>$rooms,'userinfo'=>$userinfo,'categorys'=>$categorys,'id'=>$request->input('category_id'),'order_sn'=>$request->input('order_sn')]);
	}

	//同意房间分配（线下）
	public function mobile_allow(Request $request){
		$room = \DB::table('goods')->select('goods.*','b.name as category_name')
			->where('goods.goods_id',$request->input('goods_id'))
			->leftJoin('goods_category as b','b.id','=','goods.category_id')
			->get();
		$userinfo = Order::where('order_sn',$request->input('order_sn'))->first();
		return view('room.admin_allow',['room'=>$room,'userinfo'=>$userinfo,'order_sn'=>$request->input('order_sn')]);
	}

	//mobile端房间分配
	public function mobile_room_arrange(Request $request){
		//处理线下,判断次房间号是否有预定  如果有，发送模板消息
		if($request->input('forms') == 0){
			//查看此状态下的房间是否可以分配
			$order = \DB::table('orders')->where('order_sn',$request->input('order_sn'))->first();;
			$room_status_arr = \DB::table('room_status')->where('goods_name',$order->goods_name)->get();
			$start = strtotime($order->start);
			$end = strtotime($order->end);
			foreach($room_status_arr as $demo){
				if(!((date('z',$start) < date('z',strtotime($demo->start_time)) && date('z',$end) < date('z',strtotime($demo->start_time))) || (date('z',$start) >= date('z',strtotime($demo->end_time)) && date('z',$end)>date('z',strtotime($demo->end_time))))){
					$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
					$wx->room_arrange_error($order->openid);
					echo "<script>alert('此房间近段时间有人预定,已提醒用户');window.history.back();</script>";
					return;
				}
			}
		}

		\DB::transaction(function () use($request){
			\DB::table('orders')->where('order_sn',$request->input('order_sn'))->update(['goods_id'=>$request->input('goods_id'),'goods_name'=>$request->input('goods_name'),'order_status'=>1]);//订单中加入房间信息，更改订单状态 为已处理
		});

		$order = Order::where('order_sn',$request->input('order_sn'))->first();
		if($order->order_status == 1){//如果订单状态正确，发送模板消息
						\DB::table('room_status')->insert(['order_id'=>$order->order_id,'name'=>$order->username,'mobile'=>$order->phone,'start_time'=>$order->start,'end_time'=>$order->end,'goods_name'=>$order->goods_name,'category'=>$order->category_name,'number'=>1]);
			$this->send_room_success_notice($order->openid,$request->category_name,$request->input('goods_name'),$order->start,$order->end);
		}
		$return = [
			'code'=>self::CODE_SUCCESS,
			'msg'=>self::SUCCESS_MSG
		];
		return response()->json($return);
	}

	//发送 预订成功 消息
	public function send_room_success_notice($openid,$category_name,$goods_name,$order_start,$order_end){
		$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
		$wx->room_arrange_notice($openid,$category_name,$goods_name,$order_start,$order_end);
	}

	//入住 判断是否实名认证
	public function makeRest(Request $request){ //goods_name  openid
		//判断房间是否入住
		$room_status  = \DB::table('room_status')->select('id')->where('goods_name',$request->input('goods_name'))->get();
//		if($room_status){
//			echo "<script>alert('已有人入住')</script>";
//			return;
//		}

		//判断房间和人是否一致
		$order = Order::where(['openid'=>$request->input('openid'),'order_status'=>1,'pay_status'=>1,'goods_name'=>$request->input('goods_name')])->first();
		if(is_null($order)){
			echo "<script>alert('查询不到订单')</script>";
			return;
		}

		if($order->goods_name != $request->input('goods_name')){
			echo "<script>alert('房间号与您的订单不符');</script>";
			return;
		}

		//通过openid 判断是否认证
		$user = \WxHotel\User::where('openid',$request->input('openid'))->first();
		if($user->verify == 0){
			echo "<script>alert('请先实名认证');window.location.href='/member/credit'</script>";
			return;
		}

		//修改房间状态  添加到 room_status  通电 发送模板消息
		$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
		$managers = \WxHotel\User::where('role','admin')->lists('openid');//查询管理员
		foreach($managers as $openid) {
			$wx->rest_notice($openid, $order->category_name, $order->goods_name, $order->start, $order->end);//给管理者发送信息
		}

		$this->open_power($order->goods_name);
		echo "<script>alert('恭喜您，房间已开电，欢迎入住！')</script>";
	}


	//通电
	public function open_power($goods_name){
		$mac = \DB::table('goods')->where('name',$goods_name)->pluck('mac');//通过mac控制通断电
		$power = new PowerController();
		$power_status = $power->control_power($mac,'open');//开电
		if($power_status == 0){//将此时的电量放入
			$all_power = $power->daypower($mac,date('Y',time()),date('m',time()),date('d',time()));
			if($all_power = []){
				$start_power = 0;
			}else{
				$start_power = 0;
				foreach($all_power as $list){
					$start_power = $start_power + $list['electricity'];
				}
			}
		}
		\DB::table('goods')->where('name',$goods_name)->update(['status'=>0]);
		\DB::table('box_power')->insert(['box_mac'=>$mac,'start'=>date('Y-m-d'),'start_power'=>$start_power]);
	}

	//退房 断电
	public function out_room(Request $request){
		//查询正在 入住的订单
		$order = Order::where(['openid'=>session('user')['openid'],'pay_status'=>1,'order_status'=>1])->first();

		if(is_null($order)){
			echo "<script>alert('查询不到订单')</script>";
			return;
		}

		if($order->goods_name != $request->input('goods_name')){
			echo "<script>alert('房间号与您的订单不符');</script>";
			return;
		}

		$mac = \DB::table('goods')->where('name',$order->goods_name)->pluck('mac');
		$start_power = \DB::table('box_power')->where('box_mac')->pluck('start_power');
		$power = new PowerController();
		$all_power = $power->daypower($mac,date('Y',time()),date('m',time()),date('d',time()));
		if($all_power = []){
			$end_power = 0;
		}else{
			$end_power = 0;
			foreach($all_power as $list){
				$end_power = $end_power + $list['electricity'];
			}
		}

		$count_power  = $end_power - $start_power;
		\DB::transaction(function ()use($mac,$order,$end_power,$count_power) {
			\DB::table('box_power')->where('box_mac', $mac)->update(['end' => date('Y-m-d',time()), 'end_power' => $end_power,'count_power'=>$count_power]);//跟新电量
			\DB::table('orders')->where('order_sn',$order->order_sn)->update(['order_status'=>2]);//更新订单状态
			\DB::table('goods')->where('goods_id',$order->goods_id)->update(['status'=>1]);//更新房间状态
			\DB::table('room_status')->where('order_id',$order->order_id)->delete();//删除房间状态表数据
		});

		//給管理员通知
		$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
		$managers = \WxHotel\User::where('role','admin')->lists('openid');//查询管理员
		foreach($managers as $openid){
			$wx->close_accounts($openid,$order->goods_name);//给管理者发送信息
		}

		//断电
		$this->close_power($order->goods_name);
		$return = [];
		$return['code'] == 0;
		$return['msg'] == '退房成功';
		return response()->json($return);
	}

	//断电
	public function close_power($goods_name){
		$mac = \DB::table('goods')->where('name',$goods_name)->pluck('mac');
		$power = new PowerController();
		$power_status = $power->control_power($mac,'close');//断电
	}

	//退款
	public function refund_record()
	{
		$list = \DB::table('orders')->select('orders.*','b.total_fee','b.refund_success_time','b.refund_fee')
			->rightJoin('orders_refund AS b', 'b.order_id', '=', 'orders.order_id')
			->orderBy('orders.order_id','desc')
			->paginate(20);
		return view('admin.order.refund_record',['list'=>$list]);
	}
}
