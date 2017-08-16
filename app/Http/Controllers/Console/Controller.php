<?php namespace WxHotel\Http\Controllers\Console;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {
	const CODE_PARAM = -1;
	const PARAM_MSG = '参数异常';
	const CODE_ERROR = 0;
	const ERROR_MSG = '错误';
	const CODE_FAIL = 2;
	const FAIL_MSG = '失败';
	const CODE_SUCCESS = 1;
	const SUCCESS_MSG = '成功';
	const PWD_ERROR_MSG = '密码错误';
	const USER_ERROR_MSG = '用户不存在';
	const NO_AUTH_MSG = '无权限';
	const PARAM_INVALID_MSG = '非法格式';
	const USER_EXIST_MSG = '用户已经存在';
	const NO_EXIST_MSG = '不存在';
	use DispatchesCommands, ValidatesRequests;

}
