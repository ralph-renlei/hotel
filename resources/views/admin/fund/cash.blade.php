@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					提现列表
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
                                <th class="info">UID</th>
								<th class="info">消费者</th>
								<th class="info">金额</th>
								<th class="info">状态</th>
                                <th class="info">方式</th>
								<th class="info" style="width:10%">申请时间</th>
								<th class="info" style="width:20%">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
							<td>{{ $item->id }}</td>
							<td>{{ $item->uid }}</td>
							<td>{{ $item->uname }}</td>
							<td>{{ $item->money }}</td>
							<td>@if($item->status == 1)
									<span class="btn btn-success">已通过</span>
								@elseif($item->status == 0)
									<span class="btn btn-default">待审核</span>
                                @elseif($item->status == -1)
                                    <span class="btn btn-default">已驳回</span>
                                @endif
							</td>
                                <td>@if((int)$item->way == 1)
                                        企业付款
                                    @elseif((int)$item->way == 2)
                                        企业红包
                                    @elseif((int)$item->way == 3)
                                        个人红包
                                    @else
                                        未审核
                                    @endif
                                </td>
							<td>{{ $item->created_at }}</td>
							<td>
								<a href="{{ url('/admin/fund/cash/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
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
