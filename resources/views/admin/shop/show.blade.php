@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">商家编辑</div>
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
							<li role="presentation" onclick="app.house.nav_tab('locate')" id="locate_li"><a href="javascript:void(0)">地理位置</a></li>
							<li role="presentation" onclick="app.house.nav_tab('gallery')" id="gallery_li"><a href="javascript:void(0)">图集</a></li>
						</ul>
						</div>
					<div style="margin-top:15px;">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/shop/store') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group base">
							<label class="col-sm-2 control-label">名称<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" id="name" placeholder="请输入店铺名称" value="{{ $item->store_name }}"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">联系人<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="contacter" class="form-control" id="contacter" placeholder="请输入联系人" value="{{ $item->contacter }}"/>
							</div>
							<div class="col-sm-4">
								<input type="number" name="mobile" class="form-control" id="mobile" placeholder="请输入联系人电话" value="{{ $item->mobile }}"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">简介<span style="color:red">*</span></label>
							<div class="col-sm-8">
							<textarea id="intro" name="intro" class="form-control" cols="30" rows="10">{{ $item->intro }}</textarea>
							</div>
						</div>
						<div class="form-group gallery photo-border" id="gallery_div" style="display: none;">
							<ul id="gallery" class="house-photo">
								@if(isset($gallery_list))
									@foreach($gallery_list as $gallery)
										<li>
											<img data-original="{{ $gallery }}" src="{{ $gallery }}">
										</li>
									@endforeach
								@endif
							</ul>
							<div class="weui_uploader_input_wrp">
                                @foreach($gallery_list as $img)
                                <input name="new_gallery[]" type="hidden" value="{{ $img }}"/>
                                @endforeach
								<input class="weui_uploader_input layui-upload-file" type="file" name="file" id="file" accept="image/jpg,image/jpeg,image/png,image/gif"/>
							</div>
						</div>
						<div class="form-group locate" style="display: none">
							<label class="col-sm-2 control-label">地址<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="address" class="form-control" id="address" placeholder="地址" value="{{ $item->address }}"/>
							</div>
						</div>
						<div class="form-group locate" style="display: none">
							<label class="col-sm-2 control-label">经纬度<span style="color:red">*</span></label>
							<div class="col-sm-2">
								<input type="text" name="lat" class="form-control" id="lat" placeholder="经度" value="{{ $item->lat }}"/>
							</div>
							<div class="col-sm-2">
								<input type="text" name="lng" class="form-control" id="lng" placeholder="纬度" value="{{ $item->lng }}"/>
							</div>
						</div>
						<div class="form-group locate" style="display: none">
							<label class="col-sm-2 control-label">地图标注</label>
							<div class="col-sm-4">
								<input type="text" name="text_key" class="form-control" id="text_key" placeholder="在地图上标注的地址"/>
							</div>
							<div  class="col-sm-4">
								<button type="button" class="btn btn-primary" onclick="searchKeyword()">查询</button>
							</div>
						</div>
						<div class="form-group locate" style="display: none;">
							<div class="house-map" id="map"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">状态<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1" @if($item->status ==1)checked="checked"@endif/>
									启用
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="0" @if($item->status ==0)checked="checked"@endif/>
									禁用
								</label>
							</div>
						</div>
						<div class="form-group do">
							<div class="col-md-6 col-md-offset-4">
								<input type="hidden" name="city" id="city" value=""/>
								<input type="hidden" name="id" id="id" value="{{ $item->id }}"/>
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
