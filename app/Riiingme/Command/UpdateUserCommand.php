<?php namespace Riiingme\Command;

class UpdateUserCommand {

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $company;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $user_type;

    /**
     * @param string id
     * @param string first_name
     * @param string last_name
     * @param string company
     * @param string email
     * @param string user_type
     */
    public function __construct($id, $first_name, $last_name, $company, $email, $user_type)
    {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->company = $company;
        $this->email = $email;
        $this->user_type = $user_type;
    }

}