@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房态列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/shop/status') }}" method="get">
							<div class="form-group">
								<label class="label_left">查看近期房态变化</label>
								<select class="form-control" name="start">
									@foreach($time_array as $time)
										<option value="{{$time}}" @if($time == $keywords) selected @endif/>{{$time}}</option>
									@endforeach
								</select>
							</div>
							<button type="submit" class="btn btn-default search_bottom">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							@foreach($goods as $item)
							<div class="out" style="width: 200px;height: 100px;float: left;position:relative;border: 3px solid #C9C9C9;background-color: @if($item->room_status == '已预定') red @else #7cfc00 @endif" data_status="{{$item->room_status}}">
								{{ $item->name }} {{ $item->category['name'] }}
								@if($item->room_status == '已预定') <button type="button" class="btn btn-default btn-sm" disabled style="position: absolute;top: 50px;left: 110px;">客房已满</button>
								@else <a href="{{ url('/admin/order/loadarrange/'.$item->goods_id) }}"><button type="button" class="btn btn-default btn-sm" style="position: absolute;top: 50px;left: 110px;">安排入住</button></a> @endif
								
								@if($item->order_info!="")
									<div style="display:none;position:absolute;top:20px;left:20px;z-index:1000;width:280px;height:150px;background-color:#ccc;opacity:0.9;border-radius:3px;">
										<p style="margin:5px">
											预订人：{{$item->order_info->username}}&nbsp;&nbsp;电话：{{$item->order_info->phone}}<br>
											预订渠道：@if($item->order_info->forms==1)线上预定@elseif($item->order_info->forms)线下预定@else前台预定@endif<br>
											房间类型：{{$item->order_info->category_name}}&nbsp;&nbsp;房间名称：{{$item->order_info->goods_name}}&nbsp;&nbsp;<br>
											订单金额：{{$item->order_info->order_amount}}<br>
											入住时间：{{$item->order_info->start}}<br>
											离店时间：{{$item->order_info->end}}
										</p>
									</div>
								@endif
							</div>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script>
		$('select[name=status_change]').each(function(){
			$(this).change(function(){
				var id = $(this).attr('id');
				var status = $(this).val();
				$.post('/admin/shop/goods/item',{id:id,field:'status',val:status},function(result){
					if(result.code==1){
						setTimeout(function(){
							window.location.reload();
						},500);
					}else{
						alert(result.msg);
					}
				},'json').error(function(jqXHR,textStatus, errorThrown){
					alert(errorThrown);
				});
			});
		});

		$(function(){
			$('.out').each(function(){
				if($(this).attr('data_status')=='已预定'){
					$(this).mousemove(function(){
							$(this).find('div:eq(0)').css('display','block');
					});
					$(this).mouseout(function(){
						if($(this).attr('data_status')=='已预定'){
							$(this).find('div:eq(0)').css('display','none');
						}
					});
				}
			});
		})
		
	</script>

@endsection
