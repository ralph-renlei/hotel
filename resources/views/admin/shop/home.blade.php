@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					商家列表
					&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/shop/create') }}">添加</a>
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/shop') }}" method="get">
							<div class="form-group">
								<label class="label_left">关键词</label>
								<input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入名字" @if(isset($keyword))value="{{ $keyword }}"@endif/>
							</div>
							<button type="submit" class="btn btn-default search_bottom">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info" style="width:14%">名称</th>
								<th class="info">返现</th>
								<th class="info">联系人</th>
								<th class="info">电话</th>
								<th class="info" style="width:14%">地址</th>
								<th class="info" style="width:5%">状态</th>
								<th class="info" style="width:10%">添加时间</th>
								<th class="info" style="width:20%">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
							<td>{{ $item->id }}</td>
							<td>{{ $item->store_name }}</td>
							<td>{{ $item->cash }}</td>
							<td>{{ $item->contacter }}</td>
							<td>{{ $item->mobile }}</td>
							<td>{{ $item->address }}</td>
							<td>@if ($item->status == 1)
									<span class="btn btn-success">启用</span>
								@else
									<span class="btn btn-danger">禁用</span>
								@endif</td>
							<td>
								{{ $item->created_at }}
							</td>
							<td>
								@if($item->status ==0)
									<button type="button" class="btn btn-default btn-sm" onclick="app.shop.audit('{{ $item->id }}',1)">启用</button>
								@else
									<button type="button" class="btn btn-default btn-sm" onclick="app.shop.audit('{{ $item->id }}',0)">禁用</button>
								@endif
								<a href="{{ url('/admin/shop/show/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
									<button type="button" class="btn btn-default btn-sm" onclick="app.shop.del('{{ $item->id }}')">删除</button>
							</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
					{!! $lists->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
