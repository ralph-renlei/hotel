<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model {

    //

    protected $table = 'users_cash_records';
    public $fillable = [
        'uid','uname','openid','money','way','images','status','note'
    ];

}
