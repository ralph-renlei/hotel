var idcardbefore_file = document.getElementById("idcardbefore_file");
var idcardback_file = document.getElementById("idcardback_file");

var driving_file = document.getElementById("driving_file");
var passport_file = document.getElementById("passport_file");
var pass_file = document.getElementById("pass_file");
var taiwan_file = document.getElementById("taiwan_file");

var car_file = document.getElementById("car_file");
var housecard_file = document.getElementById("housecard_file");

var personphoto_file = document.getElementById("person_photo");


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
	//驾驶证
	if(driving_file) {
		driving_file.addEventListener('change', readFile, false);
	}
	//护照
	if(passport_file) {
		passport_file.addEventListener('change', readFile, false);
	}
	//港澳通行证
	if(pass_file) {
		pass_file.addEventListener('change', readFile, false);
	}
	//台湾通行证
	if(taiwan_file) {
		taiwan_file.addEventListener('change', readFile, false);
	}
	//车辆信息
	if(car_file) {
		car_file.addEventListener('change', readFile, false);
	}
	// 住址信息
	if(housecard_file) {
		housecard_file.addEventListener('change', readFile, false);
	}
	// 个人生活照
	if(personphoto_file){
		personphoto_file.addEventListener('change', readFile, false);
	}
}
// 选择证件有无
$(".having_card").click(function() {
	var $that = $(this);
	var picker = new mui.PopPicker();
	picker.setData(have_picker);
	picker.show(function(items) {
		$that.text(items[0].text);
		if(items[0].value == "1") {
			$that.parent().parent().next().css('display', 'inline');
		} else {
			$that.parent().parent().next().hide();
		}
	});
})

// 保存个人信息
var img_card;
$(".submit_person").bind("click", function() {
	//img_card = imgcard_url.join("|");
	var person_data = {
		real_name: $("#real_name").val(),
		img_beforecard: $("#idcardbefore_file").attr("data_url"),
		img_backcard: $("#idcardback_file").attr("data_url"),
		height: $("#height").val(),
		weight: $("#weight").val(),
		weixin: $("#weixin").val(),
		email: $("#email").val(),
		phone: $("#phone").val(),
		driving_card:  $("#driving_file").attr("data_url"),
		passport_card:  $("#passport_file").attr("data_url"),
		pass_card:  $("#pass_file").attr("data_url"),
		taiwan_card:  $("#taiwan_file").attr("data_url"),
		car_card: $("#car_file").attr("data_url"),
		house_address: $("#house_address").val(),
		live_type:$("#housecard_file").attr("data_url"),
		origin_address: $("#origin_address").val()
	};
	var j = judge(person_data);
	if(j == false) {
		return false;
	}
	$.ajax({
		type: "POST",
		url: "approve",
		data: person_data,
		success: function(res) {
			if(res.data.url){
				window.location.href = res.data.url;
			}
		}
	});
})

// 保存工作信息
$(".submit_workinfo").bind("click", function(){
	var work_year = $("#work_year").text();
	if(work_year == "请选择"){
		work_year = "";
	}
	var principal_phone = $("#principal_phone").val();
	if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(principal_phone))) {
		alert("请填写正确的手机号码!");
		return false;
	}
	var work_data = {
		work_nature: $("#work_nature").val(),
		company_name: $("#company_name").val(),
		work_year: work_year,
		company_address: $("#company_address").val(),
		principal_name: $("#principal_name").val(),
		principal_phone: principal_phone
	};
	if(!work_data.work_nature||!work_data.company_name||!work_data.work_year||!work_data.company_address||!work_data.principal_name||!work_data.principal_phone){
		alert('请完善信息');
		return false;
	}
	$.ajax({
		type: "POST",
		url: "work",
		data: work_data,
		success: function(res) {
			if(res.data.url){
				window.location.href = res.data.url;
			}
		},
		error:function(err){
			console.log(err);
		}
	});
})

// 保存负债信息
$(".submit_debt").bind("click", function(){
	if($("#urgency_name").val() == '' || $("#urgency_mobilephone").val() == '' || $("#urgency_companyname").val() == ''){
		alert("请完善紧急联系人信息！")
		return false;
	}
	var debt_data = {
		house_debt: $("#house_debt").val(),
		car_debt: $("#car_debt").val(),
		credit_debt: $("#credit_debt").val(),
		phone_debt: $("#phone_debt").val(),
		net_debt: $("#net_debt").val(),
		other_debt: $("#other_debt").val(),
		person_photo: $("#person_photo").attr("data_url"),
		urgency_name: $("#urgency_name").val(),
		urgency_mobilephone: $("#urgency_mobilephone").val(),
		urgency_phone: $("#urgency_phone").val(),
		urgency_companyname: $("#urgency_companyname").val()
	};
	$.ajax({
		type: "POST",
		url: "debt",
		data: debt_data,
		success: function(res) {
			window.location.href = res.data.url;

		}
	});

})

