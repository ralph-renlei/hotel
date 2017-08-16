<?php namespace WxHotel;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id','pid','nickname','username','name','password','openid','role','age','sex','mobile','licence','hk_permit','taiwan_permit',
		'email','avatar','country','province','city','area','height','weight','idcard_no','idcard_front','idcard_back','wechatid','has_car',
		'car','residence','household','passport','address','verify','money','award','point','level','vip','status'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['remember_token'];

	public $user_level_map = array(
		1=>array('title'=>'青铜','min'=>'0','max'=>'100'),
		2=>array('title'=>'白银','min'=>'101','max'=>'300'),
		3=>array('title'=>'黄金','min'=>'301','max'=>'500'),
		4=>array('title'=>'铂金','min'=>'501','max'=>'1000'),
		5=>array('title'=>'钻石','min'=>'1001','max'=>'0'),
	);

	public function getLevelTitle($level){
		if(!isset($this->user_level_map[$level])){
			return '未知';
		}
		return $this->user_level_map[$level]['title'];
	}

	public function getUserLevel($point){
		$level = array();
		foreach($this->user_level_map as $k=>$l){
			if( ($point > $l['min'] || $point == $l['min']) && ($point < $l['max'] || $point == $l['max']) ) {
				$level = $k;
				break;
			}else if($point > $l['min'] && $l['max']==0){
				$level = $k;
				break;
			}
		}
		return $level;
	}

	public function getUserByMobile($mobile){
		return \DB::table($this->table)
			->select('*')
			->where('mobile',$mobile)
			->first();
	}

	public function getUserByOpenid($openid){
		return \DB::table($this->table)
			->select('*')
			->where('openid',$openid)
			->first();
	}

}
