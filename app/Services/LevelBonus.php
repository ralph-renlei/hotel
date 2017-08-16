<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;


class LevelBonus
{
    //会员级别
    protected $level = 0;
    protected $level_map = array(
        1=>array('title'=>'青铜','min'=>'0','max'=>'100'),
        2=>array('title'=>'白银','min'=>'101','max'=>'300'),
        3=>array('title'=>'黄金','min'=>'301','max'=>'500'),
        4=>array('title'=>'铂金','min'=>'501','max'=>'1000'),
        5=>array('title'=>'钻石','min'=>'1001','max'=>'0'),
    );
    //消费次数
    protected $num = 0;

    //消费1次数返现
    public $bonus1 = NULL;

    //消费2次数返现
    public $bonus2 = NULL;

    //消费3次数返现
    public $bonus3 = NULL;
    //消费3次以上返现
    public $bonusn = NULL;

    //获取返现金额
    public $bonus = 0.00;

    //获得积分
    protected $point = 0;

    protected $month = 0;


    public function __construct($level,$bonus_list)
    {
        $this->level = $level;
        foreach($bonus_list as $item){
            if($item->code == 'level'.$level.'bonus1'){
                $this->bonus1 = $item->val;
            }
            if($item->code == 'level'.$level.'bonus2'){
                $this->bonus2 = $item->val;
            }
            if($item->code == 'level'.$level.'bonus3'){
                $this->bonus3 = $item->val;
            }
            if($item->code == 'level'.$level.'bonusn'){
                $this->bonusn = $item->val;
            }
        }

    }

    public function setBonus($num){
        $this->num = $num;
        switch((int)$num){
            case 1:
                $this->bonus = $this->bonus1;
                break;
            case 2:
                $this->bonus = $this->bonus1+$this->bonus2;
                break;
            case 3:
                $this->bonus = $this->bonus1+$this->bonus2+$this->bonus3*2;
                break;
            default:
                $this->bonus = $this->bonus1+$this->bonus2+$this->bonusn*($this->num-2);
                break;
        }
        return $this->bonus;
    }


    public function getBonus(){
        return $this->bonus;
    }

    public function setPoint($people){
        $this->point = $this->month*$people+$this->num;
    }

    public function getPoint(){
        return $this->point;
    }

    public function setMonth($month){
        $this->month = $month;
    }

    public function getMonth(){
        return $this->month;
    }

    public function setNum($num){
        $this->num = $num;
    }

    public function getNum(){
        return $this->num;
    }

    public function setLevel($level){
        $this->level = $level;
    }

    public function getLevel(){
        return $this->level;
    }

    public function getLevelTitle(){
        foreach($this->level_map as $level){
            if($level['max']>0 && $level['min']>0){
                 if(($this->point < $level['max'] || $this->point == $level['max'] )
                     && ($this->point > $level['min'] || $this->point == $level['min']) ){
                        return $level['title'];
                 }
            }else if($level['max']>0 && $level['min']==0){
                if(($this->point < $level['max'] || $this->point == $level['max'] )
                    && ($this->point > $level['min'] || $this->point == $level['min']) ){
                    return $level['title'];
                }
            }else if($level['min']>0 && $level['max']==0){
                if($this->point > $level['min'] || $this->point == $level['min'] ){
                    return $level['title'];
                }
            }
        }
    }

}