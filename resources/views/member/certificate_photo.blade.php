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
		<p class="certificate_note">根据国家法令。入住酒店需要身份证登记</p>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<!--表单-->
				<form action="/member/credit" method="post" id="form1" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					<input type="hidden" name="photo1" value=""/>
					<input type="hidden" name="photo2" value=""/>
					<div class="no_interval_cell">
						<span class="">真实姓名：</span >
						<input type="text" name="realname" id="realname" value="{{$creditList->name}}" placeholder="请输入真实姓名"/>
					</div>
					<div class="no_interval_cell">
						<span >身份证号：</span >
						<input type="text" name="idcard_number" id="idcard_number" value="{{$creditList->idcard_no}}" placeholder="请输入身份证号码"/>
					</div>
					<div class="no_interval_cell clearfix">
						<span class="idcard_label">身份证正面照：</span>
						<div class="img_container">
							<img src="{{$creditList->idcard_front}}" style="width: 200px;"/>
						</div>
					</div>
					<div class="no_interval_cell clearfix">
						<span class="idcard_label">身份证背面照：</span >
						<div class="img_container">
							<img src="{{$creditList->idcard_back}}" style="width: 200px;"/>
						</div>
					</div>
				</form>
			</div>
		</div>
		<p class="button orange_btn" id="makecredit">@if($creditList->status==-1) 未认证 @elseif($creditList->status==0) 审核中 @else 已认证 @endif</p>

	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>