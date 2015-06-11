<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin {

    /** @var Guard */
    private $auth;

    function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if($this->auth->guest()) {
            return response('Unauthorized', 401);
        }
        $user = $this->auth->user()->load('role');
        if($user->role->role !== 'Admin') {
            return response('Unauthorized', 401);
        }
		return $next($request);
	}

}
