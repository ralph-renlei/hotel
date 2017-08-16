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
								<div class="form-group goods">
									<label class="col-sm-5 ">商品名<span>:&nbsp;&nbsp;{{$goods->name}}</span></label>
								</div>
								<div class="form-group goods">
									<label class="col-sm-5 ">商品编号<span>:&nbsp;&nbsp;{{$goods->goods_sn}}</span></label>
								</div>
								<div class="form-group goods">

								</div>
                                <div class="form-group goods">
                                    <label class="col-sm-5">简介<span>:&nbsp;&nbsp;{{$goods->description}}</span></label>
                                </div>
                                <div class="form-group goods">
                                    <label class="col-sm-5 ">售价<span>:&nbsp;&nbsp;{{$goods->productprice}}</span></label>
                                </div>
                                <div class="form-group goods">
                                    <label class="col-sm-5 ">成本价<span>:&nbsp;&nbsp;{{$goods->costprice}}</span></label>
                                </div>
							</form>
					</div>
					<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
@endsection
