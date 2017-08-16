/**
 * Created by Jian on 2016/12/22.
 */
$(function(){
    if($('#facility').length>0){
        $("#facility").TagsInput({
            usedTags: "",
            hotTags: "",
            tagNum: 10,
            maxWords: 4
        });
    }

    if($('#detail').length>0){
        layui.use('layedit', function(){
            var layedit = layui.layedit;
            layedit.set({
                uploadImage: {
                    url: '/upload/image' //接口url
                    ,type: 'post' //默认post
                    ,before:function(input){
                        $(input).after('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
                    }
                }
            });
            layedit.build('detail'); //建立编辑器
        });
    }
    layui.use('upload', function(){
        layui.upload({
            url: '/upload/image' //接口url
            ,type: 'post' //默认post
            ,unwrap: true
            ,before:function(input){
                $(input).after('<input type="hidden" name="_token" value="'+$('meta[name="csrf-token"]').attr('content')+'">');
            }
            ,success: function(res){
                if(res.code==0){
                    var html = "<li><img data-original='"+res.data.src+"' src='"+res.data.src+"'></li>";
                    $('#gallery').append(html);
                    var input = "<input name='new_gallery[]' type='hidden' value='"+res.data.source+"' />";
                    $('#gallery_div').append(input);
                }else{
                    alert(res.msg);
                }
            }
        });
    });
});