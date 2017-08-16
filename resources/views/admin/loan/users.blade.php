@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">认证用户</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">UID</th>
								<th class="info">姓名</th>
								<th class="info">手机</th>
                                <th class="info">邮箱</th>
                                <th class="info">身份证</th>
								<th class="info">身高/体重</th>
								<th class="info">时间</th>
								<th class="info">状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($lists as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->mobile }}</td>
									<td class="data">{{ $item->email }}</td>
                                    <td class="data">{{ $item->idcard_no }}</td>
                                    <td class="data">{{ $item->height }}cm/{{ $item->weight }}kg</td>
                                    <td class="data">{{ $item->audited_at }}</td>
									<td class="data">
										@if ($item->verify == 1)
											<span class="btn btn-success">已认证</span>
										@else
											<span class="btn btn-danger">未认证</span>
										@endif
									</td>
									<td class="do">
										<a href="{{ url('/admin/loan/identify/user/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">预览</button></a>
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
