<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Http\Requests;
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
//		print_r($request->all());exit;
		$id = $request->input('id');
		$name = $request->input('name');
		$category=$request->input('category');
		$this->validate($request,
			[
				'name'=>'required|max:30|min:2',
				'category'=>'integer',
			]
			);
		$regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
		if(!empty($category)){
			$category=$category;
		}

		$data = array(
			'name'=>$name,
			'category_id'=>$category,
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

	public function getCategory(Request $request){
		$parentId=$request->input('id');
		$category2=Category::where('parent',$parentId)->get();
//		$this->var['category2']=$category2;
		return response()->json($category2);
	}

	public function qrcode($id){
		$value = url('/goods_id/'.$id); //二维码内容
		$errorCorrectionLevel = 'L'; //容错级别
		$matrixPointSize = 6; //生成图片大小

		// 生成二维码图片
		QRcode::png($value, 'qrcode/'.$id.'.png', $errorCorrectionLevel, $matrixPointSize, 2);
		$image_url = url('/qrcode/'.$id.'.png');
		$result = Goods::where('goods_id',$id)->update(['qrcode'=>$image_url]);
		if($result){
			echo "<script>alert('生成二维码成功');window.history.back();</script>";
		}
	}

	public function show_qrcode($id){
		$goods = Goods::find($id);
		if(is_null($goods->qrcode)){
			echo "<script>alert('请先生成二维码');window.history.back();</script>";
		}
		return view('admin.goods.qrcode',['goods'=>$goods]);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
