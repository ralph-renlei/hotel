<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Controllers\Console;

use WxHotel\Services\WxPay;

class PayController extends Controller
{
    public function index(){
        $config['sign_type'] = 'MD5';
        $pay = new WxPay('wx34ae061ae1c8df73','ef8fcc35f5a7e23459534fa010a3036e',11);
    }
}