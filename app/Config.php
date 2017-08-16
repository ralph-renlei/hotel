<?php
// +----------------------------------------------------------------------
// | www.emake.cc
// +----------------------------------------------------------------------
// | Copyright (c) 2016 emake.cc Team All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tonny Cao <647812411@qq.com>
// +----------------------------------------------------------------------

namespace WxHotel;


use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = 'config';
    protected $fillable = array('code','type','name','val');
    protected $primaryKey = 'code';
    public $timestamps = FALSE;
    public $incrementing = FALSE;

    public function item($code){
        return $this->find($code);
    }

    public function lists(){
        return $this->all();
    }
    public function type($type){
        return $this->where('type',$type)->get();
    }
    public function add($config){
        return $this->create($config);
    }

}