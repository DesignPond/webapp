<?php namespace App\Riiingme\Activite\Worker;

use App\Riiingme\Activite\Worker\ChangeWorker;

class SendWorker{

    protected $change;

    public function __construct(ChangeWorker $change){

        $this->change  = $change;

    }


}