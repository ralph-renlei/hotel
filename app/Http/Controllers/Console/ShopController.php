<?php namespace WxHotel\Http\Controllers\Console;

use WxHotel\Http\Requests;

use WxHotel\Store;
use Illuminate\Http\Request;

class ShopController extends Controller {

    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		//
		$var = array();
		$key = $request->input('keyword');
		if(!empty($key)){
			$list = Store::where('store_name','LIKE','%'.$key.'%')->orderBy('id','desc')->paginate(20);
			$list->setPath('/admin/shop?keyword='.$key);
			$var['keyword'] = $key;
		}else{
			$list = Store::orderBy('id','desc')->paginate(20);
			$list->setPath('/admin/shop');
		}

		$var['lists'] = $list;

		return view('admin.shop.home',$var);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return view('admin.shop.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$this->validate($request,[
			'name'=>'required|max:30|min:2',
			'contacter'=>'max:10|min:2',
			'mobile' => 'regex:/^1[2-9]\d{9}$/|max:11',
			'intro'=>'max:500',
			'address'=>'required',
			'lat'=>'required',
			'lng'=>'required',
			'status'=>'required|in:1,0'
		]);
		$name = $request->input('name');
		$category = $request->input('category');
		$contacter = $request->input('contacter');
		$mobile = $request->input('mobile');
		$intro = $request->input('intro');
		$address = $request->input('address');
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		$status = $request->input('status');
		$new_gallery = $request->input('new_gallery');
		$id = $request->input('id');

		$data = array(
			'store_name'=>$name,
			'address'=>$address,
			'lat'=>$lat,
			'lng'=>$lng,
			'status'=>$status
		);
		if(!empty($intro)){
			$data['intro'] = $intro;
		}
		if(!empty($contacter)){
			$data['contacter'] = $contacter;
		}
		if(!empty($mobile)){
			$data['mobile'] = $mobile;
		}

		if(!empty($new_gallery)){
			$data['logo'] = $new_gallery[0];
			$data['images']='';
			for($i=0;$i<count($new_gallery);$i++){
				$data['images'].=$new_gallery[$i].',';
			}
			$data['images'] = substr($data['images'],0,strlen($data['images'])-1);
			//	$data['images'] = json_encode($new_gallery);
		}
		$store = NULL;
		if($id){
			$store = Store::find($id);
			if($store){
				Store::where('id',$store->id)->update($data);
			}
		}
		if(!$store){
			$store = Store::create($data);
		}

		if(!$store){
			return redirect()->back()->withErrors(['status' => '失败']);
		}
		return redirect('/admin/shop');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$var = array();
		$store = Store::find($id);
		$var['item'] = $store;
		$gallery_list = array();
		if(!empty($store->images)){
			//$gallery_list = json_decode($store->images,true);
			$gallery_list = explode(',',$store->images);
		}
		$var['gallery_list'] = $gallery_list;
		return view('admin.shop.show',$var);
	}

	public function audit(Request $request){
		$return = array(
			'code'=>self::CODE_SUCCESS,
			'msg'=>self::SUCCESS_MSG
		);
		$id = $request->input('id');
		$status = $request->input('status');
		if(empty($id)){
			$return['code'] = self::CODE_PARAM;
			$return['msg'] = self::PARAM_MSG;
			return response()->json($return);
		}

		if(!in_array((int)$status,array(1,0),true)){
			$return['code'] = self::CODE_PARAM;
			$return['msg'] = self::PARAM_MSG;
			return response()->json($return);
		}

		$store = Store::find($id);
		if(empty($store)){
			$return['code'] = self::CODE_PARAM;
			$return['msg'] = self::PARAM_MSG;
			return response()->json($return);
		}
		$store->status = $status;
		$store->save();
		return response()->json($return);
	}

	public function delete(Request $request){
		$return = array(
			'code'=>self::CODE_SUCCESS,
			'msg'=>self::SUCCESS_MSG
		);
		$id = $request->input('id');
		if(empty($id)){
			$return['code'] = self::CODE_PARAM;
			$return['msg'] = self::PARAM_MSG;
			return response()->json($return);
		}
		$store = Store::find($id);
		if(empty($store)){
			$return['code'] = self::CODE_PARAM;
			$return['msg'] = self::PARAM_MSG;
			return response()->json($return);
		}
		$store->delete();
		return response()->json($return);
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
