@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">添加销售员&nbsp;（默认密码：手机后6位）</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/sale') }}">
						<div class="form-group">
							<label class="col-md-4 control-label">OpenID<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="openid" id="openid" placeholder="输入OpenID"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="mobile" id="mobile" placeholder="请输入您的手机号码"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" id="name" placeholder="请输入您的姓名"/>
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
