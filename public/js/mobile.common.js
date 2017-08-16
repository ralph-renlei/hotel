
// 展示店铺地图位置
function init() {
	var map = new qq.maps.Map(document.getElementById("container"), {
		// 地图的中心地理坐标。
		center: new qq.maps.LatLng(LAT, LNG)
	});
}

// 获取地理位置
function getLocation() {
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else {
		alert("Geolocation is not supported by this browser.");
	}
}

function showPosition(position) {
	if(position.coords.latitude && position.coords.longitude) {
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;
	}
	$.ajax({
		type: "POST",
		url: LOCATE_URL,
		data: {
			lat: latitude,
			lng: longitude
		},
		success: function(res) {
            document.cookie = "lat=" + latitude;
            document.cookie = "lng=" + longitude;
		}
	});
}

var page = 1;
var searchFlag = false;
// 首页搜索
$("#storename").bind('input propertychange', function() {
	if($("#storename").val().length >= 2) {
		searchFlag = true;
		$.ajax({
			type: "POST",
			url: URL,
			data: {
				keyword: $("#storename").val()
			},
			dataType: "json",
			success: function(res) {
				$('#store_wrap').empty();
				$(".dropload-down").remove();
				if(res.data.length < 10) {
					resdom(res);
				} else {
					// 若搜索记录大于10条
					$.ajax({
						type: 'POST',
						url: URL,
						dataType: 'json',
						data: {
							page: 1,
							keyword: $("#storename").val(),
							lat: latitude,
							lng: longitude
						},
						success: function(res) {
							resdom(res);
						},
						// 加载出错
						error: function(xhr, type) {
							alert('Ajax error!');
							me.resetload();
						}
					});
					$('.store_wrap').dropload({
						scrollArea: window,
						loadDownFn: function(me) {
							page++;
							$.ajax({
								type: 'POST',
								url: URL,
								dataType: 'json',
								data: {
									page: page,
									keyword: $("#storename").val(),
									lat: latitude,
									lng: longitude
								},
								success: function(res) {
									$(".dropload-down").remove();
									resdom(res);
									if(res.data.length < 1) {
										me.lock();
										me.noData();
									}
									me.resetload();
								}
							});
						}
					});
				}
			},
			error: function(msg) {}
		});
	} else if($("#storename").val().length < 1 && searchFlag == true) {
		// 搜索之后将搜索框内容清空
		$.ajax({
			type: 'post',
			url: URL,
			dataType: 'json',
			data: {
				page: 1,
			},
			success: function(res) {
				resdom(res);
			},
			// 加载出错
			error: function(xhr, type) {
				alert('Ajax error!');
				me.resetload();
			}
		});
	}
});

// 首页大分类
//$(".classbox").bind("click", function() {
//	var cate = that.attr('id');
//	$.ajax({
//		type: "POST",
//		url: "",
//		cate: cate,
//		success: function(res) {
//			resdom(res);
//		},
//		error: function(xhr, type) {
//			alert('Ajax error!');
//			me.resetload();
//		}
//	});
//})

