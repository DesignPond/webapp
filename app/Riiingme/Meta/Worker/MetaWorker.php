<?php namespace App\Riiingme\Meta\Worker;

use App\Riiingme\Meta\Repo\MetaInterface;

class MetaWorker{

    protected $meta;

    public function __construct(MetaInterface $meta)
    {
        $this->meta = $meta;
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
}
