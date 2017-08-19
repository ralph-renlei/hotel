<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Order extends Model {

	//
    protected $table = 'orders';
    protected $loan_table = 'orders_loan';
	protected $fillable=['order_sn','order_status','pay_status','openid','uid','goods_id','goods_name','goods_price','order_amount','add_time','forms','pdt_snapshot','start','end','category_id',
        'category_name','phone','username','last'
	];
    public $primaryKey = 'order_id';
    public $timestamps = false;

	public function check($order_id){
		$data = array();
		$data = $this->where('order_id',$order_id)->first();
		return $data;
	}

    public function getList($keywords=NULL){
        $data = array();
        if($keywords){
            $data = \DB::table($this->table)
                ->select('*')
                ->where('mobile','LIKE','%'.$keywords.'%')
                ->orderBy('order_id','desc')
                ->paginate(20);
            $data->setPath('/admin/order?keyword='.$keywords);
        }else{
            $data = \DB::table($this->table)
                ->select('*')
                ->orderBy('order_id','desc')
                ->paginate(20);
            $data->setPath('/admin/order');
        }
        return $data;
    }
}
