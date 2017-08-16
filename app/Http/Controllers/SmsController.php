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

use WxHotel\Services\Sms;
use WxHotel\SmsRecord;
use WxHotel\User;


class SmsController extends Controller
{

    public function validSms(Request $request){
        $mobile = $request->input('mobile');
        $code = $request->input('code');
        $return = array(
            'code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG
        );

        if(empty($mobile) || empty($code)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_MSG;
            return response()->json($return);
        }

        if(!preg_match('/^1[2-9]\d{9}$/',$mobile)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_INVALID_MSG;
            return response()->json($return);
        }

        $Sms_record = new SmsRecord();
        $sms_record = $Sms_record->where('mobile',$mobile)->orderBy('id','DESC')->first();
        $return['data'] = array('url'=>url('mobile'));
        if(isset($sms_record) && $sms_record->token == $code){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
            return response()->json($return);
        }else{
            return response()->json($return);
        }

    }

    public function sendCode(Request $request){
        $mobile = $request->input('mobile');
        $sms_record = new SmsRecord();
        $sms = new Sms($sms_record);
        $return = array(
            'code'=>self::CODE_FAIL,'data'=>NULL,'msg'=>self::FAIL_MSG
        );
        if(empty($mobile)){
            return response()->json($return);
        }
        if(!preg_match('/^1[2-9]\d{9}$/',$mobile)){
            $return['code'] = self::CODE_PARAM;
            $return['msg'] = self::PARAM_INVALID_MSG;
            return response()->json($return);
        }
        $result = $sms->send_valid_sms($mobile);

        if(isset($result) && isset($result['code']) && $result['code']==0){
            $return['code'] = self::CODE_SUCCESS;
            $return['msg'] = self::SUCCESS_MSG;
            return response()->json($return);
        }else{
            return response()->json($return);
        }
    }

}