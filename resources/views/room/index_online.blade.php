<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>线上预订</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/dateRange.css')}}"/>
	<style>
		.person_center{
			width: 40px;
			position: fixed;
			bottom: 50px;
			right: 10px;
		}
	</style>
</head>
<body>
<div class="main_top">
	<img src="{{asset('/hotel/img/main.png')}}" class="hotel_img" />
	<p class="hotel_title">淘源圆岭岗</p>
	<p class="reserve_type">线上预订</p>
</div>
<div class="qrcode_wrap">
	<div class="no_interval_wrap">
		<div class="no_interval_on" id="date1">
			<div class="online_time">
				<i class="iconfont icon-icon-test"></i> 入住时间：
				<span class="bigger_text sInput">8月13日</span> 今天
				<i class="iconfont icon-icon right"></i>
			</div>
			<div class="range reserve_online_range">
				<span id="last">1</span>晚
			</div>
			<div class="online_time" style="border-bottom: 1px solid #ddd;">
				<i class="iconfont icon-icon-test"></i> 离店时间：
				<span class="bigger_text eInput">8月18日</span> 周四
				<i class="iconfont icon-icon right"></i>
			</div>
		</div>
	</div>
	<a class="button orange_btn" href="javascript:void(0);" onclick="sendtime()">开始预订</a>
</div>
</div>
<p class="mainbtn_wrap">
	<span class="online_line"></span>
	<span class="bottom_title">淘源圆岭岗</span>
	<span class="online_line"></span>
</p>
<a href="/member"><img src="{{asset('/hotel/img/p.png')}}"  class="person_center"/></a>
</body>
<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('/hotel/js/dateRange.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	init_date();
	var start = $('.sInput');//the element I want to monitor
	var end = $('.eInput');
	var one = "";
	var two = "";
	start.bind('DOMNodeInserted', function(e) {
		one = $('.sInput').text();
	});
	end.bind('DOMNodeInserted', function(e) {
		two = $('.eInput').text();
		var day = DateMinus(one,two);
		$('#last').text(day);
	});
	
	function DateMinus(start,end){ 
	　　var one = new Date(start.replace(/-/g, "/")); 
	　　var two = new Date(end.replace(/-/g, "/")); 
	　　var days = two.getTime() - one.getTime(); 
	　　var day = parseInt(days / (1000 * 60 * 60 * 24)); 
	　　return day; 
	}
	
	function sendtime(){
		window.location.href = '/reserve?start='+$(".sInput").text()+'&end='+$(".eInput").text();
	}
</script>
</html>