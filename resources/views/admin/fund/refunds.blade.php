@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					还款列表
				</div>
				<div class="panel-body">
					<div class="row">
						<form class="form-inline" action="{{ url('/admin/fund/refund') }}" method="get">
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
								<th class="info">标题</th>
								<th class="info">状态</th>
                                <th class="info">逾期</th>
                                <th class="info">期数</th>
                                <th class="info">利息</th>
                                <th class="info">本金</th>
                                <th class="info">还款金额</th>
								<th class="info">姓名</th>
                                <th class="info" style="width:8%">应还日期</th>
								<th class="info" style="width:8%">还款时间</th>
                                <th class="info">操作</th>
							</tr>
							@foreach($lists as $item)
							<tr>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @if($item->status==0)
                                        未还款
                                    @elseif($item->status==1)
                                        已还款
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_overdue==0)
                                        未逾期
                                    @elseif($item->is_overdue==1)
                                        已逾期
                                    @endif
                                </td>
							    <td>{{ $item->num }}</td>
                                <td>{{ $item->interest }}</td>
                                <td>{{ $item->capital }}</td>
                                <td>{{ $item->money }}</td>
                                <td>{{ $item->uname }}</td>
							    <td>{{ $item->refund_date }}</td>
                                <td>@if($item->refund_at){{ $item->refund_at }}@endif</td>
                                <td>
                                    @if($item->status==0)
                                    <button type="button" class="btn btn-default" onclick="app.fund.refund({{ $item->id }})">还款</button>
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
