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
                $groupe[$label['groupe_id']][$label['type_id']]['label'] = (!empty($label['label']) ? $label['label'] : '');
                $groupe[$label['groupe_id']][$label['type_id']]['id']    = $label['id'];
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
                $class = 'mask_tel';
                $placeholder = '032 555 55 55';
                break;
            case 10:
                $class = 'mask_date';
                $placeholder = '1982-10-01';
                break;
            case 11:
                $class = 'mask_web';
                $placeholder = 'wwww.domaine.ch';
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

        return ['start_at' => $dates[0], 'end_at' => $dates[1]];

    }

    public function getUsedMetas($id, $metas,$groupe){

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

        if(!empty($exist))
        {
            foreach($exist as $group => $labels)
            {
                if(isset($new[$group]))
                {
                    $data[$group] = array_merge($labels, array_diff($new[$group], $labels));
                }
                else
                {
                    $data[$group] = $labels;
                }
            }
        }
        else
        {
            $data = $new;
        }

        return $data;
    }

    public function array_merge_recursive_new()
    {
        $arrays = func_get_args();
        $base   = array_shift($arrays);

        if(!is_array($base)) $base = empty($base) ? array() : array($base);

        foreach($arrays as $append)
        {
            if(!is_array($append)) $append = array($append);

            foreach($append as $key => $value)
            {
                if(!array_key_exists($key, $base) and !is_numeric($key))
                {
                    $base[$key] = $append[$key];
                    continue;
                }

                if(is_array($value) or ( isset($base[$key]) && is_array($base[$key]) && isset($append[$key])))
                {
                    $base[$key] = $this->array_merge_recursive_new($base[$key], $append[$key]);
                }
                else if(is_numeric($key))
                {
                    if(!in_array($value, $base)) $base[] = $value;
                }
                else
                {
                    $base[$key] = $value;
                }
            }
        }

        return $base;
    }

    public function getKeyValue($array,$key,$value){

        $results = array();

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

}


