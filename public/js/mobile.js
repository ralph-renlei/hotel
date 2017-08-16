/**
 * Created by Jian on 2016/12/8.
 */
var mobile  = mobile || {};
(function(window,document,$,mobile){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    mobile.click_login = function(){
        window.location.href = '/login';
    };

    $(function(){
       $('.del_favor').on('click',function(){
           var self = this;
           $.ajax({
               url: '/favor',
               type: 'DELETE',
               dataType:'json',
               data:{type:TYPE,id:HID,uid:UID},
               success: function(result) {
                   if(result.code==1){
                       $(self).removeClass('del_favor').addClass('favor');
                       $(self).find('span').removeClass('collected').addClass('no-collect');
                   }else{
                       alert(result.msg);
                   }
               },
               error:function(jqXHR,textStatus, errorThrown ){
                   alert(errorThrown);
               }
           });
       });

        $('.favor').on('click', function () {
            var self = this;
            $.post('/favor',{type:TYPE,id:HID,uid:UID},function(res){
                if(res.code==1){
                    $(self).removeClass('favor').addClass('del_favor');
                    $(self).find('span').removeClass('no-collect').addClass('collected');
                    return;
                }else{
                    alert(res.msg);
                    return false;
                }
            },'json').error(function(jqXhR,textStatus,errorThrown){
                alert(errorThrown);
                return;
            });
        });

    });



    mobile.service = function(){
        var type = $('input[name="type"]:checked').val();
        var note = $('#note').val();
        var mobile = $('#mobile').val();
        var name = $('#name').val();
        var code = $('#code').val();

        if(!type ){
            alert('贷款类型不能为空');
            return false;
        }
        if(!note){
            alert('说明不能为空');
            return false;
        }
        if( !mobile){
            alert('手机号码不能为空');
            return false;
        }
        if(!code){
            alert('验证码不能为空');
            return false;
        }
        if(!name){
            alert('姓名不能为空');
            return false;
        }
        $.post('/service',{type:type,note:note,mobile:mobile,name:name,code:code},function(res){
            if(res.code==1){
                alert(res.msg);
                setTimeout(function(){
                    window.location.href = res.data.url;
                },1500);
                return;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
            return;
        });
    };
    mobile.transfer = function(){
        var type = $('input[name="type"]:checked').val();
        var note = $('#note').val();
        var mobile = $('#mobile').val();
        var name = $('#name').val();
        var code = $('#code').val();
        var acreage = $('#acreage').val();
        var property = $('#property').val();
        var price = $('#price').val();

        if(!type ){
            alert('贷款类型不能为空');
            return false;
        }
        if(!acreage){
            alert('面积不能为空');
            return false;
        }
        if(!property){
            alert('房屋性质不能为空');
            return false;
        }
        if(!price){
            alert('报价不能为空');
            return false;
        }
        if(!note){
            alert('说明不能为空');
            return false;
        }
        if( !mobile){
            alert('手机号码不能为空');
            return false;
        }
        if(!code){
            alert('验证码不能为空');
            return false;
        }
        if(!name){
            alert('姓名不能为空');
            return false;
        }
        $.post('/transfer',{type:type,acreage:acreage,property:property,price:price,note:note,mobile:mobile,name:name,code:code},function(res){
            if(res.code==1){
                alert(res.msg);
                setTimeout(function(){
                    window.location.href = res.data.url;
                },1500);
                return;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
            return;
        });
    };

    mobile.match = function(){
        var type = $('input[name="type"]:checked').val();
        var note = $('#note').val();
        var mobile = $('#mobile').val();
        var name = $('#name').val();
        var code = $('#code').val();

        if(!type ){
            alert('贷款类型不能为空');
            return false;
        }
        if(!note){
            alert('说明不能为空');
            return false;
        }
        if( !mobile){
            alert('手机号码不能为空');
            return false;
        }
        if(!code){
            alert('验证码不能为空');
            return false;
        }
        if(!name){
            alert('姓名不能为空');
            return false;
        }
        $.post('/match',{type:type,note:note,mobile:mobile,name:name,code:code},function(res){
            if(res.code==1){
                alert(res.msg);
                setTimeout(function(){
                    window.location.href = res.data.url;
                },1500);
                return;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
            return;
        });
    };
    mobile.ads_switch = function(type){
        if(type=='resold'){
            $('.resold').show();
            $('.rent').hide();
        }else{
            $('.rent').show();
            $('.resold').hide();
        }
    };
    mobile.ads = function(){
        var type = $('input[name="type"]:checked').val();
        var area = $('#area').val();
        var community = $('#community').val();
        var mobile = $('#mobile').val();
        var name = $('#name').val();
        var code = $('#code').val();
        var acreage = $('#acreage').val();
        var unit = $('#unit').val();
        var parlour = $('#parlour').val();
        var toilet = $('#toilet').val();
        var floor = $('#floor').val();
        var floors = $('#floors').val();
        var total_price = $('#total_price').val();
        var price = $('#price').val();
        var toward = $('#toward').val();
        var decorate = $('#decorate').val();
        var detail = $('#detail').val();
        var gallery = [];

        if($('.weui_uploader_file').length>0){
            $('.weui_uploader_file').each(function(i,v){
                gallery.push($(this).attr('data'));
            });
        }

        if(!type ){
            alert('推广类型不能为空');
            return false;
        }
        if(!community){
            alert('小区不能为空');
            return false;
        }
        if(!area){
            alert('地区不能为空');
            return false;
        }
        if(!acreage){
            alert('面积不能为空');
            return false;
        }
        if(!unit || !parlour || !toilet){
            alert('户型信息不完善');
            return false;
        }
        if(!price && !total_price){
            alert('价格不能为空');
            return false;
        }
        if( !mobile){
            alert('手机号码不能为空');
            return false;
        }
        if(!code){
            alert('验证码不能为空');
            return false;
        }
        if(!name){
            alert('姓名不能为空');
            return false;
        }
        var toward_val = decorate_val = 1;
        var toward_list = [{
            value: '1',
            text: '南北通透'
        }, {
            value: '2',
            text: '朝东'
        }, {
            value: '3',
            text: '朝南'
        }, {
            value: '4',
            text: '朝西'
        }, {
            value: '5',
            text: '朝北'
        }, {
            value: '6',
            text: '东西'
        }];
        var decorate_list = [{
            value: '1',
            text: '毛坯'
        }, {
            value: '2',
            text: '简装'
        }, {
            value: '3',
            text: '中装'
        }, {
            value: '4',
            text: '精装'
        }, {
            value: '5',
            text: '豪华'
        }];
        if(toward){
            for(var t in toward_list){
                if(toward_list[t].text==toward){
                    toward_val = toward_list[t].value;
                    break;
                }
            }
        }
        if(decorate){
            for(var d in decorate_list){
                if(decorate_list[d].text==decorate){
                    decorate_val = decorate_list[d].value;
                    break;
                }
            }
        }
        var data = {
            type:type,
            area:area,
            unit:unit,
            parlour:parlour,
            toilet:toilet,
            price:price,
            total_price:total_price,
            acreage:acreage,
            floor:floor,
            floors:floors,
            gallery:gallery.join(','),
            community:community,
            toward:toward_val,
            decorate:decorate_val,
            detail:detail,
            mobile:mobile,
            name:name,
            code:code
        };
        $.post('/ads',data,function(res){
            if(res.code==1){
                alert(res.msg);
                setTimeout(function(){
                    window.location.href = res.data.url;
                },1000);
                return;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
            return;
        });
    };

    mobile.loan = function(){
        var type = $('input[name="type"]:checked').val();
        var note = $('#note').val();
        var mobile = $('#mobile').val();
        var name = $('#name').val();
        var code = $('#code').val();

        if(!type ){
            alert('贷款类型不能为空');
            return false;
        }
        if(!note){
            alert('说明不能为空');
            return false;
        }
        if( !mobile){
            alert('手机号码不能为空');
            return false;
        }
        if(!code){
            alert('验证码不能为空');
            return false;
        }
        if(!name){
            alert('姓名不能为空');
            return false;
        }
        $.post('/loan',{type:type,note:note,mobile:mobile,name:name,code:code},function(res){
            if(res.code==1){
                alert(res.msg);
                setTimeout(function(){
                    window.location.href = res.data.url;
                },1500);
                return;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
            return;
        });
    };

    mobile.init = function(){
        this.uid = UID;
        this.is_weixin = IS_WEIXIN;
        this.openid = OPENID;
    };

    mobile.logout = function(){
        $.post('/logout',{},function(res){
            if(res.code==1){
                window.location.href = res.data.url;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
        });
    };

    mobile.login = function(){
        var mobile = $('#mobile').val();
        var pwd = $('#password').val();
        if(!mobile || !pwd){
            alert('请输入手机号码或者密码');
            return false;
        }
        var re = /^1\d{10}$/
        if (!re.test(mobile)) {
            alert('手机号码格式不正确');
            return false;
        }
        if(pwd.length<6){
            alert('密码格式不正确');
            return false;
        }
        $.post('/login',{mobile:mobile,password:pwd},function(res){
            if(res.code==1){
                window.location.href = res.data.url;
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
        });
    };

    mobile.reg = function(){
        var mobile = $('#mobile').val();
        var code = $('#code').val();
        var password = $('#password').val();
        var password2 = $('#password2').val();
        if(!mobile || !code || !password || !password2){
            alert('手机号码或验证码或密码不能为空');
            return false;
        }
        var re = /^1\d{10}$/
        if (!re.test(mobile)) {
            alert('手机号码格式不正确');
            return false;
        }
        if(code.length<4){
            alert('验证码格式不正确');
            return false;
        }
        if(password.length<6){
            alert('密码太短');
            return false;
        }
        if(password != password){
            alert('密码和确认密码不一致');
            return false;
        }
        $.post('/register',{mobile:mobile,code:code,password:password,password2:password2},function(res){
            if(res.code==1){
                alert(res.msg);
                setTimeout(function(){
                    window.location.href = res.data.url;
                },1500);
            }else{
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            alert(errorThrown);
        });
    };

    mobile.send_code = function(){
        var m = $('#mobile').val();
        if(!m){
            alert('手机号码不能为空');
            return false;
        }
        var re = /^1\d{10}$/
        if (!re.test(m)) {
            alert('手机号码格式不正确');
            return false;
        }
        this.countDown('send');
        $.post('/sms/sendcode',{mobile:m},function(res){
            if(res.code==1){
                alert(res.msg);
                return;
            }else{
                $('#send').removeAttr('disabled');
                alert(res.msg);
                return false;
            }
        },'json').error(function(jqXhR,textStatus,errorThrown){
            $('#send').removeAttr('disabled');
            alert(errorThrown);
        });
    };
    mobile.countDown = function(div){
        $('#'+div).attr('disabled','disabled');
        var count = 60;
        var loop = function(){
            if(count==0){
                $('#'+div).removeAttr('disabled');
                $('#'+div).text('发送验证码');
                return;
            }
            count--;
            $('#'+div).text(count);
            setTimeout(loop,1000);
        }
        loop();
    };
    mobile.init();
})(window,document,jQuery,mobile);