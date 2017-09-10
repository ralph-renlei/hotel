<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Http\Requests;
use WxHotel\Order;
use WxHotel\Services\QRcode;
use WxHotel\Store;
use Illuminate\Http\Request;
use WxHotel\Goods;
use WxHotel\Category;
use DB;

class GoodsController extends Controller {

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$var = array();
		$list = Goods::orderBy('category_id','desc')->orderBy('goods_id','DESC')->paginate(20);
		foreach($list as &$one){
			$one['category'] = Category::where('id',$one->category_id)->first();
		}
		$list->setPath('/admin/shop/goods');
		$var['goods'] = $list;
		return view('admin.goods.home',$var);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $categories = [];
        $categories = Category::orderBy('sort','desc')->orderBy('id','asc')->get();
        $this->var['categories'] = $categories;

        return view('admin.goods.create',$this->var);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$id = $request->input('id');
		$name = $request->input('name');
		$mac = $request->input('mac');
		$category=$request->input('category');
		$this->validate($request,
			[
				'name'=>'required|max:30|min:2',
				'category'=>'integer',
				'mac'=>'required',
			]
			);
		$regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
		if(!empty($category)){
			$category=$category;
		}

		$data = array(
			'name'=>$name,
			'category_id'=>$category,
			'mac'=>$mac,
		);

		$goods = NULL;
		if($id){
			$goods = Goods::where('goods_id',$id)->first();
			if($goods){
				$goods::where('goods_id',$id)->update($data);
			}
		}
		if(!$goods){
			$goods = Goods::create($data);
		}

