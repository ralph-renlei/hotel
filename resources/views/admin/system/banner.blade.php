@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">轮播图上传&nbsp;&nbsp;<a class="glyphicon glyphicon-plus" href="{{ url('/admin/system/addBanner') }}">新增</a></div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
                                <th class="info">ID</th>
								<th class="info">名称</th>
								<th class="info">内容</th>
								<th class="info">操作</th>
							</tr>
							@if(isset($list) && !empty($list))
							@foreach ($list as $item)
								<tr>
									<td class="data">{{ $item->code }}</td>
									<td class="data">{{ $item->name }}</td>
									<td class="data"><img src="{{ $item->val }}" width="300px" height="150px"></td>
									<td class="do">
										<a href="{{ url('/admin/system/banner/'.$item->code) }}"><button type="button" class="btn btn-default btn-sm">修改</button></a>
										<button type="button" class="btn btn-default btn-sm" onclick="app.system.del_banner('{{ $item->code }}')">删除</button>
									</td>
								</tr>
							@endforeach
                            @else
                                <tr>
                                    <td colspan="4">抱歉，暂无数据！</td>
                                </tr>
							@endif
						</table>
					</div>
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
