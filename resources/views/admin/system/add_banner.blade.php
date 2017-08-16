@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">轮播图添加</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/system/banner') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">键值<span style="color:red">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="code" id="code" placeholder="请输入键值"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">名称<span style="color:red">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入名称"/>
                                </div>
                            </div>
                            <div class="form-group cert" id="gallery_div">
                                <label class="col-md-4 control-label">上传图片</label>
                                <div class="col-md-6">
                                    <ul id="gallery" class="house-photo">
                                    </ul>
                                    <div class="weui_uploader_input_wrp">
                                        <input class="weui_uploader_input layui-upload-file" type="file" name="file" id="file" accept="image/jpg,image/jpeg,image/png"/>
                                    </div>
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
