<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Riiingme\Invite\Repo\InviteInterface;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;

use Illuminate\Http\Request;
use App\Commands\CreateRiiinglink;
use App\Commands\SendEmail;
use App\Commands\ProcessInvite;

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

	use AuthenticatesAndRegistersUsers;

    protected $redirectTo = '/user';

    protected $loginPath = '/';

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Les identifiants email / mot de passe ne correspondent pas.';
    }

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar, InviteInterface $invite, RiiinglinkInterface $riiinglink)
	{
		$this->auth      = $auth;
		$this->registrar = $registrar;
        $this->invite    = $invite;

        $this->riiinglink = $riiinglink;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Register new user
     * GET /register
     *
     * @return Response
     */
    public function register_private()
    {
        return view('auth.private');
    }

    /**
     * Register new user
     * GET /register
     *
     * @return Response
     */
    public function register_company()
    {
        return view('auth.company');
    }

    /**
     * Register new user
     * GET /register
     *
     * @return Response
     */
    public function activate()
    {
        return view('auth.activate');
    }


    /**
     * Destroy session
     *
     * @return Response
     */
    public function destroy()
    {
        \Auth::logout();
        return Redirect::to('/');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMesssage()
    {
        return 'Les identifiants email / mot de passe sont incorrects !';
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->registrar->validator($request->all());

        if ($validator->fails())
        {
            $this->throwValidationException( $request, $validator );
        }

        $user = $this->registrar->create($request->all());

        \Auth::login($user);

        $invite_id = $request->input('invite_id');

        if(isset($invite_id) && !empty($invite_id))
        {
            // find invite
            $invite = $this->invite->find($invite_id);

            // update with new user id
            $invite->invited_id = $user->id;
            $invite->save();

            // Create riiinglink between users
            $this->riiinglink->create(['host_id' => $invite->user_id, 'invited_id' => $invite->invited_id]);

            $this->dispatch(new SendEmail($invite->user_id,$invite->invited_id));
            $this->dispatch(new ProcessInvite($invite_id));

        }

        return redirect($this->redirectPath());
    }

}
