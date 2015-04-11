<?php namespace App\Riiingme\Traits;

use App\Riiingme\Activite\Entities\Activite;

trait RecordsActivity
{
   protected static function bootRecordsActivity()
   {

       foreach(static::getModelEvents() as $event)
       {
           static::$event(function($model) use ($event)
           {
                $model->recordActivite($event);
           });
       }

   }

    public function recordActivite($event)
    {
        Activite::create([
            'type'        => get_class($this),
            'activite_id' => $this->id,
            'name'        => $this->getActiviteName($this,$event),
            'user_id'     => (isset($this->host_id)? $this->host_id : $this->user_id),
            'invited_id'  => (isset($this->invited_id)? $this->invited_id : null),
            'token'       => (isset($this->token)? $this->token : null),
        ]);
    }

    protected function getActiviteName($model,$action)
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