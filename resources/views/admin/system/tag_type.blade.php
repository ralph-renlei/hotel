@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">标签类型列表&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal">新增</a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">类型</th>
								<th class="info">说明</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($list as $item)
								<tr id="item_{{ $item->ttid }}">
									<td class="data">{{ $item->ttid }}</td>
									<td class="data">{{ $item->tcode }}</td>
									<td class="data">{{ $item->tnote }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" onclick="app.system.edit_type('{{ $item->ttid }}')">修改</button>
										<button type="button" class="btn btn-default btn-sm" onclick="app.system.del_type('{{ $item->ttid }}')">删除</button>
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
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true" onclick="app.system.consel_ttype()">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">新增类型</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">类型</label>
							<div class="col-sm-10">
								<input type="text" name="code" class="form-control" id="code" placeholder="类型">
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">说明</label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" id="name" placeholder="名称">
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" class="form-control" id="id" value="0"/>
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.consel_type()">关闭</button>
					<button type="button" class="btn btn-primary" onclick="app.system.save_type()">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
