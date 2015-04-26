<?php namespace App\Riiingme\User\Worker;

use Illuminate\Foundation\Bus\DispatchesCommands;

use App\Riiingme\User\Repo\UserInterface;
use App\Commands\ProcessInvite;
use App\Riiingme\Invite\Repo\InviteInterface;
use App\Riiingme\Label\Worker\LabelWorker;

class UserWorker{

    use DispatchesCommands;

    protected $user;
    protected $invite;
    protected $helper;
    protected $label;

    public function __construct(UserInterface $user, LabelWorker $label, InviteInterface $invite)
    {
        $this->user   = $user;
        $this->invite = $invite;
        $this->label  = $label;
        $this->helper = new \App\Riiingme\Helpers\Helper;
    }

    public function proceesPendingInvites($user){

        $pending = $this->invite->getToProcess($user);

        if(!$pending->isEmpty())
        {
            foreach($pending as $invite)
            {
                $this->dispatch(new ProcessInvite($invite->id));
                $invite->activated_at = date('Y-m-d G:i:s');
                $invite->save();
            }
        }
    }

}