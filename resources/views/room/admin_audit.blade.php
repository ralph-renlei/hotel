<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>审核</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<!--<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>-->
			<!--<span class="h_title"></span>-->
			<!--<i class="iconfont right icon-biaodan"></i>-->
		</header>
		<p class="certificate_note">根据国家法令，入住酒店需要身份证登记。</p>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">真实姓名：</span >
					<input type="text" name="realname" id="realname" value="{{$user->name}}" readonly="readonly"/>
					<input type="hidden" name="openid" id="openid" value="{{$user->openid}}"/>
					<a class="blue_btn right" id="contact" href="tel:15771801111">
						联系客户
					</a>
				</div>
				<div class="no_interval_cell">
					<span >身份证号：</span >
					<input type="text" name="idcard_number" id="idcard_number" value="{{$user->idcard_no}}" readonly="readonly"/>
				</div>
				<div class="no_interval_cell clearfix">
					<span class="idcard_label">身份证正面照：</span>
					<div class="img_container">
						<img src="{{$user->idcard_front}}" />
					</div>
				</div>
				<div class="no_interval_cell clearfix">
					<span class="idcard_label">身份证背面照：</span >
					<div class="img_container">
						<img src="{{$user->idcard_back}}" />
					</div>
				</div>
			</div>
		</div>
		<div class="mainbtn_wrap" id="audit_wrap">
			<a href="javascript:void(0);" onclick="agree()">同意</a>
			<a href="javascript:void(0);" onclick="reject()">驳回</a>
		</div>

	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>