@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">配置项&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal">新增</a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">键值</th>
								<th class="info">名称</th>
								<th class="info">内容</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($list as $item)
								<tr id="item_{{ $item->code }}">
									<td class="data">{{ $item->code }}</td>
									<td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->val }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" onclick="app.system.edit('{{ $item->code }}')">修改</button>
										<button type="button" class="btn btn-default btn-sm" onclick="app.system.del('{{ $item->code }}')">删除</button>
									</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel();">&times;</span><span class="sr-only" onclick="app.system.cancel();">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">新增配置项</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">键值<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="code" class="form-control" id="code" paceholder="请输入键值"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">名称<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" id="name" placeholder="请输入名称"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">内容<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="val" class="form-control" id="val" placeholder="请输入内容"/>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
					<button type="button" class="btn btn-primary" onclick="app.system.add()">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
