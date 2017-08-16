<?php namespace WxHotel\Http\Controllers\Console\Auth;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use WxHotel\Http\Controllers\Console\Controller;
use WxHotel\Services\HPassword;
use Illuminate\Support\Facades\Auth;
use WxHotel\Services\Sms;
use WxHotel\SmsRecord;
use WxHotel\User;

class PasswordController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct()
	{

		$user = new User();
		$sms_record = new SmsRecord();
		$sms = new Sms($sms_record);
		$this->passwords = new HPassword($user,$sms,$sms_record);
		$this->middleware('guest');
	}
	public function index(){

		return view('auth.password');
	}
	public function getMobile()
	{
		return view('auth.password');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postMobile(Request $request)
	{
		$this->validate($request, ['mobile' => 'required|regex:/^1[2-9]\d{9}$/|max:11']);

		$response = $this->passwords->sendResetCode($request->only('mobile'), function($m)
		{
			$m->subject($this->getMobileSubject());
		});

		switch ($response)
		{
			case PasswordBroker::RESET_LINK_SENT:
				return redirect('/admin/password/reset');

			case PasswordBroker::INVALID_USER:
				return redirect()->back()->withErrors(['mobile' => trans($response)]);
		}
		return redirect()->back()->withErrors(['mobile' => trans($response)]);
	}

	/**
	 * Get the e-mail subject line to be used for the reset link email.
	 *
	 * @return string
	 */
	protected function getMobileSubject()
	{
		return isset($this->subject) ? $this->subject : '您的验证码已发';
	}

	/**
	 * Display the password reset view for the given token.
	 *
	 * @param  string  $token
	 * @return Response
	 */
	public function getReset()
	{
		return view('auth.reset');
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'mobile' => 'required|regex:/^1[2-9]\d{9}$/|max:11',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'mobile','token','password'
		);

		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = bcrypt($password);
			$user->save();
		});

		switch ($response)
		{
			case PasswordBroker::PASSWORD_RESET:
				return redirect($this->redirectPath());

			default:
				return redirect()->back()
					->withInput($request->only('mobile'))
					->withErrors(['mobile' => trans($response)]);
		}
	}

	/**
	 * Get the post register / login redirect path.
	 *
	 * @return string
	 */
	public function redirectPath()
	{
		if (property_exists($this, 'redirectPath'))
		{
			return $this->redirectPath;
		}

		return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin';
	}
}
