<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Http\Requests;
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
		$list = Goods::orderBy('goods_id','DESC')->paginate(20);

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
		//
        $stores = [];
        $stores = Store::where('status',1)->get();
		$this->var['stores'] = $stores;

        $categories = [];
        $categories = Category::where('parent',0)->orderBy('sort','desc')->orderBy('id','asc')->get();
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
		//
		$id = $request->input('id');
		$name = $request->input('name');
		$description = $request->input('description');
		$content = $request->input('content');
		$marketprice = $request->input('marketprice');
		$productprice = $request->input('productprice');
		$agentprice = $request->input('agentprice');
		$costprice = $request->input('costprice');
		$issale = $request->input('issale');
		$isnew = $request->input('isnew');
		$ishot = $request->input('ishot');
		$isdiscount = $request->input('isdiscount');
		$isrecommand = $request->input('isrecommand');
		$istime = $request->input('istime');
		$sort = $request->input('sort');
		$status = $request->input('status');
		$audited = $request->input('audited');
		$images = $request->input('images');
		$new_gallery = $request->input('new_gallery');
		$storeId=$request->input('store_id');
		$video=$request->input('video');
		$voice=$request->input('voice');
		$type=$request->input('type');
		$category1=$request->input('category1');
		$category2=$request->input('category2');
		$this->validate($request,
			[
				'name'=>'required|max:30|min:2',
				'description'=>'max:1000',
				'marketprice'=>'required',
				'productprice'=>'required',
				'issale'=>'in:1,0',
				'ishot'=>'in:1,0',
				'isnew'=>'in:1,0',
				'isdiscount'=>'in:1,0',
				'isrecommand'=>'in:1,0',
				'istime'=>'in:1,0',
				'sort'=>'integer',
				'status'=>'required|in:1,0',
				'audited'=>'required|in:1,0',
				'store_id'=>'required'
			]
			);
		$regex = '@(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))@';
		if(!empty($video)) {
			if(!preg_match($regex,$video)){
				return redirect()->back()->withErrors(['status' => '视频地址不符合规范']);
			}
		}
		if(!empty($voice)) {
			if(!preg_match($regex,$voice)){
				return redirect()->back()->withErrors(['status' => '音频地址不符合规范']);
			}
		}
		if(!empty($category1)){
			$category1=Category::where('id',$category1)->first();
			$category1=$category1->name;
		}
		if(!empty($category2)){
			$category2=Category::where('id',$category2)->first();
			$category2=$category2->name;
		}
		$category=$category1.'|'.$category2;
		$data = array(
			'name'=>$name,
			'productprice'=>$productprice,
			'status'=>$status,
			'audited'=>$audited,
			'video'=>$video,
			'voice'=>$voice,
			'type'=>$type,
			'category'=>$category
		);
		if(!empty($description)){
			$data['description'] = $description;
		}
		if(!empty($content)){
			$data['content'] = $content;
		}
		if(!empty($marketprice)){
			$data['marketprice'] = $marketprice;
		}
		if(!empty($agentprice)){
			$data['agentprice'] = $agentprice;
		}
		if(!empty($costprice)){
			$data['costprice'] = $costprice;
		}
		if(isset($sort)){
			$data['sort'] = $sort;
		}
		if(isset($ishot)){
			$data['ishot'] = $ishot;
		}
		if(isset($isdiscount)){
			$data['isdiscount'] = $isdiscount;
		}
		if(isset($isrecommand)){
			$data['isrecommand'] = $isrecommand;
		}
		if(isset($issale)){
			$data['issale'] = $issale;
		}
		if(isset($istime)){
			$data['istime'] = $istime;
		}
		if(isset($isnew)){
			$data['isnew'] = $isnew;
		}

		if(!empty($new_gallery)){
			$data['thumb'] = $new_gallery[0];
			$data['images']='';
			for($i=0;$i<count($new_gallery);$i++){
				$data['images'].=$new_gallery[$i].',';
			}
			$data['images'] = substr($data['images'],0,strlen($data['images'])-1);
		}
		$goods = NULL;
		if($id){
			$goods = Goods::where('goods_id',$id)->first();
			if($goods){
				$goods::where('goods_id',$id)->update($data);
			}
		}
		if(!$goods){
			$data['goods_sn']=date('YmdHis',time());
			$data['store_id']=$storeId;
			$store = Store::where('id',$storeId)->first();
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
		if(!in_array($field,array('status','audited'),true)){
			return response()->json($return);
		}
		if(!in_array((int)$val,array(1,0),true)){
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
		$gallery_list = array();
		if(!empty($var['goods']->images)){
			//$gallery_list = json_decode($store->images,true);
			$gallery_list = explode(',',$var['goods']->images);
		}
		$var['category']=explode('|',$var['goods']['category']);
		$var['categorys']=DB::select('SELECT * FROM goods_category WHERE id IN (SELECT DISTINCT parent FROM goods_category)');
		$var['gallery_list'] = $gallery_list;
		return view('admin.goods.show',$var);
	}

	public function getCategory(Request $request){
		$parentId=$request->input('id');
		$category2=Category::where('parent',$parentId)->get();
//		$this->var['category2']=$category2;
		return response()->json($category2);
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
