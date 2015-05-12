<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Riiingme\Activite\Worker\ChangeWorker;
use App\Riiingme\Groupe\Worker\GroupeWorker;
use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Type\Repo\TypeInterface;

class SendChange extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'change:send';

    protected $user;

    protected $change;

    protected $type;

    protected $groupe;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send changes to users from invited';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChangeWorker $change, UserInterface $user, TypeInterface $type, GroupeWorker $groupe)
    {
        parent::__construct();

        $this->changes = $change;
        $this->user    = $user;
        $this->type    = $type;
        $this->groupe  = $groupe;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $types   = $this->type->getAll()->lists('titre','id');
        $groupes = $this->groupe->getGroupes();
        unset($groupes[1]);

        $interval = $this->option('interval');

        // Get all users who want notifications every week
        $users = $this->user->getAll($interval);

        // Get all users who have made updates last week
        $all   = $this->changes->setPeriod($interval)->getUsersHaveUpdate();

        foreach ($users as $user)
        {
            // Load user riiinglinks to get all invited
            $invited   = $user->load('riiinglinks')->riiinglinks->lists('invited_id');
            // If the invited have updates get them
            $intersect = array_intersect($all,$invited);

            $this->changes->setUser($user->id)->setPeriod($user->notification_interval);
            $data = $this->changes->allChanges();

            if(!empty($intersect))
            {
                $ids = $this->user->getEmails($intersect);

                if(!empty($data))
                {
                    \Mail::send('emails.changement', array('user' => $user, 'types' => $types, 'groupes_titres' => $groupes, 'data' => $data) , function($message) use ($ids)
                    {
                        $message->to($ids)->subject('Notification de changement du partage');
                    });
                }
            }
        }

    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['interval', null, InputOption::VALUE_REQUIRED, 'Interval option.', null],
        ];
    }

}
