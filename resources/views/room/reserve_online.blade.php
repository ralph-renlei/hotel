<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>线上预订</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
			<!--<span class="h_title">个人资料</span>-->
			<i class="iconfont icon-biaodan right" onclick="window.location.href='/member'"></i>
		</header>
		<div class="reserve_wrap">
			<div class="reserve_on clearfix">
				<img src="{{asset('/hotel/img/main.png')}}" class="reserve_img left" />
				<div class="right_info">
					<div class="right_top clearfix">
						<p class="bigger_text left">淘源圆岭岗</p>
					</div>
					<div class="right_top clearfix">
						<p class="bigger_text left">18814040788</p>
					</div>
				</div>
			</div>
		</div>
		<!--<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell clearfix">
					<div class="left">
						<i class="iconfont icon-saoyisao"></i>
						<span>扫一扫选择房间号</span>
					</div>
					<div class="right">
						<i class="iconfont icon-icon"></i>
					</div>
				</div>
			</div>
		</div>-->
		<div class="no_interval_wrap">
			<div class="reserve_time_wrap clearfix">
				<div class="start_time left">
					入住时间
					<p>
						<span class="bigger_text" id="start">{{$start}}</span>
					</p>
					<i class="iconfont icon-icon"></i>
				</div>
				<div class="end_time right">
					离店时间
					<p>
						<span class="bigger_text" id="end">{{$end}}</span>
					</p>
					<i class="iconfont icon-icon"></i>
				</div>
				<div class="range reserve_range">
					<span id="last">{{$last}}</span>晚
				</div>
				<span id="reserve_range_line"></span>
			</div>
		</div>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
					@foreach($categorys as $category)
					<div class="no_interval_cell clearfix">
					<img src="{{$category->thumb}}" class="reserve_img1" style="width: 90px;height: 70px;"/>
					<div class="mid_wrap left">
						<ul>
							<li>
								挂牌价格
								<span class="orange_text">￥{{$category->marketprice}}</span>
							</li>
							<li>
								普通价格
								<span class="orange_text">￥{{$category->normalprice}}</span>
							</li>
							<li>
								会员价格
								<span class="orange_text">￥{{$category->vipprice}}</span>
							</li>
						</ul>
					</div>
					<div class="right_wrap">
						<p>{{$category->name}}</p>
						@if($category->number == 0)
							<a class="orange_btn reserve_btn" href="javascript:void(0);" title="该时间段客房爆满">客满</a>
						@else
							<a class="orange_btn reserve_btn" href="javascript:void(0);" onclick="orderonline({{$category->id}})">预定</a>
						@endif
					</div>
				</div>
					@endforeach
			</div>
		</div>

	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/dateRange.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		init_date();
		function orderonline(id){
			var start = $('#start').text();
			var end = $('#end').text();
			var last = $('#last').text();
			window.location.href='/reserve/orderonline?start='+start+'&end='+end+'&last='+last+'&id='+id+'&forms=1';
		}
	</script>

</html>