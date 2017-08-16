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

class Area extends Model
{
    protected $table = 'common_area';
    protected $fillable = ['code', 'name', 'parent'];
    protected $primaryKey = 'code';
    public $timestamps = FALSE;
    public $incrementing = FALSE;
}