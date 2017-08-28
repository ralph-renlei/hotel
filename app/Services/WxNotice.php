<?php
namespace WxHotel\Services;

use WxHotel\Http\Controllers\Mobile\HomeController;
use WxHotel\Services\JSSDK;

//消息模板
class WxNotice extends JSSDK
{
	private $access_token = NULL;
	private $appId = NULL;
	private $appSecret = NULL;

	public function get_industry(){
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token='.$this->getAccessToken();
		$json = $this->httpGet($url);
		return  json_decode($json,true);
	}
	public function get_all_tpl(){
		$url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token='.$this->getAccessToken();
		$json = $this->httpGet($url);
		return  json_decode($json,true);
	}
	
	public function add_tpl($tpl_short){
		$url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token='.$this->getAccessToken();
		$json = $this->httpPost($url, array('template_id_short'=>$tpl_short));
		$result = json_decode($json,true);
		return $result['template_id'];
		
	}
	/***
	{{first.DATA}}
	订单号：{{keyword1.DATA}}
	下单时间：{{keyword2.DATA}}
	买家地址：{{keyword3.DATA}}
	卖家地址：{{keyword4.DATA}}
	支付方式：{{keyword5.DATA}}
	{{remark.DATA}}
	 **/
	//待配送订单
	public function forShipping($openid,$order_id,$order_time,$mobile,$customer_address){
		$template_id = 'Lua7IYM6wTO3k33BmZ0F1z0bMQ_W9ojQZ741QZgxt6M';
		$txt = array(
			'first'=>array('value'=>urlencode('您好，有新的待配送订单')),
			'keyword1'=>array('value'=>$order_id),
			'keyword2'=>array('value'=>urlencode($order_time)),
			'keyword3'=>array('value'=>urlencode($customer_address)),
			'keyword4'=>array('value'=>urlencode('魇食')),
			'keyword5'=>array('value'=>urlencode('微信支付')),
			'remark'=>array('value'=>urlencode('有任何疑问请联系客服18581835277'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>'http://www.yanshihealth.com/qrcode.jpg'
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	public function delivery($openid,$customer,$marki,$goods_name){
		$template_id = 'MYlTjTdCIfItbGPUSSntBn8uWBI7dbxQHYzpINzQJKk';
		/**
		{{first.DATA}}

		{{Content1.DATA}}
		商品名称：{{Good.DATA}}
		配送服务商：{{distributors.DATA}}
		配送人员：{{name.DATA}}
		收费标准：{{menu.DATA}}
		{{remark.DATA}}
		 **/
		$txt = array(
			'first'=>array('value'=>urlencode('尊敬的'.$customer.'，您好')),
			'Content1'=>array('value'=>urlencode('您的健身餐已经送达目的地，请您及时领取呦~')),
			'Good'=>array('value'=>urlencode($goods_name)),
			'distributors'=>array('value'=>urlencode('餍食')),
			'name'=>array('value'=>urlencode($marki)),
			'menu'=>array('value'=>urlencode('免运费')),
			'remark'=>array('value'=>urlencode('有任何疑问请随时和配送员联系'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>'http://www.yanshihealth.com/qrcode.jpg'
		);
		return $this->send(urldecode(json_encode($msg)));
	}

  /**
	{{first.DATA}}
	订单编号：{{keyword1.DATA}}
	酒店名称：{{keyword2.DATA}}
	入住时间：{{keyword3.DATA}}
	下单金额：{{keyword4.DATA}}
	支付方式：{{keyword5.DATA}}
	{{remark.DATA}}
   */
	public function book_success($openid,$order_sn,$start_time,$order_amount,$url){
		$template_id = 'PWiPgtUPLcgx_fBZnsDLPPrY6pziiqpSJDbodeoFkBI';
		$txt = array(
			'first'=>array('value'=>urlencode('恭喜你，您的酒店预订已提交成功')),
			'keyword1'=>array('value'=>$order_sn),
			'keyword2'=>array('value'=>urlencode('西安希尔顿酒店')),
			'keyword3'=>array('value'=>$start_time),
			'keyword4'=>array('value'=>$order_amount),
			'keyword5'=>array('value'=>urlencode('微信支付')),
			'remark'=>array('value'=>urlencode('祝您休息愉快'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>$url,
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	/**
	{{first.DATA}}
	订单号：{{keyword1.DATA}}
	支付用户：{{keyword2.DATA}}
	订单金额：{{keyword3.DATA}}
	酒店房型：{{keyword4.DATA}}
	抵离时间：{{keyword5.DATA}}
	{{remark.DATA}}
	 */
	public function room_to_manager($openid,$realname,$order_amount,$category_name,$goods_name,$start,$end,$url){
		$template_id = 'S5fEb4A8k7hyZ6vCfUDVBarSDtB22mksQ7uC5Mpg1Rg';
		$txt = array(
			'first'=>array('value'=>urlencode('您已成功收到用户订单')),
			'keyword1'=>array('value'=>session('order_sn')),
			'keyword2'=>array('value'=>urlencode($realname)),
			'keyword3'=>array('value'=>urlencode($order_amount)),
			'keyword4'=>array('value'=>urlencode($category_name)),
			'keyword5'=>array('value'=>urlencode($start).'~'.urlencode($end)),
			'remark'=>array('value'=>urlencode('请及时更新'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>$url,
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	/**
	{{first.DATA}}
	订单号：{{keyword1.DATA}}
	支付用户：{{keyword2.DATA}}
	订单金额：{{keyword3.DATA}}
	酒店房型：{{keyword4.DATA}}
	抵离时间：{{keyword5.DATA}}
	{{remark.DATA}}
	 */
	public function room_arrange_notice($category_name,$goods_id,$start,$end){
		$template_id = 'S60NKkC-w8s7Rx5psPIuAC4DF_ISVoF1n3VYIJxBH88';
		$txt = array(
			'first'=>array('value'=>urlencode('恭喜你，您的酒店预订已提交成功')),
			'keyword1'=>array('value'=>$category_name),
			'keyword2'=>array('value'=>$goods_id),
			'keyword3'=>array('value'=>urlencode('正常入住')),
			'keyword4'=>array('value'=>urlencode($start)),
			'keyword5'=>array('value'=>urlencode($end)),
			'remark'=>array('value'=>urlencode('祝您休息愉快'))
		);
		$msg = array(
			'touser'=>session('user')['openid'],'template_id'=>$template_id,'data'=>$txt,'url'=>'',
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	/**
	{{first.DATA}}
	申请用户：{{keyword1.DATA}}
	申请类型：{{keyword2.DATA}}
	申请时间：{{keyword3.DATA}}
	{{remark.DATA}}
	 */
	public function verity_application($realname,$application_time,$openid,$url){
		$template_id = 'JGQi_Fsk-Wf3UhgyZD72VNDpdsScjUQ4i7iKB3uPiAQ';
		$txt = array(
			'first'=>array('value'=>urlencode('顾客入住实名认证申请，请尽快核实')),
			'keyword1'=>array('value'=>urlencode($realname)),
			'keyword2'=>array('value'=>urlencode('身份证实名认证')),
			'keyword3'=>array('value'=>urlencode($application_time)),
			'remark'=>array('value'=>urlencode('请用手机或系统审核审核'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>$url,
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	/**
	{{first.DATA}}
	审核内容：{{keyword1.DATA}}
	审核结果：{{keyword2.DATA}}
	客服电话：{{keyword3.DATA}}
	{{remark.DATA}}
	 */
	public function verifymsg(){
		$template_id = 'tXS_P-C9LOkRvHuDr5uLJooUyaFDue2zilt45EPjp_E';
		$txt = array(
			'first'=>array('value'=>urlencode('您的身份认证审核已通过')),
			'keyword1'=>array('value'=>urlencode('身份证审核')),
			'keyword2'=>array('value'=>urlencode('审核已通过')),
			'keyword3'=>array('value'=>urlencode('40000000')),
			'remark'=>array('value'=>urlencode('您已通过审核'))
		);
		$msg = array(
			'touser'=>session('user')['openid'],'template_id'=>$template_id,'data'=>$txt,'url'=>''
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	/**
	{{first.DATA}}
	酒店名称：{{keyword1.DATA}}
	房间号：{{keyword2.DATA}}
	时间：{{keyword3.DATA}}
	{{remark.DATA}}
	 */
	public function close_accounts($openid,$goods_name){
		$template_id = 'X-gUrjtyBPsoaOa-c2RE3_B9_wWwH2qxx6vPVb-b5qs';
		$txt = array(
			'first'=>array('value'=>urlencode('客人等待结账，请尽快查房')),
			'keyword1'=>array('value'=>urlencode('西安希尔顿酒店')),
			'keyword2'=>array('value'=>urlencode($goods_name)),
			'keyword3'=>array('value'=>urlencode(date('Y-m-d H:i:s',time()))),
			'remark'=>array('value'=>urlencode('请尽快处理'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>''
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	public function fillOrder($openid,$order_id,$goods_name,$order_date){
		$template_id = 'gnNe2AM7KTEVfprdmX5DptuXCWxfaKfBBm_PrbDO91c';
		$txt = array(
			'first'=>array('value'=>urlencode('请您尽快补充完整您订单的配送信息。')),
			'keyword1'=>array('value'=>urlencode($order_id)),
			'keyword2'=>array('value'=>urlencode($goods_name)),
			'keyword3'=>array('value'=>urlencode('完善配送信息')),
			'keyword4'=>array('value'=>urlencode($order_date)),
			'remark'=>array('value'=>urlencode(' 点击详情识别二维码进入小程序完善'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>'http://www.yanshihealth.com/qrcode.jpg'
		);
		return $this->send(urldecode(json_encode($msg)));
	}

	public function paidSuccess($openid,$orderMoneySum,$orderProductName){
		$template_id = '9mnTsOisCB-P6yj0XbG8RTRVvo2CZIRJhLMgqP_3i6g';
		$txt = array(
			'first'=>array('value'=>urlencode('我们已收到您的货款，开始为您打包商品，请耐心等待')),
			'orderMoneySum'=>array('value'=>urlencode($orderMoneySum)),
			'orderProductName'=>array('value'=>urlencode($orderProductName)),
			'Remark'=>array('value'=>urlencode('点击详情输入信息'))
		);
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'data'=>$txt,'url'=>'http://www.yanshihealth.com/qrcode.jpg'
		);
		return $this->send(urldecode(json_encode($msg)));
	}
	//收款成功提醒
	public function receipt($openid,$money,$shopname='',$consumer='',$url=''){
		$template_id = '2uamO5RUfTpjXLctvtXUv1DGvyNnyLhPbbZB8_KPdOY';
		$txt = array(
				'first'=>array('value'=>urlencode('恭喜您有一笔收款到账'),'color'=>'#173177'),
				'keyword1'=>array('value'=>urlencode($shopname),'color'=>'#173177'),
				'keyword2'=>array('value'=>urlencode(number_format ( $money ,  2 ,  '.' ,  '' ).'元'),'color'=>'#173177'),
				'keyword3'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>'#173177'),
				'remark'=>array('value'=>urlencode('您可以在微信支付后台查看明细'),'color'=>'#173177')
			);
			$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'url'=>$url,'topcolor'=>'#173177','data'=>$txt,
		);
		return $this->send(urldecode(json_encode($msg)));
	}
	//实时消费提醒
	public function consume($openid,$money,$shopname='',$consumer='',$url=''){
			$template_id = 'eK25MTMj-8oFgAgXFeCbGQcSphSS7tUQ3vFY6M9ZRGY';
			$txt = array(
				'first'=>array('value'=>urlencode('消费者'.$consumer.'在'.$shopname.'消费'),'color'=>'#173177'),
				'tradeDateTime'=>array('value'=>date('Y-m-d H:i:s',time()),'color'=>'#173177'),
				'tradeType'=>array('value'=>urlencode('消费'),'color'=>'#173177'),
				'curAmount'=>array('value'=>$money,'color'=>'#173177'),
				'remark'=>array('value'=>urlencode('您可以在微信支付后台查看明细'),'color'=>'#173177')
			);
			$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'url'=>$url,'topcolor'=>'#173177','data'=>$txt,
		);
		return $this->send(urldecode(json_encode($msg)));
	}
	
	public function rewardNotice($openid,$uname,$gold,$url,$type='do'){
		$template_id = 'Y1znK0foCXe0Mln7Mtt7DA_2K1EAVkwXJG-vZn2FsqA';
		if($type=='do'){
			$txt = array(
				'first'=>array('value'=>urlencode('恭喜您的听众'.$uname.'打赏了您'),'color'=>'#173177'),
				'Friend'=>array('value'=>urlencode($uname),'color'=>'#173177'),
				'Value'=>array('value'=>$gold,'color'=>'#173177'),
				'remark'=>array('value'=>urlencode('请您及时领取'),'color'=>'#173177')
			);
		}else{
			$txt = array(
				'first'=>array('value'=>urlencode('恭喜您的听众'.$uname.'领取了您的红包'),'color'=>'#173177'),
				'Friend'=>array('value'=>urlencode($uname),'color'=>'#173177'),
				'Value'=>array('value'=>$gold,'color'=>'#173177'),
				'remark'=>array('value'=>urlencode('您可以跟Ta聊天了'),'color'=>'#173177')
			);
		}
		$msg = array(
			'touser'=>$openid,'template_id'=>$template_id,'url'=>$url,'topcolor'=>'#173177','data'=>$txt,
		);
		return $this->send(urldecode(json_encode($msg)));
	}
	
	
	public function send($data){
//		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->getAccessToken();
		$url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->get_token();
		$result = $this->httpPost($url, $data);
		return $result;
	}

	public function get_token(){
		//判断 存在access文件，并且token文件不过期，返回access_token
		$tokenFile = storage_path() . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'token.txt';
		$arrContextOptions = array(
			"ssl"=>array(
				"verify_peer"=>false,
				"verify_peer_name"=>false,
			),
		);
		if(!is_file($tokenFile)){
			fopen($tokenFile,'w');
		}
		$data = json_decode(file_get_contents($tokenFile),true); //转换为数组格式

		if ($data['expire_time'] > time()) {
			$access_token = $data['access_token'];
		}else{
//            fopen($tokenFile, 'w');//创建文件，或者覆盖 过期的access_token
			$appid = env('WECHAT_APPID');
			$secret = env('WECHAT_SECRET');
			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;

			$res = file_get_contents($url,false, stream_context_create($arrContextOptions));//重新获取
			$res = json_decode($res, true); // 对 JSON 格式的字符串进行编码
			$access_token = $res['access_token'];
			if ($access_token) {
				$data['expire_time'] = time() + 7200; //保存2小时
				$data['access_token'] = $access_token;
				$fp = fopen($tokenFile, "w"); //只写文件
				fwrite($fp, json_encode($data)); //写入json格式文件
				fclose($fp); //关闭连接
			}
		}
		return $access_token;
	}
}
?>