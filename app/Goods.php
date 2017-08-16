<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model {

	//
    protected $table = 'goods';
    protected $fillable = [
        'store_id','goods_sn','type','category', 'goods_cate', 'name', 'thumb','images','description', 'voice', 'video', 'content', 'marketprice','productprice',
        'agentprice','costprice','issale','isnew','ishot','isdiscount','isrecommand','istime','sort','views','status','audited'
    ];
    protected $primaryKey = 'goods_id';
}
