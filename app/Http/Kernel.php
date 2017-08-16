<?php namespace WxHotel\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		//'WxHotel\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'mobile.auth' => 'WxHotel\Http\Middleware\MobileAuth',
		'auth' => 'WxHotel\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'WxHotel\Http\Middleware\RedirectIfAuthenticated',
        'rbac' => 'WxHotel\Http\Middleware\Rbac',
        'channel.auth'=>'WxHotel\Http\Middleware\ChannelAuthenticate',
        'risk.auth'=>'WxHotel\Http\Middleware\RiskAuthenticate',
        'finance.auth'=>'WxHotel\Http\Middleware\FinanceAuthenticate',
	];

}
