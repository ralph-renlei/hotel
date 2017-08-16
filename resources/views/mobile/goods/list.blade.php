<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>商品列表</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/swiper.min.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/dropload.css')}}"/>
	</head>
	<body style="background: #fff;">
		<header class="clearfix">			
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
			<div class="search">
				<input type="text" placeholder="请输入关键字" name="keyword" id="keyword"/>
				<span><i class="iconfont icon-search" id="icon_search"></i></span>
			</div>
		</header>
		<div id="wrapper">
		<ul id="thelist" class="inner list_wrap">
			@include('mobile.goods._list')
		</ul>
			</div>
		<span id='type' hidden="true">{{$type}}</span>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/dropload.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var page=0;
		$.ajax({
			type: 'POST',
			url: '/goods/type',
			dataType: 'json',
			data: {
				page: page,
				type:$("#type").html(),
				key:$("#keyword").val()
			},
			success: function(res) {
				document.getElementById('thelist').innerHTML=res.data.html;
				if(!res.data.html){
				}
				$(".dropload-down").remove();
			}
		});
		var dropload = $('.inner').dropload({
//			domDown : {
//				domClass   : 'dropload-down',
//				domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
//				domUpdate  : '<div class="dropload-update">↓释放加载</div>',
//				domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
//			},
			scrollArea: window,
			loadDownFn : function(me){
				$.ajax({
					type: 'POST',
					url: '/goods/type',
					dataType: 'json',
					data: {
						page: ++page,
						type:$("#type").html(),
						key:$("#keyword").val()
					},
					success: function(res) {
						document.getElementById('thelist').innerHTML+=res.data.html;
						if(!res.data.html){
							alert('没有更多的数据了')
						}
						me.resetload();
					},
					error: function(xhr, type) {
					}

				});
				me.resetload();
			}
		});
		$("#icon_search").bind("click", function(){
			page=0;
			$.ajax({
				type: 'POST',
				url: '/goods/type',
				dataType: 'json',
				data: {
					page: page,
					type:$("#type").html(),
					key:$("#keyword").val()
				},
				success: function(res) {
					document.getElementById('thelist').innerHTML=res.data.html;
					if(!res.data.html){
					}
					$(".dropload-down").remove();
				}
			});
		})
		$('#keyword').bind('keypress', function(event) {   //回车事件绑定
			if (event.keyCode == "13") {  //js监测到为为回车事件时 触发
				page=0;
				$.ajax({
					type: 'POST',
					url: '/goods/type',
					dataType: 'json',
					data: {
						page: page,
						type:$("#type").html(),
						key:$("#keyword").val()
					},
					success: function(res) {
						document.getElementById('thelist').innerHTML=res.data.html;
						if(!res.data.html){
						}
						$(".dropload-down").remove();
					}
				});
			}
		})
	</script>
</html>
