@if(isset($list))
	@foreach($list as $goods)
	<a href="{{ url('goods/'.$goods->goods_id)}}">
		<img src="{{$goods->thumb}}" />
		<p class="name">{{$goods->name}}</p>
		<div class="list_goods_momey clearfix">
			<p class="left">￥<span>{{$goods->productprice}}</span></p>
			<div class="see right clearfix">
				<i class="iconfont icon-xiayibu right"></i>
				<span class="right">立即查看</span>
			</div>
		</div>
	</a>
	@endforeach
@endif