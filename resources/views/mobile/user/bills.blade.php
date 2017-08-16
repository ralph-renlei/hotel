<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>账单列表</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
	</head>
	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
		</header>
		@foreach($refunds as $refund)
			@if($refund->select==1)
				<a class="bill_list bill_list_all current_bill" href="javascript:;">
					<div class="left">
						<p>
							<span>{{$refund->title}}</span>
							<span>{{$refund->money}}</span>
						</p>
						<p>
						<span><input type="checkbox" name="" value="{{$refund->id}}" class="checkbox_refund"/>第{{$refund->num}}/{{$refund->nums}}期</span>
					    <span>
							@if($refund->status==0)
								待还款
							@elseif($refund->status==1)
								已还
							@elseif($refund->status==-1)
								逾期
							@endif
						</span>
						</p>
					</div>
				</a>
			@else
			<a class="bill_list bill_list_all" href="javascript:;">
				<div class="left">
					<p>
					<span>{{$refund->title}}</span>
					<span>{{$refund->money}}</span>
					</p>
					<p>
						<span><input type="checkbox" name="" value="{{$refund->id}}" class="checkbox_refund"/>第{{$refund->num}}/{{$refund->nums}}期</span>
						<span>	@if($refund->status==0)
								待还款
							@elseif($refund->status==1)
								已还
							@elseif($refund->status==-1)
								逾期
							@endif
						</span>
					</p>
				</div>
			</a>
			@endif
		@endforeach
		<p class="btn true_btn" id="before_refund">提前还款</p>
	</body>
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script>
	$('#before_refund').hide();
	$(".checkbox_refund").change(function() {
		$("#before_refund").show();
	});
	var array_id =[];
	$("#before_refund").click(function() {
		$(".checkbox_refund").each(function () {
			if ($(this).is(":checked")) {
				array_id.push($(this).val());
			}
		})
		$.ajax({
			type: "POST",
			url: "recharge",
			data: {
				ids:array_id,
				type: 'refund'
			},
			success: function(res) {
				if(res.data.url){
					window.location.href = 'https://pay.swiftpass.cn/pay/jspay'+res.data.url;
				}
			},
			error: function(msg) {
				alert(JSON.stringify(msg));
			}
		});
	})
</script>
</html>
