<?php
namespace App\Riiingme\Label\Transformer;

use App\iiingme\Label\Entities\Label;
use App\iiingme\Groupe\Entities\Groupe;
use App\iiingme\Type\Entities\Type;

use League\Fractal;

class LabelTransformer extends Fractal\TransformerAbstract
{
    public function transform(Label $label)
    {

        $groupes = $this->getGroupes();
        $types   = $this->getTypes();

        return [
            'id'      => (int) $label->id,
            'label'   => $label->label_text,
            'type'  => [
                'id'    => (int) $label->type_id,
                'titre' => $types[$label->type_id],
            ],
            'groupe'  => [
                'id'    => (int) $label->groupe_id,
                'titre' => $groupes[$label->groupe_id],
            ]
        ];
    }

    protected function getTypes(){
        return Type::all()->lists('titre','id');
    }

    protected function getGroupes(){
        return Groupe::all()->lists('titre','id');
    }
}
