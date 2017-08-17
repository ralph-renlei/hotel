<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Controllers\Console;

use WxHotel\Attribute;
use WxHotel\Category;
use WxHotel\Config;
use WxHotel\GoodsType;
use WxHotel\Tag;
use WxHotel\TagType;
use WxHotel\LoanConfig;
use WxHotel\Province;
use WxHotel\City;
use WxHotel\Area;
use WxHotel\Street;
use WxHotel\Community;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class SystemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $var = array();
        $Config = new Config();
        $var['list'] = $Config->lists();
        return view('admin.system.home',$var);
    }
    public function cate(){
        $var = [];
        $list = Category::orderBy('sort','DESC')->orderBy('id','ASC')->paginate(20);
        $list->setPath('/admin/system/cate');

        $var['lists'] = $list;
        return view('admin.system.cate',$var);
    }
    public function postCate(Request $request){
        $return = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG
        );

        $id = $request->input('id');
        $name = $request->input('name');
        $marketprice = $request->input('marketprice');
        $normalprice = $request->input('normalprice');
        $vipprice = $request->input('vipprice');
        $bed = $request->input('bed');
        $description = $request->input('description');
        $number = $request->input('number');
        $sort = $request->input('sort');
        $status = $request->input('status');

        if(!isset($name)|| empty($name) || strlen($name)>20){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = '名称为空或者太长';
            return response()->json($return);
        }
        if(isset($sort) && !is_numeric((int)$sort) ){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = '排序必须为数字';
            return response()->json($return);
        }
        if(isset($status) && !in_array((int)$status,array(0,1),TRUE)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = '状态必须为数字';
            return response()->json($return);
        }
        $cate = NULL;
        if(isset($id) && (int)$id>0){
            $cate = Category::find((int)$id);
        }

        if(!empty($cate)){
            $cate->name = $name;
            if(isset($marketprice)){
                $cate->marketprice = $marketprice;
            }
            if(isset($normalprice)){
                $cate->normalprice = $normalprice;
            }
            if(isset($vipprice)){
                $cate->vipprice = $vipprice;
            }
            if(isset($bed)){
                $cate->bed = $bed;
            }
            if(isset($description)){
                $cate->description =  $description;
            }
            if(isset($number)){
                $cate->number = $number;
            }
            if(isset($sort)){
                $cate->sort = (int)$sort;
            }
            if(isset($status)){
                $cate->status = (int)$status;
            }
            if(isset($images)){
                $cate->images = $images;
            }
            $cate->save();
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }else{
            $data = [
                'name'=>$name,
                'marketprice'=>$marketprice,
                'normalprice'=>$vipprice,
                'vipprice'=>$vipprice,
                'bed'=>$bed,
                'description'=>$description,
                'number'=>(int)$number,
                'sort'=>(int)$sort,
                'status'=>(int)$status,
            ];

            $cate = Category::create($data);
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function delCate(Request $request){
        $id = $request->input('id');
        if(!isset($id) || empty($id)){
            $return = [
                'code'=>self::CODE_PARAM,
                'msg'=>self::PARAM_MSG
            ];
            return response()->json($return);
        }
        $cate = Category::find($id);
        if(!$cate){
            $return = [
                'code'=>self::CODE_PARAM,
                'msg'=>self::PARAM_MSG
            ];
            return response()->json($return);
        }
        Category::where('id',$cate->id)->delete();
        $cate->delete();
        $return = [
            'code'=>self::CODE_SUCCESS,
            'msg'=>self::SUCCESS_MSG
        ];
        return response()->json($return);
    }

    public function getImage($id){
        $images = Category::where('id',$id)->first();
        $gallery_list = array();
        if(!empty($images->images)){
            $gallery_list = explode(',',$images->images);
        }

        return view('admin.system.cate_children',['gallery_list'=>$gallery_list,'id'=>$id]);
    }

    public function saveImage(Request $request){
        //查询数据库中的图片，将所有提交的图片 与已有图片做差值，剩下的图片更新
        $old_img = Category::where('id',$request->id)->lists('images');
        $old_img = explode(',',$old_img[0]);
        $images_array = explode(',',trim($request->images,','));//所有提交的图片
        if(isset($old_img)){//修改
            $new_array = array_diff($images_array,$old_img);print_r($new_array);
            $thumb = current($new_array);//缩略图，区第一张图
            if(count($new_array)>1){
                $images = trim(implode(',',array_shift($new_array)),',');//图片
            }
            $images = $thumb;
        }else{
            $thumb = $images_array[0];
            if(count($images_array)>1){
                $images = array_shift($images_array);
            }
            $images = $thumb;
        }

        $cate = Category::where('id',$request->id)->update(['thumb'=>$thumb,'images'=>$images]);
        $return['code'] = self::CODE_SUCCESS;
        $return['msg'] = self::SUCCESS_MSG;
        return response()->json($return);
    }
    public function getCate($id){
        if(!isset($id) || empty($id)){
            $return = [
                'code'=>self::CODE_PARAM,
                'msg'=>self::PARAM_MSG
            ];
            return response()->json($return);
        }
        $cate = Category::find($id);

        if(!$cate){
            $return = [
                'code'=>self::CODE_PARAM,
                'msg'=>self::PARAM_MSG
            ];
            return response()->json($return);
        }
        $return = [
            'code'=>self::CODE_SUCCESS,
            'data'=>$cate->toArray(),
            'msg'=>self::SUCCESS_MSG
        ];
        return response()->json($return);
    }

    public function banner(){
        $var = array();
        $Config = new Config();
        $var['list'] = $Config->type('banner');

        return view('admin.system.banner',$var);
    }

    public function addBanner(){
        $var = [];
        return view('admin.system.add_banner',$var);
    }

    public function delBanner(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $id = $request->input('code');

        if($id){
            $config = Config::find($id);
            $result = $config->delete();
            if($result){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }
        return response()->json($return);
    }

    public function saveBanner(Request $request){
        $code = $request->input('code');
        $name = $request->input('name');
        $new_gallery = $request->input('new_gallery');
        if( empty($code) || empty($name) || empty($new_gallery)){
            return redirect()->back()->withErrors(array('error'=>'参数异常'));
        }
        $banner = NULL;

        $banner = Config::find($code);
        $url = array_pop($new_gallery);

        if(empty($banner)){
            $data = array(
                'code'=>$code,
                'name'=>$name,
                'type'=>'banner',
                'val'=>$url,
            );
            $banner = Config::create($data);
        }elseif(!empty($banner) && $banner->type!=='banner') {
            return redirect()->back()->withErrors(array('error'=>'键值已经存在'));
        }else{
            $banner->name = $name;
            $banner->val = $url;
            $banner->save();
        }
        return redirect('/admin/system/banner');
    }

    public function bannerItem($code){
        $var = [];
        $item = Config::find($code);
        $var['item'] = $item;
        return view('admin.system.banner_item',$var);
    }

    public function config(){
        $var = array();
        $Config = new Config();
        $var['list'] = $Config->type('system');
        return view('admin.system.home',$var);
    }

    public function saveConfig(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $name = $request->input('name');
        $code = $request->input('code');
        $val = $request->input('val');
        $type = 'system';

        if(empty($name) || empty($code) || empty($val)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $code = strtoupper($code);

        $config = Config::find($code);

        if($config){
            $config->name = $name;
            $config->val = $val;
            $result = $config->save();
        }else{
            $config = array('code'=>$code,'name'=>$name,'val'=>$val,'type'=>$type);
            $result = Config::create($config);
        }

        if($result){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function delConfig(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $id = $request->input('code');

        if($id){
            $config = Config::find($id);
            $result = $config->delete();
            if($result){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }
        return response()->json($return);
    }

    public function bonus(){
        $var = array();
        $Config = new Config();
        $var['list'] = $Config->type('bonus');
        return view('admin.system.home',$var);
    }

    public function saveBonus(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $name = $request->input('name');
        $code = $request->input('code');
        $val = $request->input('val');
        $type = 'bonus';

        if(empty($name) || empty($code) || empty($val)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $code = strtoupper($code);


        $config = Config::find($code);

        if($config){
            $config->name = $name;
            $config->val = $val;
            $result = $config->save();
        }else{
            $config = array('code'=>$code,'name'=>$name,'val'=>$val,'type'=>$type);
            $result = Config::create($config);
        }

        if($result){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function delBonus(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $id = $request->input('code');

        if($id){
            $config = Config::find($id);
            $result = $config->delete();
            if($result){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }
        return response()->json($return);
    }

    public function affiliate(){
        $var = array();
        $Config = new Config();
        $var['list'] = $Config->type('affiliate');
        return view('admin.system.home',$var);
    }

    public function saveAffiliate(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $name = $request->input('name');
        $code = $request->input('code');
        $val = $request->input('val');
        $type = 'affiliate';

        if(empty($name) || empty($code) || empty($val)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $code = strtoupper($code);


        $config = Config::find($code);

        if($config){
            $config->name = $name;
            $config->val = $val;
            $result = $config->save();
        }else{
            $config = array('code'=>$code,'name'=>$name,'val'=>$val,'type'=>$type);
            $result = Config::create($config);
        }

        if($result){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function delAffiliate(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $id = $request->input('code');

        if($id){
            $config = Config::find($id);
            $result = $config->delete();
            if($result){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }
        return response()->json($return);
    }

    public function option(){
        $var = array();
        $list=GoodsType::orderBy('type_id','DESC')->paginate(10);
        $list->setPath('/admin/system/option');
        $var['list']=$list;
        return view('admin.system.option',$var);
    }
    public function show($id){
        $var=array();
        $type=GoodsType::where('type_id',$id)->first();
        $var['type']=$type;
        $var['attributes']=Attribute::where('type_id',$id)->get();
        foreach($var['attributes'] as $attribute){
            $attribute['attr_value']=explode('|',$attribute['attr_value']);
        }
        return view('admin.system.show',$var);
    }

    public function postOption(){

    }

    public function deleteOption(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $attrId=$request->input('attr_id');
        $attrValue=$request->input('attr_value');
        $attribute=Attribute::where('attr_id',$attrId)->first();
        $attribute->attr_value=explode('|',$attribute->attr_value);
        $key = array_search($attrValue,$attribute->attr_value);
        if(isset($key)){
            unset($attribute->attr_value[$key]);
        }
        $attribute->attr_value=implode('|',$attribute->attr_value);
        $attribute->save();
        //de
        return response()->json($return);
    }

    public function member(){
        $var = array();
        $Config = new Config();
        $var['list'] = $Config->type('member');
        return view('admin.system.home',$var);
    }

    public function saveMember(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $name = $request->input('name');
        $code = $request->input('code');
        $val = $request->input('val');
        $type = 'member';
        if(empty($name) || empty($code) || empty($val)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $code = strtoupper($code);


        $config = Config::find($code);

        if($config){
            $config->name = $name;
            $config->val = $val;
            $result = $config->save();
        }else{
            $config = array('code'=>$code,'type'=>$type,'name'=>$name,'val'=>$val);
            $result = Config::create($config);
        }

        if($result){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function delMember(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $id = $request->input('code');

        if($id){
            $config = Config::find($id);
            $result = $config->delete();
            if($result){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }
        return response()->json($return);
    }

    public function loan(){
        $var = array();
        $list= LoanConfig::orderBy('loan_id','DESC')->paginate(10);
        $list->setPath('/admin/system/loan');
        $var['list']=$list;
        return view('admin.system.loan',$var);
    }

    public function saveLoan(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $name = $request->input('name');
        $id = $request->input('id');
        $num = $request->input('num');
        $fee = $request->input('fee');
        $rate = $request->input('rate');
        $note = $request->input('note');
        if(empty($name) || empty($id) || empty($num)|| empty($fee) || empty($rate)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }
        $loan = LoanConfig::where('loan_id',$id)->first();
        if($loan){
            $loan->name = $name;
            $loan->num = $num;
            $loan->fee = $fee;
            $loan->rate = $rate;
            $loan->note = $note;
            $loan = $loan->save();
            $result=$loan;

        }else{
            $loan = array('name'=>$name,'num'=>$num,'fee'=>$fee,'rate'=>$rate,'note'=>$note);
            $result = LoanConfig::create($loan);
        }
        if($result){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
        }
        return response()->json($return);
    }

    public function delLoan(Request $request){
        $return = array('code'=>self::CODE_FAIL,'msg'=>self::FAIL_MSG,'data'=>NULL);
        $id = $request->input('id');

        if($id){
            $config = LoanConfig::find($id);
            $result = $config->delete();
            if($result){
                $return['code'] = self::CODE_SUCCESS;
                $return['msg'] = self::SUCCESS_MSG;
            }
        }
        return response()->json($return);
    }
}