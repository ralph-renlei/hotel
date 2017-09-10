@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房间列表
					&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/shop/goods/create') }}">添加</a>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">房间名称（编号）</th>
								<th class="info">房间类型</th>
								<th class="info">开关房</th>
								<th class="info">当前状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach($goods as $item)
							<tr>
							<td>{{ $item->goods_id }}</td>
							<td>{{ $item->name }}</td>
							<td>{{ $item->category['name'] }}</td>
							<td>
								@if($item->open==1)
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('open','{{ $item->goods_id }}',0)" title="点击关房">开房</button>
								@else
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('open','{{ $item->goods_id }}',1)" title="点击开房">关房</button>
								@endif
							</td>
							<td>
								@if($item->open==1)
									<select class="form-control" name="status_change" id="{{$item->goods_id}}">
										<option value="1" @if($item->status==1) selected @endif>无人入住</option>
										<option value="0" @if($item->status==0) selected @endif>有人入住</option>
										<option value="-1"  @if($item->status==-1) selected @endif>维护中</option>
									</select>
								@else
									关房不可入住
								@endif
							</td>
							<td>
								<a href="{{ url('/admin/shop/goods/show/'.$item->goods_id) }}"><button type="button" class="btn btn-default btn-sm">修改</button></a>
								<button type="button" class="btn btn-default btn-sm" onclick="app.goods.del('{{ $item->goods_id }}')">删除</button>
								@if(!$item->qrcode)
								<a href="/admin/shop/goods/qrcode/{{$item->goods_id}}". ><button type="button" class="btn btn-default btn-sm">生成二维码</button></a>
								@else
								<a href="/admin/shop/goods/show_qrcode/{{$item->goods_id}}". ><button type="button" class="btn btn-default btn-sm">查看二维码</button></a>
								@endif
							</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
					{!! $goods->render() !!}
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
	</script>

@endsection
