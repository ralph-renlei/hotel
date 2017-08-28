<?php namespace WxHotel\Http\Controllers\Console;

use Illuminate\Http\Request;
use DB;
use WxHotel\Services\Mantun;

class PowerController extends Controller {
	//获取 项目的所有电箱
	public function boxes(){
		$power = new Mantun('O000000006','F7A7B2F64C23CC22BACD89798C0CC76','huizhou001','hz888888','P00000000068');
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		//获取电箱
		$boxes = $power->getBoxes($access_token);dd($boxes);
//		Array ( [0] => Array ( [unit] => 1单元 [phone] => 13798358751 [name] => 陈先生 [mac] => 187ED530D134 [build] => 1栋 [room] => 101 ) )
	}

	//获取日用电量
	public function daypower($mac,$year,$month,$day){
		$power = new Mantun('O000000006','F7A7B2F64C23CC22BACD89798C0CC76','huizhou001','hz888888','P00000000068');
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		$data = $power->getDaypower($access_token,$mac,$year,$month,$day);
	}

	//控制通断电
	public function control_power($mac,$openorclose){
		$power = new Mantun('O000000006','F7A7B2F64C23CC22BACD89798C0CC76','huizhou001','hz888888','P00000000068');
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
		$power = new Mantun('O000000006','F7A7B2F64C23CC22BACD89798C0CC76','huizhou001','hz888888','P00000000068');
		//获取code
		$code = $power->getCode();
		//获取access_token
		$access_token = $power->getAccessToken($code);
		$data = $power->getAlarm($access_token,$mac,date('Y-m-d H:m',strtotime($start)),date('Y-m-d H:m',strtotime($end)),$pageSize,$page);//获取警报
	}

	public function save_boxes(){
		$data = $this->boxes();
		$boxes_arr = [];
		foreach($data as $list){
			$boxes_arr[] =['mac'=>$list['mac'],'unit'=>$list['unit'],'build'=>$list['build'],'room'=>$list['room']];
		}

		\DB::table('boxes')->insert($boxes_arr);
	}
}
