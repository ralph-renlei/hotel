<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>交易记录</title>
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
				@if(isset($moneyList))
					@if(count($moneyList)>0)
						@foreach($moneyList as $list)
							<div class="interval_bar clearfix">
								<div class="left">
									<p>{{$list->title}}</p>
									<p>{{$list->created_at}}</p>
								</div>
								<div class="right">
									@if($list->type==0)
										<p>-{{$list->money}}</p>
									@elseif($list->type==1)
										<p>+{{$list->money}}</p>
									@endif
									<p class="passed">已成功</p>
								</div>
							</div>
						@endforeach
					@else
						<p style="font-size: 14px;color: #666;text-align: center;margin-top: 10px;">尚无交易记录</p>
					@endif
				@endif
			</div>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>
