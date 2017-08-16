@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					手续费缴费列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/fund/fee') }}" method="get">
							<div class="form-group">
								<label class="label_left">手机号码</label>
								<input class="form-control" id="keyword" name="keyword" placeholder="请输入手机号码"/>
							</div>
							<button type="submit" class="btn btn-default search_bottom">搜索</button>
						</form>
					</div>
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">编号</th>
								<th class="info">状态</th>
                                <th class="info">本金</th>
                                <th class="info">比率</th>
                                <th class="info">手续费</th>
								<th class="info">姓名</th>
                                <th class="info">手机</th>
								<th class="info" style="width:10%">放款时间</th>
                                <th class="info" style="width:10%">缴费时间</th>
                                <th class="info">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
                                <td>{{ $item->id }}</td>
                                <td>
                                    @if($item->poundage==0)
                                        未缴费
                                    @elseif($item->poundage==1)
                                        已缴费
                                    @endif
                                </td>
							    <td>{{ $item->loan_money }}</td>
                                <td>{{ $item->loan_fee }}</td>
							    <td>{{ $item->fee_money }}</td>
                                <td>{{ $item->uname }}</td>
                                <td>{{ $item->mobile }}</td>
							    <td>{{ $item->created_at }}</td>
                                <td>@if($item->poundaged_at){{ $item->poundaged_at }}@endif</td>
                                <td>
                                    @if($item->poundage==0)
                                        <button onclick="app.fund.fee({{ $item->id }})" type="button" class="btn btn-default btn-sm">缴费</button>
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
