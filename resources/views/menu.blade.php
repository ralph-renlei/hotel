<div class="col-md-2 sidebar">
    <ul class="nav nav-sidebar active" id="home_menu">
        <li class="active"><a href="{{ url('/admin') }}">后台首页</a></li>
    </ul>
    <ul class="nav nav-sidebar" id="shop_menu" style="display: none">
		<li><a href="{{ url('/admin/shop/cate') }}">房型管理</a></li>
	    <li><a href="{{ url('/admin/shop/goods') }}">房间管理</a></li>
	    <li><a href="{{ url('/admin/shop/price') }}">房价管理</a></li>
	    <li><a href="{{ url('/admin/shop/status') }}">房态管理</a></li>
	    <li><a href="{{ url('/admin/shop/power_count') }}">电量统计</a></li>
    </ul>
	<ul class="nav nav-sidebar" id="order_menu" style="display: none">
	    <li><a href="{{ url('/admin/order/home') }}">订单列表</a></li>
	    <li><a href="{{ url('/admin/order/refundrecord') }}">退款记录</a></li>
	    {{--<li><a href="{{ url('/admin/order/charge') }}">充值列表</a></li>--}}
	    {{--<li><a href="{{ url('/admin/order/user') }}">用户资金</a></li>--}}
	    {{--<li><a href="{{ url('/admin/order/money') }}">资金流水</a></li>--}}
    </ul>
	<ul class="nav nav-sidebar" id="user_menu" style="display: none">
	    {{--<li><a href="{{ url('/admin/user/member') }}">消费者</a></li>--}}
	    <li><a href="{{ url('/admin/user/verify') }}">用户管理</a></li>
	    {{--<li><a href="{{ url('/admin/user/store') }}">商家</a></li>--}}
	    {{--<li><a href="{{ url('/admin/user/admin') }}">管理员</a></li>--}}
	    {{--<li><a href="{{ url('/admin/user/account') }}">账户资料</a></li>--}}
    </ul>
	{{--<ul class="nav nav-sidebar" id="system_menu" style="display:none">--}}
        {{--<li><a href="{{ url('/admin/system/banner') }}">首页BANNER</a></li>--}}
        {{--<li><a href="{{ url('/admin/system/config') }}">系统配置</a></li>--}}
    {{--</ul>--}}
</div>