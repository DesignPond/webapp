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
                break;
            case 8:
            case 9:
                $class = 'mask_tel';
                break;
            case 10:
                $class = 'mask_date';
                break;
            case 11:
                $class = 'mask_web';
                break;
            default:
                $class = '';
        }

        return $class;

    }

    public function generateInput($type, $groupe, $exist, $data = null){

        $class = $this->labelClass($type);
        $id    = ($class == 'mask_tel' ? 'placeholder="032 555 55 55"' : '');

        if($exist)
        {
            $content = '<input value="'.$data['text'].'" '.$id.' type="text" name="edit['.$data['id'].']" class="form-control '.$class.'">';
        }
        else{
            $content = '<input value="" '.$id.' type="text" name="label['.$groupe.']['.$type.']" class="form-control '.$class.'">';
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
}


