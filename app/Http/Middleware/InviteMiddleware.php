<?php namespace App\Http\Middleware;

use Closure;
use App\Riiingme\Invite\Repo\InviteInterface;

class InviteMiddleware {

    protected $invite;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(InviteInterface $invite)
    {
        $this->invite = $invite;
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

		return $next($request);
	}

}
