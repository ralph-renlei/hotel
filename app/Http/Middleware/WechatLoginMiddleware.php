<?php namespace WxHotel\Http\Middleware;

use Closure;

class WechatLoginMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if(!session('user')){
			return redirect('/wechat');
		}
		return $next($request);
	}

}
