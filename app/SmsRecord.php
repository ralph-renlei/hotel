<?php namespace WxHotel;

use Illuminate\Database\Eloquent\Model;

class SmsRecord extends Model {

    protected $table = 'sms_record';
    protected $fillable = ['mobile','token','status'];

}
