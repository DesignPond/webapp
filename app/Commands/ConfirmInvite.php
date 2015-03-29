<?php namespace App\Commands;

use App\Commands\Command;
use App\Commands\CreateRiiinglink;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Bus\DispatchesCommands;

class ConfirmInvite extends Command implements SelfHandling {

    use DispatchesCommands;

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

        // Decode from email
        $email  = base64_decode($this->ref);

        // Find registered user if any
        $user   = $this->user->findByEmail($email);

        // Token checks out
        if($invite && $user)
        {

            // Update invite with new user id
            $this->invite->invited_id = $this->user->id;
            $this->invite->save();

            // User is registred create riiinglink
            $this->dispatch(new CreateRiiinglink($user,$invite));

            // Log in the user
            \Auth::login($user);

            return ['status' => 'confirmed'];
        }
        elseif($invite && !$user)
        {
            if($email != $invite->email)
            {
                return ['status' => 'error'];
            }
            // It's not a user yet, redirect to register form with from invitation id and email used
            return ['status' => 'register', 'email' => $email, 'invite_id' => $invite->id];
        }
        else
        {
            return ['status' => 'error'];
        }
    }

}
