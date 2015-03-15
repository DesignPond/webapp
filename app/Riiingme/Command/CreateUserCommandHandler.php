<?php namespace Riiingme\Command;

use Laracasts\Commander\Events\DispatchableTrait;

use Laracasts\Commander\CommandHandler;
use Riiingme\Helpers\Helper;
use Riiingme\User\Repo\UserInterface;
use Riiingme\Invite\Repo\InviteInterface;
use Riiingme\User\Validation\CreateUserValidation;
use Riiingme\Riiinglink\Repo\RiiinglinkInterface;

class CreateUserCommandHandler implements CommandHandler {

    use DispatchableTrait;

    protected $user;
    protected $invite;
    protected $validator;
    protected $riiinglink;
    protected $helper;

    public function __construct(UserInterface $user, InviteInterface $invite, CreateUserValidation $validator, RiiinglinkInterface $riiinglink)
    {
        $this->user       = $user;
        $this->invite     = $invite;
        $this->validator  = $validator;
        $this->riiinglink = $riiinglink;
        $this->helper     = new Helper();
    }

    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

        $this->validator->validate(array(
            'first_name'            => $command->first_name,
            'last_name'             => $command->last_name,
            'email'                 => $command->email,
            'company'               => $command->company,
            'user_type'             => $command->user_type,
            'password'              => $command->password,
            'password_confirmation' => $command->password_confirmation
        ));

        // Make activation token
        $activation_token = md5( $command->email.\Carbon\Carbon::now() );

        // Create user
        $user = $this->user->create(array(
            'first_name'       => $command->first_name,
            'last_name'        => $command->last_name,
            'email'            => $command->email,
            'company'          => $command->company,
            'user_type'        => $command->user_type,
            'password'         => \Hash::make($command->password),
            'activation_token' => $activation_token
        ));

        $this->dispatchEventsFor($user);

        \Auth::login($user);

        return $user;

    }

}