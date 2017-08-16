<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>申请记录</title>
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
				@if(isset($loanList))
					@if(count($loanList)>0)
						@foreach($loanList as $list)
							<div class="interval_bar clearfix">
								<div class="left">
									<p>{{$list->title}}</p>
									<p>{{$list->created_at}}</p>
								</div>
								<div class="right">
									<p>￥{{$list->loan_money}}&nbsp;手续费:￥{{$list->loan_money*$list->loan_fee}}</p>
										@if($list->audit==0)
											<p class="shenhe">审核中</p>
										@elseif($list->audit==1)
											<p class="passed"><span class="poundage" data-id="{{$list->order_id}}">交手续费</span>成功</p>
										@elseif($list->audit==-1)
											<p class="failed">已驳回</p>
										@endif
								</div>
							</div>
						@endforeach
						@else
							<p style="font-size: 14px;color: #666;text-align: center;margin-top: 10px;">尚无申请记录</p>
						@endif
				@endif
			</div>
		</div>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>
