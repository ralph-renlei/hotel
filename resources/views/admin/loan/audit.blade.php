@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $item->title }}审核</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/loan/audit') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<label class="col-md-4 control-label">标题</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->title }}</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">期数</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->loan_num }}</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">金额</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->loan_money }}</label>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">姓名</label>
                            <div class="col-md-6">
                                <label class="radio-inline">{{ $item->uname }}</label>
                            </div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label">手机</label>
							<div class="col-md-6">
                                <label class="radio-inline">{{ $item->mobile }}</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">状态<span style="color:red">*</span></label>
							<div class="col-md-6">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1" @if($item->status==1)checked="checked"@endif disabled="disabled"/>
									新申请
								</label>
                                <label class="radio-inline">
                                    <input type="radio" name="status" id="status3" value="2" @if($item->status==2)checked="checked"@endif disabled="disabled"/>
                                    已放款
                                </label>
							</div>
						</div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">审核<span style="color:red">*</span></label>
                            <div class="col-md-6">
                                @if($item->audit==0)
                                    <label class="radio-inline">
                                        <input type="radio" name="audit" id="audit1" value="0" @if($item->audit==0)checked="checked"@endif/>
                                        新申请
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="audit" id="audit2" value="1" @if($item->audit==1)checked="checked"@endif/>
                                        审核通过
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="audit" id="audit3" value="-1" @if($item->audit==-1)checked="checked"@endif/>
                                        审核未通过
                                    </label>
                                @else
                                    <label class="radio-inline">
                                        <input type="radio" name="audit" id="audit1" value="0" @if($item->audit==0)checked="checked"@endif disabled="disabled"/>
                                        新申请
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="audit" id="audit2" value="1" @if($item->audit==1)checked="checked"@endif disabled="disabled"/>
                                        审核通过
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="audit" id="audit3" value="-1" @if($item->audit==-1)checked="checked"@endif disabled="disabled"/>
                                        审核未通过
                                    </label>
                                @endif

                            </div>
                        </div>
                        <div class="form-group note">
                            <label class="col-md-4 control-label">备注</label>
                            <div class="col-md-6">
                                <input type="text" name="note" class="form-control" id="note" value="{{ $item->note }}"/>
                            </div>
                        </div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
                                <input type="hidden" name="id" id="id" value="{{ $item->order_id }}"/>
								@if($item->audit==0)
                                <button type="submit" class="btn btn-primary">保存</button>
                                @endif
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
