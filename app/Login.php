<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Login extends Model {

	//
    protected $table = 'users_login';

    protected $fillable = ['uid','openid','login_time','login_lat','login_lng'];

    protected $primaryKey = 'id';

    public $timestamps = FALSE;

    public function getLoginCount($uid,$max_time,$min_time){
        $total = 0;
        $total = $this->where('uid',$uid)
            ->where('login_time','<',$max_time)
            ->where('login_time','>',$min_time)
            ->count();
        return $total;
    }

}
