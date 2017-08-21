@extends('app')
@section('content')
	<div class="container">
		<div class="row">
			@include('menu')
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">用户管理&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/user/add') }}">新增</a></div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th class="info">ID</th>
									<th class="info">手机号码</th>
									<th class="info">真实姓名</th>
									<th class="info">注册时间</th>
									<th class="info">状态</th>
									<th class="info">操作</th>
								</tr>
								@foreach ($users as $item)
									<tr id="item_{{ $item->id }}">
										<td class="data">{{ $item->id }}</td>
										<td class="data">{{ $item->mobile }}</td>
										<td class="data">{{ $item->name }}</td>
										<td class="data">{{ $item->created_at }}</td>
										<td class="data">
											@if($item->verify==0) 未认证 @elseif($item->verify==-1) 待审核 @else 已认证 @endif
										</td>
										<td class="do">
											<a href="{{ url('/admin/user/user/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">修改</button></a>
											<button type="button" class="btn btn-default btn-sm" onclick="app.user.del('{{ $item->id }}')">删除</button>
											<a href="{{ url('/admin/user/verify/image/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">上传身份证照片</button></a>
										</td>
									</tr>
								@endforeach
							</table>
						</div>
					</div>
					<div class="panel-footer">
						{!! $users->render() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
