@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">用户编辑</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/user') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">角色</label>
							<div class="col-sm-6" id="category">
								<select class="form-control" name="role">
									<option value="">请选择角色</option>
									<option value="member" @if($user->role=='member') selected @endif>普通用户</option>
									<option value="admin" @if($user->role=='admin') selected @endif>管理员</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" placeholder="请输入您的姓名"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">openid</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="openid" id="name" value="{{ $user->openid }}" placeholder="请输入您的姓名"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机</label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="mobile" id="mobile" value="{{ $user->mobile }}" placeholder="请输入您的手机号码"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">身份证号</label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="idcard_no" id="idcard_no" value="{{ $user->idcard_no }}" placeholder="请输入您的身份证号码"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-4 control-label">状态<span style="color:red">*</span></label>
							<div class="col-sm-6" id="category">
								<select class="form-control" name="verify">
									<option value="">请选择分类</option>
									<option value="1" @if($user->verify==1) selected @endif>已认证</option>
									<option value="0" @if($user->verify==0) selected @endif>未认证</option>
								</select>
							</div>
						</div>
						@if(isset($user->idcard_front))
							<div class="form-group">
								<label class="col-md-4 control-label">身份证正反面</label>
								<div class="col-md-6">
									<img src="{{$user->idcard_front}}" width="450px;"/> <br><br>
									<img src="{{$user->idcard_back}}"  width="450px;"/>
								</div>
							</div>
						@else
							<div class="form-group">
								<label class="col-md-4 control-label">身份证正反面</label>
								<div class="col-md-6">
									<input type="text" class="form-control"  value="未上传" disabled/>
								</div>
							</div>
						@endif

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<input type="hidden" class="form-control" name="id" id="id" value="{{ $user->id }}" />
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
