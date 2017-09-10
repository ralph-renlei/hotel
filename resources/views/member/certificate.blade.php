<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>实名认证</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
			<!--<span class="h_title"></span>-->
			<i class="iconfont right icon-biaodan"></i>
		</header>
		<p class="certificate_note">根据国家法令，入住酒店需要身份证登记</p>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<!--表单-->
				<form action="/member/credit" method="post" id="form1" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<input type="hidden" name="photo1" value=""/>
					<input type="hidden" name="photo2" value=""/>
					<div class="no_interval_cell">
						<span class="">真实姓名：</span >
						<input type="text" name="realname" id="realname" value="" placeholder="请输入真实姓名"/>
					</div>
					<div class="no_interval_cell">
						<span >身份证号：</span >
						<input type="text" name="idcard_number" id="idcard_number" value="" placeholder="请输入身份证号码"/>
					</div>
					<div class="no_interval_cell clearfix">
						<span class="idcard_label">身份证正面照：</span>
					<span class="upload_btn">
						<i class="iconfont icon-shangchuan"></i>上传身份证正面照
						<input type="file" id="idcardbefore_file" accept="image/jpeg,image/png,image/jpg" name="front"/>
					</span>
						<div class="img_container">
							<!--<img src="../img/avatar.png" />-->
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
						<input type="file" id="idcardback_file" accept="image/jpeg,image/png,image/jpg" name="behind"/>
					</span>
						<div class="img_container">
							<!--<img src="../img/avatar.png" />-->
							<p class="delete_wrap">
								<i class="iconfont icon-shanchu-copy"></i>
								<span class="delete_label">删除</span>
							</p>
						</div>
					</div>
				</form>
			</div>
		</div>
		<p class="button orange_btn" id="makecredit">提交</p>

	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script>
		$('#makecredit').click(function(){
			var front = $('input[name="front"]').attr('data_url');
			var behind = $('input[name="behind"]').attr('data_url');
			var reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;

			if($('#realname').val() == '' || $('#idcard_number').val() == ''){
				alert('您的信息必须填写');
				return false;
			}

			if(reg.test($('#idcard_number').val()) === false){
				alert("身份证输入不合法");
				return  false;
			}

			if(front == undefined || behind == undefined){
				alert('请上传照片');
				return false;
			}

			$('input[name="photo1"]').attr('value',front);
			$('input[name="photo2"]').attr('value',behind);
			$('#form1').submit();
		});
	</script>
</html>