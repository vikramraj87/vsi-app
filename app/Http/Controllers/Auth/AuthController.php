<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    /**
     * @var Guard
     */
    protected $auth;

    /**
     * @var Registrar
     */
    protected $registrar;

    public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => ['user', 'logout']]);
        $this->middleware('auth', ['except' => 'authenticate']);
	}

    public function authenticate(Request $request)
    {
        $email = urldecode($request->input('email'));
        $password = urldecode($request->input('password'));

        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->jsend('fail', [
                'reason' => 'ValidationFailed',
                'errors' => $validator->errors()->all()
            ]);
        }

        $result = $this->auth->attempt($credentials);

        if(false === $result) {
            return response()->jsend('fail', [
                'reason' => 'InvalidCredentials'
            ]);
        }

        return response()->jsend('success', $this->auth->user()->load('role'));
    }

    public function user()
    {
        if($this->auth->guest()) {
            return response()->jsend('fail', [
                'reason' => 'Guest'
            ]);
        }
        return response()->jsend('success', $this->auth->user()->load('role'));
    }

    public function logout()
    {
        $this->auth->logout();
        return response()->jsend('success');
    }

}
