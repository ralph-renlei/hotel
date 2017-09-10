@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					订单列表 &nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#no3Modal">前台预定新增</a>
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/order/home') }}" method="get">
							<div class="form-group">
								<label class="label_left">查看当天的订单情况</label>
								<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="start" id="start" value="">
							</div>
							<button type="submit" class="btn btn-default search_bottom">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">订单id</th>
								<th class="info">姓名</th>
								<th class="info">电话</th>
								<th class="info">预定渠道</th>
                                <th class="info">房间类型</th>
                                <th class="info">房间名称</th>
                                <th class="info">订单金额</th>
								<th class="info">付款状态/订单状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach($list as $item)
							<tr>
								<td>{{$item->order_id}} </td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>@if($item->forms==1) 线上预定 @elseif($item->forms==0) 线下预定 @else 前台预定 @endif</td>
								<td>{{ $item->category_name}}</td>
								<td> @if(($item->forms==1||$item->forms==2) && !$item->goods_name) 未分配 @else {{ $item->goods_name  }} @endif</td>
                                <td>{{ $item->order_amount }}</td>
                                <td>
									@if($item->pay_status == 0) 未付款/不允入住
									@elseif($item->pay_status == 2) 已退款/订单完成
									@else 已付款
										/ @if($item->order_status == 0) 新订单 @elseif($item->order_status == 1) 已处理 @else 订单完成 @endif
									@endif
                                </td>
							    <td class="do">
									<button type="button" class="btn btn-default btn-sm" onclick="order_detail({{$item->order_id}})" data-toggle="modal" data-target="#myModal" title="可关闭订单">查看/修改</button>
									@if($item->pay_status == 1)
										@if($item->forms == 1 || $item->forms == 2)
											@if($item->order_status==0)
												<a href="/admin/shop/status"><button type="button" class="btn btn-default btn-sm">分配房间</button></a>
											@elseif($item->order_status==1)
												<button type="button" class="btn btn-default btn-sm">已经处理</button></a>
											@else
												<button type="button" class="btn btn-default btn-sm">订单完成</button></a>
											@endif
										@else
											@if($item->order_status==0)
												<a href="/admin/order/allowarrange/{{$item->order_id}}"><button type="button" class="btn btn-default btn-sm">同意请求</button></a>
											@elseif($item->order_status==1)
												<button type="button" class="btn btn-default btn-sm">已经处理</button></a>
											@else
												<button type="button" class="btn btn-default btn-sm">订单完成</button></a>
											@endif
										@endif
										
										@if($item->order_status!=2)
											<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#no2Modal">申请退款</button></a>
										@endif
									@else
										<button type="button" class="btn btn-default btn-sm" title="未付款无法分配">无法分配</button></a>
									@endif
                                </td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
					{!! $list->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;"><div class="modal-backdrop fade in"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">×</span><span class="sr-only" onclick="app.system.cancel();">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">订单详情</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">预定渠道<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="forms" class="form-control" id="forms" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">预订人<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="name" class="form-control" id="name" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">电话<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="mobile" class="form-control" id="mobile" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">房间类型<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="category" class="form-control" id="category" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">房间名称<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="goods_name" class="form-control" id="goods_name" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">总价<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="order_amount" class="form-control" id="order_amount" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">入住时间<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="start" class="form-control" id="start_time" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">离店时间<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="end" class="form-control" id="end_time" disabled>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">付款状态<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<label class="radio-inline user_role">
								<input type="radio" name="pay_status" id="status1" value="1">
								已付款
							</label>
							<label class="radio-inline user_role">
								<input type="radio" name="pay_status" id="status2" value="0">
								未付款
							</label>
						</div>
					</div>
					<div class="form-group base">
						<label class="col-sm-2 control-label">订单状态<span style="color:red">*</span></label>
						<div class="col-sm-3" id="category">
							<select class="form-control" name="order_status" id="order_status">
								<option value="0" id="option0">新订单</option>
								<option value="1" id="option1">已处理</option>
								<option value="2" id="option2">已完成</option>
							</select>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<input type="hidden" name="id" id="id" value="" order_id=""/>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
				<button type="button" class="btn btn-primary" onclick="order_edit()">保存</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade in" id="no2Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;"><div class="modal-backdrop fade in"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">×</span><span class="sr-only" onclick="app.system.cancel();">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">退款申请</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">订单id<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="id_refund" class="form-control" id="id_refund" value="" placeholder="请填写订单id">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-2 control-label">实付金额<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="shifu_amount" class="form-control" id="shifu_amount" value="" placeholder="请填写实付金额">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-2 control-label">退款金额<span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="text" name="refund_fee" class="form-control" id="refund_fee" value="" placeholder="请填写退款金额">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
				<button type="button" class="btn btn-primary" onclick="refund()">保存</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade in" id="no3Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;"><div class="modal-backdrop fade in"></div>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">×</span><span class="sr-only" onclick="app.system.cancel();">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">添加订单</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<input type="hidden" name="_token" value="{{csrf_token()}}" id="_token"/>
					<input type="hidden" name="forms" value="2">
					<div class="form-group base">
						<label class="col-sm-2 control-label">姓名<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="username" id="name_add"/>
						</div>
					</div>
					<div class="form-group base">
						<label class="col-sm-2 control-label">电话<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input type="text" class="form-control" name="phone" id="mobile_add"/>
						</div>
					</div>
					<div class="form-group base">
						<label class="col-sm-2 control-label">房型<span style="color:red">*</span></label>
						<div class="col-sm-3" id="category">
							<select class="form-control" name="category" id="category_add">
								<option value ="0">请选择房型</option>
								@foreach($categorys as $category)
									<option value ="{{$category->id}}">{{$category->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group base">
						<label for="inputEmail3" class="col-sm-2 control-label">入住时间<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="start" id="start_add" value="">
						</div>
					</div>
					<div class="form-group base">
						<label for="inputEmail3" class="col-sm-2 control-label">离店时间<span style="color:red">*</span></label>
						<div class="col-sm-5">
							<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="end" id="end_add" value="">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
				<button type="button" class="btn btn-primary" onclick="add()">保存</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
add = function(){
	var username = $('#name_add').val();
	var phone = $('#mobile_add').val();
	var category = $('#category_add').val();
	var start = $('#start_add').val();
	var end = $('#end_add').val();
	var _token = $('#_token').val();

	$.ajax({
		url: '/reserve/ordercommit',
		type: 'POST',
		dataType:'json',
		data:{'_token':_token,'username':username,'phone':phone,'category':category,'start':start,'end':end,'forms':2},
		success: function(result) {
			if(result.code==1){
				alert('下单成功，请查看实名认证');
				window.location.href = '/admin/user/verify';
			}else{
				alert(result.msg);
			}
		},
		error:function(jqXHR,textStatus, errorThrown ){
			alert(errorThrown);
		}
	});
};


order_detail = function(id){
	if(!id){
		alert('参数异常');
		return false;
	}
	$.ajax({
		url: '/admin/order/order_id/'+id,
		type: 'GET',
		dataType:'json',
		success: function(result) {
			if(result.code==1){
				var c = result.data;
				$('#id').attr('order_id', c.order_id);
				$('#name').val(c.username);
				$('#mobile').val(c.phone);
				$('#category').val(c.category_name);
				if(c.goods_name =="" || c.goods_name == null){
					$('#goods_name').val('需要分配房间');
				}else{
					$('#goods_name').val(c.goods_name);
				}
				$('#goods_name').val();
				$('#start_time').val(c.start);
				$('#end_time').val(c.end);
				$('#order_amount').val(c.order_amount);
				if(c.forms == 1){
					$('#forms').val('线上预订');
				}else if(c.forms == 0){
					$('#forms').val('线下预定');
				}else{
					$('#forms').val('前台预定');
				}
				if(c.pay_status==1){
					$('#status1').attr('checked','checked');
				}else{
					$('#status2').attr('checked','checked');
				}
				if(c.order_status == 0){
					$('#option0').attr('selected','selected');
				}else if(c.order_status == 1){
					$('#option1').attr('selected','selected');
				}else{
					$('#option2').attr('selected','selected');
				}
			}else{
				alert(result.msg);
			}
		},
		error:function(jqXHR,textStatus, errorThrown ){
			alert(errorThrown);
		}
	});
};

order_edit = function(){
	var id = $('#id').attr('order_id');
	if(!id){
		alert('参数异常');
		return false;
	}
	var pay_status = $('input[name="pay_status"]:checked').val();
	var order_status = $("#order_status").find("option:selected").val();
	$.ajax({
		url: '/admin/order/order_id/'+id,
		type: 'POST',
		dataType:'json',
		data:{id:id,pay_status:pay_status,order_status:order_status,_token:"{{csrf_token()}}"},
		success: function(result) {
			if(result.code==1){
				alert(result.msg);
				window.location.href = '/admin/order/home';
			}else{
				alert(result.msg);
			}
		},
		error:function(jqXHR,textStatus, errorThrown ){
			alert(errorThrown);
		}
	});
}

refund = function(){
	var id = $('#id_refund').val();
	var order_amount = $('#shifu_amount').val();
	var refund_fee = $('#refund_fee').val();
	if(refund_fee == ''){
		alert('请填写退款金额');
	}
	if(Number(order_amount) < Number(refund_fee)){
		alert('退款金额多余实付金额');
	}

	$.ajax({
		url: '/refund',
		type: 'get',
		dataType:'json',
		data:{id:id,refund_fee:refund_fee},
		success: function(result) {
			if(result.code==1){
				alert(result.msg);
				window.location.href = '/admin/order/home';
			}else{
				alert(result.msg);
			}
		},
		error:function(jqXHR,textStatus, errorThrown ){
			alert(errorThrown);
		}
	});
}
</script>
@endsection
