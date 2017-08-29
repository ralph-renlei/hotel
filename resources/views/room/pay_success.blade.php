<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<title>支付成功</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
</head>

<body style="background: #FFFFFF;">
<header>
	<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
</header>
<img src="{{asset('/hotel/img/success.png')}}" class="pay_state" />
<p class="pay_title">支付成功！</p>
<div class="pay_detail">
	<div class="order_cell clearfix">
		<p>订单号</p>
		<p>{{$list->order_sn}}</p>
	</div>
	<div class="order_cell clearfix">
		<p>订单金额</p>
		<p>{{$list->order_amount}}0</p>
	</div>
	<div class="order_cell clearfix">
		<p>订单时间</p>
		<p>{{$list->add_time}}</p>
	</div>
</div>
<a href="index.html" class="goback">
	<input type="hidden" id="verify" value="{{$verify}}"/>
	<span class="theme_text" id="seconds">3</span>秒后<span class="theme_text">返回首页</span>
</a>
</body>
<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	var seconds = $("#seconds").text();
	setInterval(function() {
		seconds--;
		if(seconds == 0) {
			if( $('#verify').val() == 0){
				alert('为了您的入住，请尽快实名认证');
				window.location.href = "{{url('/member/credit')}}";
			}else{
				window.location.href = '{{url('/member/order')}}';
			}
		} else {
			$("#seconds").text(seconds);
		}
	}, 1000);
</script>

</html>