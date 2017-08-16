@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					会员卡订单列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/user/order') }}" method="get">
							<div class="form-group">
								<label for="exampleInputName2">关键词</label>
								<input type="number" class="form-control" id="keyword" name="keyword" placeholder="请输入订单号或者手机号码"/>
							</div>
							<button type="submit" class="btn btn-default">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">会员卡</th>
								<th class="info">已付金额</th>
								<th class="info">状态</th>
								<th class="info">会员姓名</th>
								<th class="info">会员手机</th>
								<th class="info" style="width:10%">创建时间</th>
								<th class="info" style="width:10%">支付时间</th>
								<th class="info" style="width:5%">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
							<td>{{ $item->order_id }}</td>
							<td>{{ $item->card_name }}</td>
							<td>￥{{ $item->pay_fee }}</td>
							<td>
								@if($item->order_status==0)
									<span class="btn btn-default">待付款</span>
								@elseif($item->order_status==1)
									<span class="btn btn-success">已付款</span>
								@endif
							</td>
							<td>{{ $item->uname }}</td>
							<td>{{ $item->mobile }}</td>
							<td>{{ date('Y-m-d H:i:s',$item->add_time) }}</td>
							<td>@if(!empty($item->pay_time)){{ date('Y-m-d H:i:s',$item->pay_time) }}@endif</td>
							<td>
								<a href="{{ url('/admin/user/order/'.$item->order_id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
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
