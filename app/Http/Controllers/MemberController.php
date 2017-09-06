<?php namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use WxHotel\Order;
use WxHotel\Services\WxNotice;
use WxHotel\SmsRecord;
use WxHotel\User;

class MemberController extends Controller {
	public function index()
	{
		//根据用户的微信 openid获取用户的头像，等信息，在页面显示
		$memberInfo = User::where('openid',session('user')['openid'])->first();
		return view('member.person_center',['memberInfo'=>$memberInfo]);
	}

	public function loadInfo()
	{
		//根据openid 查询个人在系统中的信息   ***这里先用死的
		$infoList = User::where('openid',session('user')['openid'])->first();
		return view('member.person_info',['infoList'=>$infoList]);
	}

	public function changesex(Request $request){
		$result = User::where('openid',$request->input('openid'))->update(['sex'=>$request->input('sex')]);
		$url = url('/member/info');
		if($result){
			echo "<script>alert('修改成功');window.location.href='$url'</script>";
			return;
		}else{
			echo "<script>alert('修改失败');window.history.back();</script>";
			return;
		}
	}

	public function order(){
		//根据用户 uid 查询用户订单，房型，数量，下单方式，入住时间，离开时间，预定状态，价格
		$orderList = Order::where(['openid'=>session('user')['openid'],'recycle'=>0])->orderBy('order_id','desc')->get();
		return view('member.my_order',['orderList'=>$orderList]);
	}

	public function order_detail($id){
		//根据订单id 查询订单详情 房型，数量，房间号，订单状态，手机号，总价
		$order_detail = Order::where('order_id',$id)->first();
		return view('member.order_detail',['order_detail'=>$order_detail]);
	}

	public function order_del(Request $request)
	{
		//用户删除订单
		$result = Order::where('order_id',$request->input('order_id'))->update(['recycle'=>1]);;
		if($result){
			echo "<script>alert('删除成功！');window.location.href='/member/order';</script>";
		}

	}

	public function credit()
	{
		$creditList = User::where('openid',session('user')['openid'])->first();
		if($creditList->verify == 0){
			return view('member.certificate');
		}else{
			return view('member.certificate_photo',['creditList'=>$creditList]);
		}
	}

	//上传认证材料
	public function makeCredit(Request $request){
		//通过当前的openid 确定用户，并添加认证信息道数据库
		$data = [
			'name'=>$request->input('realname'),
			'idcard_no'=>$request->input('idcard_number'),
			'idcard_front'=>$request->input('photo1'),
			'idcard_back'=>$request->input('photo2')
		];
		$cate = User::where('openid',session('user')['openid'])->update($data);
		if($cate){
			$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
			$managers = User::where('role','admin')->lists('openid');//查询管理员
			foreach($managers as $openid) {
				$wx->verity_application($request->input('realname'),date('Y-m-d H:i:s',time()),$openid,url('/member/mobile_credit_allow?openid='.session('user')['openid']));//給管理员发送模板消息
			}
			echo "<script>alert('已提交，等待审核');window.location.href='/member';</script>";
		}
	}

	public function mobile_credit_allow(Request $request){
		$user = User::where('openid',$request->input('openid'))->first();
		return view('room.admin_audit',['user'=>$user]);
	}

	public function mobile_credit_make(Request $request){
		$wx = new WxNotice(env('WECHAT_APPID'),env('WECHAT_SECRET'));
		if($request->input('flag') == 'ok'){
			$result = User::where('openid',$request->input('openid'))->update(['verify'=>1]);
			$wx->verifymsg($request->input('openid'));
			$return['code'] = 1;
			$return['msg'] = '成功';
			return response()->json($return);
		}
		$wx->verifyerror($request->input('openid'),url('/member/credit'));
		$return['code'] = 1;
		$return['msg'] = '已驳回';
		return response()->json($return);
	}

	public function setting()
	{
		return view('member.setting');
	}

	public function bind(Request $request){
		//根据用户 的 电话 和 验证码判断
		$code = SmsRecord::where('mobile',$request->input('mobile'))->orderBy('id','desc')->lists('token');
		if($code[0] == $request->input('code')){
			//判断当前提交的号码和数据库中的号码是否一致，不一致进行覆盖，一致，加载修改页面
			$oldphone = User::where('openid',session('user')['openid'])->lists('mobile');
			if($oldphone[0] != $request->input('mobile')){
				User::where('openid',session('user')['openid'])->update(['mobile'=>$request->input('mobile')]);
				$return['code'] = self::CODE_SUCCESS;
				$return['msg'] = self::SUCCESS_MSG;
				$return['data'] = ['url'=>'/member'];
				return response()->json($return);
			}else{
				$return['code'] = self::CODE_SUCCESS;
				$return['msg'] = self::SUCCESS_MSG;
				$return['data'] = ['url'=>'/member/setting/new'];
				return response()->json($return);
			}
		}else{
			$return['code'] = 0;
			$return['msg'] = '验证码不正确';
			return response()->json($return);
		}
	}

	//加载新手机后页面
	public function newphone(){
		return view('member.setting_newphone');
	}


}
