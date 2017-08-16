<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Store extends Model {

	//
    protected $table = 'stores';
    public $fillable = [
        'mch_id','category','store_name','logo','images','intro','star','contacter','telephone',
        'mobile','note','province','city','area','community','address','open_time','close_time',
        'avgprice','cash','lat','lng','status'
    ];

    public function getListByLocation($lat=NULL,$lng=NULL,$start=0,$limit=10,$where=NULL){
        if(!empty($where)){
            $sql = 'select *,ROUND(2 * 6378.137 * ASIN(SQRT(POW(SIN(PI()*('.$lat.'-lat)/360),2)+COS(PI()*33.07078170776367/180)* COS(lat * PI()/180)*POW(SIN(PI()*('.$lng.'-lng)/360),2)))) as distance from `stores` where '.
$where.' order by distance asc limit '.$start.','.$limit;
        }else if($lat && $lng){
            $sql = 'select *,ROUND(2 * 6378.137 * ASIN(SQRT(POW(SIN(PI()*('.$lat.'-lat)/360),2)+COS(PI()*33.07078170776367/180)* COS(lat * PI()/180)*POW(SIN(PI()*('.$lng.'-lng)/360),2)))) as distance from `stores`
order by distance asc limit '.$start.','.$limit;
        }else{
            $sql = 'select * from `stores` order by id desc limit '.$start.','.$limit;
        }
        $results = \DB::select($sql);
        $time = date('H:s');
        foreach($results as &$r){
            $r->is_open = 0;
            if(!empty($r->open_time) && !empty($r->close_time)){
                if( ($time > $r->open_time || $time == $r->open_time)
                    || ( $time < $r->close_time || $time == $r->close_time)){
                    $r->is_open = 1;
                }
            }
        }
        return $results;
    }

}
