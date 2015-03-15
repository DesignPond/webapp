<?php namespace Riiingme\Command;

use Laracasts\Commander\CommandHandler;

use Riiingme\User\Repo\UserInterface;
use Riiingme\Invite\Repo\InviteInterface;
use Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use Riiingme\Label\Worker\LabelWorker;

class CreateRiiinglinkCommandHandler implements CommandHandler {

    protected $user;
    protected $invite;
    protected $label;
    protected $riiinglink;

    public function __construct(UserInterface $user, InviteInterface $invite, RiiinglinkInterface $riiinglink, LabelWorker $label)
    {
        $this->user       = $user;
        $this->invite     = $invite;
        $this->label      = $label;
        $this->riiinglink = $riiinglink;
    }

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

          // Create riiinglink
          $host    = $this->riiinglink->create(['host_id' => $command->invite->user_id, 'invited_id' => $command->user->id]);
          $invited = $this->riiinglink->create(['host_id' => $command->user->id, 'invited_id' => $command->invite->user_id]);

          // infos to partage
          $partage_host    = $command->invite->partage_host;
          $partage_invited = $command->invite->partage_invited;

          // get riiinglinks to sync
          $riiinglink_host    = $this->riiinglink->find($host->id)->first();
          $riiinglink_invited = $this->riiinglink->find($invited->id)->first();

          // get labels to sync
          $metas_host    = $this->label->labelForUser($partage_host,$command->invite->user_id);
          $metas_invited = $this->label->labelForUser($partage_invited,$command->user->id);

          // Sync metas
          $riiinglink_host->labels()->sync($metas_host);

          if($metas_invited)
          {
              $riiinglink_invited->labels()->sync($metas_invited);
          }

          // Log in the user
          \Auth::login($command->user);

    }

}