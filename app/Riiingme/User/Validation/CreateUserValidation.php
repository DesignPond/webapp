<?php namespace Riiingme\User\Validation;

use Laracasts\Validation\FormValidator;

class CreateUserValidation extends FormValidator {

    /**
     * Validation rules for logging in
     *
     * @var array
     */
    protected $rules = [
        'first_name' => 'required_if:user_type,private',
        'last_name'  => 'required_if:user_type,private',
        'company'    => 'required_if:user_type,company',
        'user_type'  => 'required',
        'email'      => 'required|email|unique:users',
        'password'   => 'required|confirmed'
    ];


    /**
     * Validation messages
     */
    protected $messages = [
        'first_name.required_if'  => 'Un Prénom est requis avec un compte privé',
        'last_name.required_if'   => 'Un nom est requis avec un compte privé',
        'company.required_if'     => 'Un nom est requis avec un compte d\'entreprise',
        'email.required'          => 'Le champs E-mail est requis'
    ];

}