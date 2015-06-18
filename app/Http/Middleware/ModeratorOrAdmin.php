<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Kivi\Services\Response\Jsend\Failure\Failure401;

class ModeratorOrAdmin {

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
        $role = $this->auth->guest() ? 'Guest' : $this->auth->user()->role->role;

        if($role === 'Admin' || $role === 'Mod') {
            return $next($request);
        }

        return response()->jsend(new Failure401());
    }

}
