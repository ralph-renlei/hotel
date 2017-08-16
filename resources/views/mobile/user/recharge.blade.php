<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>充值</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>
	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
		</header>
		<div class="release_wrap">
			<div class="r_cell clearfix">
				<div class="left">
					充值金额
				</div>
				<div class="right">
					<input type="number" name="" id="money" value="" placeholder="输入充值金额"/>
				</div>
			</div>
		</div>
		<p class="btn green_btn" id="recharge">充值</p>
		<p style="display: none" class="type">charge</p>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>
