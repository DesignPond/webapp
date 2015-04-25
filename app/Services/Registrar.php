<?php namespace App\Services;

use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Illuminate\Foundation\Bus\DispatchesCommands;

class Registrar implements RegistrarContract {

    protected $user;
    protected $label;

    use DispatchesCommands;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->user  = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->label = \App::make('App\Riiingme\Label\Repo\LabelInterface');
    }

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
            'first_name' => 'required_if:user_type,private|max:255',
            'last_name'  => 'required_if:user_type,private|max:255',
            'company'    => 'required_if:user_type,company|max:255',
            'user_type'  => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed|min:6',
            'my_name'    => 'honeypot',
            'my_time'    => 'required|honeytime:5'
		],
        [
            'first_name.required_if' => 'Pour un compte privé le prénom est requis',
            'last_name.required_if'  => 'Pour un compte privé le nom est requis',
            'company.required_if'    => 'Pour un compte entreprise un nom est requis',
            'email.unique'           => 'Cet email est déjà utilisé',
        ]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
        $date = \Carbon\Carbon::now();
        $activation_token = md5($data['email'].$date);

        $user = $this->user->create([
            'email'            => $data['email'],
            'password'         => bcrypt($data['password']),
            'first_name'       => (isset($data['first_name']) && !empty($data['first_name']) ? $data['first_name'] : ''),
            'last_name'        => (isset($data['last_name']) && !empty($data['last_name']) ? $data['last_name'] : ''),
            'company'          => (isset($data['company']) && !empty($data['company']) ? $data['company'] : ''),
            'user_type'        => $data['user_type'],
            'activation_token' => $activation_token
        ]);

        $this->label->create([
            'label'     => $data['email'],
            'user_id'   => $user->id,
            'type_id'   => 1,
            'groupe_id' => 1
        ]);

        $invite_id = (isset($data['invite_id']) && !empty($data['invite_id']) ? $data['invite_id'] : null);

        \Event::fire(new \App\Events\AccountWasCreated($user,$invite_id));

        return $user;

	}

}
