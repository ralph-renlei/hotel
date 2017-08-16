var FancyForm=function(){
	return{
		inputs:".FancyForm input, .FancyForm textarea",
		setup:function(){
			var a=this;
			this.inputs=$(this.inputs);
			a.inputs.each(function(){
				var c=$(this);
				a.checkVal(c)
			});
			a.inputs.live("keyup blur",function(){
				var c=$(this);
				a.checkVal(c);
			});
		},checkVal:function(a){
			a.val().length>0?a.parent("li").addClass("val"):a.parent("li").removeClass("val")
		}
	}
}();




$(document).ready(function() {
	FancyForm.setup();
});


var searchAjax=function(){};
var G_tocard_maxTips=30;

$(function(){(
	function(){
		
		var a=$(".plus-tag");
		$("a em",a).live("click",function(){
			var c=$(this).parents("a"),b=c.attr("title"),d=c.attr("value");
			//alert(b+'*'+d)
			$.ajax({
				type: "POST",
				url: "/admin/system/option/delate",
				data: {
					attr_id:d,
					attr_value:b
				},
				success: function(res) {
					if(res.data.url){
						window.location.href = res.data.url;
					}
				}
			});
			//删除部分
			//delTips(b,d)
		});
		
		hasTips=function(b){
			var d=$("a",a),c=false;
			d.each(function(){
				if($(this).attr("title")==b){
					c=true;
					return false
				}
			});
			return c
		};

		isMaxTips=function(){
			return	
			$("a",a).length>=G_tocard_maxTips
		};

		setTips=function(c, d,e){
			if(hasTips(c)){
				return false
			}if(isMaxTips()){
				alert("最多添加"+G_tocard_maxTips+"个标签！");
				return false
			}
			var b=d?'value="'+d+'"':"";
			a.append($("<a "+b+' title="'+c+'" href="javascript:void(0);" ><span>'+c+"</span><em></em></a>"));
		//	searchAjax(c,d,true);
			return true
		};

		delTips=function(b,c){
			if(!hasTips(b)){
				return false
			}

			$("a",a).each(function(){
				var d=$(this);
				if(d.attr("title")==b){
					d.remove();

					return false
				}
			});
			searchAjax(b,c,false);
			return true
		};

		getTips=function(){
			var b=[];
			$("a",a).each(function(){
				b.push($(this).attr("title"))
			});
			return b
		};

		getTipsId=function(){
			var b=[];
			$("a",a).each(function(){
				b.push($(this).attr("value"))
			});
			return b
		};
		
		getTipsIdAndTag=function(){
			var b=[];
			$("a",a).each(function(){
				b.push($(this).attr("value")+"##"+$(this).attr("title"))
			});
			return b
		}
	}
	
)()});


//// 更新选中标签标签
//$(function(){
//	setSelectTips();
//	$('.plus-tag').append($('.plus-tag a'));
//});
//var searchAjax = function(name, id, isAdd){
//	setSelectTips();
//};
// 搜索
(function(){
	var $b = $('.plus-tag-add button');
	$b.click(function(){
		$i = $('.plus-tag-add input');
		var $b = $('.plus-tag-add button');
		var e=$(this).attr('id');
		var name = $(this).siblings().val();
		if(name != ''){
			var d=e;
			var b=d?'value="'+d+'"':"";
			$(this).parent().parent().parent().siblings('.plus-tag').append($("<a "+b+' title="'+name+'" href="javascript:void(0);" ><span>'+name+"</span><em></em></a>"));
		}
		$i.val('');
		$i.select();
	});
})();
// 更换链接
(function(){
	var $b = $('#change-tips'),
		$d = $('.default-tag div'),
		len = $d.length,
		t = 'nowtips';
	$b.click(function(){
		var i = $d.index($('.default-tag .nowtips'));
		i = (i+1 < len) ? (i+1) : 0;
		$d.hide().removeClass(t);
		$d.eq(i).show().addClass(t);
	});
	$d.eq(0).addClass(t);
})();