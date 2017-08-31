@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					订单列表 &nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="/admin/order/add">添加</a>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">订单id</th>
								<th class="info">姓名</th>
								<th class="info">电话</th>
                                <th class="info">房间类型</th>
                                <th class="info">实付金额</th>
								<th class="info">退款金额</th>
								<th class="info">退款时间</th>
							</tr>
								@foreach($list as $item)
								<tr>
									<td>{{$item->order_id}} </td>
									<td>{{ $item->username }}</td>
									<td>{{ $item->phone }}</td>
									<td>{{ $item->category_name }} @if($item->forms!=1) {{$item->goods_name}} @endif</td>
									<td>{{ $item->order_amount }}</td>
									<td>退款金额</td>
								</tr>
								@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
					{!! $list->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
