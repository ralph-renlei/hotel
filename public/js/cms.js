/**
 * Created by Jian on 2016/12/21.
 */
$(function(){
    if($('#tags').length>0){
        $("#tags").TagsInput({
            usedTags: "",
            hotTags: "",
            tagNum: 10,
            maxWords: 4
        });
    }

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
});