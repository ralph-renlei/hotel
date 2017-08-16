@extends('app')
@section('content')
<div class="container">
	<div class="row">
		@include('menu')
		<div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">地区列表</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table">
							<tr>
								<th class="info">ID</th>
								<th class="info">类型</th>
								<th class="info">内容</th>
							</tr>
							@foreach ($list as $item)
								<tr>
									<td>{{ $item->code }}</td>
									<td>{{ $type }}</td>
									<td>{{ $item->name }}</td>
								</tr>
							@endforeach
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
