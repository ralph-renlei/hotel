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
					<input type="text" name="username" id="username" value="{{$userinfo->username}}" readonly="readonly"/>
				</div>
				<div class="no_interval_cell">
					<span >手机：</span >
					<input type="text" name="phone" id="phone" value="{{$userinfo->phone}}" readonly="readonly"/>
				</div>
				<div class="no_interval_cell">
					<span >房型：</span >
					<select name="room_type" id="room_type">
						@foreach($categorys as $category)
						<option value="{{$category->id}}" @if($id == $category->id) selected @endif disabled>{{$category->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="no_interval_cell">
					<span >房间号：</span >
					<select name="room_number" id="goods_id">
						@foreach($rooms as $room)
						<option value="{{$room->goods_id}}">{{$room->name}}</option>
						@endforeach
					</select>
					<input type="hidden" name="order_sn" id="order_sn" value="{{$order_sn}}"/>
					<!--<input type="text" name="idcard_number" id="idcard_number" value="8080" placeholder="请输入身份证号码"/>-->
				</div>
			</div>
		</div>
		<p class="button orange_btn" onclick="assignRoom()">确定</p>

	</body>
	<script src="{{asset('/hotel/js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
	<script src="{{asset('/hotel/js/common.js')}}" type="text/javascript" charset="utf-8"></script>

</html>