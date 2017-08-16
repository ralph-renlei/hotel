@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $card->name }}优惠活动</div>
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
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/promote') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group base">
							<label class="col-sm-2 control-label">会员卡名称<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="name" id="name" value="{{ $card->name }}" disabled="disabled"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">月数<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="number" name="months" class="form-control" id="months" value="{{ $card->months }}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">价格<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="number" name="money" class="form-control" id="money" placeholder="请输入价格" @if(isset($item) && $item->money)value="{{ $item->money }}"@endif />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">限制购买个数<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="number" name="num" class="form-control" id="num" @if(isset($item) && $item->num)value="{{ $item->num }}"@endif/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">优惠开始时间</label>
							<div class="col-sm-5">
								<input type="text" name="start" class="form-control layui-input" id="start" placeholder="请输入开始时间" @if(isset($item) && $item->start_time)value="{{ date('Y-m-d H:i:s',$item->start_time) }}"@endif/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">优惠结束时间</label>
							<div class="col-sm-5">
								<input type="text" name="end" class="form-control layui-input" id="end" placeholder="请输入结束时间" @if(isset($item) && $item->end_time)value="{{ date('Y-m-d H:i:s',$item->end_time) }}"@endif/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">状态<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1" @if(isset($item) && (int)$item->status==1)checked="checked"@endif/>
									启用
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="0" @if(isset($item) && (int)$item->status==0)checked="checked"@endif/>
									禁用
								</label>
							</div>
						</div>
						<div class="form-group do">
							<div class="col-md-6 col-md-offset-4">
								<input type="hidden" name="card_id" id="card_id" value="{{ $card->id }}"/>
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


	</script>
@endsection
