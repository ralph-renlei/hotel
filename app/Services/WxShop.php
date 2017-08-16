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

class WxShop extends JSSDK
{
     public function getOrderDetail($order_id){
         $url = 'https://api.weixin.qq.com/merchant/order/getbyid?access_token=%s';
         $access_token = $this->getAccessToken();
         $url  = sprintf($url,$access_token);
         $data = '{"order_id": "'.$order_id.'"}';
         $result = $this->httpPost($url, $data);
         return $result;
     }

    public function delivery($order_id,$delivery_company=NULL,$delivery_track_no=NULL,$need_delivery=0,$is_others=0){
        $url = 'https://api.weixin.qq.com/merchant/order/setdelivery?access_token=%s';
        $access_token = $this->getAccessToken();
        $url  = sprintf($url,$access_token);
        if($need_delivery){
            $data = '{"order_id":"'.$order_id.'",'.
                    '"delivery_company":"'.$delivery_company.'",'.
                    '"delivery_track_no":"'.$delivery_track_no.'",'.
                    '"need_delivery":"'.$need_delivery.'",'.
                    '"is_others":"'.$is_others.'",'.
                    '}';

        }else{
            $data = '{"order_id":"'.$order_id.'",'.
                    '"need_delivery":"'.$need_delivery.'",'.
                    '"is_others":"'.$is_others.'",'.
                    '}';
        }

        return $result = $this->httpPost($url, $data);
    }

    public function getOrderByStatus($status=NULL,$start_time=NULL,$end_time=NULL){
        $list = array();
        $url = 'https://api.weixin.qq.com/merchant/order/getbyfilter?access_token=%s';
        $access_token = $this->getAccessToken();
        $url  = sprintf($url,$access_token);
        $data = '';
        if(!empty($status) && !empty($start_time) && !empty($end_time)){
            $data = '{"status": "'.$status.'","begintime":"'.$start_time.'","endtime":"'.$end_time.'"}';
        }else if(!empty($status) ){
            $data = '{"status": "'.$status.'"}';
        }else if(!empty($start_time) && !empty($end_time)){
            $data = '{"begintime":"'.$start_time.'","endtime":"'.$end_time.'"}';
        }

        $result = $this->httpPost($url, $data);

        if(!empty($result)){
            if(isset($result['errcode']) && $result['errcode'] ==0){
                $list = $result['order_list'];
                return $list;
            }
        }
        return $list;
    }
}