<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\Commands\CreateRiiinglink;

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

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth      = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * Register new user
     * GET /register
     *
     * @return Response
     */
    public function register()
    {
        return view('login.register');
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
            $invite->update(['invited_id' => $user->id]);

            // Create riiinglink between users
            $this->dispatch(new CreateRiiinglink($user,$invite));
        }

        return redirect($this->redirectPath());
    }

}
