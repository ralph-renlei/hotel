<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel\Services;


class Level
{
    protected static $level_map = array(
        1=>array('title'=>'青铜','min'=>0,'max'=>100),
        2=>array('title'=>'白银','min'=>101,'max'=>300),
        3=>array('title'=>'黄金','min'=>301,'max'=>500),
        4=>array('title'=>'铂金','min'=>501,'max'=>1000),
        5=>array('title'=>'钻石','min'=>1001,'max'=>1001),
    );

    protected $level=1;
    protected $title = NULL;
    protected $point = 0;

    public static function userLevel($level){
        return self::$level_map[$level];
    }

    public static function upper($point,$level=0){
        $upper = array();

        if($level==0){
            $level = self::getLevel($point);
        }
        if($level==5){
            return $upper;
        }

        $upper_level = $level+1;
        $upper['level'] = $upper_level;
        $upper['point'] = self::$level_map[$upper_level]['min']-$point;
        $upper['title'] = self::$level_map[$upper_level]['title'];
        return $upper;
    }

    public static function getTitle($point){
        $title = '';
        ksort(self::$level_map,SORT_NUMERIC);
        foreach(self::$level_map as $key=>$l){
            if($point<$l['max']){
                $title = $l['title'];
                break;
            }
        }
        return $title;
    }

    public static function getLevel($point){
        $level = 1;
        ksort(self::$level_map,SORT_NUMERIC);
        foreach(self::$level_map as $key=>$l){
            if($point<$l['max']){
                $level = $key;
                break;

            }
        }
        return $level;
    }
}