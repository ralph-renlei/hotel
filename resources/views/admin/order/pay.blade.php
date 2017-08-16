@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $item->goods_name }}放款</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/fund/pay') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">商品</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->goods_name }}</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">个数</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->goods_amount }}</label>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">金额</label>
                            <div class="col-md-6">
                                <label class="radio-inline">{{ $item->pay_fee }}</label>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $user->name }}</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $user->mobile }}</label>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">认证</label>
                            <div class="col-md-6">
                                @if($user->verify==1)
                                <label class="radio-inline">已认证</label>
                                @else
                                <label class="radio-inline">未认证</label>
                                @endif
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label">卖家</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->store_name }}</label>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">分期</label>
                            <div class="col-md-6 ">
                                <label class="radio-inline">{{ $loan->loan_num }}期</label>
                            </div>
                        </div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                                <input type="hidden" name="id" id="id" value="{{ $item->order_id }}"/>
                                <button type="submit" class="btn btn-primary">放款</button>
                                <a href="{{ url('admin/fund') }}"><button type="button" class="btn btn-primary">返回</button></a>
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
