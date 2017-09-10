<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>填写订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/dateRange.css')}}"/>
	</head>

	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
			<!--<span class="h_title">个人资料</span>-->
			<i class="iconfont icon-biaodan right" onclick="window.location.href='/member'"></i>
		</header>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell order_title">
					<span class="bigger_text" id="category_name">{{$category->name}}</span><span id="category_id" data="{{$category->id}}"></span><span id="goods_id" data="{{$goods_id}}"></span><span id="goods_name" data="{{$goods_name}}"></span>
					<span>@if($forms==1) 线上预定 @else 线下预定 @endif <input type="hidden" id="forms" value="{{$forms}}"/> </span>
				</div>
				<div class="no_interval_cell time_range" id="date1">
					<div class="start_time">
						入住时间：
						<span class="bigger_text sInput" id="start"></span>
						<span class="markToday"></span>
					</div>
					<div class="end_time">
						离店时间：
						<span class="bigger_text eInput" id="end"></span>
						<span class="markTom"></span>
					</div>
					<div class="range order_range">
						<span class="allDate" id="last">1</span>晚
					</div>
				</div>
			</div>
		</div>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">房间数：1间</span >
				</div>
				<div class="no_interval_cell">
					<span class="">入住人：</span >
					<input type="text" name="checkin_name" id="checkin_name" value="@if(session('name')){{session('name')}}@endif" placeholder="请输入入住人姓名"/>
				</div>
				<div class="no_interval_cell">
					<span class="">手机号：</span >
					<input type="number" name="checkin_phone" id="phone" value="@if(session('mobile')){{session('mobile')}}@endif" placeholder="请输入手机号码" onblur="checkMobile(this)"/>
					<input type="button" class="send_code" name="" id="" value="发送验证码" />
				</div>
				<div class="no_interval_cell">
					<span class="">验证码：</span >
					<input type="text" name="vertify_code" id="vertify_code" value="" placeholder="验证码"/>
				</div>
			</div>
		</div>
		<div class="no_interval_wrap" style="display:@if(session('verify')) none @else block @endif">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">真实姓名：</span >
					<input type="text" name="realname" id="realname" value="@if(session('name')){{session('name')}}@endif" placeholder="请输入真实姓名"/>
				</div>
				<div class="no_interval_cell">
					<span >身份证号：</span >
					<input type="text" name="idcard_number" id="idcard_number" value="" placeholder="请输入身份证号码"/>
				</div>
				<div class="no_interval_cell clearfix">
					<span class="idcard_label">身份证正面照：</span>
						<span class="upload_btn">
							<i class="iconfont icon-shangchuan"></i>上传身份证正面照
							<input type="file" id="idcardbefore_file" accept="image/jpeg,image/png,image/jpg"/>
						</span>
					<div class="img_container">
						<!--<img src="img/avatar.png" />-->
						<p class="delete_wrap">
							<i class="iconfont icon-shanchu-copy"></i>
							<span class="delete_label">删除</span>
						</p>
					</div>
				</div>
				<div class="no_interval_cell clearfix">
					<span class="idcard_label">身份证背面照：</span >
						<span class="upload_btn">
							<i class="iconfont icon-shangchuan"></i>上传身份证背面照
							<input type="file" id="idcardback_file" accept="image/jpeg,image/png,image/jpg"/>
						</span>
					<div class="img_container">
						<!--<img src="img/avatar.png" />-->
						<p class="delete_wrap">
							<i class="iconfont icon-shanchu-copy"></i>
							<span class="delete_label">删除</span>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">支付方式：</span >
					<label><input type="radio" name="pay_way" id="wechat_pay" value="1" />在线支付</label>
					<label><input type="radio" name="pay_way" id="member_card" value="2"/>会员卡支付</label>
				</div>
				<div class="no_interval_cell member_cell">
					<span class="">会员卡号：</span >
					<input type="text" name="" id="" value="" placeholder="请输入会员卡号码"/>
				</div>
				<div class="no_interval_cell member_cell">
					<span class="">会员卡密码：</span >
					<input type="password" name="" id="" value="" placeholder="请输入会员卡密码"/>
				</div>
				<div class="no_interval_cell">
					<span class="">房间预留至：18:00</span >
				</div>
			</div>
		</div>

		<div class="bottom_bar clearfix">
			<div class="left">
				<label>总价:</label>
				<span class="orange_text" id="order_amount">￥{{$category->normalprice}}</span>
			</div>
			<input type="hidden" name="flag" value="no"/>
			<div class="right orange_btn" onclick="order_commit()">
				提交订单
			</div>
		</div>
	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/dateRange.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>
<script type="text/javascript">
	init_date();
	//		getLocalstorage();
	$(".member_cell").css('display', 'none');
	$('input:radio[name="pay_way"]').change(function() {
		if($('input:radio[name="pay_way"]:checked').val() == 2){
			$(".member_cell").css('display', 'block');
		}else{
			$(".member_cell").css('display', 'none');
		}
	});

	order_commit = function(){
		var username = $("#checkin_name").val();
		var phone = $("#phone").val();
		var start = $('#start').text();
		var end = $('#end').text();
		var str = $('#order_amount').text();
		var order_amount = str.replace('￥','');
		var id = $('#category_id').attr('data');
		var goods_id = $('#goods_id').attr('data');
		var goods_name = $('#goods_name').attr('data');
		var category_name = $('#category_name').text();
		var forms = $('#forms').val();
		if(username == '' || phone == ''){
			alert('您的信息必须填写');
			return false;
		}

		if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(phone))){
			alert('手机号格式不正确');
			return false;
		}

		if($('#verify_code').val() == 'no'){
			alert('验证码不正确，不能提交');
			return false;
		}

		//身份证
		var idcard_front = $('#idcardbefore_file').attr('data_url');
		var idcard_back = $('#idcardback_file').attr('data_url');
		var verify = "{{session('verify')}}";
		
		if(idcard_front == undefined || idcard_back == undefined){
			if(verify == 0){
				alert('请上传照片');
				return false;
			}
		}

		$.ajax({
			type: "POST",
			url: "/reserve/ordercommit_offline",
			async: true,
			data: {
				_token:"{{csrf_token()}}",
				username: username,
				phone: phone,
				start: start,
				end: end,
				order_amount: order_amount,
				id:id,
				goods_id:goods_id,
				goods_name:goods_name,
				category_name:category_name,
				forms:forms,
				idcard_front:idcard_front,
				idcard_back:idcard_back,
			},
			success: function(res) {
				if(res.code==1) {
					window.location.href = "/pay_offline?uid="+res.data.uid+"&openid="+res.data.openid+"&category_name="+res.data.category_name+"&order_amount="+res.data.order_amount+"&goods_id="+res.data.goods_id;
				}else{
					alert(res.msg);
					window.location.href= '/';
				}
			},
		});
	}

	var last = $('#last');//the element I want to monitor
	last.bind('DOMNodeInserted', function(e) {
		var count = Number($(e.target).html());
		var order_amount = Number("{{$category->normalprice}}");
		$('#order_amount').text(count*order_amount);
	});

	$('#vertify_code').blur(function(){
		if($('#vertify_code').val() == ''){
			alert('验证码不能为空');
			return false;
		}

		$.ajax({
			type:'get',
			url: "/reserve/verify_code",
			async: true,
			data:{'code':$('#vertify_code').val(),'mobile':$("#phone").val()},
			success:function(res) {
				if(res.code == 0){
					$('#flag').val('ok');
				}else{
					alert(res.msg);
				}
			}
		});
	});

	$('#member_card').click(function(){
		alert('目前不支持会员卡支付');
	})

</script>