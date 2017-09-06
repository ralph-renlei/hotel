@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">消费者管理</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">昵称</th>
                                <th class="info">姓名</th>
								<th class="info">手机</th>
                                <th class="info">认证</th>
                                <th class="info">添加时间</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($lists as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->nickname }}</td>
                                    <td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->mobile }}</td>
                                    <td class="data">
                                        @if ($item->verify == 1)
                                            <span class="btn btn-success">是</span>
                                        @else
                                            <span class="btn btn-danger">否</span>
                                        @endif
                                    </td>
                                    <td class="data">{{ $item->created_at }}</td>
									<td class="do">
										<a href="{{ url('/admin/user/user/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">修改</button></a>
                                        <button type="button" class="btn btn-default btn-sm" onclick="app.user.del('{{ $item->id }}')">删除</button>
                                        <button type="button" class="btn btn-default btn-sm" onclick="app.user.del('{{ $item->id }}')">详情</button>
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
