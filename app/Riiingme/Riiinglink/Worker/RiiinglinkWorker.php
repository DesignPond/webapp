<?php namespace App\Riiingme\Riiinglink\Worker;

use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;
use App\Riiingme\Riiinglink\Transformer\RiiinglinkTransformer;
use App\Riiingme\Groupe\Repo\GroupeInterface;
use App\Riiingme\Meta\Repo\MetaInterface;

use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class RiiinglinkWorker{

    protected $fractal;
    protected $riiinglink;
    protected $items;
    protected $groupe;
    protected $labels;
    protected $meta;
    protected $transformer;

    public function __construct(Manager $fractal, RiiinglinkInterface $riiinglink, GroupeInterface $groupe, MetaInterface $meta, RiiinglinkTransformer $transformer)
    {
        $this->fractal     = $fractal;
        $this->riiinglink  = $riiinglink;
        $this->groupe      = $groupe;
        $this->meta        = $meta;
        $this->transformer = $transformer;
        $this->helper      = new \App\Riiingme\Helpers\Helper;
    }

    public function generate(){

        $collection = new Collection($this->items, new RiiinglinkTransformer);
        $rootScope  = $this->fractal->createData($collection)->toArray();

        return $rootScope;
    }
/*
    public function getRiiinglinks($id,$single = null,$nbr = null){

        $this->items = ($single ? $this->riiinglink->find($id) : $this->riiinglinkCollection($id,$nbr));

        return $this->generate();
    }*/


    public function getRiiinglinkPrepared($id){

        $this->items = $this->riiinglink->find($id);

        return $this->generate();
    }

    /*
     * EGt latest riiinglinks list for user
     * */
    public function getLatest($user_id)
    {
        $latest = $this->riiinglink->latest($user_id);

        if(!$latest->isEmpty())
        {
            $latest = $latest->map(function($linked)
            {
                $labels = $linked->invite->labels;
                $photo  = $this->helper->getKeyValue($labels,'type_id',12);

                $photo = ($photo != '' ? $photo : 'avatar.jpg');
                $linked->setAttribute('photo',$photo);

                return $linked;
            });
        }

        return $latest;
    }

    public function riiinglinkItem($id)
    {
        return $this->riiinglink->find($id)->first();
    }
    /*
        public function riiinglinkCollection($user,$nbr = null){

            return $this->riiinglink->findBy($user,'hosted',$nbr);
        }

        public function riiinglinkCollectionPaginate($user,$params){

            return $this->riiinglink->findBy($user,'hosted',$params);
        }*/

    public function getRiiinglinkWithParams($user_id,$params)
    {
        $pagination = $this->riiinglink->findByHostWithParams($user_id,$params);

        if($pagination->count() > 0 )
        {
            $riiinglinks = $pagination->map(function($linked)
            {
                $labels = $linked->invite->labels;
                $photo  = $this->helper->getKeyValue($labels,'type_id',12);

                $photo = ($photo != '' ? $photo : 'avatar.jpg');
                $linked->setAttribute('photo',$photo);

                return $linked;
            });

            return [$pagination,$riiinglinks];
        }

        return [ [],[] ];
    }

    public function convert($riiinglinks,$user_labels){

        return $this->helper->convert($riiinglinks,$user_labels);
    }

    public function convertToGroupLabel(){

        $groupes = $this->groupe->getAll()->toArray();

        foreach($groupes as $groupe_type)
        {
            foreach($groupe_type['groupe_type'] as $type)
            {
                $data[$groupe_type['id']][] = $type['pivot']['type_id'];
            }
        }

        return ($data ? $data : []);

    }

    public function setMetasForRiiinglink($user_id,$id,$metas){

        $meta = $this->meta->findByRiiinglink($id);

        if(!$meta->isEMpty())
        {
            $meta     = $meta->first();
            $metas    = $this->transformer->getMetaLabelId($user_id,$metas);
            $newmetas = $this->updateMetas($meta,$metas);

            $meta->labels = serialize($newmetas);
            $meta->save();
        }
        else
        {
            $this->meta->create([
                'riiinglink_id' => $id,
                'label_id'      => 0,
                'labels'        => serialize($metas)
            ]);
        }

    }

    public function updateMetas($old,$new){

        $exist  = ($old->labels != '' ? unserialize($old->labels) : []);

        $result = $this->helper->addMetas($exist,$new);

        return $result;

    }

    public function createRiiinglink($host_id,$invited_id){

        return $this->riiinglink->create(['host_id' => $host_id, 'invited_id' => $invited_id]);

    }

}