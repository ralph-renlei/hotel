$("#check_out").click(function() {
	if(confirm('确定退房？十分钟后将自动断电！')) {
		$.ajax({
			type: "get",
			url: "/out_room",
			async: true,
			data: {},
			success: function(res) {},
		});
		setTimeout(function() {
			alert("欢迎您下次光临！");
		}, 1000);
	}
});
$(".submit_order").click(function() {
	var username = $("#checkin_name").val();
	var phone = $("#checkin_phone").val();
	var start = $('#start').text();
	var end = $('#end').text();
	var str = $('#order_amount').text();
	var order_amount = str.replace('￥','');
	var id = $('#category_id').attr('data');
	var goods_id = $('#goods_id').attr('data');
	var goods_name = $('#goods_name').attr('data');
	var category_name = $('#category_name').text();
	var forms = $('#forms').val();
	if(username == '' || phone == ''){
		alert('您的信息必须填写');
		return false;
	}

	if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(phone))){
		alert('手机号格式不正确');
		return false;
	}
	$.ajax({
		type: "POST",
		url: "/reserve/ordercommit",
		async: true,
		data: {
			_token:"{{csrf_token()}}",
			username: username,
			phone: phone,
			start: start,
			end: end,
			order_amount: order_amount,
			id:id,
			goods_id:goods_id,
			goods_name:goods_name,
			category_name:category_name,
			forms:forms,
		},
		success: function(res) {
			if(res.code==1) {
				window.location.href = "/pay?uid="+res.data.uid+"&openid="+res.data.openid+"&category_name="+res.data.category_name+"&order_amount="+res.data.order_amount+"&goods_id="+res.data.goods_id;
				//window.location.href = '/unifiedorder';
			}else{
				alert(res.msg);
				window.location.href= '/';
			}
		},
	});
});

//上传图片
var idcardbefore_file = document.getElementById("idcardbefore_file");
var idcardback_file = document.getElementById("idcardback_file");
if(typeof FileReader === 'undefined') {
	result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
	input1.setAttribute('disabled', 'disabled');
} else {
	//身份证
	if(idcardbefore_file) {
		idcardbefore_file.addEventListener('change', readFile, false);
	}
	if(idcardback_file) {
		idcardback_file.addEventListener('change', readFile, false);
	}
}
function readFile() {
	var UPLOADURL = '/upload/image';
	var formData = new FormData();
	var $that = $(this);
	$that.parent().css("display", "none");
//	$that.parent().next().html('');
	for(var i = 0; i < this.files.length; i++) {
		var reader = new FileReader();
		reader.readAsDataURL(this.files[i]);
		formData.append("file", this.files[0]);
		reader.onload = function(e) {
			img = document.createElement('img');
			img.setAttribute("src", this.result);
			console.log($that.parent().next().children(':first'));
			$that.parent().next().children(':first').css("display", "initial");
			$.ajax({
				type: "POST",
				url: UPLOADURL,
				data: formData,
				processData: false,
				contentType: false,
				success: function(res) {
					$that.attr("data_url", res.data.src);
				}
			});
			$that.parent().next().prepend(img);
		}
	}
}
//图片点击删除
$(".delete_wrap").click(function(){
	$(this).parent().prev().css("display",'initial');
	$(this).css("display", "none");
	$(this).siblings().remove();
});

//验证手机号码
function checkMobile(option) {
	var sMobile = $(option).val();
	if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(sMobile))) {
		$(option).val("");
		return false;
	} else {
		return true;
	}
}

// post发送手机号和验证码
function validation() {
	var mobile = $("#phone").val();
	var code = $("#vertify_code").val();
	if(!mobile || !code) {
		alert('手机号码和验证码不能为空');
		return false;
	}

	$.ajax({
		type: "GET",
		url: '/member/setting/bind',
		data: {
			mobile: mobile,
			code: code,
		},
		dataType: "json",
		success: function(res) {
			if(res.code == 1) {
				if(res.data.url) {
					window.location.href = res.data.url;
				}
			}else{
				alert(res.msg)
			}
		},
		error: function(msg) {
			alert('发生异常，请重试');
		}
	});
}

// 发送验证码  --
$(".send_code").bind("click", function() {
	var mobile = $('#phone').val();
	if(!mobile) {
		alert("手机号不能为空");
		return false;
	}

	var v = this;
	settime(v);
	$.ajax({
		url: '/sms/sendcode',
		type: 'post',
		dataType: 'json',
		data: {
			mobile: mobile
		},
		success: function(res) {
			if(res.code == 1) {
//				settime(v);
			} else {
				alert(res.msg);
				return false;
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert('发送异常，请重试');
			return false;
		}
	});
});

// 发送验证码倒计时
var countdown = 60;
function settime(v) {
	if(checkMobile($(v).parent().prev().children().eq(1).children()) || checkMobile($(v).prev())) {
		if(countdown == 0) {
			$(v).removeAttr("disabled");
			$(v).val("重新发送");
			$(v).attr("class", "right send_code new_sendcode");
			countdown = 60;
		} else {
			$(v).attr("disabled", true);
			$(v).attr("class", "right send_code new_sendcode grey_sendcode");
			$(v).val("(" + countdown + "s)");
			countdown--;

			setTimeout(function() {
				settime(v)
			}, 1000)
		}
	} else {
		//alert("请输入合法的手机号");
	}
}

//管理员审核
function agree() {
	$.ajax({
		type:"get",
		url:"/member/mobile_credit_make",
		async:true,
		data:{'openid':$('#openid').val(),'flag':'ok'},
		success: function(res){
			if(res.code == 1){
				setTimeout(function() {
					alert('已同意！');
				}, 1000);
			}
		}
	});
}

function reject() {
	$.ajax({
		type:'get',
		url:"/member/mobile_credit_make",
		async:true,
		data:{'openid':$('#openid').val(),'flag':'no'},
		success: function(res){
			if(res.code == 0){
				setTimeout(function() {
					alert('已驳回！');
				}, 1000);
			}
		}
	});
}

function assignRoom(){
	$.ajax({
		type:"POST",
		url:"/mobile_room_arrange",
		async:true,
		data:{
			goods_id: $('#goods_id').val(),
			goods_name:$('#goods_id').find('option:selected').text(),
			category_name:$('#room_type').find('option:selected').text(),
			order_sn:$('#order_sn').val(),
		},

		success: function(res){
			if(res.code == 1){
				alert('成功');
			}
		}
	});
}

//时间选择
function init_date() {
	var nowDate = new Date();
	var nowyear = nowDate.getFullYear();
	var nowmonth = nowDate.getMonth() + 1;
	var nowday = nowDate.getDate();
	var tomorrowday = Number(nowday) + 1;
	var today = nowyear + '-' + nowmonth + '-' + nowday;
	var tomorrow = nowyear + '-' + nowmonth + '-' + tomorrowday;

	var dateRange1 = new pickerDateRange('date1', {
		stopToday: false,
		isTodayValid: true,
		startDate: today,
		endDate: tomorrow,
		needCompare: false,
		defaultText: ' 离开 ',
		autoSubmit: false,
		inputTrigger: 'input_trigger1',
		theme: 'ta',
		autoSubmit: 'true'
		
	});

}