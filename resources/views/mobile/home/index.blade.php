<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>首页</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/swiper.min.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/dropload.css')}}"/>
	</head>
	<body>
		<div class="whole">
			<div class="swiper-container">
				<div class="swiper-wrapper">
					<div class="swiper-slide"><img src="{{ asset('img/banner.png') }}" /></div>
					<div class="swiper-slide"><img src="{{ asset('img/banner.png') }}" /></div>
					<div class="swiper-slide"><img src="{{ asset('img/banner.png') }}" /></div>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<div class="menu">
				<div class="classify classify_first">
					<a class="classbox" href="{{url('goods/type/travel')}}">
						<i class="iconfont icon-lvyou"></i>
						<span>旅游</span>
					</a>
					<a class="classbox" href="{{ url('goods/type/beauty')}}">
						<i class="iconfont icon-weiyizhengxing-zhengxingwaikezhongxin-01"></i>
						<span>医美</span>
					</a>
					<a class="classbox" href="{{ url('goods/type/train')}}">
						<i class="iconfont icon-peixun-copy"></i>
						<span>培训</span>
					</a>
				</div>
				<span id="line"></span>
				<div class="classify classify_second">
					<a class="classbox" href="{{ url('goods/type/fit')}}">
						<i class="iconfont icon-jianshenzhongxin"></i>
						<span>健身</span>
					</a>
					<a class="classbox" href="{{ url('goods/type/3c')}}">
						<i class="iconfont icon-shuma"></i>
						<span>3C</span>
					</a>
					<a class="classbox" href="{{ url('goods/type/other')}}">
						<i class="iconfont icon-xueke-qita"></i>
						<span>其他</span>
					</a>
				</div>
			</div>
			<div id="wrapper">
				<div id="scroller" class="inner">
					<ul id="thelist" class="home_wrap" style="margin-bottom: 50px;">
						@include('mobile.home._index')
					</ul>
				</div>
			</div>

			<!--tabbar-->
			<div class="tabbar">
				<a href="{{ url('/')}}">
					<div style="color: #e20795;">
						<i class="iconfont icon-shouyeshouye"></i>
						<p>首页</p>
					</div>
				</a>
				<a href="{{ url('/user')}}">
					<div>
						<i class="iconfont icon-gerenzhongxin"></i>
						<p>个人中心</p>
					</div>
				</a>
			</div>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/swiper.jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/dropload.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		// 轮播图
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			paginationClickable: true,
//			autoplay: 1000,
			loop: true
		});
		var page=0;
		$.ajax({
			type: 'POST',
			url: '/index',
			dataType: 'json',
			data: {
				page: page,
			},
			success: function(res) {
				document.getElementById('thelist').innerHTML=res.data.html;
				if(!res.data.html){
				}
				$(".dropload-down").remove();
			}
		});
		var dropload = $('.inner').dropload({
			scrollArea: window,
			domDown : {
				domClass   : 'dropload-down',
				domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
				domUpdate  : '<div class="dropload-update">↓释放加载</div>',
				domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
			},
			loadDownFn : function(me){
				page++;
				$.ajax({
					type: 'POST',
					url: '/index',
					dataType: 'json',
					data: {
						page: page,
					},
					success: function(res) {
						document.getElementById('thelist').innerHTML+=res.data.html;
						if(!res.data.html){
							me.lock();
							alert('没有更多了')
						}
						me.resetload();
					},
					// 加载出错
					error: function(xhr, type) {
					}
				});
				me.resetload();
			}
		});
	</script>
</html>