<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>资质认证</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('mui/css/mui.min.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('mui/css/mui.picker.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('mui/css/mui.poppicker.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('css/iconfont.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<a href="javascript:history.back(-1);"><i class="iconfont icon-fanhui"></i></a>
		</header>
		<div class="release_wrap">
			<div class="r_cell clearfix">
				<div class="left approve_title">
					<i class="iconfont icon-ph-1info-on"></i>
					<span>个人信息</span>
				</div>
			</div>
		</div>
		<p class="note grey_text">带<span class="red_annotation">*</span>为必填项</p>
		<div class="release_wrap">
			<div class="r_cell clearfix">
				<div class="left">
					<span class="red_annotation">*</span>真实姓名
				</div>
				<div class="right">
					<input type="text" name="" id="real_name" value="" placeholder="输入真实姓名" />
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="describe">
					<span class="red_annotation">*</span>身份证
				</div>
				<!--<div class="blank"></div>-->
				<div class="" style="height: 100px;overflow: hidden;">
					<div class="upimg_box left" style="">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="idcardbefore_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传正面照片）</p>

				</div>
				<div class="" style="height: 100px;overflow: hidden;">
					<div class="upimg_box left" style="">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="idcardback_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传反面照片）</p>
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					<span class="red_annotation">*</span>身高
				</div>
				<div class="right">
					<input type="number" name="" id="height" value="" placeholder="输入身高" />cm
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					<span class="red_annotation">*</span>体重
				</div>
				<div class="right">
					<input type="number" name="" id="weight" value="" placeholder="输入体重" />kg
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					<span class="red_annotation">*</span>个人微信号
				</div>
				<div class="right">
					<input type="text" name="" id="weixin" value="" placeholder="输入微信号" />
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					<span class="red_annotation">*</span>电子邮箱
				</div>
				<div class="right">
					<input type="email" name="" id="email" value="" placeholder="输入电子邮箱" />
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					<span class="red_annotation">*</span>手机号
				</div>
				<div class="right">
					<input type="number" name="" id="phone" value="" placeholder="输入手机号" />
				</div>
			</div>
		</div>
		<div class="release_wrap">
			<div class="r_cell">
				<div class="clearfix">
					<div class="left">
						<span class="red_annotation">*</span>驾驶证
					</div>
					<div class="right">
						<p class="having_card driving_card">请选择</p>
					</div>
				</div>
				<div class="have_wrap clearfix">
					<div class="upimg_box left">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="driving_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传证件照片）</p>
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="clearfix">
					<div class="left">
						<span class="red_annotation">*</span>护照号码
					</div>
					<div class="right">
						<p class="having_card passport_card">请选择</p>
					</div>
				</div>
				<div class="have_wrap clearfix">
					<div class="upimg_box left">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="passport_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传证件照片）</p>
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="clearfix">
					<div class="left">
						<span class="red_annotation">*</span>港澳通行证
					</div>
					<div class="right">
						<p class="having_card pass_card">请选择</p>
					</div>
				</div>
				<div class="have_wrap clearfix">
					<div class="upimg_box left">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="pass_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传证件照片）</p>
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="clearfix">
					<div class="left">
						<span class="red_annotation">*</span>台湾通行证
					</div>
					<div class="right">
						<p class="having_card taiwan_card">请选择</p>
					</div>
				</div>
				<div class="have_wrap clearfix">
					<div class="upimg_box left">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="taiwan_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传证件照片）</p>
				</div>
			</div>
		</div>
		<!--个人车辆信息-->
		<div class="release_wrap">
			<div class="r_cell clearfix">
				<div class="clearfix">
					<div class="left">
						<span class="red_annotation">*</span>个人车辆信息
					</div>
					<div class="right">
						<p class="having_card car_card">请选择</p>
					</div>
				</div>
				<div class="have_wrap clearfix">
					<div class="upimg_box left">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="car_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（上传照片）</p>
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					房产信息
				</div>
				<div class="right">
					<input id="house_address" name="" id="" value="" placeholder="输入房产的所在地址或无" />
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="clearfix">
					<div class="left">
						<span class="red_annotation">*</span>个人现实际住址
					</div>
					<div class="right">
						<p class="having_card taiwan_card">请选择居住类型</p>
					</div>
				</div>
				<div class="have_wrap clearfix">
					<div class="upimg_box left">
						<i class="iconfont icon-jiahao"></i>
						<input type="file" name="" id="housecard_file" value="" accept="image/jpeg,image/png,image/jpg" />
					</div>
					<div class="imgmain_container"></div>
					<p class="img_note grey_text">（请上传租房合同或房产证）</p>
				</div>
			</div>
			<div class="r_cell clearfix">
				<div class="left">
					户口所在地地址
				</div>
				<div class="right">
					<input id="origin_address" name="" id="" value="" placeholder="输入户口所在地地址" />
				</div>
			</div>
		</div>
		<a>
			{{--
			<a href="{{url('work')}}">--}}
				<p class="btn true_btn submit_person">下一步</p>
			</a>
	</body>
	<script src="{{asset('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/data.city.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/mui.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/mui.picker.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('mui/js/mui.poppicker.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var UPLOADURL = "{{ url('upload/image') }}";
	</script>

</html>