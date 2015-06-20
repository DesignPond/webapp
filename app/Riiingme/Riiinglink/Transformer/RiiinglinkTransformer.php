<?php
namespace App\Riiingme\Riiinglink\Transformer;

use App\Riiingme\Riiinglink\Entities\Riiinglink;
use App\Riiingme\Label\Entities\Label;
use League\Fractal;

class RiiinglinkTransformer extends Fractal\TransformerAbstract
{

    protected $user;
    protected $link;
    protected $label;
    protected $helper;

    public $host;
    public $invited;

    public function __construct()
    {
        $this->user   = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->link   = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label  = \App::make('App\Riiingme\Label\Repo\LabelInterface');
        $this->helper = new \App\Riiingme\Helpers\Helper;
    }

    /**
     * List of resources possible to include
     *
     * @var array
     */

    public function transform(Riiinglink $riiinglink)
    {
        $this->host    = $this->getUser($riiinglink->host_id);
        $this->invited = $this->getUser($riiinglink->invited_id);

        $invited_link  = $this->getInvited($riiinglink)->id;

        return [
            'id'             => (int) $riiinglink->id,
            'invited_link'   => (int) $invited_link,
            'invited_id'     => (int) $riiinglink->invited_id ,
            'host_photo'     => $this->host->user_photo,
            'host_name'      => $this->getName($this->host),
            'host_email'     => $this->host->email,
            'invited_photo'  => $this->invited->user_photo,
            'invited_name'   => $this->getName($this->invited),
            'invited_email'  => $this->invited->email,
            'host_labels'    => $this->getHostLabels($riiinglink),
            'invited_labels' => $this->getInvitedLabels($riiinglink),
            'tags'           => $this->getTags($riiinglink)
        ];
    }

    public function getUser($user_id)
    {
        return $this->user->find($user_id);
    }

    public function getName($user)
    {
        return (isset($user->company) && !empty($user->company) ? $user->company : $user->first_name.' '.$user->last_name );
    }

    public function getInvited($riiinglink)
    {
        $host_id    = $riiinglink->host_id;
        $invited_id = $riiinglink->invited_id;

        return $this->link->findByHostAndInvited($invited_id,$host_id);
    }

    public function getTags($riiinglink)
    {
        if(isset($riiinglink->tags) && !empty($riiinglink->tags))
        {
            return $riiinglink->tags->lists('title');
        }

        return '';
    }

    public function getHostLabels($riiinglink){

        if(isset($riiinglink->usermetas->labels) && !empty($riiinglink->usermetas->labels))
        {
            $data = unserialize($riiinglink->usermetas->labels);

            return $this->getLabels($data);
        }

        return [];
    }

    public function userHasPeriodRange($user,$groupe)
    {
        $isGroupe = [ 2 => 4, 3 => 5 ];

        if(isset($isGroupe[$groupe]) && isset($user->user_groups))
        {
            $dates = $user->user_groups->filter(function ($item) use ($groupe,$isGroupe) {
                return $item->pivot->groupe_id == $isGroupe[$groupe];
            })->first();

            if ($dates)
            {
                $start = \Carbon\Carbon::parse($dates->pivot->start_at);
                $end   = \Carbon\Carbon::parse($dates->pivot->end_at);
                $now   = \Carbon\Carbon::now();

                return ($start < $now && $end > $now ? true : false);
            }

            return false;
        }

        return false;
    }

    public function getInvitedLabels($riiinglink){

        $link = $this->getInvited($riiinglink);

        if($link)
        {
            if(isset($link->usermetas->labels))
            {
                $data = unserialize($link->usermetas->labels);
                return $this->getLabels($data,true);
            }

            return [];
        }

        return [];

    }

    public function getLabelItem($id){

        $label = $this->label->find($id);

        if( $label && !empty($label->label)){

            return $label->label_text;
        }

        return '';
    }

    /*
     * Labels and change if there is a period in effect
     * */
    public function getLabels($data,$invited = null)
    {
        if(!empty($data))
        {
            $labels = [];

            $isNormalGroupe = [1,2,3,6];
            $isGroupeUnset  = [4 => 2, 5 => 3];

            foreach($data as $groupe_id => $groupe)
            {
                //$hasPeriodRange = $this->userHasPeriodRange($this->invited,$groupe_id);

                /*
                if($invited && $hasPeriodRange)
                {
                    if(in_array($groupe_id,$isGroupeUnset) )
                    {
                        $labels = $labels + $this->getInvitedGroupLabels($groupe_id);
                    }
                }
                */
                //else
                //{
                    //if(in_array($groupe_id,$isNormalGroupe))
                    //{
                        foreach($groupe as $type => $id)
                        {
                            $labels[$groupe_id][$type] = $this->getLabelItem($id);
                        }
                   // }
                //}
            }

            return $labels;
        }

        return [];
    }

    public function getInvitedGroupLabels($group)
    {
        $labels   = $this->invited->labels;
        $data     = [];
        $isGroupe = [ 2 => 4, 3 => 5 ];

        if(!$labels->isEmpty())
        {
            foreach($labels as $label)
            {
                if($isGroupe[$group] == $label->groupe_id)
                {
                    $data[$label->groupe_id][$label->type_id] = $label->label_text;
                }
            }
        }

        return $data;
    }

    public function getMetaLabelId($user_id,$metas){

        if(!empty($metas))
        {
            $labels = [];

            foreach($metas as $groupe_id => $types)
            {
                foreach($types as $type_id)
                {
                    $label = $this->label->findByUserGroupeType($user_id,$groupe_id,$type_id);

                    if(!$label->isEmpty())
                    {
                        $labels[$groupe_id][$type_id] = $label->first()->id;
                    }
                }
            }

            return $labels;
        }

        return [];
    }

}
