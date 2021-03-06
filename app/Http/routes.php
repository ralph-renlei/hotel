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
Route::get('/goods_id', 'ReserveController@offlineIndex');
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
Route::get('/pay','ReserveController@pay');
Route::get('/pay_offline','ReserveController@pay_offline');
Route::get('/unifiedorder','Mobile\WxpayController@unifiedorder');
Route::get('/prepay','Mobile\WxpayController@prepay');//预下单
Route::post('/notify','Mobile\WxpayController@notify');//异步通知
Route::get('/pay_success','Mobile\WxpayController@pay_success');//支付成功
Route::get('/pay_success_offline','Mobile\WxpayController@pay_success_offline');//支付成功
Route::get('pay_error','Mobile\WxpayController@pay_error');//支付失败
Route::get('/refund','Mobile\WxpayController@refund');//申请退款
Route::get('/refundquery','Mobile\WxpayController@refundquery');//查询退款

//--------------------------------个人中心---------------------------------
Route::get('/member','MemberController@index');
Route::get('/member/info','MemberController@loadInfo');
Route::post('/member/changesex','MemberController@changesex');
Route::get('/member/order','MemberController@order');
Route::get('/member/order_detail/{id}','MemberController@order_detail');
Route::get('/member/order_del','MemberController@order_del');
Route::get('/member/credit','MemberController@credit');
Route::post('/member/credit','MemberController@makeCredit');
Route::get('/member/mobile_credit_allow','MemberController@mobile_credit_allow');
Route::get('/member/mobile_credit_make','MemberController@mobile_credit_make');

Route::get('/member/setting','MemberController@setting');
Route::get('/member/setting/bind','MemberController@bind');
Route::get('/member/setting/new','MemberController@newphone');

//--------------------------------房间预定---------------------------------
Route::get('/reserve','ReserveController@index');
Route::get('/reserve/orderonline','ReserveController@makeOrder');//线上预订
Route::post('/reserve/ordercommit','ReserveController@orderCommit');//生成订单
Route::post('/reserve/ordercommit_offline','ReserveController@ordercommit_offline');//生成订单
Route::get('/reserve/verify_code','ReserveController@verify_code');
Route::get('/reserve/orderoffline','ReserveController@orderoffline');//线下预定
Route::get('/mobile_room','Console\OrderManageController@mobile_room');//管理员通过手机分配房间
Route::get('/mobile_allow','Console\OrderManageController@mobile_allow');//管理员通过手机同意
Route::post('mobile_room_arrange','Console\OrderManageController@mobile_room_arrange');//分配房间写入数据库
Route::get('/power','Console\PowerController@control_power');//通断电
Route::get('/test','Console\PowerController@save_boxes');//测试
Route::get('/rest','Console\OrderManageController@makeRest');//入住
Route::get('/out_room','Console\OrderManageController@out_room');//退房
Route::get('/admin/shop/power_count','Console\GoodsController@power_count');

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
    Route::get('shop/status','GoodsController@room_status');//房态管理
    Route::get('shop/price/{id}', 'SystemController@priceShow');//修改
    Route::post('shop/price/save', 'SystemController@priceStore');//修改
    Route::get('/shop/goods','GoodsController@index');
    Route::get('/shop/goods/show/{id}','GoodsController@show');
    Route::get('/shop/goods/create','GoodsController@create');
    Route::post('/shop/goods/store','GoodsController@store');
    Route::get('/shop/goods/qrcode/{id}','GoodsController@qrcode');//生成二维码
    Route::get('/shop/goods/show_qrcode/{id}','GoodsController@show_qrcode');//生成二维码
    Route::delete('/shop/goods','GoodsController@deleteItem');
    Route::post('/shop/goods/item','GoodsController@postAudit');
    Route::post('/shop/status','OrderController@postStatus');
    Route::get('/shop/total','OrderController@getDeliveryTotal');
    Route::post('category','GoodsController@getCategory');

    Route::get('/order/home','OrderManageController@index');
    Route::get('/order/order_id/{id}','OrderManageController@show');
    Route::post('/order/order_id/{id}','OrderManageController@orderedit');
    Route::get('/order/loadarrange/{id}','OrderManageController@loadarrange');//加载房间分配
    Route::get('/order/allowarrange/{id}','OrderManageController@allowarrange');//加载房间分配
    Route::post('/order/room_arrange','OrderManageController@room_arrange');//分配房间
    Route::get('/order/add','OrderManageController@loadadd');//加载添加订单
    Route::get('/order/refundrecord','OrderManageController@refund_record');//加载退款记录

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
    Route::post('/user/saveUser','UserController@saveUser');
    Route::get('/user/verify','UserController@verify');
    Route::get('/user/verify/image/{id}','UserController@getImage');
    Route::post('/user/verify/saveimage','UserController@saveImage');

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


