$(function(){
    $('.user_role').on('click',function(){
        var role = $(this).find("input[name=role]").val();
        console.log(role);
        if(role == 'risk'){
            $('.level').show();
        }else{
            $('.level').hide();
        }
    });
});
/**
 * Created by Jian on 2016/12/30.
 */
layui.use('upload', function(){
    layui.upload({
        url: '/upload/image' //接口url
        ,type: 'post' //默认post
        ,title: '请上传图片'
        ,unwrap: false
        ,before:function(input){
            $(input).after('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
        }
        ,success: function(res){
            if(res.code==0){
                $('#avatar').val(res.data.src);
                if($('#article-thumb').length>0){
                    $('#article-thumb').attr('src',res.data.src);
                }else{
                    var html = "<img id='article-thumb' src='"+res.data.src+"'>";
                    $('#upload').append(html);
                }
                $('#thumb').val(res.data.src);
            }else{
                alert(res.msg);
            }
        }
    });
});
