@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房间二维码</div>
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
						<div class="col-md-offset-1">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active" onclick="app.house.nav_tab('base')" id="base_li"><a href="javascript:void(0)">二维码</a></li>
						</ul>
						</div>
					<div style="margin-top:15px;">
					<form class="form-horizontal" role="form">
						<div class="form-group base">
							<label class="col-sm-2 control-label">房间名称（编号）<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" id="name" value="{{$goods->name}}"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label"> 二维码 <span style="color:red">*</span></label>
							<div class="col-sm-5">
								<img src="{{$goods->qrcode}}"/>
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
