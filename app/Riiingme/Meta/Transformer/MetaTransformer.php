<?php
namespace App\Riiingme\Api\Transformer;

use App\Riiingme\Meta\Entities\Meta;
use League\Fractal;

class MetaTransformer extends Fractal\TransformerAbstract
{
    public function transform(Meta $meta)
    {
        return [
            'id'         => (int) $meta->id,
            'label'      => (isset($meta->labels->label) ? $meta->labels->label: null),
            'type'       => (int) $meta->labels->type_id,
            'user_id'    => (int) $meta->labels->user_id,
            'riiinglink' => (int) $meta->riiinglink_id,
            'groupe'     => (int) $meta->labels->groupe_id
        ];
    }
}
