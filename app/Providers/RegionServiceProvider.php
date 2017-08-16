<?php namespace WxHotel\Providers;

use Illuminate\Support\ServiceProvider;

class RegionServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		//
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		$this->app->bind(
			'Aimi/Services/RegionSource'
		);
	}

}
