<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model {

	//
    protected $table = 'goods';
    protected $fillable = [
        'category_id', 'name',
    ];
    protected $primaryKey = 'goods_id';
}
