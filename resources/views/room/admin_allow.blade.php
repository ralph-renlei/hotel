<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>分配房间</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/style.css')}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('/hotel/css/iconfont/iconfont.css')}}" />
	</head>

	<body>
		<header class="clearfix">
			<!--<a href="javascript:history.back(-1);"><i class="iconfont icon-qianjin-copy"></i></a>-->
			<!--<span class="h_title"></span>-->
			<!--<i class="iconfont right icon-biaodan"></i>-->
		</header>
		<div class="no_interval_wrap">
			<div class="no_interval_on">
				<div class="no_interval_cell">
					<span class="">姓名：</span >
					<input type="text" name="username" id="username" value="{{$userinfo->name}}" readonly="readonly"/>
				</div>
				<div class="no_interval_cell">
					<span >手机：</span >
					<input type="text" name="phone" id="phone" value="{{$userinfo->mobile}}" readonly="readonly"/>
				</div>
				<div class="no_interval_cell">
					<span >房型：</span >
					<input type="text" name="category_name" id="category_name" value="{{$room[0]->category_name}}" readonly="readonly"/>
				</div>
				<div class="no_interval_cell">
					<span >房间号：</span >
					<input type="hidden" id="goods_id" name="goods_id" value="{{$room[0]->goods_id}}"/>
					<input type="hidden" id="order_sn" name="order_sn" value="{{$order_sn}}"/>
					<input type="text" name="goods_name" id="goods_name" value="{{$room[0]->name}}"  readonly="readonly"/>
					<!--<input type="text" name="idcard_number" id="idcard_number" value="8080" placeholder="请输入身份证号码"/>-->
				</div>
			</div>
		</div>
		<p class="button orange_btn" onclick="allow()">确定</p>

	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		function allow(){
				$.ajax({
					type:"POST",
					url:"/mobile_room_arrange",
					async:true,
					data:{
						goods_id: $('#goods_id').val(),
						goods_name:$('#goods_name').val(),
						category_name:"{{$room[0]->category_name}}",
						order_sn:$('#order_sn').val(),
						forms:0,
					},

					success: function(res){
						if(res.code == 1){
							alert('成功');
						}
					}
				});
		}
	</script>
</html>