<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>设置</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
        <script>
            var UID = "{{ $user->id }}";
            var OPENID = "{{ $user->openid }}";
            var SMS_URL = "{{ url('sms/sendcode') }}";
            var VALID_URL = "{{ url('sms/valid') }}";
        </script>
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
                <a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">设置</span>
			</header>
			<div class="interval_bar clearfix">
				<div class="left install_text_left">
					手机号
				</div>
				<div class="right install_text_right">
					<input type="number" placeholder="输入手机号" name="phone" id="phone" onblur="checkMobile()"/>
				</div>
			</div>
			<div class="interval_bar clearfix">
				<input type="number" placeholder="输入验证码" name="code" id="code"/>
				<input type="button" class="right send_code install_sendcode" name="send_code" id="send_code" value="发送验证码" />
			</div>
			<p class="btn red_btn" id="next" onclick="validation()">换绑手机</p>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('js/mobile.common.js?t='.time()) }}" type="text/javascript" charset="utf-8"></script>
</html>
