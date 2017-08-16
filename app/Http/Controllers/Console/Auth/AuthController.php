<?php namespace WxHotel\Http\Controllers\Console\Auth;

use WxHotel\Http\Controllers\Console\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/


	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;
		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function getRegister()
	{
		return view('auth.register');
	}

	public function postRegister(Request $request)
	{

		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}
		$data = $request->all();
		$data['role'] = 'admin';
		$data['status'] = 1;
		$this->auth->login($this->registrar->create($data));

		return redirect($this->redirectPath());
	}

	public function getLogin(){
		$var = array();

		return view('auth.login',$var);
	}

	public function postLogin(Request $request){
		$this->validate($request, [
			'mobile' => 'required|regex:/^1[2-9]\d{9}$/|max:11',
			'password' => 'required',
		]);

		$credentials = $request->only('mobile', 'password');
		$credentials['status'] = 1;
		$credentials['role'] = 'admin';
		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
			->withInput($request->only('mobile', 'remember'))
			->withErrors([
				'mobile' => '没有找到用户或密码错误',
			]);
	}

	public function loginPath(){
		return '/admin/auth/login';
	}

	public function getLogout()
	{
		$this->auth->logout();

		return redirect('/');
	}

	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}
		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin';
	}
}
