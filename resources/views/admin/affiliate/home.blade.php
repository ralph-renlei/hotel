@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">用户管理&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('user/add') }}">新增</a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">用户名</th>
								<th class="info">手机号码</th>
								<th class="info">真实姓名</th>
								<th class="info">注册时间</th>
								<th class="info">状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($users as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->nickname }}</td>
									<td class="data">{{ $item->mobile }}</td>
									<td class="data">{{ $item->real_name }}</td>
									<td class="data">{{ $item->created_at }}</td>
									<td class="data">
										@if ($item->status == 1)
											<span class="btn btn-success">启用</span>
										@else
											<span class="btn btn-danger">禁用</span>
										@endif
									</td>
									<td class="do">
										<a href="{{ url('user/user/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">修改</button></a>
										<button type="button" class="btn btn-default btn-sm" onclick="app.user.del('{{ $item->id }}')">删除</button>
									</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
					{!! $users->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
