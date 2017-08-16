<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>换绑手机</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>

	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
			</header>
			<div class="bar_wrap">
				<div class="interval_bar clearfix">
					<div class="left left_text">
						新手机号
					</div>
					<div class="right right_text">
						<input type="number" placeholder="输入新手机号" name="" id="phone" value="" onblur="checkMobile()" />
					</div>
				</div>
				<div class="interval_bar clearfix">
					<input type="number" placeholder="XXXX" name="" id="code" value="" />
					<input type="button" class="right send_code " name="" id="" value="发送验证码" />
				</div>
			</div>

			<p class="btn true_btn"  onclick="validation()">确定</p>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>