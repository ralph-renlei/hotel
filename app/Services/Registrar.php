<?php namespace WxHotel\Services;

use WxHotel\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|regex:/^[a-z0-9]{4,30}$/|max:30|min:4',
			'mobile' => 'required|regex:/^1[2-9]\d{9}$/|max:11|unique:users',
			'password' => 'required|confirmed|min:6|max:30',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		return User::create([
			'name' => $data['name'],
			'mobile' => $data['mobile'],
			'role' => $data['role'],
			'password' => bcrypt($data['password']),
			'status'=>$data['status'],
			'username'=>$data['username'],
		]);
	}

}
