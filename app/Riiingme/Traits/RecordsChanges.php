<?php namespace App\Riiingme\Traits;

use App\Riiingme\Activite\Entities\Change;

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
        if(!$this->itExist($this) && \Auth::check())
        {
            Change::create([
                'meta_id'       => $this->id,
                'riiinglink_id' => $this->riiinglink_id,
                'name'          => $this->getChangeName($this,$event),
                'user_id'       => \Auth::user()->id,
                'changed_at'    => date('Y-m-d')
            ]);
        }
    }

    protected function itExist($model)
    {
        $exist = Change::where('changed_at','=',date('Y-m-d'))->where('meta_id','=',$model->id)->get();

        return ($exist->isEmpty() ? false : true);
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