<div class="well">
    <div class="row">
        <div class="col-md-12">
            <div class="checkbox">
                <label class="text-primary"><input id="partageCheckAll" class="partageCheckAll" data-who="{{ $who }}" type="checkbox">{{ trans('menu.selectionner') }}</label>
            </div>
            <hr/>
        </div>
    </div>

    <?php

        $keys  = array_keys($invitemetas);

        if(in_array(6,$keys))
        {
            $GroupeTypes = [$all_groupe_type[5]];
            $prive = false;
        }
        else
        {
            $GroupeTypes = [$all_groupe_type[1],$all_groupe_type[2]];
            $prive = true;
        }

    ?>

    <div id="partageMain">
        @include('backend.partage.labels', [ 'GroupeTypes' => $GroupeTypes, 'who' => $who, 'prive' => $prive , 'metas' => $invitemetas])
    </div>

</div>