function resdom(res) {
	var result = '';
	for(var i = 0; i < res.data.length; i++) {
		if(res.data[i].is_open == 0) {
			res.data[i].isopen = "已停业";
		} else {
			res.data[i].isopen = "营业中";
		}
		result += '<li><a href="' + SITE + '/item/' + res.data[i].id + '">' +
			'<div class="store_cell clearfix">' +
			'<div class="store_left">' +
			'<img src="' + res.data[i].logo + '" alt=""/>' +
			'</div>' +
			'<div class="store_right clearfix">' +
			'<div class="s_title clearfix">' +
			'<p class="store_name">' + res.data[i].store_name + '</p>' +
			'<p class="grey_text distance">' + res.data[i].distance + 'km </p>' +
			'</div>' +
			'<p class="star_wrap">' +
			'<i class="iconfont icon-ds xuanzhong_ds"></i>' +
			'<i class="iconfont icon-ds xuanzhong_ds"></i>' +
			'<i class="iconfont icon-ds xuanzhong_ds"></i>' +
			'<i class="iconfont icon-ds"></i>' +
			'<i class="iconfont icon-ds"></i>' +
			'<div class="s_title grey_text clearfix">' +
			'<p>最低消费： <span class="red_text mini_charge">' + res.data[i].avgprice + '</span>元</p>' +
			'<p class="grey_text back_price">返<span class="red_text">&nbsp;80</span></p>' +
			'<p class="status">' + res.data[i].isopen + '</p>' +
			'</div>' +
			'</div>' +
			'</div>' +
			'</a></li>';
	}
	$('#store_wrap').append(result);
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
		type: "post",
		url: VALID_URL,
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

$('#reg_btn').on('click', function() {
	var mobile = $('#phone').val();
	var code = $('#code').val();
	if(!mobile || !code) {
		alert("手机号和验证码不能为空");
		return false;
	}
    var self = this;
    $(this).text('正在注册，请稍后..');
    $(this).attr('disabled','disabled');
	$.ajax({
		url: REG_URL,
		type: 'POST',
		dataType: 'json',
		data: {
			mobile: mobile,
			code: code,
			uid: UID,
			openid: OPENID
		},
		success: function(res) {
			if(res.code == 1) {
                window.location.href = USER_URL;
			} else {
                $(self).removeAttr('disabled');
                $(self).text('注册');
				alert(res.msg);
				return false;
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert('发送异常，请重试');
            $(self).removeAttr('disabled');
            $(self).text('注册');
			return false;
		}
	});
});

// 点亮星星
var star = 0;
$(".icon-ds").click(function() {
	$(".icon-ds").css("color", "");
	$(this).css("color", "#fd5001");
	$(this).prevAll("i").css("color", "#fd5001");
	star = $(this).index() + 1;
});

$(".regist_sendcode").bind("click", function() {
	var mobile = $('#phone').val();
	if(!mobile) {
		alert("手机号不能为空");
		return false;
	}
	var v = this;
	$.ajax({
		url: SMS_URL,
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

// 设置  --
$(".install_sendcode").bind("click", function() {
	var mobile = $('#phone').val();
	if(!mobile) {
		alert("手机号不能为空");
		return false;
	}
	var v = this;
	$.ajax({
		url: SMS_URL,
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

// 绑定新手机 发送验证码  --
$(".new_sendcode").bind("click", function() {
	var mobile = $('#phone').val();
	if(!mobile) {
		alert("手机号不能为空");
		return false;
	}
	var v = this;
	$.ajax({
		url: SMS_URL,
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

function modifymobile() {
	var mobile = $("#phone").val();
	var code = $("#code").val();
	if(!mobile || !code) {
		alert('手机号码和验证码不能为空');
		return false;
	}

	$.ajax({
		type: "post",
		url: VALID_URL,
		data: {
			uid: UID,
			openid: OPENID,
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

function checkMobile(option) {
	var sMobile = $(option).val();
	if(!(/^1[3|4|5|7|8][0-9]{9}$/.test(sMobile))) {
		$(option).val("");
		return false;
	} else {
		return true;
	}
}

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
		alert("请输入合法的手机号");
	}
}

// 个人中心
$("#exp_value").text("30");
$("#level_text").text('白银');

// 200表示现有经验值
var barwidth = 200 / 10;
$(".bar").css({
	"width": barwidth + '%'
});

// 提现
$("#deposit").bind("click", function() {
	var can_cash = Number($("#can_cash").text());
	var money = $("#money").val();

	if(money > can_cash) {
		alert("提现金额大于账户余额!");
        return false;
	}
    if(money<1){
        alert("提现金额不能小于1元!");
        return false;
    }

	$.ajax({
		type: "POST",
        dataType:'json',
		url: CASH_URL,
		data: {
			uid: UID,
			openid: OPENID,
			money: money
		},
		success: function(res) {
         if(res.code==1){
             alert('申请成功');
             window.location.href = USER_URL;
         }else{
             alert('申请失败');
         }
		},
		error: function(msg) {

		}
	});
});

function search() {

}