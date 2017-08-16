<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model {

	//
    protected $table = 'goods';
    protected $fillable = [
        'goods_sn','category', 'name','stock', 'thumb','images','description', 'marketprice','productprice',
        'vipprice','costprice','weekendprice','holidayprice','sort',
    ];
    protected $primaryKey = 'goods_id';
}
