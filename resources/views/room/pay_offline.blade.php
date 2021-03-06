<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8" />
		<title>线上预订</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/dateRange.css')}}"/>
	</head>

	<body>
		<div class="main_top">
			<img src="{{asset('/hotel/img/main.png')}}" class="hotel_img" />
			<p class="hotel_title">淘源圆岭岗</p>
			<p class="reserve_type">线上预订</p>
		</div>
		<div class="qrcode_wrap">
			<a class="button orange_btn" href="javascript:void(0);" onclick="pay()">立即付款</a>
		</div>
		</div>

		<p class="mainbtn_wrap">
			<span class="online_line"></span>
			<span class="bottom_title">淘源圆岭岗</span>
			<span class="online_line"></span>
		</p>
	</body>

	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/dateRange.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		init_date();
		function pay(){
			var uid = "{{$uid}}";
			var openid = "{{$openid}}";
			var category_name = "{{$category_name}}";
			var order_amount  = "{{$order_amount}}";
			var goods_id = "{{$goods_id}}";
			$.ajax({
				url: '/prepay',
				type: 'get',
				dataType: 'json',
				data: {
					uid:uid,
					openid:openid,
					category_name:category_name,
					order_amount:order_amount,
					goods_id:goods_id,
				},
				success: function(res) {
					if(res.code == 1) {
						//onBridgeReady(res.data.appId,res.data.timeStamp,res.data.nonceStr,res.data.package,res.data.signType,res.data.paySign);
                        WeixinJSBridge.invoke(
                                'getBrandWCPayRequest', {
                                    "appId":res.data.appId,     //公众号名称，由商户传入
                                    "timeStamp":res.data.timeStamp,         //时间戳，自1970年以来的秒数
                                    "nonceStr":res.data.nonceStr, //随机串
                                    "package":res.data.package,
                                    "signType":res.data.signType,         //微信签名方式：
                                    "paySign":res.data.paySign //微信签名
                                },
                                function(res){
									if(res.err_msg == "get_brand_wcpay_request:ok" ) {
										window.location.href = '/pay_success_offline';
									}
									if(res.err_msg == 'get_brand_wcpay_request:fail' || res.err_msg == 'get_brand_wcpay_request:cancel'){
										window.location.href = '/pay_error';
									}
                                }
                        );
					} else {
						alert(res.msg);
						return false;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('发送异常，请重试');
					return false;
				}
			});
		}
	</script>

</html>