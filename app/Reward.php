<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model {

	//
    protected $table = 'users_reward_records';
    public $fillable = [
        'uid','uname','money', 'sid','sname','note','status'
    ];

}
