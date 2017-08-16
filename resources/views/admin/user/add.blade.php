@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">用户添加&nbsp;（默认密码：手机后6位）</div>
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
							<label class="col-md-4 control-label">角色<span style="color:red">*</span></label>
							<div class="col-md-6">
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role1" value="admin"/>
										管理员
									</label>
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role2" value="channel"/>
										渠道
									</label>
                                    <label class="radio-inline user_role">
                                        <input type="radio" name="role" id="role3" value="risk" checked="checked"/>
                                        分控员
                                    </label>
                                    <label class="radio-inline user_role">
                                        <input type="radio" name="role" id="role4" value="finance"/>
                                        财务
                                    </label>
									<label class="radio-inline user_role">
										<input type="radio" name="role" id="role5" value="member"/>
										消费者
									</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Openid</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="openid" id="openid" placeholder="公众号粉丝openid"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">姓名</label>
							<div class="col-md-6">
								<input type="text" class="form-control" name="name" id="name" placeholder="请输入您的姓名"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机<span style="color:red">*</span></label>
							<div class="col-md-6">
								<input type="mobile" class="form-control" name="mobile" id="mobile" placeholder="请输入您的手机号码"/>
							</div>
						</div>
                        <div class="form-group level">
                            <label class="col-md-4 control-label">风控级别</label>
                            <div class="col-md-6">
                                <label class="radio-inline">
                                    <input type="radio" name="level" id="level1" value="1" checked="checked"/>
                                    上门核查员
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="level" id="level2" value="2"/>
                                    内网风控员
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="level" id="level3" value="3"/>
                                    渠道风控员
                                </label>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label">状态<span style="color:red">*</span></label>
							<div class="col-md-6">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1"  checked="checked"/>
									启用
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="0"/>
									禁用
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
