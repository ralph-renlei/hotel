<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;


class Mantun
{

    public $appid = NULL;
    public $appscret = NULL;
    public $username = NULL;
    public $password = NULL;
    public $projectCode = NULL;

    public function __construct($appid,$appscret,$username,$password,$project)
    {
        $this->appid = $appid;
        $this->appscret = $appscret;
        $this->username = $username;
        $this->password =  $password;
        $this->projectCode = $project;

    }

    //获取电箱
    public function getBoxes($accessToken){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $boxes = [
            'method'=>'GET_BOXES',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode
        ];
        $boxes['sign'] = $this->makeSign($boxes);
        $raw_result = $this->httpPost($url,$boxes);

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //获取某电箱的实时信息
    public function getRealtime($accessToken,$mac){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $realtime = [
            'method'=>'GET_BOX_CHANNELS_REALTIME',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac
        ];

        $realtime['sign'] = $this->makeSign($realtime);
        $raw_result = $this->httpPost($url,$realtime);

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //GET_BOX_ALARM 告警信息 yyyy-MM-dd HH:mm yyyy-MM-dd HH:mm
    public function getAlarm($accessToken,$mac,$start,$end,$pageSize = 100,$page = 1){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $alarmdata = [
            'method'=>'GET_BOX_ALARM',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac,
            'start'=>$start,
            'end'=>$end,
            'pageSize'=>$pageSize,
            'page'=>$page
        ];

        $alarmdata['sign'] = $this->makeSign($alarmdata);
        $raw_result = $this->httpPost($url,$alarmdata);

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //某年某月的信息 'YYYY' 'mm'
    public function getMonthpower($accessToken,$mac,$year,$month){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $monthpower = [
            'method'=>'GET_BOX_MON_POWER',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac,
            'year'=>$year,
            'month'=>$month
        ];

        $monthpower['sign'] = $this->makeSign($monthpower);
        $raw_result = $this->httpPost($url,$monthpower);

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //某年某月某日的用电 'YYYY' 'mm' 'dd'
    public function getDaypower($accessToken,$mac,$year,$month,$day){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $daypower = [
            'method'=>'GET_BOX_DAY_POWER',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac,
            'year'=>$year,
            'month'=>$month,
            'day'=>$day
        ];

        $daypower['sign'] = $this->makeSign($daypower);
        $raw_result = $this->httpPost($url,$daypower);

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //某电箱所有线路某年某月 平均电压
    public function getMonthavgvoltage($accessToken,$mac,$year,$month){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $monthavgvoltage = [
            'method'=>'GET_BOX_MON_AVG_VOLTAGE',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac,
            'year'=>$year,
            'month'=>$month
        ];

        $monthavgvoltage['sign'] = $this->makeSign($monthavgvoltage);
        $raw_result = $this->httpPost($url,$monthavgvoltage);

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //某电箱所有线路每天 平均电压
    public function getDayavgvoltage($accessToken,$mac,$year,$month,$day){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $dayavgvoltage = [
            'method'=>'GET_BOX_DAY_AVG_VOLTAGE',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac,
            'year'=>$year,
            'month'=>$month,
            'day'=>$day
        ];

        $dayavgvoltage['sign'] = $this->makeSign($dayavgvoltage);
        $raw_result = $this->httpPost($url,$dayavgvoltage);print_r($raw_result);exit;

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['data'];
        }
        return $data;
    }

    //控制电箱的开关
    public function control_power($accessToken,$mac,$openorclose,$addr){
        $url = 'http://open.snd02.com/invoke/router.as';
        $data = [];
        $power = [
            'method'=>'PUT_BOX_CONTROL',
            'client_id'=>$this->appid,
            'access_token'=>$accessToken,
            'timestamp'=>date('YmdHis'),
            'projectCode'=>$this->projectCode,
            'mac'=>$mac,
            'cmd'=>'OCSWITCH',
            'value1'=>$openorclose,
            'value2'=>$addr
        ];
        $power['sign'] = $this->makeSign($power);//获取签名
        $raw_result = $this->httpPost($url,$power);//"{"message":"成功","success":true,"code":"0"}"

        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $data = $result['code'];
        }
        return $data;
    }

    public function getAccessToken($code){
        $access_token = '';
        $client_secret = MD5($this->appid.'authorization_code'.'http://open.snd02.com/demo.jsp'.$code.$this->appscret);
        $token_url = 'http://open.snd02.com/oauth/token.as';
        $token_data = [
            'client_id'=>$this->appid,
            'client_secret'=>$client_secret,
            'grant_type'=>'authorization_code',
            'redirect_uri'=>'http://open.snd02.com/demo.jsp',
            'code'=>$code
        ];
        $raw_result = $this->httpPost($token_url,$token_data);
        $result = json_decode($raw_result,true);
        if($result['success']==true){
            $access_token = $result['data']['accessToken'];
        }
        return $access_token;
    }


    public function getCode(){
        $result = [];
        $code = '';
        $url= 'http://open.snd02.com/oauth/authverify2.as';
        $data = [
            'response_type'=>'code',
            'client_id'=>'O000000006',
            'redirect_uri'=>'http://open.snd02.com/demo.jsp',
            'uname'=>$this->username,
            'passwd'=>$this->password,
        ];
        $raw_result = $this->httpPost($url,$data);
        if($raw_result){
            $result = json_decode($raw_result,true);
            if($result['success']==true){
                $code = $result['code'];
            }
        }
        return $code;
    }

    public function makeSign($params){
        ksort($params);
        $str = '';
        foreach($params as $k=>$v){
            $str .= $v;
        }
        return md5($str.$this->appscret);
    }

    public function httpPost($url, $data){
        $ch = curl_init();
        $header[] = "Accept-Charset: utf-8";
        $header[] = "application/x-www-form-urlencoded";

        $paramsJoined = array();
        foreach($data as $param => $value) {
            $paramsJoined[] = "$param=$value";
        }
        $zhi = implode('&',$paramsJoined);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $zhi);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res = curl_exec($ch);
        return $res;
    }
}