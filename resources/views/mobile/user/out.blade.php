<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>提现</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
                <a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">提现</span>
			</header>
			<div class="info_content">
				<div class="info clearfix">
					<span>可提现金额</span>
					<span>￥<span>0.00</span></span>
				</div>
				<div class="info clearfix">
					<span>提现金额</span>
					<span>
						<input type="number" placeholder="输入提现金额" name="money" id="money"/>
					</span>
				</div>
			</div>
			<p class="grey_small">注：只能提现到微信钱包且提现金额不得小于1元</p>
			<p class="btn green_btn">确定</p>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('js/mobile.common.js') }}" type="text/javascript" charset="utf-8"></script>
</html>