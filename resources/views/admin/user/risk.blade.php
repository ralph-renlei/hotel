@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					分控员管理
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">姓名</th>
								<th class="info">手机</th>
                                <th class="info">级别</th>
                                <th class="info">状态</th>
								<th class="info">时间</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($lists as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->mobile }}</td>
                                    <td class="data">
                                        @if ($item->level == 1)
                                            上门核查员
                                        @elseif ($item->level == 2)
                                            内网风控员
                                        @elseif ($item->level == 3)
                                            渠道风控员
                                        @endif
                                    </td>
                                    <td class="data">
                                        @if ($item->status == 1)
                                            <span class="btn btn-success">启用</span>
                                        @else
                                            <span class="btn btn-danger">禁用</span>
                                        @endif
                                    </td>
									<td class="data">{{ $item->created_at }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" onclick="app.user.del('{{ $item->id }}')">删除</button>
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
