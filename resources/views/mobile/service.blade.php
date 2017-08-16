<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>客服中心</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t=').time() }}" />
</head>
<body>
<div class="whole">
    <div class="panel">
        <img src="{{ asset('img/logo.jpg') }}"/>
    </div>
    <div class="contact">
        <div class="qq_cell clearfix">
            <i class="iconfont icon-QQ"></i>
            <span class="number">{{ $qq }}</span>
            <a class="service_btn" href="http://wpa.qq.com/msgrd?V=1&Uin={{ $qq }}&Menu=yes" target="_blank">在线咨询</a>
        </div>
        <span class="service_line"></span>
        <div class="phone_cell clearfix">
            <i class="iconfont icon-icon"></i>
            <span class="number">{{ $tel }}</span>
            <a href="tel:{{ $tel }}" class="service_btn">一键拨号</a>
        </div>
    </div>
</div>
<div class="tabbar">
    <a href="{{ url('index') }}">
        <i class="iconfont icon-shouyeshouye"></i>
        <p>首页</p>
    </a>
    <a href="{{ url('service') }}" class="current_page" style="color: #11b6f5;">
        <i class="iconfont icon-kefu"></i>
        <p>客服</p>
    </a>
</div>
</body>
<script src="{{ url('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/mobile.common.js?t='.time()) }}" type="text/javascript" charset="utf-8"></script>
</html>