<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

use DB;

class Card extends Model {

	//
    protected $table = 'users_cards';
    protected $promote = 'users_cards_promote';
    public $primaryKey = 'id';

    public $fillable = [
      'name','money','months','days','point','level','status','promote','sort'
    ];

    public function getCardList($start=0,$limit=20,$status=NULL){
        $list = array();
        if($status){
            $list = \DB::table($this->table)
                ->select(\DB::raw('users_cards.*,users_cards_promote.money as promote_money,users_cards_promote.months as promote_months,users_cards_promote.num as promote_num,users_cards_promote.start_time,users_cards_promote.end_time'))
                ->where($this->table.'.status',(int)$status)
                ->leftJoin($this->promote, function ($join) {
                    $join->on($this->table.'.id', '=',$this->promote.'.card_id')->where($this->promote.'.status', '=',1,'and');
                })
                ->orderBy('sort','desc')
                ->orderBy('id','asc')
                ->skip($start)
                ->take($limit)
                ->get();
        }else{
            $list = \DB::table($this->table)
                ->select(\DB::raw('users_cards.*,users_cards_promote.money as promote_money,users_cards_promote.months as promote_months,users_cards_promote.num as promote_num,users_cards_promote.start_time,users_cards_promote.end_time'))
                ->leftJoin($this->promote, function ($join) {
                    $join->on($this->table.'.id', '=',$this->promote.'.card_id')->where($this->promote.'.status', '=',1,'and');
                })
                ->orderBy('sort','desc')
                ->orderBy('id','asc')
                ->skip($start)
                ->take($limit)
                ->get();

        }

        return $list;
    }
}
