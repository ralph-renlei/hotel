<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>注册</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<i class="iconfont icon-fanhui1"></i>
				<span class="h_title">注册</span>
			</header>
			<div class="interval_bar clearfix radiu_bar" style="margin-top: 50px;">
				<div class="left install_text">
					手机号
				</div>
				<div class="right">
					<input type="number" name="phone" id="phone" placeholder="输入手机号"/>
					<input type="button" class="right send_code regist_sendcode" name="send_code" id="send_code" value="发送验证码" />
				</div>
			</div>
			<div class="interval_bar clearfix radiu_bar">
				<div class="left install_text">
					输入验证码
				</div>
				<div class="right">
					<input type="number" placeholder="输入验证码" name="code" id="code"/>
				</div>
			</div>
			<p class="btn red_btn" id="reg_btn">注册</p>
		</div>
	</body>
	<script>
		var REG_URL = "{{ url('register') }}";
		var SMS_URL = "{{ url('sms/sendcode') }}";
        var USER_URL = "{{ url('user') }}";
		var OPENID = "{{ $openid }}";
        var UID = "{{ $uid }}";
	</script>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/mobile.common.js?t='.time()) }}" ></script>
</html>