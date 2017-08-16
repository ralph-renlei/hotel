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
			<i class="iconfont icon-gongzuo"></i>
			<span>工作信息</span>
		</div>
	</div>
</div>
<p class="note grey_text">带<span class="red_annotation">*</span>为必填项</p>
<div class="release_wrap">
	<div class="r_cell clearfix">
		<div class="left">工作性质</div>
		<div class="right">
			<input type="text" name="" id="work_nature" value="" placeholder="请输入" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">工作单位名称</div>
		<div class="right">
			<input type="text" name="" id="company_name" value="" placeholder="请输入" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">当前工作年限</div>
		<div class="right">
			<p id="work_year">请选择</p>
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">工作单位地址</div>
		<div class="right">
			<input type="text" name="" id="company_address" value="" placeholder="请输入" />
		</div>
	</div>
</div>
<div class="release_wrap">
	<div class="r_cell clearfix">
		<div class="left">工作单位负责人姓名</div>
		<div class="right">
			<input type="text" name="" id="principal_name" value="" placeholder="请输入" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">工作单位负责人电话</div>
		<div class="right">
			<input type="number" name="" id="principal_phone" value="" placeholder="请输入" />
		</div>
	</div>
</div>
<a><p class="btn true_btn submit_workinfo">下一步</p></a>
</body>
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/data.city.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/mui.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/mui.picker.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/mui.poppicker.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
</html>