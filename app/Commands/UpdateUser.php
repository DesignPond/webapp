<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class UpdateUser extends Command implements SelfHandling {

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($infos)
	{
        $this->infos = $infos;
        $this->user  = \App::make('App\Riiingme\User\Repo\UserInterface');
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        $this->validator->validate($this->infos);

        $user = $this->user->find($this->infos['id']);

        if($this->infos['email'] != $user->email)
        {
            $used = $this->user->findByEmail($this->infos['email']);

            if(!$used->isEmpty())
            {
                throw new FormValidationException('Validation failed', array('error' => 'Cet E-mail est déjà utilisé'));
            }
            else
            {
                $this->user->update(array('id' => $this->infos['id'] ,'email' => $this->infos['email']));
            }
        }

        $user = $this->user->update($this->infos);

        return $user;


    }

}
