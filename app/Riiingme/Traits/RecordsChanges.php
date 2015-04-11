<?php namespace App\Riiingme\Traits;

use App\Riiingme\Activite\Entities\Change;

trait RecordsChanges
{
   protected static function bootRecordsChange()
   {

       foreach(static::getModelEvents() as $event)
       {
           static::$event(function($model) use ($event)
           {
                $model->recordActivite($event);
           });
       }

   }

    public function recordChange($event)
    {
        Change::create([
            'meta_id'    => $this->id,
            'user_id'    => $this->user_id,
            'changed_at' => date('Y-m-d G:i:s')
        ]);

    }

    protected static function getModelEvents(){

        if(isset(static::$recordEvents)){
            return static::$recordEvents;
        }

        return ['created','updated','deleted'];
    }

}