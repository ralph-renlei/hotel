<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;


class Affiliate
{
    //一级分销的提成
    public $affiliate1 = NULL;

    //二级分销的提成
    public $affiliate2 = NULL;

    //三级分销的提成
    public $affiliate3 = NULL;

    //当前用户的子类级别
    public $level = NULL;

    //当前用户ID
    public $id = 0;

    //当前用户的子类
    public $children = array();

    //奖励类型
    public $reward_map = array('money','point');
    public $reward_type = NULL;

    //奖励类型
    public function __construct($a1,$a2=NULL,$a3=NULL)
    {
        $this->affiliate1 = $a1;
        $this->affiliate2 = $a2;
        $this->affiliate3 = $a3;
    }

    public function getReward(){
        $reward = 0;
        switch((int)$this->level){
            case 1:
                $reward = $this->affiliate1*$this->children[$this->reward_type];
                break;
            case 2:
            default:
                $reward = $this->affiliate2*$this->children[$this->reward_type];
                break;
            case 3:
                $reward = $this->affiliate3*$this->children[$this->reward_type];
                break;
        }
        $this->reward = $reward;
        return $reward;
    }

    public function setLevel($level){
        return $this->level = $level;
    }

    public function getLevel(){
        return $this->level;
    }

    public function setRewardType($type){
        $this->reward_type = $type;
    }

    public function getRewardType(){
        return $this->reward_type;
    }

    public function setChildren($data){
        $this->children = $data;
    }

    public function getChildren(){
        return $this->children;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

}