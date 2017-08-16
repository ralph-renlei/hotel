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

class Province extends Model
{
    protected $table = 'common_province';
    protected $fillable = ['code', 'name', 'parent'];
    public $timestamps = FALSE;
    public $incrementing = FALSE;
    protected $primaryKey = 'code';
}