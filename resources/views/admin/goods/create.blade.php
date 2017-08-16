@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">商品编辑</div>
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
							<li role="presentation" onclick="app.house.nav_tab('gallery')" id="gallery_li"><a href="javascript:void(0)">图集</a></li>
							<li role="presentation" onclick="app.house.nav_tab('status')" id="status_li"><a href="javascript:void(0)">价格</a></li>
						</ul>
						</div>
					<div style="margin-top:15px;">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/shop/goods/store') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group base">
							<label class="col-sm-2 control-label">名称<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" id="name" placeholder="请输入名称"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">库存<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="stock" id="stock" placeholder="请输入名称"/>
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
						<div class="form-group base">
							<label class="col-sm-2 control-label">早餐<span style="color:red">*</span></label>
							<div class="col-sm-3" id="category">
								<select class="form-control" name="breakfast" id="breakfast">
									<option value ="">请选择分类</option>
										<option value ="0">无早餐</option>
										<option value ="1">单早</option>
										<option value ="0">双早</option>
								</select>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">简介<span style="color:red">*</span></label>
							<div class="col-sm-8">
							<textarea id="description" name="description" class="form-control" cols="30" rows="10"></textarea>
							</div>
						</div>
						<div class="form-group gallery photo-border" id="gallery_div" style="display: none;">
							<ul id="gallery" class="house-photo">
							</ul>
							<div class="weui_uploader_input_wrp">
								<input class="weui_uploader_input layui-upload-file" type="file" name="file" id="file" accept="image/jpg;image/png;image/jpeg;"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">市场价</label>
							<div class="col-sm-5">
								<input type="number" name="marketprice" class="form-control" id="marketprice" placeholder="请输入市场价"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">售价<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="number" name="productprice" class="form-control" id="productprice" placeholder="请输入售价"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">成本价</label>
							<div class="col-sm-5">
								<input type="number" name="costprice" class="form-control" id="costprice" placeholder="请输入成本价"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">会员价</label>
							<div class="col-sm-5">
								<input type="number" name="vipprice" class="form-control" id="vipprice" placeholder="请输入会员价"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">周末价</label>
							<div class="col-sm-5">
								<input type="number" name="weekendprice" class="form-control" id="weekendprice" placeholder="请输入周末价"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">假日价</label>
							<div class="col-sm-5">
								<input type="number" name="holidayprice" class="form-control" id="holidayprice" placeholder="请输入假日价"/>
							</div>
						</div>
						<div class="form-group status" style="display: none">
							<label class="col-sm-2 control-label">排序</label>
							<div class="col-sm-5">
								<input type="number" name="sort" class="form-control" id="sort" placeholder="请输入序号" value="0"/>
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
