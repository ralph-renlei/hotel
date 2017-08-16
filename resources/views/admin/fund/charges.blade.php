@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					充值列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/fund/charge') }}" method="get">
							<div class="form-group">
								<label class="label_left">关键词</label>
								<input  class="form-control" id="keyword" name="keyword" placeholder="请输入订单号或者商品名"/>
							</div>
							<button type="submit" class="btn btn-default search_bottom">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">编号</th>
								<th class="info">订单状态</th>
								<th class="info">支付状态</th>
                                <th class="info">金额</th>
								<th class="info">姓名</th>
                                <th class="info">手机</th>
								<th class="info" style="width:10%">下单时间</th>
                                <th class="info" style="width:10%">支付时间</th>
							</tr>
							@foreach($lists as $item)
							<tr>
                                <td>{{ $item->out_trade_no }}</td>
                                <td>
                                    @if($item->order_status==0)
                                        新订单
                                    @elseif($item->order_status==1)
                                        已支付
                                    @else
                                        未通过
                                    @endif
                                </td>
                                <td>
                                    @if($item->pay_status==0)
                                        未付款
                                    @elseif($item->pay_status==1)
                                        已付款
                                    @endif
                                </td>
                                <td>{{ $item->pay_fee }}</td>
                                <td>{{ $item->uname }}</td>
                                <td>{{ $item->mobile }}</td>
							    <td>{{  $item->add_time }}</td>
                                <td>@if($item->pay_time){{  $item->pay_time }}@endif</td>
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
