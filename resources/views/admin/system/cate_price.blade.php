@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房型价格走势&nbsp;&nbsp;</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">房型名称</th>
								<th class="info">挂牌价/普通价/会员价</th>
                                <th class="info">状态</th>
                                <th class="info">开始时间</th>
                                <th class="info">结束时间</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($list as $item)
								<tr id="item_{{ $item->id }}">
                                    <td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->marketprice }}/{{$item->normalprice }}/{{ $item->vipprice }}</td>
									<td class="data">@if($item->status==1) 上线 @else 不上线 @endif</td>
									<td class="data">{{$item->start}}</td>
									<td class="data">{{$item->end}}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm"  data-toggle="modal" data-target="#my2Modal">修改计划</button>
									</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">&times;</span><span class="sr-only" onclick="app.system.cancel();">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">分类</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">名称<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" id="name" placeholder="请输入名称2-10个字符"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">挂牌价<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="marketprice" class="form-control" id="marketprice" placeholder="请输入数字" value=""/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">普通价<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="normalprice" class="form-control" id="normalprice" placeholder="请输入数字"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">会员价<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="vipprice" class="form-control" id="vipprice" placeholder="请输入数字"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">床位数量<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="bed" class="form-control" id="bed" placeholder="请输入整数"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">房间数<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="number" class="form-control" id="number" placeholder="请输入整数"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">简介<span style="color:red">*</span></label>
							<div class="col-sm-8">
								<textarea id="description" name="description" class="form-control" cols="30" rows="10"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">排序<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="number" name="sort" class="form-control" id="sort" placeholder="请输入整数"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">状态<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<label class="radio-inline user_role">
									<input type="radio" name="status" id="status1" value="1" checked/>
									上线
								</label>
								<label class="radio-inline user_role">
									<input type="radio" name="status" id="status2" value="0"/>
									不上线
								</label>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" id="id" value="0"/>
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
					<button type="button" class="btn btn-primary" onclick="app.system.cate_add()">保存</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="my2Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">分类</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form" id="price_store">
						<div class="form-group">
							<label class="col-sm-2 control-label">房型分类<span style="color:red">*</span></label>
							<div class="col-sm-3" id="category">
								<select class="form-control" name="category" id="category_add">
									<option value ="0">请选择分类</option>
									@foreach($list as $category)
										<option value ="{{$category->id}}">{{$category->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">挂牌价<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="marketprice" class="form-control" id="marketprice_add" placeholder="请输入数字" value="">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">普通价<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="normalprice" class="form-control" id="normalprice_add" placeholder="请输入数字">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">会员价<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input type="text" name="vipprice" class="form-control" id="vipprice_add" placeholder="请输入数字">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">开始时间<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input class=" form-control" type="text" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="start_add" id="start_add">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">结束时间<span style="color:red">*</span></label>
							<div class="col-sm-5">
								<input class=" form-control" type="text" onClick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd'})" name="end_add" id="end_add">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="reset" class="btn btn-default" data-dismiss="modal">重置</button>
					<button type="button" class="btn btn-primary" onclick="price_add()">添加</button>
				</div>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	price_add = function(){
		var category = $('#category_add').val();
		var marketprice = $('#marketprice_add').val();
		var normalprice = $('#normalprice_add').val();
		var vipprice = $('#vipprice_add').val();
		var start= $('#start_add').val();
		var end = $('#end_add').val();

		$.ajax({
			url: '/admin/shop/price/store',
			type: 'POST',
			dataType:'json',
			data:{category:category,marketprice:marketprice,normalprice:normalprice,vipprice:vipprice,start:start,end:end,_token:"{{csrf_token()}}"},
			success: function(result) {
				if(result.code==1){
					alert(result.msg);
					window.location.href = '/admin/shop/price';
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
