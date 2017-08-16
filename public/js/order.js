/**
 * Created by Jian on 2017/6/27.
 */
$(function(){
    $('.audit').on('click',function(){
        var v = $(this).val();
        if(v=='-1'){
            $('.note').show();
        }else{
            if(v==1){
                $('.radio-way').show();
            }
            $('.note').hide();
        }
    });

    $('.way').on('click',function(){
        var v = $(this).val();
        if(v==3){
            $('.cert').show();
        }else{
            $('.cert').hide();
        }
    });

    layui.use('upload', function(){
        layui.upload({
            url: '/upload/image' //接口url
            ,type: 'post' //默认post
            ,unwrap: true
            ,title: '请上传图片'
            ,before:function(input){
                $(input).after('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
            }
            ,success: function(res){
                if(res.code==0){
                    var html = "<li><img data-original='"+res.data.src+"' src='"+res.data.src+"'></li>";
                    $('#gallery').append(html);
                    var input = "<input name='new_gallery[]' type='hidden' value='"+res.data.src+"' />";
                    $('#gallery_div').append(input);
                }else{
                    alert(res.msg);
                }
            }
        });
    });
});
