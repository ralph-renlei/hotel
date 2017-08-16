@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">微信菜单&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal">新增</a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">顺序</th>
								<th class="info">类型</th>
								<th class="info">父级</th>
								<th class="info">名称</th>
								<th class="info">内容</th>
								<th class="info">操作</th>
							</tr>
							@if(isset($list))
							@foreach ($list as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->sort }}</td>
									<td class="data">{{ $item->mtype }}</td>
									<td class="data">{{ $item->pid }}</td>
									<td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->val }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" onclick="app.system.edit_menu('{{ $item->id }}')">修改</button>
										<button type="button" class="btn btn-default btn-sm" onclick="app.system.del_menu('{{ $item->id }}')">删除</button>
									</td>
								</tr>
							@endforeach
							@endif
						</table>
					</div>
				</div>
				<div class="panel-footer">
					<button type="button" class="btn btn-primary btn-sm" onclick="app.system.create_menu()">更新</button>
					<button type="button" class="btn btn-primary btn-sm" onclick="app.system.delete_menu()">删除</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel_menu()">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">新增菜单</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">类型</label>
							<div class="col-sm-10">
								<select class="form-control" id="mtype" name="mtype">
									<option value="click">点击事件</option>
									<option value="view">超级链接</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">类型</label>
							<div class="col-sm-10">
								<select class="form-control" id="pid" name="pid">
									<option value="0">父菜单</option>
									@if(isset($parents))
										@foreach($parents as $parent)
										<option value="{{ $parent->id }}">{{ $parent->name }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">名称<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" id="name" placeholder="菜单名称"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">内容<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="val" class="form-control" id="val" placeholder="菜单内容"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">排序<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="sort" class="form-control" id="sort" placeholder="排序"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">状态<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<label class="radio-inline">
									<input type="radio" name="status" id="status1" value="1" checked="checked"/>
									启用
								</label>
								<label class="radio-inline">
									<input type="radio" name="status" id="status2" value="0"/>
									禁用
								</label>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" class="form-control" id="id" value="0"/>
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel_menu()">关闭</button>
					<button type="button" class="btn btn-primary" onclick="app.system.save_menu()">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
