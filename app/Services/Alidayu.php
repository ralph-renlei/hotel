<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;

class Alidayu{
    public function sendAli($telphone,$randomCode){
        include(app_path().'/Services/alidayu/top/TopClient.php');
        include(app_path().'/Services/alidayu/top/ResultSet.php');
        include(app_path().'/Services/alidayu/top/RequestCheckUtil.php');
        include(app_path().'/Services/alidayu/top/TopLogger.php');
        include(app_path().'/Services/alidayu/top/request/AlibabaAliqinFcSmsNumSendRequest.php');
        include app_path()."/Services/alidayu/TopSdk.php";
        date_default_timezone_set('Asia/Shanghai');
        $c = new \TopClient;
        $c->appkey = '23651118';
        $c->secretKey = '514246ba52fcf74227fbfc965c2cb251';
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req ->setExtend( "123456" );//固定参数
        $req ->setSmsType( "normal" );//固定参数
        $req ->setSmsFreeSignName( "全景天成" );//来源于配置短信签名 下面列表中有签名名称
        $number = $randomCode;
        $time = 10;
        $req ->setSmsParam( "{code:'{$number}',product:'{$time}'}" ); //变量来源于 配置短信模板 点击列表中的详情 模板内容的变量
        $req ->setRecNum($telphone); //手机号
        $req ->setSmsTemplateCode("SMS_91850005"); //配置短信模板 列表中有模板id
        $resp = $c ->execute( $req );
        $resp->code = $randomCode;
        return $resp;
    }

    //追加手机验证码
    public function registCode($telphone)
    {
        $randomCode=$this->randCode(4,1);
        $return = $this->sendAli($telphone , $randomCode);
        return $return;
    }
    /**
    +----------------------------------------------------------
     * 生成随机字符串
    +----------------------------------------------------------
     * @param int       $length  要生成的随机字符串长度
     * @param string    $type    随机码类型：0，数字+大写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
    +----------------------------------------------------------
     * @return string
    +----------------------------------------------------------
     */
    function randCode($length = 5, $type = 0) {
        $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
        if ($type == 0) {
            array_pop($arr);
            $string = implode("", $arr);
        } else if ($type == "-1") {
            $string = implode("", $arr);
        } else {
            $string = $arr[$type];
        }
        $count = strlen($string) - 1;
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $str[$i] = $string[rand(0, $count)];
            $code .= $str[$i];
        }
        return $code;
    }
}