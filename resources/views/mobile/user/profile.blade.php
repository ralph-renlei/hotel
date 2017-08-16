<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>个人资料</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
                <a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">个人资料</span>

			</header>
			<div class="info_content">
				<div class="info clearfix">
					<span>昵称</span>
					<span>{{ $user->nickname }}</span>
				</div>
				<div class="info clearfix">
					<span>绑定手机号</span>
					<span>{{ $user->mobile }}</span>
				</div>
			</div>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('js/mobile.common.js') }}" type="text/javascript" charset="utf-8"></script>
</html>