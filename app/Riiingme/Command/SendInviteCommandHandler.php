<?php namespace Riiingme\Command;

use Laracasts\Commander\CommandHandler;
use Riiingme\Invite\Repo\InviteInterface;
use Riiingme\Type\Repo\TypeInterface;
use Laracasts\Commander\Events\DispatchableTrait;

class SendInviteCommandHandler implements CommandHandler {

    use DispatchableTrait;

    protected $invite;
    protected $type;

    public function __construct( InviteInterface $invite, TypeInterface $type)
    {
        $this->invite = $invite;
        $this->type   = $type;
    }

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {
        $types = $this->type->getAll()->lists('titre','id');

        $partage_host    = ( !empty($command->partage_host) ? serialize($command->partage_host) : []);
        $partage_invited = ( !empty($command->partage_invited) ? serialize($command->partage_invited) : []);

        $data = array( 'user_id' => $command->user_id, 'email' => $command->email, 'partage_host' => $partage_host, 'partage_invited' => $partage_invited);

        $send = $this->invite->create( $data );

        $send_invite = $this->invite->find($send->id);
        $send_invite = $this->invite->setToken($send_invite->id);

        \Mail::send('emails.invitation', array('invite' => $send_invite, 'types' => $types, 'partage' => $command->partage_invited), function($message) use ($send_invite)
        {
            $message->to($send_invite->email, $send_invite->email)->subject('Demande de partage');
        });

    }

}