<?php namespace WxHotel\Http\Middleware;

use Closure;

class WechatLogin {
	public function handle($request, Closure $next)
	{
		if (is_null(session('user'))) {
			return redirect('/');
		}

		return $next($request);
	}

}
