@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ $user->name }}的邀请码
                    &nbsp;&nbsp;<button type="button" class="btn btn-default btn-sm" onclick="app.user.add_code({{ $user->id }})">生成邀请码</button>
                </div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">邀请码</th>
                                <th class="info">状态</th>
								<th class="info">时间</th>
								<th class="info">操作</th>
							</tr>
							@foreach ($lists as $item)
								<tr id="item_{{ $item->id }}">
									<td class="data">{{ $item->id }}</td>
									<td class="data">{{ $item->code }}</td>
                                    <td class="data">
                                        @if ($item->used == 1)
                                            <span class="btn btn-danger">使用</span>
                                        @else
                                            <span class="btn btn-success">未使用</span>
                                        @endif
                                    </td>
									<td class="data">{{ $item->created_at }}</td>
									<td class="do">
										<button type="button" class="btn btn-default btn-sm" onclick="app.user.del_code('{{ $item->id }}')">删除</button>
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
</div>
@endsection
