<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Controllers;
use Storage;

class UploadController extends Controller
{

    public function image(){
        $Storage = Storage::disk('local');
        if(!$Storage->exists(date('Ymd'))){
            $Storage->makeDirectory(date('Ymd'));
        }

        $target_dir = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR;

        $item = $_FILES['file'];
        $type = $this->getImageType($item);

        if (empty($type)) {
            $return  = array('code'=>1,'data'=>NULL,'msg'=>self::FAIL_MSG);
            return response()->json($return);
        }
        $target_file = time() . '.' . $type;
        $flag = move_uploaded_file($item['tmp_name'], $target_dir . $target_file);
        if($flag){
            $public = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR;
            copy($target_dir . $target_file,$public.$target_file);
            $data = array('source'=>$target_dir.$target_file, 'src'=>config('app.url').'images/'.$target_file);
            $return = array('code'=>0,'data'=>$data,'msg'=>self::SUCCESS_MSG);
            return response()->json($return);
        }else{
            $error = isset($item['error']) ? $item['error'] : 4;
            $msg = '未知的错误';
            switch ($error)
            {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $msg = '文件大小超过限制';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $msg = '文件只上传了一部分';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $msg = '没有选择文件';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $msg = '临时目录不存在';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $msg = '临时目录没有写的权限';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $msg = '文件格式受限';
                    break;
                default:
                    $msg = '没有选择文件';
                    break;
            }
            $return  = array('code'=>1,'data'=>NULL,'msg'=>$msg);
            return response()->json($return);
        }
    }

    protected function bytesToSize1024($bytes, $precision = 2) {
        $unit = array('B','KB','MB');
        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
    }

    protected function getImageType($image){
        $type = '';
        switch($image['type']){
            case 'image/jpeg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $type = 'jpg';
                break;
            case 'image/png':
            case 'image/x-png':
                $type = 'png';
                break;
            case 'image/gif':
                $type = 'gif';
                break;
            case 'image/bmp':
            case 'image/x-bmp':
            case 'image/x-bitmap':
            case 'image/x-xbitmap':
            case 'image/x-win-bitmap':
            case 'image/x-windows-bmp':
            case 'image/ms-bmp':
            case 'image/x-ms-bmp':
            case 'application/bmp':
            case 'application/x-bmp':
            case 'application/x-win-bitmap':
                $type = 'bmp';
                break;
        }
        return $type;
    }
}