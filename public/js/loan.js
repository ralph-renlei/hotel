/**
 * Created by Jian on 2017/6/27.
 */
$(function(){
    if($('.purpose_cell').length>0){
        $('.purpose_cell').on('click',function(){
            if($(this).hasClass('current_purpose')){
                $(this).removeClass('current_purpose');
                var id = $(this).attr('data');
                $('#purporse_val'+id).remove();
            }else{
                $(this).addClass('current_purpose');
                var id = $(this).attr('data');
                var obj_id = $(this).attr('id');
                var txt =  $(this).text();
                var html = '<input type="hidden" name="purpose[]" id="purporse_val'+id+'" value="'+txt+'"/>';
                $(this).after(html);
            }
        });
    }
});
