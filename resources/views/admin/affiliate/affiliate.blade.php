@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $user->nickname }}推广用户</div>
				<div class="panel-body">
					<div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th class="info">ID</th>
                                <th class="info">昵称</th>
                                <th class="info">姓名</th>
                                <th class="info">手机</th>
                                <th class="info">认证</th>
                            </tr>
                            @foreach ($lists as $item)
                                <tr id="item_{{ $item->id }}">
                                    <td class="data">{{ $item->id }}</td>
                                    <td class="data">{{ $item->nickname }}</td>
                                    <td class="data">{{ $item->name }}</td>
                                    <td class="data">{{ $item->mobile }}</td>
                                    <td class="data">
                                        @if($item->verify == 1)
                                            <span class="btn btn-green">已认证</span>
                                        @else
                                            <span class="btn btn-default">未认证</span>
                                        @endif
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
