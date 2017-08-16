<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>资质认证</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('mui/css/mui.min.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('mui/css/mui.picker.css')}}"/>
		<link rel="stylesheet" type="text/css" href="{{asset('mui/css/mui.poppicker.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
		</header>
		<div class="release_wrap">
			<div class="r_cell clearfix">
				<div class="left approve_title">
					<i class="iconfont icon-daikuan"></i>
					<span>贷款信息</span>
				</div>
			</div>
		</div>
		<p class="note grey_text">带<span class="red_annotation">*</span>为必填项</p>
		<div class="release_wrap">
			<div class="r_cell clearfix">
				<div class="left">个人月收入</div>
				<div class="right">
					<input type="number" name="" id="month_earning" value="" placeholder="请输入" />元
				</div>
			</div>
			<div class="r_cell clearfix purpose">
				<div class="describe">
					分期用途(多选)
				</div>
				<div class="purpose_wrap">
					<span class="purpose_cell">整形美容</span>
					<span class="purpose_cell">奢侈品</span>
					<span class="purpose_cell">购房</span>
				</div>
				<div class="purpose_wrap">
					<span class="purpose_cell">购车</span>
					<span class="purpose_cell">旅游</span>
					<span class="purpose_cell">健身</span>
				</div>
				<div class="purpose_wrap">
					<span class="purpose_cell">教育</span>
					<span class="purpose_cell">房屋租赁</span>
					<span class="purpose_cell">投资装修</span>
				</div>
				<div class="purpose_wrap">
					<span class="purpose_cell">婚庆</span>
					<span class="purpose_cell">居家</span>
					<span class="purpose_cell">数码产品</span>
				</div>
				<div class="purpose_wrap">
					<span class="purpose_cell">资金周转</span>
				</div>
			</div>

			<div class="r_cell clearfix">
				<div class="left">分期金额需求</div>
				<div class="right">
					<p class="price_need">请选择</p>
				</div>
			</div>
		</div>
		<p class="btn true_btn submit_loan">确定</p>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/data.city.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/mui.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/mui.picker.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/mui.poppicker.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>

</html>