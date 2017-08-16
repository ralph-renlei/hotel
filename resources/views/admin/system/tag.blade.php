@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">标签列表&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal">新增</a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">类型</th>
								<th class="info">内容</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($list as $item)
								<tr id="item_{{ $item->tid }}">
									<td class="data">{{ $item->tid }}</td>
									<td class="data">{{ $item->tcode }}</td>
									<td class="data">{{ $item->tag }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" onclick="app.system.edit_tag('{{ $item->tid }}')">修改</button>
										<button type="button" class="btn btn-default btn-sm" onclick="app.system.del_tag('{{ $item->tid }}')">删除</button>
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
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.cancel_tag()">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">新增标签</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">类型</label>
							<div class="col-sm-10">
								<input type="text" name="code" class="form-control" id="code" placeholder="键值"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">内容</label>
							<div class="col-sm-10">
								<input type="text" name="val" class="form-control" id="val" placeholder="内容"/>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" class="form-control" id="id" value="0"/>
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel_tag()">关闭</button>
					<button type="button" class="btn btn-primary" onclick="app.system.save_tag()">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
