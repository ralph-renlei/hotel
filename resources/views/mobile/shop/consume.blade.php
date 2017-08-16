<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>消费凭证</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/iconfont.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css?t='.time()) }}" />
	</head>
	<body>
		<div class="whole">
			<header class="clearfix">
				<a href="{{ url('user') }}"><i class="iconfont icon-fanhui1"></i></a>
				<span class="h_title">消费凭证</span>
			</header>
			<div class="interval_bar clearfix">
				<div class="left install_text_left">
					消费日期
				</div>
				<div class="right">
					<input type="date" placeholder="" name="date" id="date" value="" />
				</div>
			</div>
			<div class="interval_bar clearfix">
				<div class="left install_text_left">
					包厢号/手牌号
				</div>
				<div class="right">
					<input type="text" placeholder="请输入" name="housenum" id="roomnum" value="" />
				</div>
			</div>
			<div class="interval_bar clearfix">
				<div class="left install_text_left">
					消费项目次数
				</div>
				<div class="right install_text_right">
					<span class="sub_num">-</span>
					<input type="number" class="cur_num" name="count" id="expensenum" value="1"/>
					<span class="add_num">+</span>
				</div>
			</div>
			<!--上传图片凭证-->
			<div class="interval_bar clearfix">
				<div class="left install_text_left" style="line-height: 92px;">
					上传图片凭证
				</div>
				<div class="right uploadimg">
					<img class="preview" />
					<img src="{{ asset('img/addimg.png') }}" class="addimg" />
					<input type="file" name="img" id="cur_file" accept="image/jpg,image/jpeg,image/png"/>
				</div>
			</div>
			<div class="interval_bar clearfix">
				<div class="left install_text_left">
					可获得返现金额
				</div>
				<div class="right install_text_right">
					<span style="font-size:16px;" class="backprice">{{ $cash }}</span>元
				</div>
			</div>
			<div class="interval_bar clearfix">
				<p class="red_text" style="font-size:14px;margin-top:10px;">{{ $store->store_name }}</p>
				<div class="comment left">
					<span style="line-height: 35px;font-size: 12px;" class="install_text_left">您对商家的评价</span>
				</div>
				<div class="right">
					<i class="iconfont icon-ds"></i>
					<i class="iconfont icon-ds"></i>
					<i class="iconfont icon-ds"></i>
					<i class="iconfont icon-ds"></i>
					<i class="iconfont icon-ds"></i>
				</div>
			</div>
            <input type="hidden" id="img_url" name="img_name"/>
			<input type="submit" class="btn red_btn" value="确认提交" onclick="submitForm();" />
			</form>
		</div>
	</body>
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript" charset="utf-8"></script>
    <script src="{{ asset('js/mobile.common.js?t='.time()) }}" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
        var SID = "{{ $store->id }}";
        var URL = "{{ url('consume') }}";
        var BONUS = '{!! json_encode($bonus) !!}';
        var LEVEL = "{{ $user->level }}";
        var UPLOADURL = "{{ url('upload/image') }}";

        var dataURL = "";
        var cur_file = document.getElementById("cur_file");
        var preview = document.querySelector(".preview");
        preview.style.display = "none";
        var addimg = document.querySelector(".addimg");

        if(typeof FileReader === 'undefined') {
            result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
            cur_file.setAttribute('disabled', 'disabled');
        } else {
            if(cur_file) {
                cur_file.addEventListener('change', readFile, false);
            }
        }

        function readFile() {
            var formData = new FormData();
            var $that = $(this);
            for(var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                reader.readAsDataURL(this.files[i]);
                formData.append("file", this.files[0]);
                reader.onload = function(e) {
                    preview.style.display = "inline-block";
                    addimg.style.display = "none";
                    img = document.querySelector(".preview");
                    img.setAttribute("src", this.result);
                    $.ajax({
                        type: "POST",
                        url: UPLOADURL,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if(res.code==0){
                                $('#img_url').val(res.data.src);
                            }
                        }
                    });
                }
            }
        }

        // 先将当前数量保存到c_num
        var c_num = $(".cur_num").val();
        $(".add_num").click(function() {
            c_num++;
            $(".cur_num").val(c_num);
            if(c_num == 1) {
                $(".backprice").text(Number(JSON.parse(BONUS).bonus1).toFixed(2));
            } else if(c_num == 2) {
                $(".backprice").text(Number(Number(JSON.parse(BONUS).bonus1) + Number(JSON.parse(BONUS).bonus2)).toFixed(2));
            } else {
                $(".backprice").text((Number(JSON.parse(BONUS).bonus1) + Number(JSON.parse(BONUS).bonus2) + Number(JSON.parse(BONUS).bonusn) * (Number(c_num) - 2)).toFixed(2));
            }
        });

        // 减少数量
        $(".sub_num").click(function() {
            if(Number(c_num) <= 1) {
                $(".cur_num").val("1");
            } else {
                c_num--;
                $(".cur_num").val(c_num);
                if(c_num == 1) {
                    $(".backprice").text(Number(JSON.parse(BONUS).bonus1).toFixed(2));
                } else if(c_num == 2) {
                    $(".backprice").text(Number(Number(JSON.parse(BONUS).bonus1) + Number(JSON.parse(BONUS).bonus2)).toFixed(2));
                } else {
                    $(".backprice").text((Number(JSON.parse(BONUS).bonus1) + Number(JSON.parse(BONUS).bonus2) + Number(JSON.parse(BONUS).bonusn) * (Number(c_num) - 2)).toFixed(2));
                }
            }
        });
        // 点亮星星
        var star = 0;
        $(".icon-ds").click(function() {
            $(".icon-ds").css("color", "");
            $(this).css("color", "#fd5001");
            $(this).prevAll("i").css("color", "#fd5001");
            star = $(this).index() + 1;
        });

        // 提交form表单数据
        function submitForm() {
            $('input[type="submit"]').css({
                background: "lightgrey",
                disabled: "disable"
            });

            var day = $("#date").val();
            var roomnum = $("#roomnum").val();
            var expensenum = $("#expensenum").val();
            var imgURL = $('#img_url').val();
            if(!day){
                alert('请选择日期');
                return false;
            }
            if(!roomnum || roomnum.length==0 || roomnum=='0' ){
                alert('请输入包厢号');
                return false;
            }
            if(!expensenum || expensenum.length==0 || expensenum =='0' ){
                alert('请选择消费次数');
                return false;
            }
            if(!imgURL){
                alert('请选择上传消费凭证');
                return false;
            }

            var data = {
                sid: SID,
                date: day,
                roomnum: roomnum,
                times: expensenum,
                imgURL: imgURL,
                star: star
            };
            $('input[type="submit"]').attr('disabled','disabled');
            $.ajax({
                type: "POST",
                url: URL,
                data: data,
                success: function(res) {
                    $('input[type="submit"]').removeAttr('disabled');
                    $('input[type="submit"]').css({
                        background: ""
                    });
                    if(res.code == 1) {
                        window.location.href = res.data;
                    } else {
                        alert(res.msg);
                    }
                },
                error:function(res){
                    $('input[type="submit"]').removeAttr('disabled');
                    $('input[type="submit"]').css({
                        background: ""
                    });
                    alert('发送异常');

                }
            });
        }
	</script>
</html>