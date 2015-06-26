<?php namespace App\Riiingme\Traits;

use App\Riiingme\Activite\Entities\Change;
use App\Riiingme\Riiinglink\Repo\RiiinglinkInterface;

trait RecordsChanges
{
   protected static function bootRecordsChanges()
   {

       foreach(static::getModelEvents() as $event)
       {
           static::$event(function($model) use ($event)
           {
                $model->recordChange($event);
           });
       }

   }

    public function recordChange($event)
    {
        if( \Auth::check())
        {
            $host       = 0;
            $exist      = $this->itExist($this);
            $riiinglink = \App::make('App\Riiingme\Riiinglink\Repo\RiiinglinkInterface');
            $link       = $riiinglink->find($this->riiinglink_id);

            if(!$link->isEmpty())
            {
                $host = $link->first()->host_id;
            }

            if (!$exist)
            {
                $change = Change::create([
                    'meta_id'       => $this->id,
                    'riiinglink_id' => $this->riiinglink_id,
                    'name'          => $this->getChangeName($this, $event),
                    'labels'        => $this->labels,
                    'user_id'       => ($host ? $host : \Auth::user()->id),
                    'changed_at'    => date('Y-m-d')
                ]);

                $new = Change::find($change->id);
                $new->labels = $this->labels;
                $new->save();
            }
            else
            {
                $change = Change::find($exist->id);

                $change->labels  = $this->labels;
                $change->save();
            }
        }
    }

    protected function itExist($model)
    {
        $exist = Change::where('changed_at','=',date('Y-m-d'))->where('meta_id','=',$model->id)->where('user_id','=',\Auth::user()->id)->get();

        return (!$exist->isEmpty() ? $exist->first() : false);
    }

    protected function getChangeName($model,$action)
    {
        $name = strtolower((new \ReflectionClass($model))->getShortName());

        return "{$action}_{$name}";
    }

    protected static function getModelEvents(){

        if(isset(static::$recordEvents)){
            return static::$recordEvents;
        }

        return ['created','updated','deleted'];
    }

}