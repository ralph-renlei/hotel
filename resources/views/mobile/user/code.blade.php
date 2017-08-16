<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>我的邀请码</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
			</header>
			<div class="record_wrap">
				@if(isset($code))
					@foreach($code as $item)
						<div class="interval_bar clearfix">
							<div class="left" style="width: 40%">
								<p style="float: left">{{$item->id}}</p><p style="float: right">{{$item->code}}</p>
								{{--<p>{{$list->created_at}}</p>--}}
							</div>
							<div class="right">
									@if($item->used==1)
									<p>已使用</p>
									@endif
							</div>
						</div>
					@endforeach
				@endif
			</div>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
</html>
