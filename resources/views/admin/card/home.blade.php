@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">会员卡列表
					&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/user/card/create') }}">添加</a>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">名称</th>
								<th class="info">优惠</th>
								<th class="info">售价</th>
								<th class="info">月数</th>
								<th class="info">状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
							<td>{{ $item->id }}</td>
							<td>{{ $item->name }}</td>
							<th class="info">
								@if($item->promote==1)
									 √
								@else
									 ×
								@endif
							</th>
							<td>
								@if($item->promote ==1)
									{{ $item->promote_money }}
								@else
									{{ $item->money }}
								@endif
							</td>
								<td>
								@if($item->promote ==1)
									{{ $item->promote_months }}
								@else
									{{ $item->months }}
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
									<button type="button" class="btn btn-default btn-sm" onclick="app.card.status('{{ $item->id }}',1)">上架</button>
								@else
									<button type="button" class="btn btn-default btn-sm" onclick="app.card.status('{{ $item->id }}',0)">下架</button>
								@endif
								<a href="{{ url('/admin/user/card/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
									<a href="{{ url('/admin/user/promote/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">优惠</button></a>
									<button type="button" class="btn btn-default btn-sm" onclick="app.card.del('{{ $item->id }}')">删除</button>
							</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
