@extends('app')
@section('content')
	<style type="text/css">
		li{ display:inline;}
		.clearfix:after{
			clear: both;
			display: block;
			content: '';
		}
		.control-label{
			text-align: right;
		}
	</style>
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">配置编辑</div>
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
						<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/potion') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group base">
							<label class="col-sm-2 control-label">分类名称<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="type_name" id="type_name" placeholder="分类名称" value="{{ $type->type_name }}"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">分类<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="type_alias" id="type_alias" placeholder="分类" value="{{ $type->type_alias }}"/>
							</div>
						</div>

						@foreach($attributes as $attribute)
						<div class="form-group base clearfix" >
								<label class="col-sm-2 control-label">{{$attribute->attr_name}}</label>
								<div class="plus-tag tagbtn clearfix col-sm-10" id="{{$attribute->attr_id}}">
								@for($i=0;$i<count($attribute['attr_value']);$i++)
									<a value="{{$attribute->attr_id}}" herf="javaseript:void(0)" title="{{$attribute->attr_value[$i]}}"><span>{{$attribute->attr_value[$i]}}</span><em></em></a>
								@endfor
							</div>
								<div class="plus-tag-add">
									<ul class="Form FancyForm" style="margin: 10px 0px 0px 140px;">
										<li class="clearfix">
											<input  name="" type="text" class="stext" value="" maxlength="20" style="width: 200px;float: left;" id="{{$attribute->attr_id}}"/>
											<button type="button" class="Button RedButton Button18" id="{{$attribute->attr_id}}" style="font-size:14px;float: left">添加{{$attribute->attr_name}}</button>
										</li>
									</ul>
								</div>
							</div>
						@endforeach
						<div class="form-group do">
							<div class="col-md-6 col-md-offset-4">
								<input type="hidden" name="city" id="city" value=""/>
								<input type="hidden" name="id" id="id" value="{{ $type->id }}"/>
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
