<?php namespace WxHotel\Http\Controllers\Console;

use Illuminate\Http\Request;
use DB;
use WxHotel\Services\Mantun;

class PowerController extends Controller {
	//获取 项目的所有电箱
	public function boxes(){
		$power = new Mantun(env('POWER_APPID'),env('POWER_APPSECRET'),env('POWER_USERNAME'),env('POWER_PASSWORD'),env('POWER_PROJECTCODE'));
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		//获取电箱
		$boxes = $power->getBoxes($access_token);;
		return $boxes;
//		Array ( [0] => Array ( [unit] => 1单元 [phone] => 13798358751 [name] => 陈先生 [mac] => 187ED530D134 [build] => 1栋 [room] => 101 ) )
	}

	//获取日用电量
	public function daypower($mac,$year,$month,$day){
		$power = new Mantun(env('POWER_APPID'),env('POWER_APPSECRET'),env('POWER_USERNAME'),env('POWER_PASSWORD'),env('POWER_PROJECTCODE'));
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		$data = $power->getDaypower($access_token,$mac,$year,$month,$day);
		return $data;
	}

	//控制通断电
	public function control_power($mac,$openorclose){
		$power = new Mantun(env('POWER_APPID'),env('POWER_APPSECRET'),env('POWER_USERNAME'),env('POWER_PASSWORD'),env('POWER_PROJECTCODE'));
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		//获取线路地址
		$realInfo = $power->getRealtime($access_token,$mac);
		//拼接线路地址
		$addrstr = '';
		foreach($realInfo as $list){
			$addrstr = $addrstr.','.$list['addr'];
		}
		$addr = trim($addrstr,',');
		$return = $power->control_power($access_token,$mac,$openorclose,$addr);
		return $return;
	}

	//获取警告
	public function alarm($mac,$start,$end,$pageSize,$page){
		$power = new Mantun(env('POWER_APPID'),env('POWER_APPSECRET'),env('POWER_USERNAME'),env('POWER_PASSWORD'),env('POWER_PROJECTCODE'));
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		$data = $power->getAlarm($access_token,$mac,date('Y-m-d H:m',strtotime($start)),date('Y-m-d H:m',strtotime($end)),$pageSize,$page);//获取警报
	}

	//将电箱数据存储在数据库中
	public function save_boxes(){
		$data = $this->boxes();
		$boxes_arr = [];
		foreach($data as $list){
			$boxes_arr[] =['mac'=>$list['mac'],'unit'=>$list['unit'],'build'=>$list['build'],'room'=>$list['room']];
		}

		\DB::table('boxes')->insert($boxes_arr);
	}


}
