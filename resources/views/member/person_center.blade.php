<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>个人中心</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>

	<body>
		<div class="whole">
			<div class="main_info">
				<a href=""><img src="img/avatar.png" class="avatar" /></a>
				<p class="username">小易</p>
			</div>
			<div class="personbar_wrap">
				<a href="/member/info">
					<span class="bar1"><i class="iconfont icon-grzl"></i></span>
					<span>个人资料</span>
					<i class="iconfont icon-icon right"></i>
				</a>
			</div>
			<div class="personbar_wrap">
				<a href="/member/order">
					<span class="bar2"><i class="iconfont icon-dingdan"></i></span>
					<span>我的订单</span>
					<i class="iconfont icon-icon right"></i>
				</a>
				<span id="interval_line"></span>
				<a href="/member/credit">
					<span  class="bar3"><i class="iconfont icon-shimingrenzheng"></i></span>
					<span>实名认证</span>
					<i class="iconfont icon-icon right"></i>
					<p class="right">@if($memberInfo->verify==-1) 审核中 @elseif($memberInfo->status==0) 未认证 @else 已认证 @endif</p>
				</a>
				<span id="interval_line"></span>
				<a href="/member/setting">
					<span  class="bar4"><i class="iconfont icon-shezhi"></i></span>
					<span>设置</span>
					<i class="iconfont icon-icon right"></i>
				</a>
			</div>

			<!--tabbar-->
			<div class="tabbar">
				<a href="/">
					<div>
						<i class="iconfont icon-shouye"></i>
						<p>首页</p>
					</div>
				</a>
				<a href="/member">
					<div style="color: #019ade">
						<i class="iconfont icon-gerenzhongxin"></i>
						<p>个人中心</p>
					</div>
				</a>
			</div>

	</body>
	<!--<script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->

</html>