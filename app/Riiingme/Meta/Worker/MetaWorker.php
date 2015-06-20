<?php namespace App\Riiingme\Meta\Worker;

use App\Riiingme\Meta\Repo\MetaInterface;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;

class MetaWorker{

    protected $meta;
    protected $riiinglink;

    public function __construct(MetaInterface $meta,RiiinglinkInterface $riiinglink)
    {
        $this->meta       = $meta;
        $this->riiinglink = $riiinglink;
    }

    public function getMetas($id){

        $metas = $this->meta->findByRiiinglink($id);

        if(!$metas->isEmpty())
        {
            $metas = $metas->first();
            $metas = unserialize($metas->labels);
        }

        return ($metas ? $metas : [] );
    }

    public function getUserMetas($id){

        $riiinglink = $this->reverseLink($id);

        if($riiinglink)
        {
            $metas = $this->getMetas($riiinglink->id);

            return $metas;
        }

        return [];

    }

    public function reverseLink($id){

        $riiinglink = $this->riiinglink->find($id)->first();

        if($riiinglink)
        {
           return $this->riiinglink->findByHostAndInvited($riiinglink->invited_id, $riiinglink->host_id);
        }

        return false;
    }

    public function getInvitedEmail($id){

        $riiinglink = $this->riiinglink->find($id)->first();

        if($riiinglink)
        {
            $riiinglink->load('host');

            return $riiinglink->host->email;
        }
    }

    public function getPartageMetas($id)
    {
        if ($this->sharedMeta($id))
        {
            $metas = $this->getMetas($id);

            return $metas;
        }

        return [];
    }

    public function sharedMeta($id){

        $metas = $this->meta->findByRiiinglink($id);

        if(!$metas->isEmpty())
        {
            $riiinglink  = $this->riiinglink->find($metas->first()->riiinglink_id);
            $currentUser = \Auth::user()->id;

            if (!$riiinglink->isEmpty())
            {
                $link = $riiinglink->first();

                return ($currentUser == $link->invited_id ? true : false);
            }
        }

        return false;
    }

    public function getMetasInGroups($id){

       $metas = $this->getMetas($id);

       return $this->dispatchInGroups($metas);

    }

    public function dispatchInGroups($collection){

        $data = array();

        if(!$collection->isEmpty())
        {
            $collection = $collection->toArray();

            foreach($collection as $meta)
            {
                $data[$meta['labels']['groupe_id']][] = $meta['label_id'];
            }
        }

        return $data;

    }

    public function destroy($id){

        $metas = $this->meta->findByRiiinglink($id);

        if(!$metas->isEmpty())
        {
            $metas->delete($id);
        }
    }
}
