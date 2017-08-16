<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class UsersOrder extends Model {

	//
    protected $table = 'users_orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;
    public $fillable = [
        'promote','out_trade_no','openid','transaction_id','order_status','pay_status',
        'uid','channel_id','uname','mobile','card_id','card_name','card_amount','months','pay_fee','money_paid','bonus',
        'order_amount','add_time','confirm_time','pay_time','receive_time','affiliate','froms'
    ];
}
