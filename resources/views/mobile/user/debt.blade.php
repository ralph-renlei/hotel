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
			<i class="iconfont icon-zhaiquan"></i>
			<span>负债信息</span>
		</div>
	</div>
</div>
<p class="note grey_text">带<span class="red_annotation">*</span>为必填项</p>
<div class="release_wrap">
	<div class="r_cell clearfix">
		<div class="left">房贷</div>
		<div class="right">
			<input type="text" name="" id="house_debt" value="" placeholder="请输入贷款总额或无" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">车贷</div>
		<div class="right">
			<input type="text" name="" id="car_debt" value="" placeholder="请输入贷款总额或无" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">信用卡</div>
		<div class="right">
			<input type="text" name="" id="credit_debt" value="" placeholder="请输入贷款总额或无" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">手机分期</div>
		<div class="right">
			<input type="text" name="" id="phone_debt" value="" placeholder="请输入贷款总额或无" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">网贷</div>
		<div class="right">
			<input type="text" name="" id="net_debt" value="" placeholder="请输入贷款总额或无" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">其他欠款</div>
		<div class="right">
			<input type="text" name="" id="other_debt" value="" placeholder="请输入贷款总额或无" />
		</div>
	</div>
</div>
<!--个人生活照-->
<div class="release_wrap">
	<div class="r_cell clearfix">
		<div class="describe">个人生活照</div>
		<div class="blank"></div>
		<div class="upimg_box left">
			<i class="iconfont icon-jiahao"></i>
			<input type="file" name="" id="person_photo" value="" accept="image/jpeg,image/png,image/jpg"/>
		</div>
		<div class="imgmain_container"></div>
		<p class="img_note grey_text">（上传个人生活照1张）</p>
	</div>
</div>
<!--紧急联系人-->
<div class="release_wrap">
	<div class="r_cell clearfix">
		<div class="left"><span class="red_annotation">*</span>紧急联系人姓名(父/母)</div>
		<div class="right">
			<input type="text" name="" id="urgency_name" value="" placeholder="请输入" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left"><span class="red_annotation">*</span>手机</div>
		<div class="right">
			<input type="text" name="" id="urgency_mobilephone" value="" placeholder="请输入" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left">电话（选填）</div>
		<div class="right">
			<input type="text" name="" id="urgency_phone" value="" placeholder="请输入" />
		</div>
	</div>
	<div class="r_cell clearfix">
		<div class="left"><span class="red_annotation">*</span>工作单位</div>
		<div class="right">
			<input type="text" name="" id="urgency_companyname" value="" placeholder="请输入" />
		</div>
	</div>
</div>
<p class="btn true_btn submit_debt">下一步</p>
</body>
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/data.city.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/mui.min.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/mui.picker.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('mui/js/mui.poppicker.js')}}" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
<script>
	var UPLOADURL = "{{ url('upload/image') }}";
</script>
</html>