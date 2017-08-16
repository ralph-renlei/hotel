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

class WxAppNotice extends JSSDK
{

    public function sendDeliveryRecord($openid,$goods_name,$order_id,$order_date){
        /**
        eJc_iqsxQgHbIMK5wYh4MTXO7oCFuIQUudZ2EUj3NvE
        标题
        服务进度通知
        关键词
        商品名称
        {{keyword1.DATA}}
        订单编号
        {{keyword2.DATA}}
        下单时间
        {{keyword3.DATA}}
        服务进度
        {{keyword4.DATA}}
         **/
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=%s';
        $template_id = 'eJc_iqsxQgHbIMK5wYh4MTXO7oCFuIQUudZ2EUj3NvE';
        $access = $this->getAccessToken('wxapp_');
        $url = sprintf($url,$access);
        $txt = array(
            'keyword1'=>array('value'=>urlencode($goods_name)),
            'keyword2'=>array('value'=>urlencode($order_id)),
            'keyword3'=>array('value'=>urlencode($order_date)),
            'keyword4'=>array('value'=>urlencode('请上传您的明日送餐信息')),
        );
        $url = '/pages/index/index';
        $msg = array(
            'touser'=>$openid,'template_id'=>$template_id,'page'=>$url,'topcolor'=>'#173177','data'=>$txt,
        );
        return $this->send(urldecode(json_encode($msg)));
    }

    public function sendDelivery($openid,$delivery){
       $template_id = '9MW1MJijNcAdMZP9XdFbk47xtQns6R8eJta4dbXC1zc';

        $txt = array(
            'keyword1'=>array('value'=>urlencode($delivery['delivery_date'].' '.$delivery['delivery_time'])),
            'keyword2'=>array('value'=>urlencode('健身餐')),
            'keyword3'=>array('value'=>urlencode($delivery['oid'])),
            'keyword4'=>array('value'=>urlencode($delivery['place'])),
            'keyword5'=>array('value'=>urlencode('请尽快前往取餐点取餐')),
            'keyword6'=>array('value'=>urlencode($delivery['name'])),
            'keyword7'=>array('value'=>urlencode('正在为您发货')),
        );
        $url = '/pages/detail/detail?id='.$delivery['id'];
        $msg = array(
            'touser'=>$openid,'template_id'=>$template_id,'page'=>$url,'data'=>$txt,
        );
        return $this->send(urldecode(json_encode($msg)));
    }

    public function send($data){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$this->getAccessToken('wxapp_');
        $result = $this->httpPost($url, $data);
        return $result;
    }

}