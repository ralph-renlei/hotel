<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>请关注公众号二维码</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<i class="iconfont icon-fanhui1"></i>
				<span class="h_title">请关注公众号二维码</span>
			</header>
			<div class="info_wrap clearfix">
			</div>
			<img src="{{ asset('img/qrcode_430.jpg') }}" class="erweima"/>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/mobile.common.js?t='.time()) }}" ></script>
</html>
