$("#check_out").click(function() {
	var goods_name = $('#goods_name').val();
	var openid = $('#openid').val();
	if(confirm('请确保已收拾好随身物品，即将断电！')) {
		$.ajax({
			type: "get",
			url: "/out_room",
			async: true,
			data: {goods_name:goods_name,openid:openid},
			success: function(res) {
				if(res.code == 0){
					alert(res.msg);
				}
			},
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
var countdown = 0;
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
	var today = new Date().getTime();
	var tommorow = today + 86400000;
	function fmtDate(obj){
		var date =  new Date(obj);
		var y = 1900+date.getYear();
		var m = "0"+(date.getMonth()+1);
		var d = "0"+date.getDate();
		return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
	}

	function getMyDay(date){
		var week;
		if(date.getDay()==0){
			week="周日";
		}
		if(date.getDay()==1) {week="周一";}
		if(date.getDay()==2) {week="周二";}
		if(date.getDay()==3) {week="周三";}
		if(date.getDay()==4) {week="周四";}
		if(date.getDay()==5) {week="周五";}
		if(date.getDay()==6) {week="周六";}
		return week;
	}
	var currentdate = fmtDate(today);
	var tomorrowdate = fmtDate(tommorow);
//	var currentdate = year + "-" + month + "-" + today;
//	var tomorrowdate = year + "-" + month + "-" + tomorrow;

	$(".sInput").text(currentdate);
	$(".eInput").text(tomorrowdate);

	var w1 = getMyDay(new Date($(".sInput").text()));
	$(".markToday").text(w1);
	var w2 = getMyDay(new Date($(".eInput").text()));
	$(".markTom").text(w2);

	var dateRange1 = new pickerDateRange('date1', {
		stopToday : false,
		isTodayValid : true,
		startDate: currentdate,
		endDate: tomorrowdate,
		needCompare : false,
		defaultText : ' 离开 ',
		autoSubmit : false,
		inputTrigger : 'input_trigger1',
		theme : 'ta',
	});

}

// 获取localStorage中存的时间
function getLocalstorage(){
	var stime = localStorage.getItem('stime');
	var etime = localStorage.getItem('etime');
	var sweek = localStorage.getItem('sweek');
	var eweek = localStorage.getItem('eweek');
	var allday = localStorage.getItem('allday');

	$("#stime").text(stime);
	$("#etime").text(etime);
	$("#sweek").text(sweek);
	$("#eweek").text(eweek);
	$("#allday").text(allday);


	console.log(stime);
}
