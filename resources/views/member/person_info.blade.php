<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>个人资料</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />

	</head>
	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>
			<!--<span class="h_title">个人资料</span>-->
		</header>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					微信昵称：{{$infoList->nickname}}
				</div>
				<div class="no_interval_cell">
					手机号码：{{$infoList->mobile}}
				</div>
				<div class="no_interval_cell">
					真实姓名：{{$infoList->name}}
				</div>
				<div class="no_interval_cell">
					身份证号：{{$infoList->idcard_no}}
				</div>
				<div class="no_interval_cell">
					<form action="/member/changesex" method="post">
						<input type="hidden" name="openid" value="{{$infoList->openid}}"/>
						性别：<input type="radio" name="sex" value="1" @if($infoList->sex == 1) checked @endif/> 男 <input type="radio" name="sex" value="0" @if($infoList->sex == 0) checked @endif/> 女
						<button class="orange_btn reserve_btn" type="submit">修改</button>
					</form>

				</div>
			</div>
		</div>
		<!--<p class="button orange_btn">修改</p>-->
	</body>
</html>