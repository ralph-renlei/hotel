@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">商品列表
					&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/shop/goods/create') }}">添加</a>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">货号</th>
								<th class="info">名称</th>
								<th class="info">售价</th>
								<th class="info">审核</th>
								<th class="info">状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach($goods as $item)
							<tr>
							<td>{{ $item->goods_id }}</td>
							<td>{{ $item->goods_sn }}</td>
							<td>{{ $item->name }}</td>
							<td>
								{{ $item->productprice }}
							</td>
								<td>
									@if($item->audited==1)
										<span class="btn btn-success">通过</span>
									@elseif($item->audited==0)
										<span class="btn btn-danger">禁用</span>
									@endif
								</td>
							<td>
								@if($item->status==1)
									<span class="btn btn-success">上架</span>
								@elseif($item->status==0)
									<span class="btn btn-danger">下架</span>
								@endif
							</td>
							<td>
								@if($item->status ==0)
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('status','{{ $item->goods_id }}',1)">上架</button>
								@else
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('status','{{ $item->goods_id }}',0)">下架</button>
								@endif
								@if($item->audited ==0)
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('audited','{{ $item->goods_id }}',1)">通过</button>
								@else
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('audited','{{ $item->goods_id }}',0)">禁用</button>
								@endif
								<a href="{{ url('/admin/shop/goods/show/'.$item->goods_id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
								<button type="button" class="btn btn-default btn-sm" onclick="app.goods.del('{{ $item->goods_id }}')">删除</button>
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
</div>
@endsection
