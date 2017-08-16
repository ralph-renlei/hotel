<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>商品详情页</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/swiper.min.css')}}"/>
	</head>

	<body>
		<div id="good_detail_mask"></div>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
		</header>
		<div class="goods_top">
			<img src="{{$goods->thumb}}" />
			<p id="goods_id" style="display: none">{{$goods->goods_id}}</p>
			<p class="now_money">￥<span class="money">{{$goods->productprice}}</span></p>
			<p class="old_money">门市价：{{$goods->marketprice}}</p>
			<p class="good_name">{{$goods->name}}</p>
		</div>
		<div class="goods_middle">
			<p class="pay_num">可分期期数
				@if($stages)
					@foreach($stages as $stage)
						<span>{{$stage->num}}期</span>
					@endforeach
				@endif
			</p>
			<div class="good_detail">
				<p>{!!$goods->content!!}</p>
			</div>
		</div>
		<div class="toggle_wrap">
			<div class="clearfix">
				<div class="left toggle_img_wrap">
					<img src="{{$goods->thumb}}" class="toggle_img" />
				</div>
				<div class="right goods_info">
					<p class="grey_text">{{$goods->name}}</p>
					<p class="now_money">￥<span>{{$goods->productprice}}</span></p>
				</div>
			</div>
			<p class="describe">选择分期数</p>
			<div class="stage amor_wrap">
				@if($stages)
					@for($i=0;$i<count($stages);$i++)
						@if($i==0)
							<p class="amor_cell current_amor">{{$stages[$i]->num}}期</p>
						@else
							<p class="amor_cell">{{$stages[$i]->num}}期</p>
						@endif
					@endfor
				@endif
			</div>
		</div>
		<div class="good_bottom fixed_wrap">
			<p>月还款金额:
				<span>￥</span>
				<span class="pay_money">{{$money}}</span>
				<span class="interest_text"></span>
				手续费:<span class="service">￥{{$serviceCharge}}</span>

			</p>
			<p id="apply_stage">我要申请分期</p> 
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script>
		$().ready(function(){
		})
	</script>
</html>