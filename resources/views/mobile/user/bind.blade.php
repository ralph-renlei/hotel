<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>换绑手机</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>

	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
			</header>
			<div class="bar_wrap">
				<div class="interval_bar clearfix">
					<div class="left left_text">
						手机号
					</div>
					<div class="right right_text">
						<input type="number" placeholder="输入现已绑定的手机号" name="mobile" id="phone" class='phone' value="" length=11 onblur="checkMobile(this)" />
					</div>
				</div>
				<div class="interval_bar clearfix">
					<input type="number" placeholder="XXXX" name="" id="code" value="" />
					<input type="button" class="right send_code new_sendcode" name="" id="" value="发送验证码" />
				</div>
				<p class="note grey_text">*如已经绑定的手机号无法正常使用，则联系客服进行换绑手机号</p>
			</div>

			<p class="btn true_btn">换绑手机</p>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$(".true_btn").bind("click", function(){
			alert("确认换绑成该手机号吗？");
			var mobile = $("#phone").val();
			var code = $("#code").val();
			if(!mobile || !code) {
				alert('手机号码和验证码不能为空');
				return false;
			}
			$.ajax({
				type: "GET",
				url: 'mobile',
				data: {
					mobile: mobile,
					code: code
				},
				dataType: "json",
				success: function(res) {
					if(res.code == 1) {
						if(res.data.url) {
							window.location.href = res.data.url;
						}
					}
				},
				error: function(msg) {
					alert('发生异常，请重试');
				}
			});
		});
	</script>
</html>