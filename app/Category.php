<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    //
    protected $table = 'goods_category';
    protected $fillable = [
        'name','status','marketprice','normalprice','vipprice','bed','description','number','sort','thumb','images'
    ];
    public $primaryKey = 'id';
    public $timestamps = FALSE;


}
