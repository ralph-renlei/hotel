<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>{{ $store->store_name }}详情</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="{{ url('home') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">商家详情</span>
			</header>
			<div class="store_box">
				<!--上部分简介-->
				<div class="clearfix">
					<img src="{{ $store->logo }}" onerror="this.src='{{ asset('img/mid.png') }}'" class="store_smallimg"/>
					<div class="store_info">
						<span class="store_name">{{ $store->store_name }}</span>
						<div class="mobile_wrap clearfix">
							<i class="iconfont icon-zuojikong"></i>
							@if($store->telephone)
                            <p><a class="grey_text" href="tel:{{ $store->telephone }}">{{ $store->telephone }}</a></p>
                            @else
                             <p><a class="grey_text" href="tel:{{ $store->mobile }}">{{ $store->mobile }}</a></p>
                            @endif
						</div>
                        <a href="{{ url('map/'.$store->id) }}">
						<div class="address clearfix">
							<i class="iconfont icon-address"></i>
							<p class="grey_text">{{ $store->address }}</p>
						</div>
                        </a>
					</div>
				</div>
				<div class="store_introduce">
					<p>商家简介</p>
                    @if(isset($store->images) && is_array($store->images))
                        @foreach($store->images as $img)
					<img src="{{ $img }}" onerror="this.src='{{ asset('img/big.png') }}'"/>
                        @endforeach
                    @endif
				</div>
                @if($store->is_open)
                    @if($user->vip)
                    <a href="{{ url('consume/'.$store->id) }}"><p class="consumed btn red_btn">我已消费，获取消费返现</p></a>
                    @else
                        <a href="{{ url('vip') }}"><p class="consumed btn red_btn">对不起您还没有会员卡，点击充值</p></a>
                    @endif
                @endif
			</div>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/mobile.common.js?t='.time()) }}" type="text/javascript" charset="utf-8"></script>
</html>