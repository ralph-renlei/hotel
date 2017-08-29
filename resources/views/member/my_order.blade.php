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
		<div class="order_whole">

			@foreach($orderList as $list)
				<a class="no_interval_wrap" href="/member/order_detail/{{$list->order_id}}">
					<div class="no_interval_on">
						<div class="no_interval_cell order_title">
							<p>
								<span class="bigger_text">淘源圆岭岗</span>
								<span>@if($list->forms == 1 ) 在线预订 @elseif($list->forms == 2) 前台预定 @else 线下预定 @endif</span>
							</p>
							<p>
								<span class="bigger_text">{{$list->goods_name}}</span>
								<span>1间</span>
							</p>
						</div>
						<div class="no_interval_cell time_range">
							<div class="start_time">
								入住时间：
								<span class="bigger_text">{{$list->start}}</span>
							</div>
							<div class="end_time">
								离店时间：
								<span class="bigger_text">{{$list->end}}</span>
							</div>
							<div class="range order_range">
								<span>{{$list->last}}</span>晚
							</div>
						</div>
						<div class="no_interval_cell">
							<div class="">
								<p>状态: <span class="orange_text"> @if($list->order_status == 0) 已提交,等待酒店处理（@if($list->pay_status == 0) 未支付 @else 已支付 @endif） @elseif($list->order_status == 1) 已处理，可以入住 	@else 订单已完成 @endif
										</span></p>
								<p>总价: <span class="orange_text">￥{{$list->order_amount}}</span></p>
							</div>
						</div>

					</div>
				</a>
			@endforeach
		</div>

	</body>

</html>