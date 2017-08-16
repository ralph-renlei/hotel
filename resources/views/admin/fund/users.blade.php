@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">用户管理</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
                                <th class="info">姓名</th>
								<th class="info">手机</th>
                                <th class="info">资金</th>
								<th class="info">注册时间</th>
                                <th class="info">操作</th>
							</tr>
							@foreach ($lists as $item)
								<tr>
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->name }}</td>
                                    <td class="data">{{ $item->mobile }}</td>
                                    <td class="data">{{ $item->money }}</td>
									<td class="data">{{ $item->created_at }}</td>
									<td class="do">
										<a href="{{ url('/admin/fund/money/'.$item->id) }}">
                                            <button type="button" class="btn btn-default btn-sm">资金记录</button>
                                        </a>
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
