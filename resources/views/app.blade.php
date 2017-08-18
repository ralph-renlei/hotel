<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>{{ env('APP_NAME') }}</title>
	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
	<link href="{{ asset('/js/layui/css/layui.css') }}" rel="stylesheet">
	<script src="{{ asset('/js/jquery.min.js') }}"></script>
	<!--[if lt IE 9]>
		<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand">{{ env('APP_ALIAS') }}</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if (!Auth::guest())
					<li id="home"><a href="{{ url('/admin') }}">管理中心</a></li>
					<li id="shop"><a href="{{ url('/admin/shop/goods') }}">房间管理</a></li>
                    <li id="fund" ><a href="{{ url('/admin/order') }}">交易管理</a></li>
                    <li id="user" ><a href="{{ url('/admin/user') }}">用户管理</a></li>
					<li id="system"><a href="{{ url('/admin/system/config') }}">系统配置</a></li>
					@endif
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/admin/auth/login') }}">登录</a></li>
						<li><a href="{{ url('/admin/auth/register') }}">注册</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/admin/user/account') }}">个人资料</a></li>
								<li><a href="{{ url('/admin/auth/logout') }}">退出</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
	@yield('content')
	<script>
		var MODULE = {
			home:"{{ url('/admin') }}",
			system:"{{ url('/admin/system')}}",
			shop:"{{ url('/admin/shop') }}",
			user:"{{ url('/admin/user') }}",
            order:"{{ url('/admin/order') }}",
		};
		var SITE = "{{ url('/admin') }}";
		var STATIC = "{{ asset('/js') }}";
	</script>

	<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/js/layui/layui.js') }}"></script>
	<script src="{{ asset('/js/viewer-jquery.min.js') }}"></script>
	<script src="{{ asset('/js/app.js') }}"></script>
	<script src="{{ asset('/js/qqmap.js') }}"></script>
	<script src="{{ asset('/js/shop.js') }}"></script>
	<script src="{{ asset('/js/My97DatePicker/WdatePicker.js') }}"></script>
</body>
</html>
