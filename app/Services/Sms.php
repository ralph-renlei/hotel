<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;
use WxHotel\SmsRecord;

class Sms
{
    protected $apikey = NULL;
    protected $sign = NULL;
    protected $tpl_id = NULL;

    const SMS_URL = 'https://sms.yunpian.com/v2/sms/single_send.json';
    const BATCH_URL = 'https://sms.yunpian.com/v2/sms/batch_send.json';
    const MULTI_URL = 'https://sms.yunpian.com/v2/sms/multi_send.json';
    const VOICE_URL = 'http://voice.yunpian.com/v2/voice/send.json';
    const USER_URL = 'https://sms.yunpian.com/v2/user/get.json';
    const TPL_URL = 'https://sms.yunpian.com/v2/sms/tpl_single_send.json';
    const APIKEY = '236911ba34b8b3e671f5dc091118d5fc';
    const SIGN = '美滙平台';
    const CODE_TPL = 1;
    const NOTICE_TPL = 2;

    public function __construct(SmsRecord $sms_record)
    {
        $this->apikey = self::APIKEY;
        $this->tpl_id = self::CODE_TPL;
        $this->sign = self::SIGN;
        $this->sms_record = $sms_record;
    }

    //$mobiles 多个用,分开
    public function send_batch_sms($mobiles,$param){
        $tpl_value = $this->get_tpl_val($param);
        $text = $this->get_sms_text($param);
        if(!$text){
            return false;
        }

        $data=array(
            'apikey'=>$this->apikey,
            'text'=>$text,
            'mobile'=>$mobiles
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, self::BATCH_URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $return = curl_exec($ch);
        curl_close($ch);
        return json_decode($return,true);
    }
    public function get_sms_text($param){
        $return = false;
        $tpl = $this->get_tpl_data($this->tpl_id);
        if(empty($tpl)){
            return $return;
        }
        $str = '【'.$this->sign.'】';
        $content = $tpl['content'];
        foreach($param as $key=>$value){
            $content = str_replace('#'.$key.'#',$value,$content);
        }
        $str .= $content;
        return $str;
    }
    public function get_tpl_val($data){
        $return = false;
        $tpl = $this->get_tpl_data($this->tpl_id);
        if(empty($tpl)){
            return $return;
        }
        $str = '';
        foreach($tpl['vars'] as $key){
            if(isset($data[$key])){
                $str .= urlencode('#'.$key.'#').'='.urlencode($data[$key]).'&';
            }
        }
        if(strlen($str)>0){
            return trim($str,'&');
        }
        return $return;
    }

    //发送模板短信
    public function send_sms($mobile,$param){
        $tpl_value = $this->get_tpl_val($param);
        if(!$tpl_value){
            return false;
        }

        $data=array(
            'tpl_id'=>$this->tpl_id,
            'tpl_value'=>$tpl_value,
            'apikey'=>$this->apikey,
            'mobile'=>$mobile
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, self::TPL_URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $return = curl_exec($ch);
        curl_close($ch);
        return json_decode($return,true);
    }

    //发生验证码
    public function send_valid_sms($mobile){
        $code = mt_rand(100000,999999);
        $record = array('mobile'=>$mobile,'token'=>$code,'status'=>0);
        $this->sms_record->create($record);
        $text= '【'.$this->sign.'】您的验证码是'.$code;
        $data=array('text'=>$text,'apikey'=>$this->apikey,'mobile'=>$mobile);
        $ch = curl_init();
        $header = array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, self::SMS_URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

    //获取当前用户信息
    public function get_user(){
        $ch = curl_init();
        $header = array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/user/get.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('apikey' => $this->apikey)));
        $result =  curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

    //发送语音验证码
    public function voice_send($mobile,$code){
        // 发送语音验证码
        $data=array('code'=>$code,'apikey'=>$this->apikey,'mobile'=>$mobile);
        $ch = curl_init();
        $header = array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded','charset=utf-8');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($ch, CURLOPT_URL, self::VOICE_URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

    public function get_tpl_data($id){
        $data = array(
            1395763 => array(
                'content'=>'您的微信支付账户于#datetime#入账人民币#content#元。',
                'vars' =>array('content','datetime')
            ),
            1514944 => array(
                'content'=>'尊敬的#name#，您的#order_name#订单已经#status#，请您#note#！',
                'vars'=>array('name','order_name','status','note')
            ),
            1514902 =>array(
                'content'=>'尊敬的#name#，您有一个#order_name#订单待处理，请登录一网通微信管理平台及时处理！',
                'vars'=>array('name','order_name')
            ),
            1516132=>array(
                'content'=>'尊敬的#name#，您的排队号码为#number#已经过期，请您重新排队！如需继续就餐，请出示此信息，工作人员为您优先安排。',
                'vars'=>array('name','number'),
            ),
        );
        return $data[$id];
    }

}