// 保存贷款信息
$(".submit_loan").bind("click", function(){
	var demand_str='';
	$(".purpose_cell").each(function() {
		if($(this).is(".current_purpose")) {
			demand_str += ($(this).text() + "|") ;
		}
	});
	var price_need = $(".price_need").text();
	if(price_need == "请选择"){
		alert("请选择分期金额需求！");
		return false;
	}

	var loan_data = {
		month_earning: $("#month_earning").val(),
		demanduse_str: demand_str,
		price_need: price_need
	};
	$.ajax({
		type: "POST",
		url: "uloan",
		data: loan_data,
		success: function(res) {
			if(res.data.url){
				window.location.href =res.data.url;
			}
		}
	});

})



// 判断必填项
function judge(data) {
	if(!data.real_name) {
		alert("请填写真实姓名!");
		return false;
	}
	if(!data.img_beforecard||!data.img_backcard) {
		alert("请上传身份证!");
		return false;
	}

	if(!data.height) {
		alert("请填写身高!");
		return false;
	}
	if(!data.weight) {
		alert("请填写体重!");
		return false;
	}
	if(!data.weixin) {
		alert("请填写个人微信号!");
		return false;
	}
	if(!data.email) {
		alert("请填写电子邮箱!");
		return false;
	}else{
		if(!(/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/.test(data.email))){
			alert("请填写正确的邮箱!");
			return false;
		}
	}
	if(!data.phone) {
		alert("请填写手机号!");
		return false;
	} else {
		if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(data.phone))) {
			alert("请填写正确的手机号码!");
			return false;
		}
	}
	if($(".driving_card")){
		if($("#driving_card").text() == "请选择"){
			alert("请选择驾驶证!");
			return false;
		}else if($("#driving_card").text() == "有" && $("#driving_file").attr("data_url") == undefined){
			alert("请上传驾驶证图片！");
			return false;
		}
	}
	if($(".passport_card")){
		if($("#driving_card").text() == "请选择"){
			alert("请选择护照!");
			return false;
		}else if($("#driving_card").text() == "有" && $("#driving_file").attr("data_url") == undefined){
			alert("请上传护照图片！");
			return false;
		}
	}
	if($(".pass_card")){
		if($("#driving_card").text() == "请选择"){
			alert("请选择港澳通行证!");
			return false;
		}else if($("#driving_card").text() == "有" && $("#driving_file").attr("data_url") == undefined){
			alert("请上传港澳通行证图片！");
			return false;
		}
	}
	if($(".taiwan_card")){
		if($(".taiwan_card").text() == "请选择"){
			alert("请选择台湾通行证!");
			return false;
		}else if($(".taiwan_card").text() == "有" && $("#driving_file").attr("data_url") == undefined){
			alert("请上传台湾通行证图片！");
			return false;
		}
	}
	// 判断个人车辆信息
	if($(".car_card")){
		if($(".car_card").text() == "请选择"){
			alert("请选择个人车辆信息!");
			return false;
		}else if($(".car_card").text() == "有" && $("#car_file").attr("data_url") == undefined){
			alert("请上传车辆信息图片！");
			return false;
		}
	}
	// 判断个人现实际住址
	if($("#housecard_file")){
		if($("#housecard_file").attr("data_url")== undefined){
			alert("请上传居住地图片！");
			return false;
		}
	}
	return true;
}

// 选择贷款金额
$(".price_need").click(function() {
	var $that = $(this);
	var picker = new mui.PopPicker();
	picker.setData(price_picker);
	picker.show(function(items) {
		$that.text(items[0].text);
	});
})


// 选择居住类型
$(".live_type").click(function(){
	var $that = $(this);
	var picker = new mui.PopPicker();
	picker.setData(live_picker);
	picker.show(function(items) {
		$that.text(items[0].text);
		$that.parent().parent().next().css('display', 'inline');
	});
});
// 选择工作年限
$("#work_year").click(function() {
	var $that = $(this);
	var picker = new mui.PopPicker();
	picker.setData(workyear_picker);
	picker.show(function(items) {
		$that.text(items[0].text);
	});
})


