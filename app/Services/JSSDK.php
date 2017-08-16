<?php
namespace WxHotel\Services;

class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }

  public function getSignPackage() {
    $jsapiTicket = $this->getJsApiTicket();

    // 注意 URL 一定要动态获取，不能 hardcode.
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $timestamp = time();
    $nonceStr = $this->createNonceStr();

    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

    $signature = sha1($string);

    $signPackage = array(
        "appId"     => $this->appId,
        "nonceStr"  => $nonceStr,
        "timestamp" => $timestamp,
        "url"       => $url,
        "signature" => $signature,
        "rawString" => $string
    );
    return $signPackage;
  }

  public function getCardSign($card_id,$code=NULL,$openid=NULL){
    $params = [
        'api_ticket'=>$this->getApiTicket(),
        'nonce_str'=>$this->createNonceStr(),
        'timestamp'=>(string)time(),
        'card_id'=>$card_id,
    ];
    if(!empty($code)){
      $params['code'] = $code;
    }
    if(!empty($openid)){
      $params['openid'] = $openid;
    }
    asort($params,SORT_STRING);
    $signature = sha1(implode('',$params));
    $sign = $params;
    $sign['signature'] = $signature;

    return $sign;
  }

  public function toUrlParams($values)
  {
    $buff = "";
    foreach ($values as $k => $v)
    {
      if($k != "sign" && $v != "" && !is_array($v)){
        $buff .= $k . "=" . $v . "&";
      }
    }
    $buff = trim($buff, "&");
    return $buff;
  }
  public function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
      $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
  }

  //获取卡券ticket
  public function getApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file("api_ticket.php"));
    if ((isset($data) && $data->expire_time < time()) || empty($data)) {
      $accessToken = $this->getAccessToken();
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=".$accessToken."&type=wx_card";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      $data = new \stdClass();
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->api_ticket = $ticket;
        $this->set_php_file("api_ticket.php", json_encode($data));
      }
    } else {
      $ticket = $data->api_ticket;
    }

    return $ticket;
  }

  public function getJsApiTicket() {
    // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode($this->get_php_file("jsapi_ticket.php"));
    if ((isset($data) && $data->expire_time < time()) || empty($data)) {
      $accessToken = $this->getAccessToken();
      $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
      $res = json_decode($this->httpGet($url));
      $ticket = $res->ticket;
      $data = new \stdClass();
      if ($ticket) {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $this->set_php_file("jsapi_ticket.php", json_encode($data));
      }
    } else {
      $ticket = $data->jsapi_ticket;
    }

    return $ticket;
  }

  public function getAccessToken($file_prefix=NULL) {
    // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    if($file_prefix){
      $file = $file_prefix."access_token.php";
    }else{
      $file = "access_token.php";
    }
    $data = json_decode($this->get_php_file($file));
    if( (isset($data) && $data->expire_time < time()) || empty($data)) {
      $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
      $arrContextOptions = array(
          "ssl"=>array(
              "verify_peer"=>false,
              "verify_peer_name"=>false,
          ),
      );
      $response = file_get_contents($url,false, stream_context_create($arrContextOptions));
      $res = json_decode($response);
      if(isset($res)){
        $access_token = $res->access_token;
        $data = new \stdClass();
        if ($access_token) {
          $data->expire_time = time() + 7000;
          $data->access_token = $access_token;
          $this->set_php_file($file, json_encode($data));
        }
      }
    } else {
      $access_token = $data->access_token;
    }
    return $access_token;
  }

  protected function httpPost($url, $data){
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
    curl_setopt($ch, CURLOPT_TIMEOUT, 6000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $res = curl_exec($ch);
    $errno = curl_errno($ch);
    curl_close($ch);
    return json_decode($res,true);
  }

  protected function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 6000);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    $errno = curl_errno($curl);
    curl_close($curl);

    return $res;
  }

  private function get_php_file($filename) {
    $dir = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR;
    if(file_exists($dir.$filename)){
      return trim(substr(file_get_contents($dir.$filename), 15));
    }
    return NULL;

  }
  private function set_php_file($filename, $content) {
    $dir = storage_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR;
    $fp = fopen($dir.$filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
  }
}

