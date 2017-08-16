@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $cate->name }}子类&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#myModal">新增</a><div class="pull-right"><a class="text-right" href="{{ url('/admin/system/cate') }}">返回</a></div></div>

                <div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">名称</th>
								<th class="info">键值</th>
                                <th class="info">icon</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($lists as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
                                    <td class="data">{{ $item->name }}</td>
									<td class="data">{{ $item->code }}</td>
									<td class="data">{{ $item->icon }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal" onclick="app.system.edit_cate('{{ $item->id }}')">修改</button>
                                        <a href="{{ url('/admin/system/cates'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">子类</button></a>
                                        <button type="button" class="btn btn-default btn-sm" onclick="app.system.del_cate('{{ $item->id }}')">删除</button>
									</td>
								</tr>
							@endforeach
						</table>
					</div>
				</div>
				<div class="panel-footer">
                    {!! $lists->render() !!}
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
							<label for="inputEmail3" class="col-sm-2 control-label">键值<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="code" class="form-control" id="code" placeholder="请输入英文名称2-20个字符"/>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword3" class="col-sm-2 control-label">ICON<span style="color:red">*</span></label>
							<div class="col-sm-10">
								<input type="text" name="name" class="form-control" id="icon" placeholder="请输入ICON名称100个字符以内"/>
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
                                    <input type="radio" name="status" id="status1" value="1" checked="checked"/>
                                    激活
                                </label>
                                <label class="radio-inline user_role">
                                    <input type="radio" name="status" id="status2" value="0"/>
                                    禁用
                                </label>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
                    <input type="hidden" name="id" id="id" value="0"/>
                    <input type="hidden" name="parent" id="parent" value="{{ $cate->id }}"/>
					<button type="button" class="btn btn-default" data-dismiss="modal" onclick="app.system.cancel();">关闭</button>
					<button type="button" class="btn btn-primary" onclick="app.system.cate_add()">保存</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
