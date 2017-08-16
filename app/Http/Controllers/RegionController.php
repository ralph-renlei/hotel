<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use WxHotel\Services\RegionSource;
use WxHotel\Province;
use WxHotel\City;
use WxHotel\Area;
use WxHotel\Street;
use WxHotel\Community;

class RegionController extends Controller
{
    public function postLocate(Request $request){
        $return = array(
            'code'=>self::CODE_FAIL,
            'msg'=>self::FAIL_MSG,
        );
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        if(!empty($lat) && !empty($lng)){
            $this->lat = $lat;
            $this->lng = $lng;
            Session::put('lat',$lng);
            Session::put('lng',$lng);
            $return = array(
                'code'=>self::CODE_SUCCESS,
                'msg'=>self::SUCCESS_MSG,
            );
        }
        response()->json($return);
    }

    public function getProvince(){
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        $list = Province::all();
        $return['code'] = self::CODE_SUCCESS;
        $return['msg'] = self::SUCCESS_MSG;
        $return['data'] = $list;
        return response()->json($return);
    }
    public function getCity($province_id){
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($province_id)){
            $return = array('code'=>self::CODE_PARAM,'data'=>NULL,'msg'=>self::PARAM_MSG);
            return response()->json($return);
        }
        $city_list = City::where('parent',$province_id)->orderBy('code')->get();
        if(!empty($city_list)){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
            $return['data'] = $city_list;
            return response()->json($return);
        }
        return response()->json($return);
    }

    public function getArea($city_id){
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($city_id)){
            $return = array('code'=>self::CODE_PARAM,'data'=>NULL,'msg'=>self::PARAM_MSG);
            return response()->json($return);
        }
        $area_list = Area::where('parent',$city_id)->orderBy('code')->get();
        if(!empty($area_list)){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
            $return['data'] = $area_list;
            return response()->json($return);
        }
        return response()->json($return);
    }

    public function getStreet($area_id){
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($area_id)){
            $return = array('code'=>self::CODE_PARAM,'data'=>NULL,'msg'=>self::PARAM_MSG);
            return response()->json($return);
        }
        $street_list = Street::where('parent',$area_id)->get();
        if(!empty($street_list)){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
            $return['data'] = $street_list;
            return response()->json($return);
        }
        return response()->json($return);
    }

    public function getCommunity($street_id){
        $return = array('code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG);
        if(empty($street_id)){
            $return = array('code'=>self::CODE_PARAM,'data'=>NULL,'msg'=>self::PARAM_MSG);
            return response()->json($return);
        }
        $comm_list = Community::where('parent',$street_id)->get();
        if(!empty($comm_list)){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
            $return['data'] = $comm_list;
            return response()->json($return);
        }
        return response()->json($return);
    }

}