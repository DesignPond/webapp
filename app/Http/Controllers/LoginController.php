<?php

use Laracasts\Commander\CommanderTrait;
use Riiingme\Invite\Repo\InviteInterface;
use Riiingme\User\Repo\UserInterface;

class LoginController extends \BaseController {

	use CommanderTrait;

	protected $invite;
	protected $user;

	public function __construct(UserInterface $user, InviteInterface $invite)
	{
		$this->user   = $user;
		$this->invite = $invite;

	}
	/**
	 * Display a listing of the resource.
	 * GET /login
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check())
		{
			return Redirect::to('user');
		}

        return View::make('login.index');
	}

	public function invite($token,$ref)
	{

		// validate token
		$invite = $this->invite->validate($token);
		$invite = (!$invite->isEmpty() ? $invite->first() : null);

		// Decode from email
		$email  = base64_decode($ref);

		// Find registered user if any
		$user  = $this->user->findByEmail($email);
		$user = (!$user->isEmpty() ? $user->first() : null);

		/*
		echo '<pre>';
		print_r($inviteFound);
		echo '</pre>';exit;
		*/

		// Token checks out
		if($invite && $user)
		{
			// User is registred
			$this->execute('Riiingme\Command\CreateRiiinglinkCommand', array('invite' => $invite, 'user' => $user));

			return Redirect::to('user');
		}
		elseif($invite && !$user)
		{
			// It's not a user yet, redirect to register form with from invitation id and email used
			return Redirect::to('register')->with(array('email' => $email, 'invite_id' => $invite->id ));
		}
		else
		{
			return Redirect::to('/')->with(array('error' => 'Problem avec le jeton'));
		}

	}

	/**
	 * Store a newly created resource in storage.
	 * POST /login
	 *
	 * @return Response
	 */
	public function store()
	{
        $user = array(
            'email'    => Input::get('email'),
            'password' => Input::get('password')
        );

        $cookie   = Input::get('cookie',null);
        $remember = ($cookie ? true : false);

        if (Auth::attempt($user,$remember)) {
            return Redirect::to('user')->with('success', 'Vous êtes connecté');
        }

        // authentication failure! lets go back to the login page
        return Redirect::to('login')
            ->with(array('status' => 'danger' , 'message' => 'Les identifiants email / mot de passe sont incorrects') )
            ->withInput();

	}

	/**
	 * Show the form for creating a new user
	 * GET /register
	 *
	 * @return Response
	 */
	public function register()
	{
		return View::make('login.register');
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /login/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
        Auth::logout();
        return Redirect::to('/');
	}

}