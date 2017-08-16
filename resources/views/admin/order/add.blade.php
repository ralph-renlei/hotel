@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">下单</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/shop/order/add') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">商品<span style="color:red">*</span></label>
							<div class="col-md-6">
								<select class="form-control" id="goods_id" name="goods_id">
									@foreach($list as $goods)
									<option value="{{ $goods->goods_id }}">{{ $goods->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">个数<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="number" class="form-control" name="goods_amount" id="goods_amount" placeholder="请输入个数"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="username" id="username" placeholder="请输入姓名"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="mobile" id="mobile" placeholder="请输入手机号码"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">OpenID<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="openid" id="openid" placeholder="请输入OpenID"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">状态<span style="color:red">*</span></label>
							<div class="col-md-6">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="0" checked="checked"/>
									新订单
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="1" />
									已处理
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status3" value="2"/>
									已发货
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status4" value="3"/>
									已收货
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status3" value="4"/>
									已完成
								</label>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">保存</button>
							</div>
						</div>
					</form>
				</div>
				<div class="panel-footer">

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
