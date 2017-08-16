<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>注册-登陆</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>
	<body style="background: #fff;">
		<img src="../img/logo.png"  class="logo"/>
		<div class="login_mobile">
			<p class="clearfix">
				<i class="iconfont icon-kehudianhua"></i>
				<input type="number" placeholder="请输入手机号" name="mobile" id="phone" class='phone' value="" length=11 onblur="checkMobile(this)" />
			</p>
			<p class="clearfix">
				<i class="iconfont icon-yanzhengma"></i>
				<input class="right " type="number" name="" id="code" value="" placeholder="请输入验证码"/>
				<span class="sendcode">发送验证码</span>
			</p>
			<p class="clearfix">
				<img src="../img/invite_code.png" class="invite_code"/>
				<input type="text" name="" id="invitecode" value="" placeholder="请输入邀请码"/>
			</p>
		</div>
		<a href="#" class="login_btn">登陆</a>
		<p class="note grey_text"><span class="annotation">*</span>首次登陆默认为注册</p>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script>
		$(".login_btn").bind("click", function() {
			var phone=$("#phone").val();
			var code=$("#code").val();
			var invitecode=$("#invitecode").val();
			if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(phone))) {
				alert('电话格式有误');
				return false;
			}
			if(!code||!invitecode){
				alert('邀请码和验证码有误');
				return false;
			}
			$.ajax({
				url: '/login',
				type: 'POST',
				dataType: 'json',
				data: {
					mobile: phone,
					code:code,
					invitecode:invitecode
				},
				success: function(res) {
					alert(res.msg);
					if(res.data.url){
						window.location.href = res.data.url;
					}
				},
				error: function(err) {
					alert('发送异常，请重试'+JSON.stringify(err));
					return false;
				}
			});
		})
		$(".sendcode").bind("click", function() {
			var mobile = $('#phone').val();
			if(!mobile) {
				alert("手机号不能为空");
				return false;
			}
			var v = this;
			settime(v);
			$.ajax({
				url: '/sms/sendcode',
				type: 'post',
				dataType: 'json',
				data: {
					mobile: mobile
				},
				success: function(res) {
					if(res.code == 1) {
						settime(v);
					} else {
						alert(res.msg);
						return false;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('发送异常，请重试');
					return false;
				}
			});
		});

		// 发送验证码倒计时
		var countdown = 60;
		function settime(v) {
			if(countdown == 0) {
				$(v).removeAttr("disabled");
				$(v).text("重新发送");
				$(v).attr("class", "new_sendcode");
				countdown = 60;
			} else {
				$(v).attr("disabled", true);
				$(v).attr("class", "new_sendcode grey_sendcode");
				$(v).text("(" + countdown + "s)");
				countdown--;
				setTimeout(function() {
					settime(v)
				}, 1000)
			}
		}

	</script>
</html>
