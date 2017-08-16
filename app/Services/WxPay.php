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

class WxPay extends Wx
{

    protected $partner_trade_no=NULL;
    protected $re_user_name=NULL;
    protected $amount=NULL;
    protected $desc=NULL;
    protected $check_name=NULL;
    protected $mch_appid=NULL;
    protected $mchid=NULL;
    protected $mch_id = NULL;
    protected $device_info = NULL;
    protected $nonce_str= NULL;
    protected $sign= NULL;
    protected $sign_type= NULL;
    protected $body= NULL;
    protected $detail= NULL;
    protected $attach= NULL;
    protected $out_trade_no= NULL;
    protected $transaction_id = NULL;
    protected $fee_type= NULL;
    protected $total_fee= NULL;
    protected $spbill_create_ip= NULL;
    protected $time_start= NULL;
    protected $time_expire= NULL;
    protected $goods_tag= NULL;
    protected $notify_url= NULL;
    protected $trade_type= NULL;
    protected $limit_pay= NULL;
    protected $openid= NULL;
    protected $timeStamp = NULL;
    protected $key = NULL;
    public function __construct($appid, $appscret, $config)
    {
        parent::__construct($appid, $appscret, $config['sign_type']);
        $this->_config($config);
    }


    public function notify(&$result)
    {
        $return = array(
            'return_code'=>'FAIL',
            'return_msg'=>'签名失败',
        );
        //获取通知的数据
        $xml = file_get_contents("php://input");
        if(empty($xml)){
            $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        }
        $result = $this->fromXml($xml);
        //如果返回成功则验证签名
        if(isset($result)){
            $return['order_sn']=$result['out_trade_no'];
            $return['time_end']=$result['time_end'];
            $return['transaction_id']=$result['transaction_id'];
            $sign = $result['sign'];
            if($sign==$this->makeSign($result,$this->key)){//不统一
                $return['return_code'] = 'SUCCESS';
                $return['return_msg'] = 'OK';
            }
        }
        return $return;
    }

    public function unifiedOrder(){
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $params = $this->unifiedOrderParams();
        $data = array();
        foreach($params as $param=>$flag){
            $value =  $this->__get($param);
            if(isset($value)){
                $data[$param] = $value;
            }
        }
        $data['notify_url'] = $this->notify_url;
        $this->setSign($data,$this->key);
        $data['sign'] = $this->getSign();
        $xml = $this->toXml($data);
        $response = $this->httpPost($url,$xml);
        $result = $this->fromXml($response);
        return $result ;
    }

    public function transfersOrder(){
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $params = $this->transfersOrderParams();
        $data = array();
        foreach($params as $param=>$flag){
            $value =  $this->__get($param);
            if(isset($value)){
                $data[$param] = $value;
            }
        }
        $data['mch_appid']= $this->mch_appid;
        $data['mchid']= $this->mch_id;
        $this->setSign($data,$this->key);
        $data['sign'] = $this->getSign();
        $xml = $this->toXml($data);
        $response = $this->httpPemPost($url,$xml);
        $result = $this->fromXml($response);
        return $result ;
    }

    public function orderQuery(){
        $url = 'https://api.mch.weixin.qq.com/pay/orderquery';
        $params = $this->orderQueryParams();
        $data = array();
        foreach($params as $param=>$flag){
            $value =  $this->__get($param);
            if(isset($value)){
                $data[$param] = $value;
            }
        }
        $data['sign'] = $this->setSign($data,$this->key);
        $xml = $this->toXml($data);
        $response = $this->httpPost($url,$xml);
        $result = $this->fromXml($response);
        return $result;
    }

    public function orderQueryParams(){
        $return = array(
            'appid'=>1,
            'mch_id'=>1,
            'transaction_id'=>1,
            'out_trade_no'=>1,
            'nonce_str'=>1,
        );
        return $return;
    }

