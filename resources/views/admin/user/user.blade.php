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
							<div class="col-md-6">
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role1" value="admin" @if($user->role=='admin')checked="checked"@endif />
										管理员
									</label>
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role3" value="member" @if($user->role=='member')checked="checked"@endif />
										消费者
									</label>
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role5" value="channel" @if($user->role=='channel')checked="checked"@endif/>
										推广员
									</label>
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role5" value="risk" @if($user->role=='risk')checked="checked"@endif/>
										风控员
									</label>
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role5" value="finance" @if($user->role=='finance')checked="checked"@endif/>
										财务员
									</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">用户名</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}"/>
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
                        @if($user->role == 'risk')
                        <div class="form-group level" style="display: block">
                            <label class="col-md-4 control-label">风控级别</label>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="level" id="level1" value="1" @if($user->level==1)checked="checked"@endif/>
                                    上门核查员
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="level" id="level2" value="2" @if($user->level==1)checked="checked"@endif/>
                                    内网风控员
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="level" id="level3" value="3" @if($user->level==1)checked="checked"@endif/>
                                    渠道风控员
                                </label>
                            </div>
                        </div>
                        @else
                            <div class="form-group level" style="display: none">
                                <label class="col-md-4 control-label">风控级别</label>
                                <div class="col-md-6">
                                    <label class="radio-inline">
                                        <input type="radio" name="level" id="level1" value="1" @if($user->level==1)checked="checked"@endif/>
                                        上门核查员
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="level" id="level2" value="2" @if($user->level==1)checked="checked"@endif/>
                                        内网风控员
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="level" id="level3" value="3" @if($user->level==1)checked="checked"@endif/>
                                        渠道风控员
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-md-4 control-label">资金</label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="money" id="money" value="{{ $user->money }}" step="0.01" readonly="readonly"/>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label">状态<span style="color:red">*</span></label>
							<div class="col-md-6">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1" @if($user->status==1)checked="checked"@endif/>
									启用
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="0" @if($user->status==0)checked="checked"@endif/>
									禁用
								</label>
							</div>
						</div>
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
