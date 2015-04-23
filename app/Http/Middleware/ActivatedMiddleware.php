<?php namespace App\Http\Middleware;

use Closure;
use App\Riiingme\User\Repo\UserInterface;

class ActivatedMiddleware {

    protected $user;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
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
        $user = $this->user->find(\Auth::user()->id);

      /*  if(!$user->activated_at)
        {
            return redirect('auth/activate');
        }*/

		return $next($request);
	}

}
