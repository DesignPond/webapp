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
            case 9:
            case 10:
                $class = 'mask_tel';
                break;
            case 11:
                $class = 'mask_date';
                break;
            case 12:
                $class = 'mask_web';
                break;
            default:
                $class = '';
        }

        return $class;

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

    public function isNonEmpty($input) {

        if(is_array($input))
        {
            foreach ($input as $value) {
                // Ignore empty cells
                if(!empty($value)) {
                   return true;
                }
            }
        }

        // Finally return the array without empty items
        return false;
    }

}


