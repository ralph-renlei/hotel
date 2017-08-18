@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">房型价格走势&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" href="/admin/shop/price/add">新增</a></div>
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
										<a href="{{ url('/admin/shop/price/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">修改计划</button></a>
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
</div>
@endsection