//上传图片
function readFile() {
	var formData = new FormData();
	var $that = $(this);
	$that.parent().siblings(".img_note").css("display", "none");
	for(var i = 0; i < this.files.length; i++) {
		var reader = new FileReader();
		reader.readAsDataURL(this.files[i]);
		formData.append("file", this.files[0]);
		reader.onload = function(e) {
			img = document.createElement('img');
			img.setAttribute("src", this.result);
			img.setAttribute("class", "main_img");
			$.ajax({
				type: "POST",
				url: UPLOADURL,
				data: formData,
				processData: false,
				contentType: false,
				success: function(res) {
					$that.attr("data_url",res.data.src);
				}
			});
			$that.parent().next().append(img);
		}
	}
}

$(".purpose_cell").click(function(){
	$(this).toggleClass("current_purpose");
});

$(".amor_cell").click(function(){
	$(this).toggleClass("current_amor");
	$(this).siblings().removeClass("current_amor");
	var num=$('.current_amor').html().substring(0,$('.current_amor').html().length-1);
	var goods_id=$('#goods_id').html();
	$.ajax({
		type: "GET",
		url: '/num',
		dataType: 'json',
		data: {
			num:num,
			goods_id:goods_id
		},
		success: function(res) {
			$('.pay_money').html(res.money);
			$('.service').html(res.serviceCharge);
		},
		error:function(err){
			console.log(err);
		}
	});
})
//我要申请分期
$("#apply_stage").click(function(){
		if($("#apply_stage").text() == "提交申请"){
			var obj;
			$(".amor_cell").each(function() {
				if($(this).is(".current_amor")){
					obj = $(this).text().split("期")[0];
				}
			});
			var goods_id=$('#goods_id').html();
			$.ajax({
				type: "POST",
				url: '/loan',
				dataType: 'json',
				data: {
					stages:obj,
					goods_id:goods_id,
					pay_money:$('pay_money').html()
				},
				success: function(res) {
					alert(res.msg);
					if(res.data.url){
						window.location.href = res.data.url;
					}
				},
				error:function(err){
					console.log(err);
				}
			});
		}
		$("#good_detail_mask").toggle();
		$(".toggle_wrap").toggle();
		$("#apply_stage").text("提交申请");
		//$(".interest_text").text("(不含利息)");
})
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

// 验证旧手机、绑定新手机 发送验证码  --
$(".new_sendcode").bind("click", function() {
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
				settime(v);
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

// post发送手机号和验证码
function validation() {
	var mobile = $("#phone").val();
	var code = $("#code").val();
	if(!mobile || !code) {
		alert('手机号码和验证码不能为空');
		return false;
	}

	$.ajax({
		type: "POST",
		url: 'bind',
		data: {
			mobile: mobile,
			code: code
		},
		dataType: "json",
		success: function(res) {
			if(res.code == 1) {
				if(res.data.url) {
					window.location.href = res.data.url;
				}
			}
		},
		error: function(msg) {
			alert('发生异常，请重试');
		}
	});
}

// 提现
$("#deposit").bind("click", function() {
	var can_cash = Number($("#can_cash").text());
	var money = $("#money").val();
	if(money > can_cash) {
		alert("余额不足!");
		return false;
	}
	if(!money){
		alert("请输入金额");
		return false;
	}
	$.ajax({
		type: "POST",
		url: "deposit",
		data: {
			money: money
		},
		success: function(res) {

			location.reload();
			alert(res.msg);
		},
		error: function(msg) {

		}
	});
});
// 充值
$("#recharge").bind("click", function() {
	var money = $("#money").val();
	if(!money){
		alert("请输入金额!");
		return false
	}
	$.ajax({
		type: "POST",
		url: "recharge",
		data: {
			money: money,
			type: 'charge'
		},
		success: function(res) {
			if(res.data.url){
				window.location.href = 'https://pay.swiftpass.cn/pay/jspay'+res.data.url;
			}
		},
		error: function(msg) {
			alert(JSON.stringify(msg));
		}
	});
});
// 交手续费
$(".poundage").bind("click", function() {
	console.log($(this).data('id'));
	var order_id=$(this).data('id');
	$.ajax({
		type: "POST",
		url: "recharge",
		data: {
			order_id:order_id,
			type: 'fee'
		},
		success: function(res) {
			if(res.data.url){
				window.location.href = 'https://pay.swiftpass.cn/pay/jspay'+res.data.url;
			}
		},
		error: function(msg) {
			alert(JSON.stringify(msg));
		}
	});
});

