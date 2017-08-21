@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					订单列表 &nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="/admin/order/add">添加</a>
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/fund') }}" method="get">
							<div class="form-group">
								<label class="label_left">关键词</label>
								<input  class="form-control" id="keyword" name="keyword" placeholder="请输入订单号或者商品名"/>
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
                                <th class="info">房间类型</th>
                                <th class="info">价格</th>
								<th class="info">入住时间</th>
								<th class="info">退房时间</th>
								<th class="info">状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach($list as $item)
							<tr>
								<td>{{$item->order_id}} </td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->category_name }} @if($item->forms!=1) {{$item->goods_name}} @endif</td>
                                <td>{{ $item->order_amount }}</td>
                                <td>{{ $item->start }}</td>
                                <td>{{ $item->end }}</td>
                                <td>
									@if($item->pay_status == 0) 未付款	@else 已付款 @endif /
								    @if($item->order_status==0) 待审核 @elseif($item->order_status==1) 预订成功 @else 已完成 @endif
                                </td>
							    <td class="do">
									<button type="button" class="btn btn-default btn-sm" onclick="order_detail({{$item->order_id}})"  data-toggle="modal" data-target="#myModal">详情</button>
									@if($item->forms == 1 || $item->forms == 2)
										@if($item->order_status==0)
											<a href="/admin/shop/goods"><button type="button" class="btn btn-default btn-sm">分配房间</button></a>
										@elseif($item->order_status==1)
											<button type="button" class="btn btn-default btn-sm" disabled>已分配</button></a>
										@else
											<button type="button" class="btn btn-default btn-sm" disabled>订单完成</button></a>
										@endif
									@else
										@if($item->order_status==0)
										<a href="/admin/order/allowarrange/{{$item->order_id}}"><button type="button" class="btn btn-default btn-sm">同意申请</button></a>
										@elseif($item->order_status==1)
											<button type="button" class="btn btn-default btn-sm" disabled>已分配</button></a>
										@else
											<button type="button" class="btn btn-default btn-sm" disabled>订单完成</button></a>
										@endif
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
						<label for="inputEmail3" class="col-sm-2 control-label">总价<span style="color:red">*</span></label>
						<div class="col-sm-10">
							<input type="text" name="order_amount" class="form-control" id="order_amount" disabled>
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
								<option value="0" id="option0">等待审核</option>
								<option value="1" id="option1">预定成功</option>
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

<script type="text/javascript">
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
				if(c.order_satus == 0){
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
</script>
@endsection
