<?php namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use WxHotel\Order;
use WxHotel\User;

class MemberController extends Controller {
	public function index()
	{
		//根据用户的微信 openid获取用户的头像，等信息，在页面显示
		$memberInfo = User::where('openid','oG3Ulv_z-uJsb-uUmy6m62J5qxc0')->first();
		return view('member.person_center',['memberInfo'=>$memberInfo]);
	}

	public function loadInfo()
	{
		//根据openid 查询个人在系统中的信息   ***这里先用死的
		$infoList = User::where('openid','oG3Ulv_z-uJsb-uUmy6m62J5qxc0')->first();
		return view('member.person_info',['infoList'=>$infoList]);
	}

	public function order(){
		//根据用户 uid 查询用户订单，房型，数量，下单方式，入住时间，离开时间，预定状态，价格
		$orderList = Order::where('uid',1)->get();
		return view('member.my_order',['orderList'=>$orderList]);
	}

	public function order_detail($id){
		//根据订单id 查询订单详情 房型，数量，房间号，订单状态，手机号，总价
		$order_detail = Order::where('order_id',1)->first();
		return view('member.order_detail');
	}

	public function credit()
	{
		$creditList = User::where('openid','oG3Ulv_z-uJsb-uUmy6m62J5qxc0')->first();
		if(!isset($creditList->idcard_front)){
			return view('member.certificate');
		}else{
			return view('member.certificate_photo',['creditList'=>$creditList]);
		}
	}

	//上传认证材料
	public function makeCredit(Request $request){
		//通过当前的openid 确定用户，并添加认证信息道数据库中
        print_r($request->all());
		$data = [
			'name'=>$request->input('realname'),
			'idcard_no'=>$request->input('idcard_number'),
			'idcard_front'=>$request->input('photo1'),
			'idcard_back'=>$request->input('photo2')
		];
		$cate = User::where('openid','oG3Ulv_z-uJsb-uUmy6m62J5qxc0')->update($data);
		if($cate){
			echo "<script>alert('已提交，等待审核');window.location.href='/member';</script>";
		}
	}

	public function setting()
	{
		return view('member.setting');
	}
}
