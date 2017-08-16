<?php namespace WxHotel;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserAddress extends Model {

	//
	protected $table = 'users_address';
	protected $fillable = ['uid','openid','mobile','email','country','province','city','area','address','lat','lng'];
	public $primaryKey = 'id';
}
