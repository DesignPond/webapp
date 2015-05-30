<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Riiingme\Activite\Worker\ChangeWorker;
use App\Riiingme\Activite\Worker\SendWorker;
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

    protected $worker;
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
    public function __construct(SendWorker $worker,ChangeWorker $change, UserInterface $user, TypeInterface $type, GroupeWorker $groupe)
    {
        parent::__construct();

        $this->changes = $change;
        $this->user    = $user;
        $this->type    = $type;
        $this->worker  = $worker;
        $this->groupe  = $groupe;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $interval = $this->option('interval');

        $types    = $this->type->getAll()->lists('titre','id');
        $groupes  = $this->groupe->getGroupes();
        unset($groupes[1]);

        $users = $this->worker->setInterval($interval)->getUsers()->send();

        if(!empty($users))
        {
            foreach($users as $user)
            {
                \Mail::send('emails.changement', array('types' => $types, 'groupes_titres' => $groupes, 'data' => $user['invite']) , function($message) use ($user)
                {
                    $message->to($user['email'])->subject('Notification de changement du partage');
                });
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