    public function transfersOrderParams(){
        $return=array(
            'mch_appid'=>1,
            'mchid'=>1,
            'device_info'=>0,
            'nonce_str'=>1,
            'sign'=>1,
            'partner_trade_no'=>1,
            'openid'=>1,
            'check_name'=>1,
            're_user_name'=>0,
            'amount'=>1,
            'desc'=>1,
            'spbill_create_ip'=>1,
        );
        return $return;
    }
    public function unifiedOrderParams(){
        $return = array(
            'appid'=>1,
            'mch_id'=>1,
            'device_info'=>0,
            'nonce_str'=>1,
            'sign'=>1,
            'sign_type'=>0,
            'body'=>1,
            'detail'=>0,
            'attach'=>0,
            'out_trade_no'=>0,
            'fee_type'=>0,
            'total_fee'=>1,
            'spbill_create_ip'=>1,
            'time_start'=>0,
            'time_expire'=>0,
            'goods_tag'=>0,
            'notify_url'=>1,
            'trade_type'=>1,
            'product_id'=>0,
            'limit_pay'=>0,
            'openid'=>1,
        );
        return $return;
    }

    protected function _config($config){
        $this->nonce_str=$this->createNonceStr();
        $this->key = $config['key'];
        $this->notify_url=$config['notify_url'];

        if(isset($config['spbill_create_ip'])){
            $this->setSpbillCreateIp($config['spbill_create_ip']);
        }
        if(isset($config['desc'])){
            $this->setDesc($config['desc']);
        }
        if(isset($config['amount'])){
            $this->setAmount($config['amount']);
        }
        if(isset($config['re_user_name'])){
            $this->setReUserName($config['re_user_name']);
        }
        if(isset($config['check_name'])){
            $this->setCheckName($config['check_name']);
        }
        if(isset($config['partner_trade_no'])){
            $this->setPartnerTradeNo($config['partner_trade_no']);
        }
        if(isset($config['mch_appid'])){
            $this->setMchAppId($config['mch_appid']);
        }


        if(isset($config['trade_type'])){
            $this->setTradeType($config['trade_type']);
        }

        if(isset($config['ip'])){
            $this->setSpbillCreateIp($config['ip']);
        }

        if(isset($config['openid'])){
            $this->setOpenid($config['openid']);
        }

        if(isset($config['product_id'])){
            $this->setProductId($config['product_id']);
        }

        if(isset($config['time_expire'])){
            $this->setTimeExpire($config['time_expire']);
        }

        if(isset($config['total_fee'])){
            $this->setTotalFee($config['total_fee']);
        }

        if(isset($config['out_trade_no'])){
            $this->setOutTradeNo($config['out_trade_no']);
        }

        if(isset($config['attach'])){
            $this->setAttach($config['attach']);
        }

        if(isset($config['detail'])){
            $this->setDetail($config['detail']);
        }

        if(isset($config['body'])){
            $this->setBody($config['body']);
        }
        if(isset($config['sign_type'])){
            $this->setSignType($config['sign_type']);
        }

        if(isset($config['device_info'])){
            $this->setDeviceInfo($config['device_info']);
        }

        if(isset($config['appid'])){
            $this->setAppId($config['appid']);
        }

        if(isset($config['mch_id'])){
            $this->setMchId($config['mch_id']);
        }

        if(isset($config['time_start'])){
            $this->setTimeStart($config['time_start']);
        }

        if(isset($config['limit_pay'])){
            $this->setLimitPay($config['limit_pay']);
        }

        if(isset($config['goods_tag'])){
            $this->setGoodsTag($config['goods_tag']);
        }

        if(isset($config['fee_type'])){
            $this->setFeeType($config['fee_type']);
        }
    }

    /**
     *
     * 检测签名
     */
    public function CheckSign()
    {
        $sign = $this->MakeSign();
        if($this->getSign() == $sign){
            return true;
        }
        return false;
    }

    public function setDesc($desc){
        $this->desc=$desc;
    }
    public function getDesc(){
        return $this->desc;
    }
    public function setAmount($amount){
        $this->amount=$amount;
    }
    public function getAmount(){
        return $this->amount;
    }
    public function setReUserName($re_user_name){
        $this->re_user_name=$re_user_name;
    }
    public function getReUserName(){
        return $this->re_user_name;
    }
    public function setCheckName($check_name){
        $this->check_name=$check_name;
    }
    public function getCheckName(){
        return $this->check_name;
    }
    public function setPartnerTradeNo($partner_trade_no){
        $this->partner_trade_no=$partner_trade_no;
    }
    public function getPartnerTradeNo(){
        return $this->partner_trade_no;
    }
    public function setMchAppId($mch_appid){
        $this->mch_appid=$mch_appid;
    }
    public function getMchAppId(){
        return $this->mch_appid;
    }
    public function setAppId($appid){
        $this->appid = $appid;
    }

