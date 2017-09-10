@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房间分配</div>
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
					<form class="form-horizontal" role="form" method="post" action="/admin/order/room_arrange">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<input type="hidden" name="goods_id" value="{{$roominfo->goods_id}}">

						<div class="form-group base">
							<label class="col-sm-2 control-label">房间名称（编号）<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="goods_name" id="goods_name" value="{{$roominfo->name}}" disabled>
							</div>
						</div>
						<div class="form-group base">
							<label class="col-sm-2 control-label">分类<span style="color:red">*</span></label>
							<div class="col-sm-3" id="category">
								<select class="form-control" name="category" id="category" disabled>
                                    <option value ="0">请选择分类</option>
                                    @foreach($categories as $category)
										<option value ="{{$category->id}}" @if($roominfo->category_id==$category->id) selected @endif>{{$category->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group base">
							<label for="inputPassword3" class="col-sm-2 control-label">订单id<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="order_id" class="form-control" id="order_id" value="" placeholder="只需填入订单号">
							</div>
						</div>
						<div class="form-group base">
							<label for="inputPassword3" class="col-sm-2 control-label">预订人<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="name" class="form-control" id="name" value="" disabled>
							</div>
						</div>
						<div class="form-group base">
							<label for="inputEmail3" class="col-sm-2 control-label">电话<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="mobile" class="form-control" id="mobile" value="" disabled>
							</div>
						</div>
						<div class="form-group base">
							<label for="inputEmail3" class="col-sm-2 control-label">人数<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="number" class="form-control" id="number" value="" disabled>
							</div>
						</div>
						<div class="form-group base">
							<label for="inputEmail3" class="col-sm-2 control-label">开房时间<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="start" id="start" value="" disabled>
							</div>
						</div>
						<div class="form-group base">
							<label for="inputEmail3" class="col-sm-2 control-label">退房时间<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="end" id="end" value="" disabled>
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
<script type="text/javascript">
	$('#order_id').blur(function(){//根据文本框中的订单id查询订单信息
		var order_id = $(this).val();
		if(order_id == null || order_id==''){
			alert('订单id不能为空');
			return false;
		}
		$.ajax({
			url: '/admin/order/order_id/'+order_id,
			type: 'GET',
			dataType:'json',
			success: function(result) {
				if(result.code==1){
					var c = result.data;
					$('#name').val(c.username);
					$('#mobile').val(c.phone);
					$('#category').val(c.category_name);
					$('#number').val(1);
					$('#start').val(c.start);
					$('#end').val(c.end);
				}else{
					alert(result.msg);
				}
			},
			error:function(jqXHR,textStatus, errorThrown ){
				alert(errorThrown);
			}
		})
	});
</script>
@endsection
