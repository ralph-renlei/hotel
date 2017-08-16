<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>返现申请详情</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="{{ url('cash') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">返现申请详情</span>
			</header>
			<div class="record_wrap">
				<div class="interval_bar clearfix">
					<div class="left">
						<p style="font-size: 16px;">{{ $cash->store_name }}</p>
						@if($cash->status==-1)
                            <p class="audit_state">审核状态：<span>已驳回</span></p>
						    <span class="red_text">原因：{{ $cash->note }}</span>
                        @elseif($cash->status==1)
                            <p class="audit_state">审核状态：<span>成功</span></p>
                        @elseif($cash->status==0)
                            <p class="audit_state">审核状态：<span>审核中</span></p>
                        @endif
					</div>
				</div>
				<div class="info_content">
					<div class="info clearfix">
						<span>消费日期</span>
						<span>{{ $cash->date }}</span>
					</div>
					<div class="info clearfix">
						<span>包厢号/手牌号</span>
						<span>{{ $cash->no }}</span>
					</div>
					<div class="info clearfix">
						<span>消费项目次数</span>
						<span>{{ $cash->total }}次</span>
					</div>
					<div class="info clearfix" style="height: 90px;">
						<span style="line-height: 90px;">图片凭证</span>
						<span class="imgup">
							<img src="{{ $cash->image }}"/>
						</span>
					</div>
					<div class="info clearfix">
						<span>您对商家的评价</span>
						<span>
                            @if($cash->star==1)
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif($cash->star==2)
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif($cash->star==3)
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif($cash->star==4)
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds"></i>
                            @elseif($cash->star==5)
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                                <i class="iconfont icon-ds" style="color: #fd5001;"></i>
                            @else
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                                <i class="iconfont icon-ds"></i>
                            @endif
						</span>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('js/mobile.common.js?t='.time()) }}" ></script>
</html>