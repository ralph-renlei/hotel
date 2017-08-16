<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>个人资料</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>

	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
				<span class="h_title">个人资料</span>
				<!--<i class="iconfont icon-share"></i>-->
			</header>
			<div class="nointerval">
				<div class="info_bar clearfix">
					<span class="left left_text">昵称</span>
					<span class="right right_text">{{$user->nickname}}</span>
				</div>
				<div class="info_bar clearfix">
					<span class="left left_text">绑定手机</span>
					<span class="right right_text">{{$user->mobile}}</span>
				</div>
			</div>
		</div>
	</body>
</html>