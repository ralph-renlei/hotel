<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
	</head>

	<body>
		<div class="main_top">
			<img src="{{asset('/hotel/img/main.png')}}" class="hotel_img"/>
			<p class="hotel_title">淘源圆岭岗</p>
		</div>
		<div class="qrcode_wrap">
			<!--<img src="img/qrcode.png" />-->
			<p class="house_num">房型：{{$goods->category_name}}</p>
			<p class="house_num">房间号：{{$goods->name}}</p>
		</div>
		<input type="hidden" name="goods_name" id="goods_name" value="{{$goods->name}}"/><input type="hidden" name="openid" id="openid" value="{{session('user')['openid']}}"/>
		<div class="mainbtn_wrap">
			@if($flag == 'book')
				<a href="/reserve/orderoffline?goods_id={{$goods->goods_id}}&goods_name={{$goods->name}}" class="">我要预定</a>
				<a href="javascript:void(0);" onclick="alert('您还未订房')">我要退房</a>
			@else
			<a href="/rest?goods_name={{$goods->name}}&openid={{session('user')['openid']}}" class="">我要入住</a>
			<a href="javascript:void(0);" id="check_out">我要退房</a>
			@endif

		</div>
	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>