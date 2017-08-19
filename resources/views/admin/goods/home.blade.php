@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房间列表
					&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/shop/goods/create') }}">添加</a>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">房间名称（编号）</th>
								<th class="info">所属类型</th>
								<th class="info">开关房</th>
								<th class="info">入住状态</th>
								<th class="info">操作</th>
							</tr>
							@foreach($goods as $item)
							<tr>
							<td>{{ $item->goods_id }}</td>
							<td>{{ $item->name }}</td>
							<td>{{ $item->category['name'] }}</td>
							<td>
								@if($item->open==1)
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('open','{{ $item->goods_id }}',0)" title="点击关房">开房</button>
								@else
									<button type="button" class="btn btn-default btn-sm" onclick="app.goods.audit('open','{{ $item->goods_id }}',1)" title="点击开房">关房</button>
								@endif
							</td>
							<td>
								@if($item->open==1)
									<select class="form-control" name="status_change" id="{{$item->goods_id}}">
										<option value="1" @if($item->status==1) selected @endif>无人入住</option>
										<option value="0" @if($item->status==0) selected @endif>有人入住</option>
										<option value="-1"  @if($item->status==-1) selected @endif>维护中</option>
									</select>
								@else
									关房不可入住
								@endif
							</td>
							<td>
								<a href="{{ url('/admin/shop/goods/show/'.$item->goods_id) }}"><button type="button" class="btn btn-default btn-sm">修改</button></a>
								<button type="button" class="btn btn-default btn-sm" onclick="app.goods.del('{{ $item->goods_id }}')">删除</button>
								@if($item->open==1)
									@if($item->status == 1) <button type="button" class="btn btn-default btn-sm" onclick=""  data-toggle="modal" data-target="#myModal">安排入住</button>
									@elseif($item->status == 0) <button type="button" class="btn btn-default btn-sm" disabled>客房已满</button>
									@else <button type="button" class="btn btn-default btn-sm" disabled>不能安排</button>
									@endif
								@else
								<button type="button" class="btn btn-default btn-sm" disabled>不能入住</button>
								@endif
							</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
					{!! $goods->render() !!}
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none;"><div class="modal-backdrop fade in"></div>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">×</span><span class="sr-only" onclick="app.system.cancel();">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">安排入住</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">订单号<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="order_id" class="form-control" id="order_id" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">预订人<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" id="name" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">电话<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="mobile" class="form-control" id="mobile" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">房间类型<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="category" class="form-control" id="category" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">房间名称（编号）<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="goods_name" class="form-control" id="goods_name" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">人数<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="number" class="form-control" id="number" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">开房时间<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="start" id="start" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">退房时间<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input class=" form-control" type="text" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="end" id="end" value="">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" id="id" value="" order_id=""/>
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
					<button type="submit" class="btn btn-primary" onclick="room_arrange()">保存</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$('select[name=status_change]').each(function(){
			$(this).change(function(){
				var id = $(this).attr('id');
				var status = $(this).val();
				$.post('/admin/shop/goods/item',{id:id,field:'status',val:status},function(result){
					if(result.code==1){
						setTimeout(function(){
							window.location.reload();
						},500);
					}else{
						alert(result.msg);
					}
				},'json').error(function(jqXHR,textStatus, errorThrown){
					alert(errorThrown);
				});
			});
		});

		room_arrange = function(){
			var order_id = $('#order_id').val();
			var name = $('#name').val();
			var mobile = $('#mobile').val();
			var category = $('#category').val();
			var goods_name = $('#goods_name').val();
			var number = $('#number').val();
			var start = $('#start').val();
			var end = $('#end').val();
			$.ajax({
				url: '/admin/order/room_arrange',
				type: 'POST',
				dataType:'json',
				data:{order_id:order_id,name:name,mobile:mobile,category:category,goods_name:goods_name,number:number,start:start,end:end,_token:"{{csrf_token()}}"},
				success: function(result) {
					if(result.code==1){
						alert(result.msg);
						setTimeout(function(){
							window.location.reload();
						},500);
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
