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

    public function __construct(Manager $fractal, RiiinglinkInterface $riiinglink, GroupeInterface $groupe, MetaInterface $meta)
    {
        $this->fractal    = $fractal;
        $this->riiinglink = $riiinglink;
        $this->groupe     = $groupe;
        $this->meta       = $meta;
        $this->helper     = new \App\Riiingme\Helpers\Helper;
    }

    public function generate(){

        $collection = new Collection($this->items, new RiiinglinkTransformer);
        $rootScope  = $this->fractal->createData($collection)->toArray();

        return $rootScope;
    }

    public function getRiiinglinks($id,$single = null,$nbr = null){

        $this->items = ($single ? $this->riiinglink->find($id) : $this->riiinglinkCollection($id,$nbr));

        return $this->generate();
    }

    public function getLatest($user_id)
    {
        $latest = $this->riiinglink->latest($user_id);

        if(!$latest->isEmpty())
        {
            $latest = $latest->map(function($linked)
            {
                $labels = $linked->invite->labels;
                $photo  = $this->helper->getKeyValue($labels,'type_id',12);

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

    public function riiinglinkCollection($user,$nbr = null){

        return $this->riiinglink->findBy($user,'hosted',$nbr);

    }

    public function riiinglinkCollectionPaginate($user){

        return $this->riiinglink->findBy($user,'hosted');

    }

    public function getRiiinglinkWithParams($user_id,$params)
    {
        $items =  $this->riiinglink->findByHostWithParams($user_id,$params);

        $collection = new Collection($items, new RiiinglinkTransformer);
        $rootScope  = $this->fractal->createData($collection)->toArray();

        return [$rootScope,$items];
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

    public function setMetasForRiiinglink($id,$metas){

        $meta = $this->meta->findByRiiinglink($id);

        if(!$meta->isEMpty())
        {
            $meta     = $meta->first();
            $newmetas = $this->updateMetas($meta,unserialize($metas));

            $meta->labels = $newmetas;
            $meta->save();
        }
        else
        {
            $this->meta->create([
                'riiinglink_id' => $id,
                'label_id'      => 0,
                'labels'        => $metas
            ]);
        }

    }

    public function updateMetas($old,$new){

        $exist = ($old->labels != '' ? unserialize($old->labels) : []);

        if(!empty($exist))
        {
            $result = $this->helper->array_merge_recursive_new($exist,$new);

            return serialize($result);
        }
        else
        {
            return serialize($new);
        }

    }

    public function createRiiinglink($host_id,$invited_id){

        return $this->riiinglink->create(['host_id' => $host_id, 'invited_id' => $invited_id]);

    }

}