<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>推广员成绩</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">推广员成绩</span>
			</header>
			<div class="interval_bar clearfix">
				<div class="left install_text">
					已推广人数
				</div>
				<div class="right install_text red_text">
					{{ $num }}
				</div>
			</div>
			<div class="interval_bar clearfix">
				<div class="left install_text">
					奖励金额
				</div>
				<div class="right install_text red_text">
					{{ $money }}
				</div>
			</div>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('js/mobile.common.js?t='.time()) }}" type="text/javascript" charset="utf-8"></script>
</html>