		if(!$goods){
			return redirect()->back()->withErrors(['status' => '失败']);
		}
		if($goods){
			return redirect(url('admin/shop/goods'));
		}
		return redirect()->back()->withErrors(array('error'=>'发布失败'));
	}
	public function postAudit(Request $request){
		$return = array(
			'code'=>self::CODE_PARAM,
			'msg'=>self::PARAM_MSG
		);
		$id = $request->input('id');
		if(empty($id)){
			return response()->json($return);
		}
		$field = $request->input('field');
		$val = $request->input('val');
		if(!in_array($field,array('status','open'),true)){
			return response()->json($return);
		}
		if(!in_array((int)$val,array(1,0,-1),true)){
			return response()->json($return);
		}
		$goods = Goods::find($id);
		if(empty($goods)){
			return response()->json($return);
		}
		$data = array(
			$field=>$val
		);
		Goods::where('goods_id',$id)->update($data);
		$return['code'] = self::CODE_SUCCESS;
		$return['msg'] = self::SUCCESS_MSG;
		return response()->json($return);
	}

	public function deleteItem(Request $request){
		$return = array(
			'code'=>self::CODE_PARAM,
			'msg'=>self::PARAM_MSG
		);
		$id = $request->input('id');
		if(empty($id)){
			return response()->json($return);
		}
		$goods = Goods::find($id);
		if(empty($goods)){
			return response()->json($return);
		}
		$goods->delete();
		$return['code'] = self::CODE_SUCCESS;
		$return['msg'] = self::SUCCESS_MSG;
		return response()->json($return);
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$var = array();
		$var['goods']=Goods::where('goods_id',$id)->first();
		$var['categorys']=DB::select('SELECT * FROM goods_category');
		return view('admin.goods.show',$var);
	}

	public function qrcode($id){
		$value = url('/goods_id?goods_id='.$id); //二维码内容
		$errorCorrectionLevel = 'L'; //容错级别
		$matrixPointSize = 6; //生成图片大小

		// 生成二维码图片
		QRcode::png($value, 'qrcode/'.$id.'.png', $errorCorrectionLevel, $matrixPointSize, 2);
		$image_url = url('/qrcode/'.$id.'.png');
		$result = Goods::where('goods_id',$id)->update(['qrcode'=>$image_url]);
		if($result){
			echo "<script>alert('生成二维码成功');window.location.href = '/admin/shop/goods';</script>";
		}
	}

	public function show_qrcode($id){
		$goods = Goods::find($id);
		if(is_null($goods->qrcode)){
			echo "<script>alert('请先生成二维码');window.history.back();</script>";
		}
		return view('admin.goods.qrcode',['goods'=>$goods]);
	}

	public function room_status(Request $request){
		$keywords = '';
		if(!empty($request->input('start'))){
			$keywords = $request->input('start');
		}

		//时间变化
		$time_array = [];
		for($i = 0 ; $i < 7 ; $i++){
			$data_array = explode('-',date('Y-m-d',time() + 3600 * 24 * $i));
			$data_array[1] = (int)$data_array[1];
			$time_array[] = implode('-',$data_array);
		}

		if(!$keywords){
			$keywords = $time_array[0];
		}

		//房间某天预定：某天时间 >= 开始时间  && 某天时间< 结束时间
		$room_status_arr = \DB::table('room_status')->get();
		$goods_name = \DB::table('goods')->lists('name');//查询所有房间号
		$new_arr = [];//有记录的房间array
		foreach($room_status_arr as $demo){
			if(in_array($demo->goods_name,$goods_name)){//这个房间短期内有预定，查询时间范围
				//查询这个订单
				if(date('z',strtotime($keywords)) >= date('z',strtotime($demo->start_time)) && date('z',strtotime($keywords)) < date('z',strtotime($demo->end_time)) ){
					$new_arr[] = $demo;//将某天内已经预定的房间写入数组
				}
			}
		}

		//将一个临时字段写入数据库，不能预定
		$goods = Goods::orderBy('category_id','desc')->orderBy('goods_id','DESC')->get();
		foreach($goods as &$one){
			$one->category = Category::where('id',$one->category_id)->first();
			if($new_arr){
				foreach($new_arr as $new){
					if($new->goods_name == $one->name){
						$one->room_status = '已预定';//不可分配
						$one->order_info = \DB::table('orders')->where('order_id',$new->order_id)->first();
						break;
					}else{
						$one->room_status = '可以预定';//
					}
				}
			}else{
				$one->room_status = '可以预定';
			}
		}

		return view('admin.goods.room_status',['goods'=>$goods,'time_array'=>$time_array,'keywords'=>$keywords]);
	}

	public function power_count(Request $request)
	{
		if(!$request->input('end')){
			$end = date('Y-m-d',time()-3600*24);
			$start = date('Y-m-d',time()-3066*48);
		}else{
			$end = date('Y-m-d',strtotime($request->input('end'))-3600*24);
			$start = date('Y-m-d',strtotime($request->input('end'))-3600*48);
		}

		//查询每天的用电量
		$data = \DB::table('goods')->select('goods.goods_id','goods.name','goods.mac','b.count_power')
			->rightJoin('box_power as b','goods.mac','=','b.box_mac')
			->where(['b.end'=>$end,'b.start'=>$start])
			->get();

		$goods_arr = \DB::table('goods')->select('goods_id','name','mac')->get();//将data中没有数据添加
		foreach($goods_arr as $key=>$demo){//goods 中有的数据 data中没有，就添加进去
			foreach($data as $list){
				if($demo->mac == $list->mac){
					unset($goods_arr[$key]);
					break;
				}
			}
		}

		if($goods_arr){
			foreach($goods_arr as $list2){
				$list2->count_power = 0;
				$data[] = $list2;
			}
		}

		//电量字符串，房间字符串
		$power_str = "";
		$room_str = "";
		foreach($data as $result){
			$power_str = $power_str.','.$result->count_power;
			$room_str = $room_str.','.$result->name;
		}

		$power_str = trim($power_str,',');
		$room_str = trim($room_str,',');

		return view('admin.goods.power_count',['power_str'=>$power_str,'room_str'=>$room_str,'hotel_name'=>env('CUSTOM_PHONE')]);
	}

}
