<?php namespace App\Riiingme\Helpers;

use Illuminate\Support\Collection;

class Helper{

    public function convert($collection,$user_labels){

        $data    = $collection['data'][0];
        $general = $data;

        $general['label']   = $this->dispatchInGroupsByType($user_labels);
        $general['invited'] = (isset($data['invited']['data']) ? $this->dispatchInGroups($data['invited']['data']) : [] );

        return $general;
    }

    public function dispatchInGroups($data){

        $groupe  = array();

        if(!empty($data))
        {
            foreach($data as $label)
            {
                $groupe[$label['groupe']['id']][] = $label;
            }
        }

        return $groupe;
    }

    public function dispatchInGroupsByType($data){

        $groupe = array();

        if(!empty($data))
        {
            foreach($data as $label)
            {
                $groupe[$label->groupe_id][$label->type_id]['label'] = (!empty($label->label_text) ? $label->label_text : '');
                $groupe[$label->groupe_id][$label->type_id]['id']    = $label->id;
            }
        }

        return $groupe;
    }

    public function labelClass($type){

        switch ($type) {
            case 1:
                $class = 'mask_email';
                $placeholder = 'nom@domaine.ch';
                break;
            case 8:
            case 9:
            case 13:
                $class = 'mask_tel';
                $placeholder = '032 555 55 55';
                break;
            case 10:
                $class = 'mask_date';
                $placeholder = '01/10/1982';
                break;
            case 11:
                $class = 'mask_web';
                $placeholder = 'www.domaine.ch';
                break;
            default:
                $class = '';
                $placeholder = '';
        }

        return [$class,$placeholder];

    }

    public function generateInput($type, $groupe, $exist, $data = null){

        list($class,$placeholder) = $this->labelClass($type);

        if($exist)
        {
            $content = '<input value="'.$data['text'].'" type="text" name="edit['.$data['id'].']" class="form-control '.$class.'" placeholder="'.$placeholder.'">';
        }
        else
        {
            $content = '<input value="" type="text" name="label['.$groupe.']['.$type.']" class="form-control '.$class.'" placeholder="'.$placeholder.'">';
        }

        return $content;
    }

    public function arrayNonEmpty($input) {
        // If it is an element, then just return it
        if (!is_array($input)) {
            return $input;
        }

        $non_empty_items = array();

        foreach ($input as $key => $value) {
        // Ignore empty cells
            if($value) {
        // Use recursion to evaluate cells
                $non_empty_items[$key] = $this->arrayNonEmpty($value);
            }
        }

        // Finally return the array without empty items
        return $non_empty_items;
    }

    public function isNotEmpty($input) {

        if(is_array($input))
        {
            foreach ($input as $value)
            {
                $value = array_filter($value);
                if(!empty($value))
                {
                   return true;
                }
            }
        }

        return false;
    }

    public function convertDateRange($date){

        $dates =  array_map('trim', explode('|', $date));

        $start = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0])->toDateString(); // 1975-05-21
        $end   = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1])->toDateString(); // 1975-05-21

        return ['start_at' => $start, 'end_at' => $end];

    }

    public function getUsedMetas($id, $metas, $groupe){

        // if we have a label in that group and some metas in that group test if this label is used those metas
        if(isset($id) && isset($metas[$groupe]))
        {
            return (in_array($id, $metas[$groupe]) ? true : false);
        }

        return false;
    }

    public function metasCompare($old,$new){

        $data = [];

        foreach($old as $groupe => $type)
        {
            if(isset($new[$groupe]))
            {
                $result = $old[$groupe] + array_diff($new[$groupe],$old[$groupe]);
                $data[$groupe] =  $result;
            }
            else
            {
                $data[$groupe] =  $old[$groupe];
            }
        }

        return $data;

    }

    public function addMetas($exist,$new){

        $data = [];

        $all_groupes = range(1,6);

        if(!empty($exist))
        {
            foreach($all_groupes as $group_id) // 1,2,3,4,5,6
            {
                if(isset($new[$group_id]))
                {
                    if(isset($exist[$group_id]))
                    {
                        $data[$group_id] = $exist[$group_id] + $new[$group_id];
                        ksort($data[$group_id]);
                    }
                    else
                    {
                        $data[$group_id] = $new[$group_id];
                    }
                }
                else
                {
                    if(isset($exist[$group_id]))
                    {
                        $data[$group_id] = $exist[$group_id];
                        ksort($data[$group_id]);
                    }
                }
            }
        }
        else
        {
            $data = $new;
        }

        return $data;
    }

    public function getKeyValue($array,$key,$value){

        $results = '';

        if (!empty($array))
        {
            foreach ($array as $subarray)
            {
                if(isset($subarray[$key]) && $subarray[$key] == $value){
                    return $subarray['label'];
                }
            }
        }

        return $results;

    }

    public function array_flatten($array)
    {
        $return = array();

        if( !empty($array) ){
            foreach($array as $a)
            {
                foreach($a as $y)
                {
                    $return[] = $y;
                }
            }
        }

        return $return;
    }

    public function convertForUserType($labels){

        $labels = $this->array_flatten($labels);
        $exist  = [4,5,6,7,8,9,11];
        $data   = array_unique(array_intersect($labels, $exist));

        sort($data);

        $result[6] = $data;

        return $result;

    }

    public function convertAutocomplete($results){

        $data = [];

        if(!$results->isEmpty())
        {
            foreach($results as $result)
            {
                $label  = ($result->name_search ? $result->name : $result->email);
                $email  = ($result->email_search ? $result->email : $result->name);

                $new    = ['label' => $label , 'desc' => $email, 'value' =>  $result->email, 'id' =>  $result->id, 'user_type' => $result->user_type];

                $data[] = $new;
            }
        }

        return $data;
    }

    public function validityPeriod($invited_user,$group){

        $dates = $invited_user->filter(function ($item) use ($group) {
            return $item->pivot->groupe_id == $group;
        })->first();

        if ($dates)
        {
            $start = \Carbon\Carbon::parse($dates->pivot->start_at);
            $end   = \Carbon\Carbon::parse($dates->pivot->end_at);

            $format = ($start->month == $end->month ? '%d' : '%d %B');

            $startPeriod = $start->formatLocalized($format);
            $endPeriod   = $end->formatLocalized('%d %B %Y');

            return 'Valable du '.$startPeriod.' au '.$endPeriod;
        }

        return '';
    }


    public function addTempLabelsForChanges($labels)
    {
        $changes = unserialize($labels);

        if(!empty($changes))
        {
            $metas = array_keys($changes);

            if(in_array(2,$metas))
            {
                $changes[4] = (isset($changes[2]) && !empty($changes[2]) ? $changes[2] : []);
            }
            if(in_array(3,$metas))
            {
                $changes[5] = (isset($changes[3]) && !empty($changes[3]) ? $changes[3] : []);
            }

            return serialize($changes);
        }

        return $labels;
    }

    public function sortArrayByArray(Array $array, Array $orderArray) {

        $ordered = array();

        foreach($orderArray as $key)
        {
            if(array_key_exists($key,$array))
            {
                $ordered[$key] = $array[$key];
            }
        }

        return $ordered;
    }

}


