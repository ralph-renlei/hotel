<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;
use WxHotel\Services\Sms;
use Illuminate\Contracts\Auth\PasswordBroker;
use Closure;
use WxHotel\User;
use WxHotel\SmsRecord;

class HPassword implements PasswordBroker{

    const INVALID_MOBILE = 'passwords.mobile';
    const SEND_FAIL = 'passwrods.send_fail';

    public function __construct(User $user,Sms $sms,SmsRecord $sms_record)
    {
        $this->user = $user;
        $this->sms = $sms;
        $this->sms_record = $sms_record;
    }

    public function sendResetLink(array $credentials, Closure $callback = null){

    }

    public function sendResetCode(array $credentials, Closure $callback = null){

        $user = $this->retrieveByCredentials($credentials);
        if(empty($user)){
            return HPassword::INVALID_USER;
        }
        if(!isset($user->mobile)){
            return HPassword::INVALID_MOBILE;
        }
        $result = $this->sms->send_valid_sms($user->mobile);
        if(isset($result) && isset($result['code']) && $result['code']==0){
            return HPassword::RESET_LINK_SENT;
        }

        return HPassword::SEND_FAIL;
    }

    public function retrieveByCredentials(array $credentials){
        $where = array();
        foreach ($credentials as $key => $value)
        {
            if (!in_array($key,array('password','token') )) {
                $where[$key] = $value;
            }
        }

        return $this->user->where($where)->first();
    }

    public function reset(array $credentials, Closure $callback){
        $user = $this->retrieveByCredentials($credentials);
        if(empty($user)){
            return HPassword::INVALID_USER;
        }
        if(!isset($user->mobile)){
            return HPassword::INVALID_MOBILE;
        }
        $this->sms_record->where('token', $credentials['token']);
        $this->sms_record->where('mobile',$credentials['mobile']);
        $record = $this->sms_record->first();
        if(!$record){
            return HPassword::INVALID_TOKEN;
        }
        $record->delete();
        call_user_func($callback, $user, $credentials['password']);

        return HPassword::PASSWORD_RESET;
    }


    public function validator(Closure $callback){

    }

    public function validateNewPassword(array $credentials){

    }
}