<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;

use WxHotel\Services\JSSDK;

class WxGoods extends JSSDK
{

    public function getByStatus($status=0){
        $list = array();
        $url = 'https://api.weixin.qq.com/merchant/getbystatus?access_token=%s';
        $access_token = $this->getAccessToken();
        $url = sprintf($url,$access_token);
        $data = '{"status":"'.$status.'"}';
        $result = $this->httpPost($url,$data);
        if(!empty($result)){
            if(isset($result['errcode']) && $result['errcode']==0){
                $list = $result['products_info'];
                return $list;
            }
        }
        return $list;
    }

    public function add(){

    }
    public function del(){

    }
    public function update(){

    }

    public function get($goods_id){
        $goods = array();
        $url = 'https://api.weixin.qq.com/merchant/get?access_token=%s';
        $access_token = $this->getAccessToken();
        $url = sprintf($url,$access_token);
        $data = '{"product_id":"'.$goods_id.'"}';
        $result = $this->httpPost($url,$data);
        if(!empty($result)){
            if(isset($result['errcode']) && $result['errcode']==0){
                $goods = $result['product_info'];
                return $goods;
            }
        }
        return $goods;
    }

}