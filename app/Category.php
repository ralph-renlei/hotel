<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    //
    protected $table = 'goods_category';
    public $fillable = [
        'name','code','icon','parent','sort','status'
    ];
    public $primaryKey = 'id';
    public $timestamps = FALSE;


}
