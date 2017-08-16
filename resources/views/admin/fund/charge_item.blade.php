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
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/fund/charge') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group order">
									<label class="col-sm-4 ">订单状</label>
                                    <div class="col-md-6">
                                        <label class="radio-inline user_role">
                                            <input type="radio" name="order_status" id="order_status1" value="0" @if($item->order_status==0)checked="checked"@endif/>
                                            新订单
                                        </label>
                                        <label class="radio-inline user_role">
                                            <input type="radio" name="order_status" id="order_status2" value="1" @if($item->order_status==1)checked="checked"@endif/>
                                            已处理
                                        </label>
                                        <label class="radio-inline user_role">
                                            <input type="radio" name="order_status" id="order_status3" value="2" @if($item->order_status==2)checked="checked"@endif/>
                                            已完成
                                        </label>
                                    </div>
								</div>

								<div class="form-group order">
									<label class="col-sm-4 ">支付状态</label>
                                    <div class="col-md-6">
                                        <label class="radio-inline user_role">
                                            <input type="radio" name="pay_status" id="pay_status1" value="0" @if($item->pay_status==0)checked="checked"@endif/>
                                            未付款
                                        </label>
                                        <label>
                                            <input type="radio" name="pay_status" id="pay_status2" value="1" @if($item->pay_status==1)checked="checked"@endif/>
                                                已付款
                                        </label>
                                    </div>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">支付金额</label>
                                    <div class="col-md-6">
                                        <label>{{ $order->pay_fee }}</label>
                                    </div>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">下单时间</label>
                                    <div class="col-md-6">
                                        <label>{{date('Y-m-d H:i:s',$order->add_time)}}</label>
                                    </div>
								</div>
								<div class="form-group order">
									<label class="col-sm-4 ">支付时间</label>
                                    <div class="col-md-6">
                                        <label>{{$order->pay_time}}</label>
                                    </div>
								</div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <button type="submit" class="btn btn-primary">保存</button>
                                    </div>
                                </div>
							</form>
					</div>
					<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
@endsection