    public function getAppID(){
        return $this->appid;
    }

    public function setMchId($mch_id){
        $this->mch_id = $mch_id;
    }

    public function getMchId(){
        return $this->mch_id;
    }

    public function setTotalFee($money){
        $this->total_fee = $money*100;
    }

    public function getTotalFee(){
        return $this->total_fee;
    }

    public function setNonceStr(){
        $this->nonce_str = $this->createNonceStr();
    }

    public function getNonceStr(){
        return $this->nonce_str;
    }

    public function getTimeStamp(){
        return $this->timeStamp;
    }
    public function setTimeStamp(){
        $this->timeStamp = time();
    }
    public function setTransactionId($id){
        $this->transaction_id = $id;
    }

    public function getTransactionId(){
        return $this->transaction_id;
    }

    public function setSign($params,$key){
        $this->sign = $this->makeSign($params,$key);
    }

    public function getSign(){
        return $this->sign;
    }

    public function getDeviceInfo(){
        return $this->device_info;
    }

    public function setDeviceInfo($device_info){
        $this->device_info = $device_info;
    }
    public function getOpenid(){
        return $this->openid;
    }
    public function setOpenid($openid){
        $this->openid = $openid;
    }
    public function setDetail($detail){
        $this->detail = $detail;
    }

    public function getDetail(){
        return $this->detail;
    }
    public function setAttach($attach){
        $this->attach = $attach;
    }

    public function getAttach(){
        return $this->attach;
    }

    public function getOutTradeNo(){
        return $this->out_trade_no;
    }

    public function setOutTradeNo($no){
        $this->out_trade_no = $no;
    }

    public function setFeeType($type){
        $this->fee_type = $type;
    }

    public function getFeeType(){
        return $this->fee_type;
    }

    public function getBody(){
        return $this->body;
    }

    public function setBody($body){
        return $this->body = $body;
    }

    public function getSpbillCreateIp(){
        return $this->spbill_create_ip;
    }

    public function setSpbillCreateIp($ip){
        $this->spbill_create_ip = $ip;
    }

    public function setTimeStart($start){
        $this->time_start = $start;
    }

    public function getTimeStart(){
        return $this->time_start;
    }

    public function setTimeExpire($expire){
        $this->time_expire = $expire;
    }

    public function getTimeExpire(){
        return $this->time_expire;
    }

    public function getGoodsTag(){
        return $this->goods_tag;
    }

    public function setGoodsTag($tag){
        $this->goods_tag = $tag;
    }

    public function setNotifyUrl($notify){
        $this->notify_url = $notify;
    }

    public function getNofityUrl(){
        return $this->notify_url;
    }

    public function setLimitPay($pay){
        $this->limit_pay = $pay;
    }

    public function getLimitPay(){
        return $this->limit_pay;
    }

    public function setTradeType($trade_type){
        $this->trade_type = $trade_type;
    }

    public function getTradeType(){
        return $this->trade_type;
    }


    public function setSignType($sign_type){
        $this->sign_type = $sign_type;
    }

    public function getSignType(){
        return $this->sign_type;
    }

    public function setProductId($product_id){
        $this->product_id=$product_id;
    }

    public function getProductId(){
        return $this->product_id;
    }
    public function __get($name)
    {
        if(strpos($name,'_')>0){
            $name_array = explode('_',$name);
            $names = array_map('ucfirst',$name_array);
            $name = join('',$names);
        }else{
            $name = ucfirst($name);
        }
        $getter = 'get' .$name ;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        return false;
    }

