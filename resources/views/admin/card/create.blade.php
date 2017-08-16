@extends('app')
@section('content')
	<div class="container">
		<div class="row">
			@include('menu')
			<div class="col-md-9 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">会员卡编辑</div>
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
							<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/card/store') }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="form-group base">
									<label class="col-sm-2 control-label">名称<span style="color:red">*</span></label>
									<div class="col-sm-5">
										<input type="text" class="form-control" name="name" id="name" placeholder="请输入名称"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">月数<span style="color:red">*</span></label>
									<div class="col-sm-5">
										<input type="number" name="months" class="form-control" id="months" placeholder="请输入月数"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">价格<span style="color:red">*</span></label>
									<div class="col-sm-5">
										<input type="number" name="money" class="form-control" id="money" placeholder="请输入价格"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">积分</label>
									<div class="col-sm-5">
										<input type="number" name="point" class="form-control" id="point" placeholder="请输入积分"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">级别</label>
									<div class="col-sm-5">
										<input type="number" name="level" class="form-control" id="level" placeholder="请输入级别"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">排序</label>
									<div class="col-sm-5">
										<input type="number" name="sort" class="form-control" id="sort" placeholder="请输入序号" value="0"/>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">状态<span style="color:red">*</span></label>
									<div class="col-sm-10">
										<label class="radio-inline">
											<input type="radio" name="status" id="status1" value="1" checked="checked"/>
											上架
										</label>
										<label class="radio-inline">
											<input type="radio" name="status" id="status2" value="0"/>
											下架
										</label>
									</div>
								</div>
								<div class="form-group do">
									<div class="col-md-6 col-md-offset-4">
										<button type="submit" class="btn btn-primary">保存</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection