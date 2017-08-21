<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>填写订单</title>
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
					<span class="bigger_text" id="category_name">{{$category->name}}</span><span id="category_id" data="{{$category->id}}"></span><span id="goods_id" data="{{$goods_id}}"></span><span id="goods_name" data="{{$goods_name}}"></span>
					<span>@if($forms==1) 线上预定 @else 线下预定 @endif</span>
				</div>
				<div class="no_interval_cell time_range">
					<div class="start_time">
						入住时间：
						<span class="bigger_text" id="start">{{$start}}</span>
					</div>
					<div class="end_time">
						离店时间：
						<span class="bigger_text" id="end">{{$end}}</span>
					</div>
					<div class="range order_range">
						<span id="last">{{$last}}</span>晚
					</div>
				</div>
			</div>
		</div>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">房间数：1间</span >
				</div>
				<div class="no_interval_cell">
					<span class="">入住人：</span >
					<input type="text" name="checkin_name" id="checkin_name" value="" placeholder="请输入入住人姓名"/>
				</div>
				<div class="no_interval_cell">
					<span class="">手机号：</span >
					<input type="text" name="checkin_phone" id="checkin_phone" value="" placeholder="请输入联系人手机号码"/>
				</div>
			</div>
		</div>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">支付方式：</span >
					<i class="iconfont icon-radio"></i>在线支付
				</div>
				<div class="no_interval_cell">
					<span class="">房间预留至：18:00</span >
				</div>
			</div>
		</div>
		
		<div class="bottom_bar clearfix">
			<div class="left">
				<label>总价:</label>
				<span class="orange_text" id="order_amount">￥{{$order_amount}}</span>
			</div>
			<div class="right submit_order orange_btn">
				提交订单
			</div>
		</div>
	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>