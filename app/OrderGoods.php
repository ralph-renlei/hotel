<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model {

    //

    protected $table = 'order_goods';
    public $fillable = [
        'ogoods_id','order_id','store_id','store_name','goods_id','goods_name','goods_sn','product_id','goods_number','market_price','goods_price','split_money','goods_attr','send_number',
        'goods_attr_id','comment_state','cost_price','promote_price'
    ];

}
