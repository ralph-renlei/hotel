@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">详情</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>对不起，有错误发生！</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<div class="col-md-offset-1">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active" onclick="app.house.nav_tab('order')" id="order_li"><a href="javascript:void(0)">订单信息</a></li>
							<li role="presentation" onclick="app.house.nav_tab('goods')" id="goods_li"><a href="javascript:void(0)">商品详情</a></li>
							<li role="presentation" onclick="app.house.nav_tab('user')" id="user_li"><a href="javascript:void(0)">买家详情</a></li>
						</ul>
					</div>
					<div style="margin-top:15px;">
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/fund') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group order">
									<label class="col-sm-4 ">订单编号<span>:&nbsp;&nbsp;{{$order->order_sn}}</span></label>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">订单状态<span>:&nbsp;&nbsp;
											@if($order->order_status==0)
												新订单
											@elseif($order->order_status==1)
												已处理
											@elseif($order->order_status==2)
												已发货
											@elseif($order->order_status==3)
												已收货
											@elseif($order->order_status==4)
												已完成
											@endif</span></label>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">支付状态
                                        <span>:&nbsp;&nbsp;
											@if($order->pay_status==0)
												未付款
											@elseif($order->pay_status==1)
												已付款
											@endif
								        </span>
                                    </label>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">支付金额
                                        <span>:&nbsp;&nbsp;{{$order->pay_fee}}</span>
                                    </label>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">下单时间
                                        <span>:&nbsp;&nbsp;
											{{$order->add_time}}
										</span>
                                    </label>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">支付时间
                                        <span>:&nbsp;&nbsp;
											@if(empty($order->pay_time))
												未支付
											@else
												{{$order->pay_time}}
											@endif
										</span>
                                    </label>
								</div>
							<div class="table-responsive form-group goods">
								<table class="table">
									<tr>
										<th class="info">编号</th>
										<th class="info">商品名</th>
										<th class="info">店铺名</th>
										<th class="info">单价</th>
										<th class="info">数量</th>
										<th class="info">总价</th>
										<th class="info">样式</th>
										<th class="info" style="width:5%">操作</th>
									</tr>
									@foreach($goods as $item)
										<tr>
											<td>{{ $item->goods_sn }}</td>
											<td>{{ $item->goods_name }}</td>
											<td>{{ $item->store_name }}</td>
											<td>{{ $item->goods_price }}</td>
											<td>{{ $item->goods_number }}</td>
											<td>{{ $item->goods_price * $item->goods_number}}</td>
											<td>{{ $item->goods_attr }}</td>
											<td class="do">
												<a href="{{ url('/admin/shop/goods/show/'.$item->goods_id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
											</td>
										</tr>
									@endforeach
								</table>
							</div>
                                <div class="form-group user">
                                    <label class="col-sm-4 ">用户名<span>:&nbsp;&nbsp;{{$user->username}}</span></label>
                                    <label class="col-sm-4 ">姓名<span>:&nbsp;&nbsp;{{$user->name}}</span></label>
                                </div>
								<div class="form-group user">
									<label class="col-sm-4 ">电话<span>:&nbsp;&nbsp;{{$address->mobile}}</span></label>
									<label class="col-sm-4 ">邮箱<span>:&nbsp;&nbsp;{{$address->email}}</span></label>
								</div>
								<div class="form-group user">
									<label class="col-sm-4 ">位置<span>:&nbsp;&nbsp;{{$address->province}}{{$address->city}}{{$address->area}}</span></label>
									<label class="col-sm-4 ">详细地址<span>:&nbsp;&nbsp;{{$address->address}}</span></label>
								</div>
							</form>
					</div>
					<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
@endsection
