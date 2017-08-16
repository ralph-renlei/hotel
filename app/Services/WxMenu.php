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

class WxMenu extends JSSDK
{
    public function getMenu(){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=%s';
        $access_token = $this->getAccessToken();
        $url  = sprintf($url,$access_token);

    }

    public function createMenu($data){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s';
        $access_token = $this->getAccessToken();
        $url  = sprintf($url,$access_token);
        $menu_list_str = '';
        $menu_str = '{"button":[%s]}';

        foreach($data as $item){
            $item_str = '';
            if($item['mtype']=='click'){
                if(isset($item['children']) && !empty($item['children'])){
                    $child_str = '';
                    foreach($item['children'] as $child){
                        if($child['mtype']=='click'){
                            $child_str .= '{'.
                                '"type":"'.$child['mtype'].'",'.
                                '"name":"'.$child['name'].'",'.
                                '"key":"'.$child['mtype'].$child['id'].'"'
                                .'},';
                        }else if($child['mtype']=='view'){
                            $child_str .= '{'.
                                '"type":"'.$child['mtype'].'",'.
                                '"name":"'.$child['name'].'",'.
                                '"url":"'.$child['val'].'"'
                                .'},';
                        }
                    }
                    $child_str = trim($child_str,',');
                    $item_str = '{'.
                        '"name":"'.$item['name'].'",'.
                        '"sub_button":['.$child_str.']'
                         .'}';
                }else{
                    $item_str = ',{'.
                        '"type":"'.$item['mtype'].'",'.
                        '"name":"'.$item['name'].'",'.
                        '"key":"'.$item['mtype'].$item['id'].'"'
                        .'}';
                }

            }else if($item['mtype']=='view'){
                $item_str = '{'.
                    '"type":"'.$item['mtype'].'",'.
                    '"name":"'.$item['name'].'",'.
                    '"url":"'.$item['val'].'"'
                    .'}';
            }
            $menu_list_str .= $item_str .',';
        }
        $menu_list_str = trim($menu_list_str,',');
        $str = sprintf($menu_str,$menu_list_str);
        return $this->httpPost($url,$str);
    }

    public function delMenu(){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s';
        $access_token = $this->getAccessToken();
        $url  = sprintf($url,$access_token);
        $result = $this->httpGet($url);
        $json = json_decode($result,true);
        return $json;
    }

}