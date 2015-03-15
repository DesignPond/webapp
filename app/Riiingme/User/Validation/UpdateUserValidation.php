<?php namespace Riiingme\User\Validation;

use Laracasts\Validation\FormValidator;

class UpdateUserValidation extends FormValidator {

    /**
     * Validation rules for logging in
     *
     * @var array
     */
    protected $rules = [
        'first_name' => 'required_if:user_type,private',
        'last_name'  => 'required_if:user_type,private',
        'company'    => 'required_if:user_type,company',
        'user_type'  => 'required'
    ];

    /**
     * Validation messages
     */
    protected $messages = [
        'first_name.required_if'  => 'Un Prénom est requis avec un compte privé',
        'last_name.required_if'   => 'Un nom est requis avec un compte privé',
        'company.required_if'     => 'Un nom est requis avec un compte d\'entreprise'
    ];

}