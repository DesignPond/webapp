<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class ConfirmInvite extends Command implements SelfHandling {

    protected $invite;
    protected $user;
    protected $token;
    protected $ref;

    public function __construct($token,$ref ){
        $this->user   = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->invite = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $this->token  = $token;
        $this->ref    = $ref;
    }

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        // validate token
        $invite = $this->invite->validate($this->token);
        $invite = (!$invite->isEmpty() ? $invite->first() : null);

        // Decode from email
        $email  = base64_decode($this->ref);

        // Find registered user if any
        $user  = $this->user->findByEmail($email);
        $user = (!$user->isEmpty() ? $user->first() : null);

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

}
