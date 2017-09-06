@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房间编辑</div>
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
									<input type="text" class="form-control" name="name" id="name" placeholder="请输入名称" value="{{$goods->name }}"/>
								</div>
							</div>
							<div class="form-group base">
								<label class="col-sm-2 control-label">电箱编号<span style="color:red">*</span></label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="mac" id="mac" placeholder="请输入电箱编号" value="{{$goods->mac }}"/>
								</div>
							</div>
							<div class="form-group base">
								<label class="col-sm-2 control-label">分类<span style="color:red">*</span></label>
								<div class="col-sm-3" id="category">
									<select class="form-control" name="category" id="category">
										@for($i=0;$i<count($categorys);$i++)
											<option value ="{{$categorys[$i]->id}}" @if($goods->category_id==$categorys[$i]->id) selected @endif>{{$categorys[$i]->name}}</option>
										@endfor
									</select>
								</div>
							</div>
							<div class="form-group do">
								<div class="col-md-6 col-md-offset-4">
									<input type="hidden" name="id" id="id" value="{{ $goods->goods_id }}"/>
									<input type="hidden" name="store_id" id="store_id" value="1"/>
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
<script>
	var categoryChange=function(){
		var categoryId = $("#category1").val();
		$.ajax({
			type: "POST",
			url: "/admin/category",
			data: {id:categoryId},
			success: function(res) {
				console.log(res)
				$("#category2").find("option").remove();
				for(var i=0;i<res.length;i++){
					$("#category2").append("<option value='"+res[i].id+"'>"+res[i].name+"</option>");
				}
			}
		});
	}
	var categoryChange1=function(){
		var categoryId = $("#category2").val();
		$.ajax({
			type: "POST",
			url: "/admin/category",
			data: {id:categoryId},
			success: function(res) {
				for(var i=0;i<res.length;i++){
					$("#category3").append("<option value='"+res[i].id+"'>"+res[i].name+"</option>");
				}
			}
		});
	}
</script>
@endsection
