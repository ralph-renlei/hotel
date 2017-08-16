<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Session;

class MobileAuth
{

    public function handle($request, Closure $next)
    {
        $uid = Session::get('uid');
        if (empty($uid))
        {
            if (!$request->ajax())
            {
                return redirect()->guest('admin/notlogin');
            }
        }

        return $next($request);
    }
}