/**
 * Created by Jian on 2016/11/26.
 */
var app  = app || {};
(function(window,document,$,app){
    app.system = {};
    app.user = {};
    app.cms = {};
    app.house = {};
    app.help = {};
    app.card = {};
    app.resold = {};
    app.shop = {};
    app.goods = {};
    app.loan={};
    app.order = {};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    app.shop.del = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/shop/item',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }
    };
    app.shop.audit = function(id,status){

            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/shop/audit',
                type: 'POST',
                dataType:'json',
                data:{id:id,status:status},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
    };
    app.goods.audit = function(field,id,val){
        if(!id){
            alert('参数异常');
            return false;
        }

        $.post('/admin/shop/goods/item',{id:id,field:field,val:val},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.goods.del = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/shop/goods',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }
    };

    app.city_list = function(province_id){

    };

    app.area_list = function(city_id){
        $.ajax({
            url: '/region/area/'+city_id,
            type: 'get',
            dataType:'json',
            data:{},
            success: function(result) {
                if(result.code==1){
                    $('#area').empty();
                    $.each(result.data,function(item,v){
                        var html = '<option value="'+v.code+'">'+v.name+'</option>';
                        $('#area').append(html);
                    });
                }else{
                    alert(result.msg);
                }
            },
            error:function(jqXHR,textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
        $('#street').empty();
        $('#community').empty();
    };

    app.street_list = function(area_id){
        $.ajax({
            url: '/region/street/'+area_id,
            type: 'get',
            dataType:'json',
            data:{},
            success: function(result) {
                if(result.code==1){
                    $('#street').empty();
                    $.each(result.data,function(item,v){
                        var html = '<option value="'+v.code+'">'+v.name+'</option>';
                        $('#street').append(html);
                    });
                }else{
                    alert(result.msg);
                }
            },
            error:function(jqXHR,textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
    };

    app.community_list = function(street_id){
        $.ajax({
            url: '/region/community/'+street_id,
            type: 'get',
            dataType:'json',
            data:{},
            success: function(result) {
                if(result.code==1){
                    $('#community').empty();
                    $.each(result.data,function(item,v){
                        var html = '<option value="'+v.code+'">'+v.name+'</option>';
                        $('#community').append(html);
                    });
                }else{
                    alert(result.msg);
                }
            },
            error:function(jqXHR,textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
    };

    app.house.nav_tab = function(id){
        $('#'+id+'_li').siblings().removeClass('active');
        $('#'+id+'_li').addClass('active');
        $('.form-group').hide();
        $('.'+id).show();
        $('.do').show();
    };



    app.cms.cancel_cate = function(){
        $('#name').val('');
        $('#code').val('');
        $('#sort').val(0);
        $('#id').val(0);
    };

    app.user.save = function(id){
        if(!id){
            alert('参数异常');
            return false;
        }
        $.ajax({
            url: '/admin/user/channel/invite',
            type: 'POST',
            dataType:'json',
            data:{uid:id},
            success: function(result) {
                if(result.code==1){
                    alert(result.msg);
                    setTimeout(function(){
                        window.location.reload();
                    },500);
                }else{
                    alert(result.msg);
                }
            },
            error:function(jqXHR,textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
    };
    app.user.del_code = function(id) {
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/user/channel/invite',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }
    };
    app.user.add_code = function(id){
        if(!id){
            alert('参数异常');
            return false;
        }
        $.ajax({
            url: '/admin/user/channel/invite',
            type: 'POST',
            dataType:'json',
            data:{uid:id},
            success: function(result) {
                if(result.code==1){
                    alert(result.msg);
                    setTimeout(function(){
                        window.location.reload();
                    },500);
                }else{
                    alert(result.msg);
                }
            },
            error:function(jqXHR,textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
    };
    app.user.del = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/user/user',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }
    };

    app.system.save_tag = function(){
        var c = $('#code').val();
        var v = $('#val').val();
        var i = $('#id').val();
        if(!c||!v){
            alert('参数异常');
            return false;
        }
        $.post('/admin/system/tags',{type:c,tag:v,id:i},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.system.edit_tag = function(){

    };

    app.system.del_tag = function(id){

    };

    app.system.del_type = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/system/tagtype',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }

    }

    app.system.edit_type = function(id){
        $('#item_'+id).children('.data').each(function(i,v){
            if(i==0){
                $('#id').val($(v).text());
            }
            if(i==1){
                $('#code').val($(v).text());
            }
            if(i==2){
                $('#name').val($(v).text());
            }
        });
    }

    app.system.save_type = function(){
        var c = $('#code').val();
        var n = $('#name').val();
        var i = $('#id').val();
        $.post('/admin/system/tagtype',{code:c,note:n,id:i},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.system.edit_menu = function(id){

        $.get('/admin/system/menu/'+id,{},function(result){
            if(result.code == 1){
                $('#id').val(result.data.id);
                $('#name').val(result.data.name);
                $('#val').val(result.data.val);
                $('#pid').val(result.data.pid);
                $('#mtype').val(result.data.mtype);
                $('#sort').val(result.data.sort);
                $('#status').val(result.data.status);
            }

        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.system.create_menu = function(){
        $.post('/admin/system/createMenu',{},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.system.delete_menu = function(){

        $.post('/admin/system/delMenu',{},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },1500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.system.save_menu = function(){
        var type = $('#mtype').val();
        var name = $('#name').val();
        var p = $('#pid').val();
        var i = $('#id').val();
        var o = $('#sort').val();
        var val = $('#val').val();
        if(!name){
            alert('名称不能为空');
            return false;
        }
        if(!val){
            alert('内容不能为空');
            return false;
        }
        $.post('/admin/system/menu',{mtype:type,name:name,val:val,pid:p,sort:o,id:i},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };

    app.system.del_menu = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/system/menu',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }
    };

    app.system.cancel_type = function(){
        $('#code').val('');
        $('#name').val('');
    };
    app.system.edit_cate = function(id){
        if(!id){
            alert('参数异常');
            return false;
        }
        $.ajax({
            url: '/admin/system/cate/'+id,
            type: 'GET',
            dataType:'json',
            success: function(result) {
                if(result.code==1){
                    var c = result.data;
                    $('#id').val(c.id);
                    $('#name').val(c.name);
                    $('#marketprice').val(c.marketprice);
                    $('#normalprice').val(c.normalprice);
                    $('#vipprice').val(c.vipprice);
                    $('#number').val(c.number);
                    $('#bed').val(c.bed);
                    $('#sort').val(c.sort);
                    if(c.status==1){
                        $('#status1').attr('checked','checked');
                    }else{
                        $('#status2').attr('checked','checked');
                    }
                }else{
                    alert(result.msg);
                }
            },
            error:function(jqXHR,textStatus, errorThrown ){
                alert(errorThrown);
            }
        });
    };
    app.system.del_cate = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/system/cate',
                type: 'DELETE',
                dataType:'json',
                data:{id:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }
    };
    app.system.cate_add = function(){
        var id = $('#id').val();
        var name = $('#name').val();
        var marketprice = $('#marketprice').val();
	    var normalprice = $('#normalprice').val();
	    var vipprice = $('#vipprice').val();
	    var bed = $('#bed').val();
	    var description = $('#description').val();
	    var number = $('#number').val();
        var sort = $('#sort').val();
	    var images = '';
	    var new_gallery="";
	    $('img').each(function(){
		    new_gallery=new_gallery+','+$(this).attr('src');
	    });
        var status = $("input[name='status'][checked]").val();
        if(!id)id = 0;
        $.ajax({
            url: '/admin/system/cate',
            type: 'POST',
            dataType:'json',
            data:{id:id,name:name,marketprice:marketprice,normalprice:normalprice,vipprice:vipprice,bed:bed,description:description,number:number,sort:sort,status:status,images:images,new_gallery:new_gallery},
	        success: function(result) {
		        if(result.code==1){
			        alert(result.msg);
			        setTimeout(function(){
				        window.location.reload();
			        },500);
		        }else{
			        alert(result.msg);
		        }
	        },
	        error:function(jqXHR,textStatus, errorThrown ){
		        alert(errorThrown);
	        }
        });
    };
    app.system.edit = function(id){
        $('#item_'+id).children('.data').each(function(i,v){
            if(i==0){
                $('#code').val($(v).text());
            }
            if(i==1){
                $('#name').val($(v).text());
            }
            if(i==2){
                $('#val').val($(v).text());
            }
        });
    }
    app.system.del = function(id){
        if(confirm('确认删除吗？')){
            if(!id){
                alert('参数异常');
                return false;
            }
            $.ajax({
                url: '/admin/system/config',
                type: 'DELETE',
                dataType:'json',
                data:{code:id},
                success: function(result) {
                    if(result.code==1){
                        alert(result.msg);
                        setTimeout(function(){
                            window.location.reload();
                        },500);
                    }else{
                        alert(result.msg);
                    }
                },
                error:function(jqXHR,textStatus, errorThrown ){
                    alert(errorThrown);
                }
            });
        }

    };

    app.system.add = function(){
        var c = $('#code').val();
        var n = $('#name').val();
        var v = $('#val').val();
        if(!c || !n || !v){
            alert('内容不能为空');
            return false;
        }
        if(c.length<2 || n.length<2){
            alert('长度不够');
            return false;
        }
        $.post('/admin/system/config',{code:c,name:n,val:v},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };
    app.system.cancel = function(){
        $('#name').val('');
        $('#marketprice').val('');
        $('#normalprice').val('');
        $('#vipprice').val('');
        $('#number').val('');
        $('#bed').val('');
        $('#sort').val(0);
        $('#id').val(0);
    };
    app.system.cancel_menu = function(){
        $('#mtype').val('');
        $('#name').val('');
        $('#pid').val(0);
        $('#val').val('');
    };

    app.loan.edit = function(id){
        $('#item_'+id).children('.data').each(function(i,v){
            if(i==0){
                $('#loan_id').val($(v).text());
            }
            if(i==1){
                $('#name').val($(v).text());
            }
            if(i==2){
                $('#num').val($(v).text());
            }
            if(i==3){
                $('#fee').val($(v).text());
            }
            if(i==4){
                $('#rate').val($(v).text());
            }
            if(i==5){
                $('#note').val($(v).text());
            }
        });
    }
    app.loan.add = function(){
        var id = $('#loan_id').val();
        var name = $('#name').val();
        var num = $('#num').val();
        var fee = $('#fee').val();
        var rate = $('#rate').val();
        var note = $('#note').val();
        if(!id || !name || !num || !fee || !rate || !note){
            alert('内容不能为空');
            return false;
        }
        if(name.length<2){
            alert('长度不够');
            return false;
        }
        $.post('/admin/system/loan',{id:id,name:name,num:num,fee:fee,rate:rate,note:note},function(result){
            if(result.code==1){
                setTimeout(function(){
                    window.location.reload();
                },500);
            }else{
                alert(result.msg);
            }
        },'json').error(function(jqXHR,textStatus, errorThrown){
            alert(errorThrown);
        });
    };


    app.init = function(){
        this.module_list = MODULE;
        var url = window.location.href;
        var module_url = url.replace(window.location.search,'');

        for(var m in this.module_list){
            var murl = this.module_list[m];
            if(murl ==module_url){
                this.current_module = m;
                break;
            }
            if(module_url.indexOf(murl)>0){
                this.current_module = m;
                break;
            }
            if(module_url.indexOf(murl)>-1 && murl!=SITE){
                this.current_module = m;
                break;
            }

        }

        if(!this.current_module){
            this.current_module = 'home';
        }

        $('#'+this.current_module).siblings().removeClass('current');
        $('#'+this.current_module).addClass('current');
        var menu = [];
        var current = '';

        $('#'+this.current_module+'_menu').children().each(function(i){
            var href = $(this).find('a').attr('href');
            menu.push(href);
            if(href==url){
                $(this).addClass('current');
                current = href;
                return;
            }
            if(url.slice(0,href.length) == href && i>0){
                $(this).addClass('current');
                current = href;
                return;
            }
        });
        if(!current){
            $('#'+this.current_module+'_menu').children().eq(0).addClass('active');
            $('#'+this.current_module+'_menu').children().eq(0).addClass('current');
        }
        this.menu = menu;
        this.current = url;
        $('#'+this.current_module+'_menu').siblings().removeClass('active').hide();
        $('#'+this.current_module+'_menu').show();
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = STATIC + "/" + this.current_module + ".js";
        document.body.appendChild(script);
    };

    $(function(){
        app.init();
    });

})(window,document,jQuery,app);