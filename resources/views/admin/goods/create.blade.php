@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房间新增</div>
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
							<li role="presentation" class="active" onclick="app.house.nav_tab('base')" id="base_li"><a href="javascript:void(0)">基本信息</a></li>
						</ul>
						</div>
					<div style="margin-top:15px;">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/shop/goods/store') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group base">
							<label class="col-sm-2 control-label">房间名称（编号）<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" id="name" placeholder="请输入名称"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">电箱编号<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="mac" id="mac" placeholder="请输入电箱编号" value=""/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">分类<span style="color:red">*</span></label>
							<div class="col-sm-3" id="category">
								<select class="form-control" name="category" id="category">
                                    <option value ="0">请选择分类</option>
                                    @foreach($categories as $category)
										<option value ="{{$category->id}}">{{$category->name}}</option>
									@endforeach
								</select>
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
