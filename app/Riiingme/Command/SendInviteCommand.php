<?php namespace Riiingme\Command;

class SendInviteCommand {

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $user_id;

    /**
     * @var string
     */
    public $partage_host;

    /**
     * @var string
     */
    public $partage_invited;

    /**
     * @param string email
     * @param string user_id
     * @param string partage_host
     * @param string partage_invited
     */
    public function __construct($email, $user_id, $partage_host, $partage_invited)
    {
        $this->email   = $email;
        $this->user_id = $user_id;
        $this->partage_host    = $partage_host;
        $this->partage_invited = $partage_invited;
    }

}