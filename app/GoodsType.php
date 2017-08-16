<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model {

    //

    protected $table = 'goods_type';
    public $fillable = [
        'type_id','type_name','type_alias','status','sort'
    ];

}
