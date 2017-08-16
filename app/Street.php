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

class Street extends Model
{
    protected $table = 'common_street';
    protected $fillable = ['code', 'name', 'parent'];
    public $timestamps = FALSE;
    public $incrementing = FALSE;
}