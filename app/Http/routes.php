<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//---------------------------基础通用模块--------------------------------

Route::get('/', 'Mobile\HomeController@index');
Route::get('wechat/valid','WechatController@valid');

Route::post('upload/image','UploadController@image');
Route::post('sms/sendcode','SmsController@sendCode');
Route::post('sms/valid','SmsController@validSms');
Route::post('region/locate', 'RegionController@postLocate');
Route::get('region/province', 'RegionController@getProvince');
Route::get('region/city/{id}', 'RegionController@getCity');
Route::get('region/area/{id}', 'RegionController@getArea');
Route::get('region/street/{id}', 'RegionController@getStreet');
Route::get('region/community/{id}', 'RegionController@getCommunity');
Route::any('notify','Mobile\SwiftController@notify');
Route::any('pay','Mobile\WxpayController@prepay');

//--------------------------------个人中心---------------------------------
Route::get('/member','MemberController@index');
Route::get('/member/info','MemberController@loadInfo');
Route::get('/member/order','MemberController@order');
Route::get('/member/order_detail/{id}','MemberController@order_detail');
Route::get('/member/credit','MemberController@credit');
Route::post('/member/credit','MemberController@makeCredit');
Route::get('/member/setting','MemberController@setting');

//--------------------------------PC管理端---------------------------------
Route::group(['prefix' => 'admin','namespace' => 'Console'], function()
{

    Route::get('/', 'HomeController@index');
    Route::get('home', 'HomeController@index');

    Route::get('/shop','ShopController@index');
    Route::get('/shop/create','ShopController@create');
    Route::post('/shop/store','ShopController@store');
    Route::get('/shop/show/{id}','ShopController@show');
    Route::delete('/shop/item','ShopController@delete');
    Route::post('/shop/audit','ShopController@audit');
    Route::get('shop/cate', 'SystemController@cate');//房型管理
    Route::get('shop/price', 'SystemController@priceList');//房价管理
    Route::get('shop/price/add', 'SystemController@priceAdd');//房价管理
    Route::post('shop/price/store', 'SystemController@priceStore');//房价管理
    Route::get('shop/price/{id}', 'SystemController@priceShow');//修改
    Route::post('shop/price/save', 'SystemController@priceStore');//修改
    Route::get('/shop/goods','GoodsController@index');
    Route::get('/shop/goods/show/{id}','GoodsController@show');
    Route::get('/shop/goods/create','GoodsController@create');
    Route::post('/shop/goods/store','GoodsController@store');
    Route::delete('/shop/goods','GoodsController@deleteItem');
    Route::post('/shop/goods/item','GoodsController@postAudit');
    Route::post('/shop/status','OrderController@postStatus');
    Route::get('/shop/total','OrderController@getDeliveryTotal');
    Route::post('category','GoodsController@getCategory');

    Route::get('order', 'OrderController@index');
    Route::get('system', 'SystemController@cate');
    Route::get('system/config', 'SystemController@config');
    Route::post('system/config', 'SystemController@saveConfig');
    Route::delete('system/config', 'SystemController@delConfig');

    Route::get('system/affiliate', 'SystemController@affiliate');
    Route::post('system/affiliate', 'SystemController@saveAffiliate');
    Route::delete('system/affiliate', 'SystemController@delAffiliate');

    Route::get('system/cate', 'SystemController@cate');
    Route::get('system/cates/images/{id}', 'SystemController@getImage');//上传图片
    Route::post('system/cates/images', 'SystemController@saveImage');//上传图片
    Route::get('system/cate/{id}', 'SystemController@getCate');
    Route::post('system/cate', 'SystemController@postCate');
    Route::delete('system/cate', 'SystemController@delCate');

    Route::get('system/option', 'SystemController@option');
    Route::get('system/option/{id}', 'SystemController@show');
    Route::post('system/option','SystemController@postOption');
    Route::post('system/option/delete','SystemController@deleteOption');

    Route::get('system/banner', 'SystemController@banner');
    Route::get('system/addBanner', 'SystemController@addBanner');
    Route::get('system/banner/{code}', 'SystemController@bannerItem');
    Route::post('system/banner', 'SystemController@saveBanner');
    Route::delete('system/banner', 'SystemController@delBanner');

    Route::get('user','UserController@index');
    Route::get('user/add','UserController@addUser');
    Route::get('user/user/{id}','UserController@getUser');
    Route::post('user/user','UserController@postUser');
    Route::delete('user/user','UserController@delUser');
    //下线
    Route::get('user/affiliate','AffiliateController@index');
    Route::get('user/affiliate/{id}','AffiliateController@show');
    //管理员
    Route::get('user/admin','UserController@admin');
    //普通用户
    Route::get('user/member','UserController@member');
    Route::get('user/channel','UserController@channel');
    Route::get('user/risk','UserController@risk');
    Route::get('user/finance','UserController@finance');
    Route::get('user/store','UserController@store');
    //渠道邀请码
    Route::get('user/channel/invite/{id}','UserController@inviteCode');
    Route::post('user/channel/invite','UserController@postInviteCode');
    Route::delete('user/channel/invite','UserController@delInviteCode');

    //登录用户的账户
    Route::get('user/account','UserController@account');
    Route::post('user/account','UserController@saveProfile');
    Route::get('password/reset','Auth\PasswordController@getReset');
    Route::post('password/reset','Auth\PasswordController@postReset');
    Route::post('password/mobile','Auth\PasswordController@postMobile');
    Route::get('password/mobile','Auth\PasswordController@getMobile');
    Route::get('password','Auth\PasswordController@index');
    Route::controllers([
        'auth' => 'Auth\AuthController',
    ]);
});


