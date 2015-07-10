<?php namespace App\Riiingme\Label\Entities;

use Illuminate\Database\Eloquent\Model;

class Label extends Model{

    use \Venturecraft\Revisionable\RevisionableTrait;

    /**
     * No timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Fillable columns
     *
     * @var array
     */
    protected $fillable = array('user_id', 'label', 'type_id', 'groupe_id');


    public function getLabelTextAttribute()
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        /**
         * Swich for format label for types
         * Format the date if type id 10 birthday
         * Format telefon numbers if type id = 8 or 9
        * */

        switch ($this->type_id) {
            case 8:
            case 9:
            case 13:
                $label = $this->format_phone($this->label);
                break;
            case 10:
                $label = \Carbon\Carbon::createFromFormat('d/m/Y', $this->label)->formatLocalized('%d %B %Y');
                break;
            default:
                $label = $this->label;
        }

        return $label;
    }

    public function format_phone($num)
    {
        $num = preg_replace('/[^0-9]/', '', $num);

        $len = strlen($num);
        if($len == 11)
            $num = preg_replace('/([0-9]{2})([0-9]{2})([0-9]{3})([0-9]{2})([0-9]{2})/', '+$1 $2 $3 $4 $5', $num);
        elseif($len == 10)
            $num = preg_replace('/([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})/', '$1 $2 $3 $4', $num);
        elseif($len == 1)
            $num = '';
        elseif($len == 13)
            $num = preg_replace('/([0-9]{4})([0-9]{2})([0-9]{3})([0-9]{2})([0-9]{2})/', '$1 $2 $3 $4 $5', $num);

        return $num;
    }

    /**
     * Labels belongs to user
     *
     * @var query
     */
    public function user(){

        return $this->belongsTo('App\Riiingme\User\Entities\User');
    }

    /**
     * Labels has one to type
     *
     * @var query
     */
    public function type(){

        return $this->belongsTo('App\Riiingme\Type\Entities\Type');
    }

    /**
     * Labels belongs to one groupe
     *
     * @var query
     */
    public function groupe(){

        return $this->belongsTo('App\Riiingme\Groupe\Entities\Groupe');
    }

}