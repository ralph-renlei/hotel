<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>充值</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">充值</span>
			</header>
			<div class="content">
				<div class="c_top">
					@foreach($list as $item)
						@if($item->promote==1)
					<div class="promotion clearfix">
						<span class="c_title">促销充值</span>
						<div class="charge_cell card" style="background:#11b6f5;" id="card{{ $item->id }}" data="{{ $item->id }}">
							<p>{{ $item->promote_months }}个月</p>
							<p>{{ $item->promote_money }}元</p>
						</div>
					</div>
					<p class="c_note">&emsp;活动说明： 充值会员特权</p>
					<p class="c_note">&emsp;截止日期： {{ date('Y-m-d',$item->end_time) }}</p>
						@endif
					@endforeach
				</div>
				@foreach($sale_list as $sale)
				<div class="c_mid">
					@foreach($sale as $s)
					<div class="charge_cell card" id="card{{ $s->id }}" data="{{ $s->id }}">
						<p>{{ $s->months }}个月</p>
						<p>{{ $s->money }}元</p>
					</div>
					@endforeach
				</div>
				@endforeach
			</div>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/mobile.common.js?t='.time()) }}" ></script>
   <script>
       var PAY_URL = "{{ url('pay') }}";
       var SUCC_URL = "{{ url('charge') }}";

       var UID = "{{ $uid }}";
       var OPENID = "{{ $openid }}";
        $('.card').on('click', function (i) {
            var id = $(this).attr('data');
            $.ajax({
                url:PAY_URL,
                type:'post',
                dataType:'json',
                data:{id:id,uid:UID,openid:OPENID},
                success:function(res){
                    if(res.code==1) {
                        WeixinJSBridge.invoke(
                                    'getBrandWCPayRequest', {
                                        "appId":res.data.appId,     //公众号名称，由商户传入
                                        "timeStamp":res.data.timeStamp,         //时间戳，自1970年以来的秒数
                                        "nonceStr":res.data.nonceStr, //随机串
                                        "package":res.data.package,
                                        "signType":res.data.signType,         //微信签名方式：
                                        "paySign":res.data.paySign
                                    },
                                    function(res){
                                        if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                                            window.location.href = SUCC_URL;
                                        }else{
                                            alert('支付失败');
                                        }
                                    }
                            );
                    }else{
                        alert(res.msg);
                        if(res.data){
                            window.location.href = res.data.url;
                        }
                        return false;
                    }
                },
                error:function(jqXHR,textStatus, errorThrown){
                    alert('发送异常，请重试');
                    return false;
                }
            });
    });
   </script>
</html>