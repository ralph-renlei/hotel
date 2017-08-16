<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Money extends Model {

	//
    protected $table = 'users_money_records';
    public $fillable = ['title','uid','uname','note','type','cate','channel_id','money','note'];

    protected $cate_map  = [
        0=>'奖励',
        1=>'充值',
        2=>'还款',
        3=>'提现'
    ];

    protected $type_map = [
        1=>'收入',
        0=>'支出',
    ];

}
