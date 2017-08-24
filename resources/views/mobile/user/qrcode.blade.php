<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>推广二维码</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">推广二维码</span>
				<i class="iconfont icon-share" id="share"></i>
			</header>
			<div class="info_wrap clearfix">
				<img class="avatar" src="{{ $user->avatar }}" onerror="this.src='{{ asset('img/avatar.png') }}'"/>
				<div class="info_right">
					<p>{{ $user->nickname }}</p>
					<p class="grey_text">{{ $user->created_at }}</p>
				</div>
			</div>
			<img src="http://qr.topscan.com/api.php?bg=f3f3f3&fg=ff0000&gc=222222&el=l&w=200&m=10&text={{ $qrcode_url }}" class="erweima"/>
		</div>
	</body>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
	<script src="{{ asset('js/mobile.common.js') }}" type="text/javascript" charset="utf-8"></script>
    <script>
        wx.config({
            debug: true,
            appId: '{{ $signPackage['appId'] }}',
            timestamp: '{{ $signPackage['timestamp'] }}',
            nonceStr: '{{ $signPackage['nonceStr'] }}',
            signature: '{{ $signPackage['signature'] }}',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'chooseImage',
                'previewImage',
                'uploadImage',
                'downloadImage',
                'getNetworkType',
                'openLocation',
                'getLocation',
                'hideOptionMenu',
                'showOptionMenu',
                'closeWindow',
                'scanQRCode'
            ]
        });
        wx.ready(function () {
            document.querySelector('#share').onclick = function () {
                //分享到朋友圈
                wx.onMenuShareTimeline({
                    title: '赛高娱乐邀请您', // 分享标题
                    link: "{{ $qrcode_url }}", // 分享链接
                    imgUrl: "http://qr.topscan.com/api.php?bg=f3f3f3&fg=ff0000&gc=222222&el=l&w=200&m=10&text={{ $qrcode_url }}", // 分享图标
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert('分享成功');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        alert('取消分享');
                    }
                });

                wx.onMenuShareAppMessage({
                    title: '赛高娱乐邀请您', // 分享标题
                    desc: '', // 分享描述
                    link: "{{ $qrcode_url }}", // 分享链接
                    imgUrl: "http://qr.topscan.com/api.php?bg=f3f3f3&fg=ff0000&gc=222222&el=l&w=200&m=10&text={{ $qrcode_url }}", // 分享图标
                    type: 'link', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                        // 用户确认分享后执行的回调函数
                        alert('分享成功');
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                        alert('取消分享');
                    }
                });

            };
        });

    </script>
</html>
