<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>提现</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>

	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
			</header>
			<div class="nointerval">
				<div class="info_bar clearfix">
					<span class="left left_text">可提现金额</span>
					<span class="right right_text">￥<span id="can_cash">{{$user->money}}</span></span>
				</div>
				<div class="info_bar clearfix">
					<span class="left left_text">提现金额</span>
					<span class="right right_text">
						<input type="number" placeholder="输入提现金额(限整数)" name="" id="money" value=""  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"/>
					</span>
				</div>
			</div>
			<p class="grey_text note">注：只能提现到微信钱包且提现金额不得小于1元</p>
				<p class="btn green_btn" id="deposit">提现</p>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>

</html>