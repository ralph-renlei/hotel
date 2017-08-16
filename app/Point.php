<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class Point extends Model {

	//
    protected $table = 'user_points_records';
    public $fillable = [
      'uid','uname','points','type','cate','note'
    ];

}
