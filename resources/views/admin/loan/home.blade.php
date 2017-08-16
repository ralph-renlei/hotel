@extends('app')

@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">申请记录表</div>
				<div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th class="info">编号</th>
                                <th class="info">标题</th>
                                <th class="info">期数</th>
                                <th class="info">金额</th>
                                <th class="info">姓名</th>
                                <th class="info">手机</th>
                                <th class="info">状态</th>
                                <th class="info">审核</th>
                                <th class="info" style="width:11%">申请时间</th>
                                <th class="info" style="width:11%">审核时间</th>
                                <th class="info">操作</th>
                            </tr>
                            @foreach($lists as $item)
                                <tr>
                                    <td>{{ $item->order_sn }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->loan_num }}</td>
                                    <td>{{ $item->loan_money }}</td>
                                    <td>{{ $item->uname }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>
                                        @if($item->status==1)
                                            新申请
                                        @elseif($item->status==2)
                                            已放款
                                        @elseif($item->status==-1)
                                            未通过
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->audit==0)
                                            未审核
                                        @elseif($item->audit==1)
                                            通过
                                        @elseif($item->audit==-1)
                                            不通过
                                        @endif
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>@if($item->audited_at){{ $item->audited_at }}@endif</td>
                                    <td class="do">
                                        @if($item->audit==0)
                                            <a href="{{ url('/admin/loan/audit/'.$item->order_id) }}"><button type="button" class="btn btn-default btn-sm">审核</button></a>
                                        @else
                                            <a href="{{ url('/admin/loan/audit/'.$item->order_id) }}"><button type="button" class="btn btn-default btn-sm">查看</button></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
