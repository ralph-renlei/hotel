<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>我的订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
			<!--<span class="h_title">个人资料</span>-->
			<i class="iconfont icon-biaodan right"></i>
		</header>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell order_title">
					<p>
						<span class="bigger_text">淘源圆岭岗</span>
						<span>@if($order_detail->forms == 1 ) 在线预订 @else 线下预定 @endif</span>
					</p>
					<p>
						<span class="bigger_text">{{$order_detail->category_name}}</span>
						<span>1间</span>
					</p>
				</div>
				<div class="no_interval_cell">
					<div class="">
						<p>订单号: <span class="bigger_text">{{$order_detail->order_sn}} </span></p><br>
						<p>实付款: <span class="bigger_text">￥{{$order_detail->order_amount}}</span></p><br>
						<p>入住人: <span class="bigger_text">{{$order_detail->username}} &nbsp; {{$order_detail->phone}}</span></p><br>
						<p>下单时间: <span class="bigger_text">{{$order_detail->add_time}} </span></p><br>
					</div>
				</div>
				<div class="no_interval_cell time_range">
					<div class="start_time">
						入住时间：
						<span class="bigger_text">{{$order_detail->start}}</span>
					</div>
					<div class="end_time">
						离店时间：
						<span class="bigger_text">{{$order_detail->end}}</span>
					</div>
					<div class="range order_range">
						<span>{{$order_detail->last}}</span>晚
					</div>
				</div>
				<div class="no_interval_cell">
					<div class="">
						<p>订单状态: <span class="orange_text">
								@if($order_detail->order_status == 0) 已预订,等待酒店确认
								@elseif($order_detail->order_status == 1) 酒店已经处理
								@else 订单已完成
								@endif</span></p>
						<p>入住的房间号: <span class="orange_text">{{$order_detail->goods_name}}</span></p>
					</div>
				</div>
				<div class="no_interval_cell">
					<div class="">
						@if($order_detail->order_status == 0 && $order_detail->pay_status == 0)
						<p><a class="orange_btn reserve_btn" href="/pay?uid={{session('uid')}}&openid={{session('user')['openid']}}&category_name={{$order_detail->category_name}}&order_amount={{$order_detail->order_amount}}&goods_id={{$order_detail->goods_id}}">立即支付</a></p>
						@endif
						@if($order_detail->order_status == 2)
						<p><a class="orange_btn reserve_btn" href="/member/order_del?order_id={{$order_detail->order_id}}">删除订单</a></p>
						@endif
						<p><span>对订单有疑问或申请退款，可拨打 18814040788 </span></p>
					</div>
				</div>

			</div>
		</div>

	</body>

</html>