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

    public function __construct()
    {
        $this->user  = \App::make('App\Riiingme\User\Repo\UserInterface');
        $this->link  = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
        $this->label = \App::make('App\Riiingme\Label\Repo\LabelInterface');
    }

    /**
     * List of resources possible to include
     *
     * @var array
     */

    public function transform(Riiinglink $riiinglink)
    {
        return [
            'id'             => (int) $riiinglink->id,
            'invited_id'     => (int) $riiinglink->invited_id ,
            'host_photo'     => $this->getPhoto($riiinglink->host_id),
            'host_name'      => $this->getName($riiinglink->host_id),
            'host_email'     => $this->getEmail($riiinglink->host_id),
            'invited_photo'  => $this->getPhoto($riiinglink->invited_id),
            'invited_name'   => $this->getName($riiinglink->invited_id),
            'invited_email'  => $this->getEmail($riiinglink->invited_id),
            'host_labels'    => $this->getHostLabels($riiinglink),
            'invited_labels' => $this->getInvitedLabels($riiinglink),
        ];
    }

    public function getUser($user_id)
    {
        return $this->user->find($user_id);
    }

    public function getName($user_id)
    {
        $user = $this->getUser($user_id);

        return (isset($user->company) && !empty($user->company) ? $user->company : $user->first_name.' '.$user->last_name );

    }

    public function getEmail($user_id)
    {
        $user = $this->user->find($user_id);

        return $user->email;
    }

    public function getPhoto($user_id)
    {
        $photo  = $this->label->findPhotoByUser($user_id);

        return (isset($photo) && !empty($photo->label) ? $photo->label : 'avatar.jpg');
    }

    public function getInvited($riiinglink)
    {
        $host_id    = $riiinglink->host_id;
        $invited_id = $riiinglink->invited_id;

        return $this->link->findByHostAndInvited($invited_id,$host_id);

    }

    public function getHostLabels($riiinglink){

        if(isset($riiinglink->usermetas->labels) && !empty($riiinglink->usermetas->labels))
        {
            $data = unserialize($riiinglink->usermetas->labels);

            return $this->getLabels($data);
        }

        return [];
    }

    public function getInvitedLabels($riiinglink){

        $link = $this->getInvited($riiinglink);

        if($link)
        {
            $data = unserialize($link->usermetas->labels);

            return $this->getLabels($data);
        }

        return [];
    }

    public function getLabelItem($id){

        $label = $this->label->find($id);

        if( $label && !empty($label->label)){

            return $label->label;
        }

        return '';
    }

    public function getLabels($data)
    {

        if(!empty($data))
        {
            $labels = [];

            foreach($data as $groupe_id => $groupe)
            {
                foreach($groupe as $type => $id)
                {
                    $labels[$groupe_id][$type] = $this->getLabelItem($id);
                }
            }

            return $labels;
        }

        return [];
    }

}
