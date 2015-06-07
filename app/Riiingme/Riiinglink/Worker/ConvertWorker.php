<?php namespace App\Riiingme\Riiinglink\Worker;

use App\Riiingme\User\Repo\UserInterface;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Meta\Repo\MetaInterface;

class ConvertWorker{

    protected $label;
    protected $meta;
    protected $riiinglink;
    protected $user;

    public $labels = [];
    public $userGroup;
    public $metas = [];

    public function __construct( RiiinglinkInterface $riiinglink, GroupeInterface $groupe, MetaInterface $meta, UserInterface $user)
    {
        $this->riiinglink  = $riiinglink;
        $this->groupe      = $groupe;
        $this->meta        = $meta;
        $this->user        = $user;
        $this->helper      = new \App\Riiingme\Helpers\Helper;
    }

    public function loadUserLabels($riiinglink)
    {
        $labels = $this->user->find($riiinglink->invited_id);
        $metas  = $this->meta->findByRiiinglink($riiinglink->id);

        $this->metas     = (!$metas->isEmpty() ? unserialize($metas->first()->labels) : '');
        $this->labels    = $labels->labels;
        $this->userGroup = $labels->users_groups;

        return $this;
    }

    public function labelsInEffect()
    {
        return array_map("array_keys", $this->metas);
        $metas = array_map("array_keys", $this->metas);

    }

    public function userHasPeriodRange($user_groups,$groupe)
    {
        $isGroupe = [
            2 => 4,
            3 => 5
        ];

        if(isset($isGroupe[$groupe]) && isset($user_groups))
        {
            $dates = $user_groups->filter(function ($item) use ($groupe,$isGroupe) {
                return $item->pivot->groupe_id == $isGroupe[$groupe];
            })->first();

            if ($dates)
            {
                $start = \Carbon\Carbon::parse($dates->pivot->start_at);
                $end   = \Carbon\Carbon::parse($dates->pivot->end_at);

                return ($start < \Carbon\Carbon::now() && $end > \Carbon\Carbon::now() ? true : false);
            }

            return false;
        }

        return false;
    }

}