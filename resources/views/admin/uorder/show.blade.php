@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">会员卡订单</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/order/store') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">会员卡<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="card_name" id="card_name" value="{{ $item->card_name }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">应付金额<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="number" class="form-control" name="pay_fee" id="pay_fee" value="{{ $item->pay_fee }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">实付金额<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="number" class="form-control" name="money_paid" id="money_paid" value="{{ $item->money_paid }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="uname" id="uname" value="{{ $item->uname }}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="mobile" id="mobile" value="{{ $item->mobile }}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">付款<span style="color:red">*</span></label>
							<div class="col-md-6">
								<label class="radio-inline">
									<input type="radio" name="status" id="pay_status1" value="0" @if($item->pay_status==0)checked="checked"@endif/>
									待付款
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="pay_status2" value="1" @if($item->pay_status==1)checked="checked"@endif/>
									已付款
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">状态<span style="color:red">*</span></label>
							<div class="col-md-6">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1" @if($item->status==1)checked="checked"@endif/>
									待付款
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="2" @if($item->status==2)checked="checked"@endif/>
									待发货
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status3" value="3" @if($item->status==3)checked="checked"@endif/>
									已发货
								</label>
							</div>
						</div>
						<div class="form-group">
						</div>
					</form>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
@endsection
