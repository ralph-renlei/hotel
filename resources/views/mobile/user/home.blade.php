<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>个人中心</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>
	<body>
		<div class="whole">
			<div class="main_info">
				<a href="{{url('bind')}}" class="bind_mobile">设置</a>
				<div class="p_top">
					<a href="{{url('person')}}">	<img src="{{$user->avatar}}" onerror="this.src='{{ asset('img/avatar.png') }}'" class="avatar"/></a>
					<p>{{$user->nickname}}</p>
				</div>
				<div class="bottom">
					<span>总资产</span>
					<span>{{$user->money}}</span>
					<span><a href="{{url('recharge')}}">充值</a></span>
				</div>
			</div>
			<!--详情-->
			<div class="person_middle">
				<a class="my_money" href="{{url('bill')}}">
					<p>我的账单</p>
					<p>本月应还</p>
					<p>{{$refund}}</p>
				</a>
				<a class="my_money" href="javascript:;">
					<p>我的额度</p>
					<p>可用额度</p>
					<p>{{$quota}}</p>
				</a>
			</div>
			<div class="personbar_wrap">
				<a href="{{ url('person')}}">
					<i class="iconfont icon-gerenziliao"></i>
					<span>个人资料</span>
					<i class="iconfont icon-dayuhao"></i>
				</a>
				<a href="{{ url('approve')}}">
					<i class="iconfont icon-renzheng"></i>
					<span>资质认证</span>
					<i class="iconfont icon-dayuhao"></i>
				</a>
			</div>
			<div class="personbar_wrap">
				<a href="{{url('record')}}">
					<i class="iconfont icon-tixian"></i>
					<span>申请记录</span>
					<i class="iconfont icon-dayuhao"></i>
				</a>
				<a href="{{url('trading')}}">
					<i class="iconfont icon-jiaoyihuizong"></i>
					<span>交易记录</span>
					<i class="iconfont icon-dayuhao"></i>
				</a>
			</div>
			@if($user->role=='channel')
			<div class="personbar_wrap last_person_wrap">
				<a href="{{url('deposit')}}" class=" no_border">
					<i class="iconfont icon-tixian1"></i>
					<span>我要提现</span>
					<i class="iconfont icon-dayuhao"></i>
				</a>
				<a href="{{url('invitecode')}}" class=" no_border">
					<i class="iconfont icon-tixian1"></i>
					<span>我的邀请码</span>
					<i class="iconfont icon-dayuhao"></i>
				</a>
			</div>
			@endif
			<!--tabbar-->
			<div class="tabbar">
				<a href="{{ url('/')}}">
					<div>
						<i class="iconfont icon-shouyeshouye"></i>
						<p>首页</p>
					</div>
				</a>
				<a href="{{ url('/user')}}">
					<div style="color: #e20795">
						<i class="iconfont icon-gerenzhongxin"></i>
						<p>个人中心</p>
					</div>
				</a>
			</div>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
</html>