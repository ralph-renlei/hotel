@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					订单列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/fund') }}" method="get">
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
								<th class="info">状态</th>
                                <th class="info">金额</th>
								<th class="info">姓名</th>
                                <th class="info">手机</th>
								<th class="info">支付时间</th>
								<th class="info" style="width:8%">下单时间</th>
								<th class="info" style="width:5%">操作</th>
							</tr>
							@foreach($list as $item)
							<tr>
                                <td>{{ $item->order_sn }}</td>
                                <td>
                                    @if($item->order_status==0)
                                        待付款
                                    @elseif($item->order_status==1)
                                        已付款
                                    @elseif($item->order_status==2)
                                        待发货
									@elseif($item->order_status==3)
										已发货
									@elseif($item->order_status==4)
										已签收
									@elseif($item->order_status==5)
										待评价
									@elseif($item->order_status==6)
										完成
									@elseif($item->order_status==7)
										取消
                                    @endif
                                </td>
							    <td>{{ $item->pay_fee }}</td>
                                <td>{{ $item->uname }}</td>
                                <td>{{ $item->mobile }}</td>
								<td>{{ date('Y-m-d m:i:s ',$item->pay_time) }}</td>
							    <td>{{ $item->add_time }}</td>
							    <td class="do">
									<a href="{{ url('/admin/fund/order/'.$item->order_id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
                                </td>
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
