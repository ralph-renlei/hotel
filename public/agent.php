<?php	 
	//今天到某天的天数
	//现在时间到某个时间的秒数
	//现在时间到某个时间的分钟数
	//现在时间到某个时间的小时数
	
    function httpPost($url, $data){
        $ch = curl_init();
		$paramsJoined = array();
		foreach($data as $param => $value) {
            $paramsJoined[] = "$param=$value";
        }
        $zhi=implode('&',$paramsJoined);
		 
        $header[] = "Accept-Charset: utf-8";
		$header[] = "application/x-www-form-urlencoded";
		print_r($data);
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
	$url = 'http://open.snd02.com/oauth/authverify2.as';
	$code_data = [
		'response_type'=>'code',
		'client_id'=>'O000000006',
		'redirect_uri'=>'http://open.snd02.com/demo.jsp',
		'uname'=>'huizhou001',
		'passwd'=>'hz888888'
	];
	$code = '35c7116edf909a537639a3ebd6df17b9';
	$raw_result = httpPost($url,$code_data);
	$result = json_decode($raw_result,true);
	var_dump($result);
	$app_secret = 'F7A7B2F64C23CC22BACD89798C0CC76';
	$app_key = 'O000000006';
	$client_secret = MD5($app_key.'authorization_code'.'http://open.snd02.com/demo.jsp'.$result['code'].$app_secret);
	$token_url = 'http://open.snd02.com/oauth/token.as';
	$token_data = [
	'client_id'=>'O000000006',
	'client_secret'=>$client_secret,
	'grant_type'=>'authorization_code',
	'redirect_uri'=>'http://open.snd02.com/demo.jsp',
	'code'=>$result['code']
	];
	$raw_result = httpPost($token_url,$token_data);
	$asscess_token_result = json_decode($raw_result,true);
	$asscess_token = '';
	
	var_dump($asscess_token_result);
	$projectCode = 'P00000000068';
	$boxes = [
	'method'=>'GET_BOXES',
	'client_id'=>$app_key,
	'access_token'=>$asscess_token_result['data']['accessToken'],
	'timestamp'=>date('YmdHis'),
	'projectCode'=>$projectCode
	];
	$sign = MD5($boxes['access_token'].$boxes['client_id'].$boxes['method'].$boxes['projectCode'].$boxes['timestamp'].$app_secret);
	$boxes['sign'] = $sign;
	
	$box_url = 'http://open.snd02.com/invoke/router.as';
	
	$raw_result = httpPost($box_url,$boxes);
	$result = json_decode($raw_result,true);
	var_dump($result);
	$realtime = [
	'client_id'=>$app_key,
	'access_token'=>$asscess_token_result['data']['accessToken'],
	'method'=>'GET_BOX_CHANNELS_REALTIME',
	'timestamp'=>date('YmdHis',time()),
	'mac'=>$result['data']['0']['mac'],
	'projectCode'=>$projectCode
	];
	$sign = MD5($realtime['access_token'].$realtime['client_id'].$realtime['mac'].$realtime['method'].$realtime['projectCode'].$realtime['timestamp'].$app_secret);
	$realtime['sign'] = $sign;
	$raw_result = httpPost($box_url,$realtime);
	$result = json_decode($raw_result,true);
	var_dump($result);
	die();
$reward_key = [
            '1'=>[],
            '2'=>[],
            '3'=>[],
        ];
		$key = 'shanxihuiyinmeiyiliaoqixiehuazhu';
		echo strlen($key);
		die();
        $reward = [];
        $act_id_list = [234,456,098,67,90,56];
		$total = 6;
		$num1 = 1;
		$num2 = 2;
		$num3 = 3;
		$stat = '2017-08-09';
		$flag = preg_match('/^(\d){4}-(\d){2}-(\d){2}$/',$stat);
		var_dump($flag);
		die();
		while($num1>0){
            $key = mt_rand(0,$total);
            if(!in_array($key,$reward_key[1],TRUE)){
                $reward_key['1'][] = $key;
                $num1--;
            }

        }

        while($num2>0){
            $key = mt_rand(0,$total);
            if(!in_array($key,$reward_key['2'],TRUE)){
                $reward_key['2'][] = $key;
                $num2--;
            }

        }


        while($num3>0){
            $key = mt_rand(0,$total);
            if(!in_array($key,$reward['3'],true)){
                $reward_key['3'][] = $key;
                $num3--;
            }
        }
	date_default_timezone_set('Asia/Shanghai');
	$date  = new DateTime(date('Y-m-d'));
	$day = (int)date('d');
	$month = (int)date('m');
	echo $day.PHP_EOL;
	echo $month.PHP_EOL;
	$last_month_start_date = date('Y-0'.($month-1).'-01');
	echo $last_month_start_date.PHP_EOL;
	$last_month_end_date = date('Y-0'.($month-1).'-'.date('t',strtotime($last_month_start_date)));
	echo $last_month_end_date.PHP_EOL;
	echo $date->format('Y-m-d') . "\n";
	$week_day =  $date->format('w');
	switch($week_day){
		case '0':
		
		break;
		case '1':
		break;
		case '2':
		echo $week_day.PHP_EOL;
		$last_week_end_date = $date->modify('-'.$week_day.' day');		
		break;
		case '3':
		break;
		case '4':
		break;
		case '5':
		break;
		case '6':
		break;
		default:
		break;
	}
	
	echo $last_week_end_date->format('Y-m-d'). "\n";
		$last_week_start_date = $last_week_end_date->modify('-6 day');
	echo $last_week_start_date->format('Y-m-d'). "\n";
	die();
?>