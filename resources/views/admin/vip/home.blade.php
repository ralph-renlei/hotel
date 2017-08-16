@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					VIP会员列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/user/vip') }}" method="get">
							<div class="form-group">
								<label for="exampleInputName2">关键词</label>
								<input type="number" class="form-control" id="keyword" name="keyword" placeholder="请输入订单号或者手机号码"/>
							</div>
							<button type="submit" class="btn btn-default">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">姓名</th>
								<th class="info">手机</th>
								<th class="info">会员卡</th>
								<th class="info">开始日期</th>
								<th class="info">结束日期</th>
								<th class="info">状态</th>
							</tr>
							@foreach($lists as $item)
							<tr>
							<td>{{ $item->uid }}</td>
							<td>{{ $item->uname }}</td>
							<td>{{ $item->mobile }}</td>
							<td>{{ $item->cname }}</td>
                            <td>{{ $item->start_date }}</td>
                            <td>{{ $item->end_date }}</td>
							<td>
								@if($item->status==0)
									<span class="btn btn-default">未激活</span>
								@elseif($item->status==1)
									<span class="btn btn-success">已激活</span>
								@elseif($item->status==-1)
									<span class="btn btn-danger">已过期</span>
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
