@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">提现申请</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/fund/cash') }}">
						<div class="form-group base">
							<label class="col-sm-2 control-label">消费者ID<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="number" name="uid" class="form-control" id="uid" value="{{ $item->uid }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">消费者OpenID<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="OpenID" class="form-control" id="OpenID" value="{{ $item->openid }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">消费者<span style="color:red">*</span></label>
							<div class="col-sm-4">
								<input type="text" name="uname" class="form-control" id="uname" value="{{ $item->uname }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group locate">
							<label class="col-sm-2 control-label">提现金额<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="number" name="total" class="form-control" id="total" value="{{ $item->money }}" disabled="disabled"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">状态<span style="color:red">*</span></label>
							<div class="col-sm-10">
                                <label class="radio-inline">
                                    <input type="radio" name="status" class="audit" id="status2" value="0" @if($item->status ==0)checked="checked"@endif/>
                                    审核中
                                </label>
                                <label class="radio-inline">
									<input type="radio" name="status" class="audit" id="status1" value="1" @if($item->status ==1)checked="checked"@endif/>
                                    审核通过
								</label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" class="audit" id="status2" value="-1" @if($item->status ==-1)checked="checked"@endif/>
                                    驳回
                                </label>
							</div>
						</div>
                        <div class="form-group note" @if($item->status!==-1)style="display:none" @endif>
                            <label class="col-sm-2 control-label">驳回原因</label>
                            <div class="col-sm-5">
                                <input type="text" name="note" class="form-control" id="note" value="{{ $item->note }}"/>
                            </div>
                        </div>
                        <div class="form-group radio-way" @if($item->status!=1)style="display:none"@endif>
                                <label class="col-sm-2 control-label">付款方式<span style="color:red">*</span></label>
                                <div class="col-sm-10">
                                    <label class="radio-inline">
                                        <input type="radio" name="way" class="way" id="way1" value="1" @if($item->way ==1)checked="checked"@endif/>
                                        企业付款
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="way" class="way" id="way2" value="2" @if($item->way ==2)checked="checked"@endif/>
                                        企业红包
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="way" class="way" id="way3" value="3" @if($item->way ==3)checked="checked"@endif/>
                                        个人红包
                                    </label>
                                </div>
                        </div>

                        <div class="form-group cert" @if($item->way!=3)style="display:none"@endif id="gallery_div">
                            <label class="col-sm-2 control-label">上传凭证</label>
                            <div class="col-sm-5">
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
                                    <input class="weui_uploader_input layui-upload-file" type="file" name="file" id="file" accept="image/jpg,image/jpeg,image/png,image/gif"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="hidden" class="form-control" name="id" id="id" value="{{ $item->id }}" />
                                @if($item->status==0)
                                <button type="submit" class="btn btn-primary">保存</button>
                                @endif
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
