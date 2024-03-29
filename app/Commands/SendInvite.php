<?php namespace App\Commands;

use App\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class SendInvite extends Command implements SelfHandling {

    protected $invite;
    protected $type;
    protected $email;
    protected $user_id;
    protected $partage_host;
    protected $partage_invited;
    protected $riiinglink;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
    public function __construct($email, $user_id, $partage_host, $partage_invited)
    {
        $this->type            = \App::make('App\Riiingme\Type\Repo\TypeInterface');
        $this->invite          = \App::make('App\Riiingme\Invite\Repo\InviteInterface');
        $this->user            = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->riiinglink      = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->email           = $email;
        $this->user_id         = $user_id;
        $this->partage_host    = $partage_host;
        $this->partage_invited = $partage_invited;
    }

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        $types = $this->type->getAll()->lists('titre','id');

        $partage_host    = ( !empty($this->partage_host)    ? serialize($this->partage_host) : '');
        $partage_invited = ( !empty($this->partage_invited) ? serialize($this->partage_invited) : '');

        $data = array( 'user_id' => $this->user_id, 'email' => $this->email, 'partage_host' => $partage_host, 'partage_invited' => $partage_invited);

        $send_invite = $this->processInvite($data);
        $user = $this->user->find($this->user_id);

        $invited_exist = $this->user->findByEmail($this->email);
        if($invited_exist)
        {
            $invited_exist = true;
        }

        $link = $this->riiinglink->findLinkByEmailAndUserId($this->email, $this->user_id);

        \Mail::send('emails.invitation', ['invite' => $send_invite, 'user' => $user, 'types' => $types, 'partage' => $this->partage_invited, 'exist_already' => $link, 'invited_exist' => $invited_exist], function($message) use ($send_invite)
        {
            $message->to($send_invite->email, $send_invite->email)->subject('Demande de partage');
        });

	}

    public function processInvite($data){

        $exist = $this->inviteExist($data['user_id'],$data['email']);

        if($exist && $exist->invited_id == null)
        {
            $data['id'] = $exist->id;
            $send = $this->invite->update( $data );
        }
        else
        {
            $send = $this->invite->create( $data );
            $send = $this->invite->setToken($send->id);
        }

        return $send;
    }

    public function inviteExist($user_id,$email)
    {
        return $this->invite->exist($user_id,$email);
    }

}
