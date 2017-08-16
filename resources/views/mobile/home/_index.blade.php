@if(isset($list))
	@foreach($list as $goods)
	<a href="{{ url('goods/'.$goods->goods_id)}}" class="goods_wrap">
		<img src="{{$goods->thumb}}" />
		<p class="name">{{$goods->name}}</p>
		<div class="goods_momey clearfix">
			<p>￥<span>{{$goods->productprice}}</span></p>
			<div class="see">
				<span>立即查看</span><span><i class="iconfont icon-xiayibu"></i></span>
			</div>
		</div>
	</a>
	@endforeach
@endif