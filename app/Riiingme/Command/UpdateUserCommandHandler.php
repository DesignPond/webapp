<?php namespace Riiingme\Command;

use Laracasts\Commander\CommandHandler;

use Riiingme\User\Repo\UserInterface;
use Riiingme\User\Validation\UpdateUserValidation;
use Laracasts\Validation\FormValidationException;

class UpdateUserCommandHandler implements CommandHandler {

    protected $user;
    protected $validator;

    public function __construct(UserInterface $user, UpdateUserValidation $validator)
    {
        $this->user       = $user;
        $this->validator  = $validator;
    }
    /**
     * Handle the command.
     *
     * @param object $command
     * @return void
     */
    public function handle($command)
    {

        $data = array(
            'id'         => $command->id,
            'first_name' => $command->first_name,
            'last_name'  => $command->last_name,
            'company'    => $command->company,
            'user_type'  => $command->user_type,
        );

        $this->validator->validate($data);

        $user = $this->user->find($command->id);

        if($command->email != $user->email)
        {
            $used = $this->user->findByEmail($command->email);

            if(!$used->isEmpty())
            {
                throw new FormValidationException('Validation failed', array('error' => 'Cet E-mail est déjà utilisé'));
            }
            else
            {
                $this->user->update(array('id' => $command->id ,'email' => $command->email));
            }
        }

        $user = $this->user->update($data);

        return $user;

    }

}