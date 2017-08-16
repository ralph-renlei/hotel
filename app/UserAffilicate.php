<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class UserAffilicate extends Model {

	//
    protected $table = 'users_affiliate';
    public $primaryKey = 'id';
    public $fillable = [
        'pid','uid','level'
    ];
}
