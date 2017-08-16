@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					消费列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/shop/consume') }}" method="get">
							<div class="form-group">
								<label for="exampleInputName2">关键词</label>
								<input type="text" class="form-control" id="keyword" name="keyword" placeholder="请输入名字" @if(isset($keyword))value="{{ $keyword }}"@endif/>
							</div>
							<button type="submit" class="btn btn-default">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">日期</th>
								<th class="info">商家</th>
								<th class="info">消费者</th>
								<th class="info">手机</th>
								<th class="info">次数</th>
								<th class="info">包厢</th>
								<th class="info">返现</th>
								<th class="info">状态</th>
								<th class="info" style="width:10%">申请时间</th>
								<th class="info" style="width:20%">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
							<td>{{ $item->id }}</td>
							<td>{{ $item->date }}</td>
							<td>{{ $item->store_name }}</td>
							<td>{{ $item->uname }}</td>
							<td>{{ $item->mobile }}</td>
							<td>{{ $item->total }}</td>
							<td>{{ $item->no }}</td>
							<td>￥{{ $item->cashback }}</td>
							<td>@if($item->status == 1)
									<span class="btn btn-success">已通过</span>
								@elseif($item->status == 0)
									<span class="btn btn-default">待审核</span>
                                @elseif($item->status == -1)
                                    <span class="btn btn-default">已驳回</span>
                                @endif
							</td>
							<td>{{ $item->created_at }}</td>
							<td>
								@if($item->status ==0)
									<button type="button" class="btn btn-default btn-sm" onclick="app.shop.cashback('{{ $item->id }}',1)">返现</button>
								@endif
								<a href="{{ url('/admin/shop/consume/'.$item->id) }}"><button type="button" class="btn btn-default btn-sm">详情</button></a>
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
