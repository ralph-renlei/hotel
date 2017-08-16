@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">个人资料</div>
				<div class="panel-body">
					@if(count($errors) > 0)
						<div class="alert alert-danger">
							<strong>对不起，有错误发生！</strong><br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/account') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">用户名</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" placeholder="请输入您的用户名"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" placeholder="请输入您的姓名"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">邮箱</label>
							<div class="col-md-6">
								<input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" placeholder="请输入您的邮箱"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机</label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="mobile" id="mobile" value="{{ $user->mobile }}" placeholder="请输入您的手机号码"/>
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
				<div class="panel-footer">

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
