<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Http\RedirectResponse;

class Rbac
{
    protected $role = NULL;
    protected $config = NULL;

    public function handle($request, Closure $next)
    {
        if (!$this->authCheck($request))
        {
            return new RedirectResponse(url('/admin/home'));
        }
        return $next($request);
    }

    public function authCheck(Request $request){
        $right = false;
        $this->config = config('rbac');
        $user = $request->user()->toArray();

        $this->role = $user['role'];
        $auth = $this->config[$this->role];
        $path = trim($request->path(),'/');
        $path_array = explode('/',$path);
        $controller = $path_array[1];

        if( count($auth['allow'])==1 && $auth['allow'][0]=='*'){
            $right = true;
        }elseif(count($auth['allow']) ==0){
            $right = false;
        } else if(in_array($controller,$auth['allow'],true)){
            $right = true;
        }
        return $right;
    }
}