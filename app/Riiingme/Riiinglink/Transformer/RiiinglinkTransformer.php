<?php
namespace App\Riiingme\Riiinglink\Transformer;

use App\Riiingme\Riiinglink\Entities\Riiinglink;
use App\Riiingme\Label\Entities\Label;
use League\Fractal;

class RiiinglinkTransformer extends Fractal\TransformerAbstract
{

    public function __construct()
    {
        $this->user = \App::make('App\Riiingme\User\Repo\UserInterface');
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
            'invited_id'     => $riiinglink->invited_id ,
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

    public function getName($user_id)
    {
        $user = $this->user->find($user_id);

        return (isset($user->company) && !empty($user->company) ? $user->company : $user->first_name.' '.$user->last_name );

    }

    public function getEmail($user_id)
    {
        $user = $this->user->find($user_id);

        return $user->email;
    }

    public function getPhoto($user_id)
    {
        $photo  = Label::where('user_id','=',$user_id)->where('type_id','=',13)->get();

        return (isset($photo[0]) ? $photo[0]->label : 'avatar.jpg');
    }

    public function getInvited($riiinglink)
    {
        $host_id    = $riiinglink->host_id;
        $invited_id = $riiinglink->invited_id;

        return Riiinglink::where('host_id','=',$invited_id)->where('invited_id','=',$host_id)->get();
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

        if(!$link->isEmpty()){

            $link = $link->first();

            $data = unserialize($link->usermetas->labels);

            return $this->getLabels($data);
        }

        return [];
    }

    public function getLabelItem($id){

        $label =  \App\Riiingme\Label\Entities\Label::where('id','=',$id)->get();

        if(!$label->isEmpty()){

            return $label->first()->label;
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