    public function __set($name, $value)
    {
        if(strpos($name,'_')>0){
            $name_array = explode('_',$name);
            $names = array_map('ucfirst',$name_array);
            $name = join('',$names);
        }else{
            $name = ucfirst($name);
        }
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        }
        return false;
    }

    /**
     * 通讯码
     */
    public function commCode($retcode){

        $code['001']='请求地址不正确';
        $code['002']='请求参数为空';
        $code['003']='请求参数格式不正确';
        $code['004']='验证签名失败';
        $code['005']='订单状态异常';
        $code['006']='微信通信异常';
        $code['007']='商户不存在';
        $code['008']='微信接口后台错误';
        $code['009']='微信参数错误';
        $code['010']='商户密钥不存在';
        $code['011']='商户未设置手续费';
        $code['012']='商户入账失败';
        $code['013']='商户出账失败';
        $code['014']='商户未设置子商户编号';
        $code['015']='商户没有操作此订单权限';
        $code['016']='订单来源不能为空';
        $code['017']='服务器忙，请稍候再试';
        $code['021']='Jsapi支付没有设置appid';
        $code['999']='系统未知异常';
        return isset($code[$retcode])?$code[$retcode]:'验证签名成功';
    }



    /**
     * 银行支付
     */
    public function getBankType($btype){

        $banktype['CFT']='微信账户余额';
        $banktype['CMBC_DEBIT']='民生银行借记卡';
        $banktype['CMB_DEBIT']='招商银行借记卡';
        $banktype['CCB_DEBIT']='建设银行借记卡';
        $banktype['CEB_DEBIT']='光大银行借记卡';
        $banktype['GDB_DEBIT']='广发银行借记卡';
        $banktype['SPDB_DEBIT']='浦发银行借记卡';
        $banktype['HXB_DEBIT']='华夏银行借记卡';
        $banktype['CIB_DEBIT']='兴业银行借记卡';
        $banktype['PSBC_DEBIT']='邮政储蓄借记卡';
        $banktype['PAB_DEBIT']='平安银行借记卡';
        $banktype['BOC_DEBIT']='中国银行借记卡';
        $banktype['ICBC_DEBIT']='工商银行借记卡';
        $banktype['COMM_DEBIT']='交通银行借记卡';
        $banktype['CITIC_DEBIT']='中信银行借记卡';
        $banktype['CRB_DEBIT']='华润银行借记卡';
        $banktype['HZB_DEBIT']='杭州银行借记卡';
        $banktype['BSB_DEBIT']='包商银行借记卡';
        $banktype['CQB_DEBIT']='重庆银行借记卡';
        $banktype['NBCB_DEBIT']='宁波银行借记卡';
        $banktype['SDEB_DEBIT']='顺德农商行借记卡';
        $banktype['QLB_DEBIT']='齐鲁银行借记卡';
        $banktype['SZRCB_DEBIT']='深圳农商银行借记卡';
        $banktype['HRBB_DEBIT']='哈尔滨银行借记卡';
        $banktype['BOCD_DEBIT']='成都银行借记卡';
        $banktype['BOSH_DEBIT']='上海银行借记卡';
        $banktype['ZJTLCB_DEBIT']='浙江泰隆银行借记卡';
        $banktype['GDNYB_DEBIT']='南粤银行借记卡';
        $banktype['LJB_DEBIT']='龙江银行借记卡';
        $banktype['QDCCB_DEBIT']='青岛银行借记卡';
        $banktype['NJCB_DEBIT']='南京银行借记卡';
        $banktype['JSB_DEBIT']='江苏银行借记卡';
        $banktype['CSRCB_DEBIT']='常熟农商银行借记卡';
        $banktype['XAB_DEBIT']='西安银行借记卡';
        $banktype['ICBC_CREDIT']='工商银行信用卡';
        $banktype['CMB_CREDIT']='招商银行信用卡';
        $banktype['ABC_CREDIT']='农业银行信用卡';
        $banktype['CCB_CREDIT']='建设银行信用卡';
        $banktype['BOC_CREDIT']='中国银行信用卡';

        $banktype['CEB_CREDIT']='光大银行信用卡';
        $banktype['GDB_CREDIT']='广发银行信用卡';
        $banktype['PAB_CREDIT']='平安银行信用卡';
        $banktype['CIB_CREDIT']='兴业银行信用卡';
        $banktype['SDB_CREDIT']='深发展信用卡';
        $banktype['CITIC_CREDIT']='中信银行信用卡';

        $banktype['SPDB_CREDIT']='浦发银行信用卡';
        $banktype['CMBC_CREDIT']='民生银行信用卡';
        $banktype['NBCB_CREDIT']='宁波银行信用卡';
        $banktype['HZB_CREDIT']='杭州银行信用卡';
        $banktype['BSB_CREDIT']='包商银行信用卡';
        $banktype['BOSH_CREDIT']='上海银行信用卡';

        $banktype['GDNYB_CREDIT']='南粤银行信用卡';
        $banktype['GZCB_CREDIT']='广州银行信用卡';
        $banktype['JSB_CREDIT']='江苏银行信用卡';
        $banktype['ABC_DEBIT']='农业银行信用卡';
        $banktype['VISA_CREDIT']='VISA信用卡';
        $banktype['MASTERCARD_CREDIT']='MASTERCARD信用卡';
        $banktype['JCB_CREDIT']='JCB信用卡';

        return isset($banktype[$btype])?$banktype[$btype]:'未知';
    }


    /**
     * 业务状态码
     */
    public function resultCode($rcode){

        $resultcode['SUCCESS']='操作成功';
        $resultcode['FAIL']='操作失败';
        $resultcode['NO_ORDER']='订单不存在';
        $resultcode['REPEAT']='重复提交';
        $resultcode['ORDERNO_REPEAT']='订单号重复';
        $resultcode['NO_PERMISSION']='没有权限';
        $resultcode['AUTHCODE_EXPIRE']='授权码已过期';
        $resultcode['NOT_ENOUGH']='余额不足';
        $resultcode['NOT_SUPORTCARD']='不支持的卡类型';
        $resultcode['ORDER_REVERSED']='微信订单已撤销';
        $resultcode['BANK_ERROR']='银行系统异常';
        $resultcode['USER_PAYING']='用户支付中';
        $resultcode['AMOUNT_NOTCONSISTENCY']='金额不符';
        $resultcode['AUTH_CODE_ERROR']='授权码错误';
        $resultcode['OUT_DATE']='超过可操作时间';
        $resultcode['ORDER_CLOSE']='订单关闭';
        $resultcode['ORDER_REFUND']='订单已退款';
        $resultcode['ORDER_INIT']='订单初始化';
        $resultcode['ORDER_TO_SETTLE']='订单未结算';
        $resultcode['ORDER_SUCCESS']='订单已支付';
        $resultcode['NO_AUTHORITY']='商户未开通微信支付';
        return isset($resultcode[$rcode])?$resultcode[$rcode]:'未知状态';
    }


    /**
     * 支付状态
     */
    public function getOrderStatus($ostatus){

        $ordstatus['INIT']='未付';
        $ordstatus['TOSETTLE']='待结算';
        $ordstatus['SUCCESS']='支付成功';
        $ordstatus['REFUND']='有退款';
        $ordstatus['CLOSE']='关闭';
        return isset($ordstatus[$ostatus])?$ordstatus[$ostatus]:'未知';
    }

    /**
     * 支付状态
     */
    public function getPayStatus($pstatus){

        $paystatus['SUCCESS']='支付成功';
        $paystatus['FAIL']='支付失败';
        $paystatus['PAYING']='支付中';
        return isset($paystatus[$pstatus])?$paystatus[$pstatus]:'未知';
    }

    public function errorCode($error){
        $errorCode = array(
            'NOAUTH' => '商户无此接口权限',
            'NOTENOUGH' => '用户帐号余额不足',
            'ORDERPAID' => '商户订单已支付',
            'ORDERCLOSED' => '订单已关闭',
            'SYSTEMERROR' => '系统错误',
            'APPID_NOT_EXIST' => 'APPID不存在',
            'MCHID_NOT_EXIST' => 'MCHID不存在',
            'APPID_MCHID_NOT_MATCH' => 'appid和mch_id不匹配',
            'LACK_PARAMS' => '缺少参数	缺少必要的请求参数',
            'OUT_TRADE_NO_USED' => '商户订单号重复',
            'SIGNERROR' => '签名错误',
            'XML_FORMAT_ERROR' => 'XML格式错误',
            'REQUIRE_POST_METHOD' => '请使用post方法',
            'POST_DATA_EMPTY' => 'post数据为空',
            'NOT_UTF8' => '编码格式错误',
        );
        return isset($errorCode[$error])?$errorCode[$error]:'未知';
    }

    public function replyNotify($xml)
    {
        echo $xml;
    }

    public function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    public function makeSign($params,$key)
    {
        //签名步骤一：按字典序排序参数
        if(is_array($params)){
            ksort($params);
            $string = $this->toUrlParams($params);
        }else{
            $string = $params;
        }
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$key;
        //签名步骤三：MD5加密
        if($this->sign_type=='HMAC-SHA256'){
            $string = sha1($string);
        }else{
            $string = md5($string);
        }

        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
}