<?php namespace App\Riiingme\User\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $fillable = ['first_name','last_name','company','email','name_search','email_search','notification_interval','user_type','password','activation_token','activated_at'];

    /**
     * Dates as carbon objects
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');


    public function getSendTokenAttribute()
    {

        return bcrypt($this->email.$this->id);

    }

    public function getUserPhotoAttribute()
    {

        if(isset($this->labels))
        {
            $photo = $this->labels->filter(function($item) {
                return $item->type_id == 12;
            })->first();
        }

        return ( isset($photo->label) && !empty($photo->label) ? $photo->label : 'avatar.jpg');

    }

    public function getLabelGroupeAttribute()
    {
        $data = [];

        if(isset($this->labels))
        {
            foreach($this->labels as $label)
            {
                $data[$label->groupe_id][] = $label->type_id;
            }

            return $data;
        }

        return [];

    }

    public function getUserLabelAttribute()
    {
        $data = [];

        if(isset($this->labels) && isset($this->user_groups))
        {
            foreach($this->labels as $label)
            {
                if($label->groupe_id > 1)
                {
                    $data[$label->groupe_id][$label->type_id] = $label->label;
                }
            }

            return $data;
        }

        return [];
    }

    public function getNameAttribute()
    {
        if($this->user_type == 1)
        {
            return $this->first_name.' '.$this->last_name;
        }
        else
        {
            return $this->company;
        }
    }

    /**
     * Metas belongs to user
     *
     * @var query
     */
    public function labels(){

        return $this->hasMany('App\Riiingme\Label\Entities\Label');
    }

    /**
     * Link belongs to user
     *
     * @var query
     */
    public function riiinglink(){

        return $this->belongsToMany('App\Riiingme\Riiinglink\Entities\Riiinglink', 'users', 'host_id', 'invited_id');
    }

    /**
     * Link belongs to user
     *
     * @var query
     */
    public function riiinglinks(){

        return $this->hasMany('App\Riiingme\Riiinglink\Entities\Riiinglink', 'host_id', 'id');
    }

    /**
     * Link belongs to user
     *
     * @var query
     */
    public function riiinglinks_inverse(){

        return $this->hasMany('App\Riiingme\Riiinglink\Entities\Riiinglink', 'invited_id', 'id');
    }

    /**
     * Group belongs to user
     *
     * @var query
     */
    public function user_groups(){

        return $this->belongsToMany('App\Riiingme\Groupe\Entities\Groupe', 'user_groups', 'user_id', 'groupe_id')->withPivot('start_at','end_at');
    }

    /**
     * Group belongs to user
     *
     * @var query
     */
    public function users_groups(){

        return $this->hasMany('App\Riiingme\User\Entities\User_group', 'user_id');
    }

    /**
     * Activites belongs to user
     *
     * @var query
     */
    public function activites(){

        return $this->hasMany('App\Riiingme\Activite\Entities\Activite');
    }

    /**
     * Activites belongs to user
     *
     * @var query
     */
    public function invitations(){

        return $this->hasMany('App\Riiingme\Activite\Entities\Activite','invited_id');
    }

    /**
     * Link belongs to user
     *
     * @var query
     */
    public function user_tags(){

        return $this->belongsToMany('App\Riiingme\Tag\Entities\Tag', 'user_tags', 'user_id', 'tag_id');
    }

}
