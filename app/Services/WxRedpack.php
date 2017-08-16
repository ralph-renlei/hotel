<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;

use WxHotel\Services\Wx;

class WxRedpack extends Wx
{
    protected $mch_billno = NULL;
    protected $mch_id = NULL;
    protected $wxappid = NULL;
    protected $send_name = NULL;
    protected $re_openid = NULL;
    protected $total_amount = NULL;
    protected $total_num = 1;
    protected $wishing = '感谢您的惠顾';
    protected $client_ip = NULL;
    protected $act_name = NULL;
    protected $remark = NULL;
    protected $scene_id = NULL;
    protected $risk_info = NULL;
    protected $consume_mch_id = NULL;

    protected $amt_type = NULL;

    protected $is_partner = false;
    protected $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';

    protected $scene_id_map = array(
      'PRODUCT_1',//商品促销
      'PRODUCT_2',//抽奖
      'PRODUCT_3',//虚拟物品兑奖
      'PRODUCT_4',//企业内部福利
      'PRODUCT_5',//渠道分润
      'PRODUCT_6',//保险回馈
      'PRODUCT_7',//彩票派奖
      'PRODUCT_8',//税务刮奖
    );

    public function send(){
        $return = array();
        $data = array(
            'nonce_str'=>$this->createNonceStr(),
            'mch_billno'=>$this->getMchBillno(),
            'mch_id'=>$this->getMchId(),
            'wxappid'=>$this->getWxAppId(),
            'send_name'=>$this->getSendName(),
            're_openid'=>$this->getReOpenid(),
            'total_amount'=>$this->getTotalAmount(),
            'total_num'=>$this->getTotalNum(),
            'wishing'=>$this->getWishing(),
            'client_ip'=>$this->getClientIp(),
            'act_name'=>$this->getActName(),
            'remark'=>$this->getRemark()
        );

        if(!empty($this->getSceneId())){
            $data['scene_id'] = $this->getSceneId();
        }

        if(!empty($this->getRiskInfo() )){
            $data['risk_info'] = $this->getRiskInfo();
        }

        if($this->is_partner){
            $data['consume_mch_id'] = $this->getConsumeMchId();
        }
        if(!empty($this->getAmtType())){
            $data['amt_type'] = $this->getAmtType();
        }
        $xml = $this->toXml($data);
        $result = $this->httpPost($this->url,$xml,true);
        if(!empty($result)){
            $return = $this->fromXml($result);
        }
        return $return;
    }

    public function getAmtType(){
        return $this->amt_type;
    }

    public function setAmtType($type){
        $this->amt_type = $type;
    }

    public function getClientIp(){
        return $this->client_ip;
    }
    public function setClientIp($ip){
        return $this->client_ip = $ip;
    }

    public function setTotalNum($num){
        $this->total_num = $num;
    }

    public function getTotalNum(){
        return $this->total_num;
    }

    public function setMchBillno($no){
        $this->mch_billno = $no;
    }

    public function getMchBillno(){
        return $this->mch_billno;
    }

    public function setMchId($id){
        $this->mch_id = $id;
    }

    public function getMchId(){
        return $this->mch_id;
    }

    public function setWxAppId($appid){
        $this->wxappid = $appid;
    }

    public function getWxAppId(){
        return $this->wxappid;
    }

    public function setSceneId($scene){
        $this->scene_id = $scene;
    }

    public function getSceneId(){
        return $this->scene_id;
    }

    public function setSendName($name){
        $this->send_name = $name;
    }

    public function getSendName(){
        return $this->send_name;
    }

    public function setOpenid($openid){
        $this->re_openid = $openid;
    }

    public function getReOpenid(){
        return $this->re_openid;
    }

    public function setTotalAmount($amount){
        $this->total_amount = $amount;
    }

    public function getTotalAmount(){
        return $this->total_amount;
    }

    public function setWishing($ads){
        $this->wishing = $ads;
    }

    public function getWishing(){
        return $this->wishing;
    }

    public function setActName($act){
        $this->act_name = $act;
    }

    public function getActName(){
        return $this->act_name;
    }

    public function setRemark($remark){
        $this->remark = $remark;
    }

    public function getRemark(){
        return $this->remark;
    }

    public function setRiskInfo($info){
        $param = http_build_query($info);
        $this->risk_info = $param;
    }

    public function getRiskInfo(){
        return $this->risk_info;
    }

    public function setConsumeMchId($mch_id){
        $this->consume_mch_id = $mch_id;
    }

    public function getConsumeMchId(){
        return $this->consume_mch_id;
    }


    public function httpPost($url, $data, $useCert=false){
        $ch = curl_init();
        $header[] = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, env('SSLCERT_PATH'));
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, env('SSLKEY_PATH'));
        }

        $res = curl_exec($ch);
        return $res;
    }

}