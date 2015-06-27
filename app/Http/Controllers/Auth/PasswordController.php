<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Riiingme\User\Repo\UserInterface;

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

	use ResetsPasswords;

    protected $redirectTo = '/user';
    protected $user;

	/**
	 * Create a new password controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
	 * @return void
	 */
	public function __construct(Guard $auth, PasswordBroker $passwords, UserInterface $user)
	{
		$this->auth = $auth;
		$this->passwords = $passwords;
        $this->user      = $user;

        $this->subject = trans('message.recoverpassword_msg'); //  < --JUST ADD THIS LINE

		$this->middleware('guest');
	}

    /**
     * Display the password new form
     *
     * @return Response
     */
    public function getNew()
    {
        return view('auth.new');
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
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwords->reset($credentials, function($user, $password)
        {
            $user->password = bcrypt($password);

            $user->save();

            $this->auth->login($user);
        });

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                return redirect($this->redirectPath())->with( array('status' => 'success' , 'message' => trans($response)) );

            default:
                return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function postDefine(Request $request)
    {

        $v = \Validator::make($request->all(), [
            'email'        => 'required|email',
            'password'     => 'required|different:old_password|min:6',
            'old_password' => 'required',
        ],[
            'password.different' => 'Le champ nouveau mot de passe doit être différent du mot de passe actuel',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withErrors($v->errors());
        }

        $email        = $request->input('email');
        $password     = $request->input('password');
        $old_password = $request->input('old_password');

        if (\Auth::attempt(['email' => $email, 'password' => $old_password]))
        {
            $user = \Auth::user();
            $user->password = bcrypt($password);

            $user->save();

            \Auth::login($user);

            return redirect('user')->with(['status' => 'success', 'message' => trans('message.changed_password') ]);
        }

        return redirect()->back()->with(['status' => 'danger', 'message' => trans('message.wrong_credentials')])->withInput($request->only('email'));

    }

}
