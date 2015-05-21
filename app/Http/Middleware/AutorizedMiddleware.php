<?php namespace App\Http\Middleware;

use Closure;
use App\Riiingme\Riiinglink\Worker\RiiinglinkWorker;

class AutorizedMiddleware {

    /**
     * Riiinglink worker
     */
    protected $riiinglink;

    /**
     * Create a new filter instance.
     *
     * @param  RiiinglinkWorker  $riiinglink
     * @return void
     */
    public function __construct(RiiinglinkWorker $riiinglink)
    {
        $this->riiinglink = $riiinglink;
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
/*        if (\Auth::check()) {
            $id = $request->segment(3);

            // Get riiinglink from id
            $link = $this->riiinglink->riiinglinkItem($id);

            // Test if id is user_id from riinglink
            if ($link && (\Auth::user()->id != $link->host_id)) {
                return redirect('/');
            }

            return $next($request);
        }*/

        return $next($request);
	}

}
