<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;

use WxHotel\Services\ClientResponseHandler;
use WxHotel\Services\PayHttpClient;
use WxHotel\Services\RequestHandler;
use WxHotel\Services\Utils;

class Swiftpass
{
    public $notify = NULL;
    public $callback = NULL;
    public $resHandler = NULL;
    public $reqHandler = NULL;
    public $pay = NULL;

    public function __construct($notify=NULL,$callback=NULL)
    {
        $this->notify = $notify;
        $this->callback = $callback;
        $this->resHandler = new ClientResponseHandler();
        $this->reqHandler = new RequestHandler();
        $this->pay = new PayHttpClient();
        $url = env('SWIFTPASS_URL');
        $key = env('SWIFTPASS_KEY');
        $this->reqHandler->setGateUrl($url);
        $this->reqHandler->setKey($key);

    }
    public function submitOrderInfo($param){
        $mchid = env('SWIFTPASS_MCHID');
        $version = env('SWIFTPASS_VERSION');
        $this->reqHandler->setReqParams($param,array('method'));
        $this->reqHandler->setParameter('service','pay.weixin.jspay');//接口类型：pay.weixin.jspay
        $this->reqHandler->setParameter('mch_id',$mchid);//必填项，商户号，由威富通分配
        $this->reqHandler->setParameter('version',$version);
        //通知地址，必填项
        $this->reqHandler->setParameter('notify_url',$this->notify);//通知回调地址，目前默认是空格，商户在测试支付和上线时必须改为自己的，且保证外网能访问到
        $this->reqHandler->setParameter('callback_url',$this->callback);
        $this->reqHandler->setParameter('nonce_str',mt_rand(time(),time()+rand()));//随机字符串，必填项，不长于 32 位
        $this->reqHandler->createSign();//创建签名

        $data = Utils::toXml($this->reqHandler->getAllParameters());
        $this->pay->setReqContent($this->reqHandler->getGateURL(),$data);

        if($this->pay->call()){
            $this->resHandler->setContent($this->pay->getResContent());
            $this->resHandler->setKey($this->reqHandler->getKey());

            if($this->resHandler->isTenpaySign()){
                //当返回状态与业务结果都为0时才返回支付二维码，其它结果请查看接口文档
                $res = $this->resHandler->getAllParameters();

                if($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0){
                    $token_id = $this->resHandler->getParameter('token_id');

                    $return = array('status'=>200,'token_id'=>$token_id,'url'=>env('SWIFTPASS_JSPAY').'?token_id='.$token_id);

                }else{
                    $return =  array('status'=>500,'msg'=>'Error Code:'.$this->resHandler->getParameter('err_code').' Error Message:'.$this->resHandler->getParameter('message'));
                }
            }else{
                $return = array('status'=>500,'msg'=>'Error Code:'.$this->resHandler->getParameter('status').' Error Message:'.$this->resHandler->getParameter('message'));
            }
        }else{
            $return = array('status'=>500,'msg'=>'Response Code:'.$this->pay->getResponseCode().' Error Info:'.$this->pay->getErrInfo());
        }

        return $return;
    }

    public function notify(){
        $xml = file_get_contents('php://input');
        $key = env('SWIFTPASS_KEY');
        $this->resHandler->setContent($xml);
        $this->resHandler->setKey($key);

        if($this->resHandler->isTenpaySign()){
            if($this->resHandler->getParameter('status') == 0 && $this->resHandler->getParameter('result_code') == 0){
                $file = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'result.txt';
                Utils::dataRecodes($file,'接口回调收到通知参数',$this->resHandler->getAllParameters());
                echo 'success';
            }else{
                echo 'failure';
            }
        }else{
            echo 'failure';
        }
        die();
    }
}