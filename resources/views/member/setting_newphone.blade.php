<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>设置</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>
	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
			<span class="h_title">绑定新手机号</span>
		</header>
		<form action="" method="post" id="old_phone">
			<div class="no_interval_wrap">
				<div class="no_interval_on">
					<div class="no_interval_cell">
						<input type="number" name="phone" id="phone" value="" placeholder="新手机号码" onblur="checkMobile(this)"/>
						<input type="button" class="send_code" name="" id="" value="发送验证码" />
					</div>
					<div class="no_interval_cell">
						<input type="number" name="vertify_code" id="vertify_code" value="" placeholder="验证码"/>
					</div>
				</div>
			</div>
		</form>

		<p class="button orange_btn" onclick="validation()">修改</p>
	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">

	</script>
</html>
