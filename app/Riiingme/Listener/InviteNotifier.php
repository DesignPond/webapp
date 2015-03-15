<?php namespace Riiingme\Listener;

use Laracasts\Commander\Events\EventListener;
use Riiingme\Event\InviteCreated;

class InviteNotifier extends EventListener {

    public function whenInviteCreated(InviteCreated $invite)
    {
        \Log::info('event fired');

        \Mail::send('emails.invitation', array('user' => $invite->invite->user_id, 'invite' => $invite->invite->invite_id), function($message) use ($invite)
        {
            $message->to($invite->invite->email, $invite->invite->email)->subject('Demande de partage');
        });
    }

}