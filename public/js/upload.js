/**
 * Created by Jian on 2016/12/15.
 */
var iBytesUploaded = 0;
var iBytesTotal = 0;
var iPreviousBytesLoaded = 0;
var iMaxFilesize = 1048576*3; // 3MB
var oTimer = 0;
var sResultFileSize = '';
var currentUpload = '';
var limit = LIMIT;
$(function() {
    $('.weui_uploader_input').on('change', function () {
        if($('.weui_uploader_file').length>limit){
            alert('图片数超过限制');
            return false;
        }
        var upload_id = $(this).attr('id');
        var status_id = upload_id + '_status';
        var preview_id = upload_id + '_preview';
        currentUpload = upload_id;
        fileSelected(upload_id, status_id, preview_id);
    });

    $(document).on('tap','.weui_uploader_file',function(){
        $(this).remove();
    });

});