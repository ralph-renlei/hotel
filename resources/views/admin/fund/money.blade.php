@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					用户资金记录
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
                                <th class="info">说明</th>
                                <th class="info">UID</th>
                                <th class="info">姓名</th>
                                <th class="info">金额</th>
                                <th class="info">出入</th>
                                <th class="info">类型</th>
                                <th class="info">时间</th>
							</tr>
							@foreach($lists as $item)
							<tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
							    <td>{{ $item->uid }}</td>
                                <td>{{ $item->uname }}</td>
                                <td>{{ $item->money }}</td>
                                <td>
                                    @if( $item->type==1 )
                                        进账
                                    @else
                                        出账
                                    @endif
                                </td>
                                <td>
                                    @if( $item->cate==1 )
                                        充值
                                    @else
                                        奖励
                                    @endif
                                </td>
							    <td>{{ $item->created_at }}</td>
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
