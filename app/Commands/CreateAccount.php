<?php namespace App\Commands;

use App\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;

class CreateAccount extends Command implements SelfHandling {

    protected $data;
    protected $user;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($data)
	{
        $this->user = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->data = $data;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        $date = \Carbon\Carbon::now();
        $activation_token = md5($this->data['email'].$date);

        $user = $this->user->create([
            'email'            => $this->data['email'],
            'password'         => bcrypt($this->data['password']),
            'first_name'       => (isset($this->data['first_name']) && !empty($this->data['first_name']) ? $this->data['first_name'] : ''),
            'last_name'        => (isset($this->data['last_name']) && !empty($this->data['last_name']) ? $this->data['last_name'] : ''),
            'company'          => (isset($this->data['company']) && !empty($this->data['company']) ? $this->data['company'] : ''),
            'user_type'        => $this->data['user_type'],
            'activation_token' => $activation_token
        ]);

        \Event::fire(new \App\Events\AccountWasCreated($user));

        return $user;
	}

}
