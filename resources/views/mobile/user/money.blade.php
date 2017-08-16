<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>交易明细</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
        <script>
            var LOCATE_URL = "{{ url('locate') }}";
            var URL = "{{ url('store') }}";
            var QQ_KEY = '2EEBZ-XZVKI-3K3GP-5LWGX-QNSS2-VNBFF';
            var DF_CITY = '西安';
            var DF_LAT = '34.34127';
            var DF_LNG = '108.93984';
            var UID = "{{ $user->id }}";
            var OPENID = "{{ $user->openid }}";
            var SITE = "{{ url() }}";
        </script>
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
                <a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">交易明细</span>
			</header>
			<div class="record_wrap" id="money_record">
                @include('mobile.user._money')
			</div>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('js/mobile.common.js') }}" type="text/javascript" charset="utf-8"></script>
</html>
