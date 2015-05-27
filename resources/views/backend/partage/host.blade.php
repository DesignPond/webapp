@if(isset($user->label_groupe) && !empty($user->label_groupe))

    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <div class="checkbox">
                    <label class="text-primary">
                        <input id="partageCheckAll" class="partageCheckAll" data-who="{{ $who }}" type="checkbox">{{ trans('menu.selectionner') }}
                    </label>
                </div>
                <hr/>
            </div>
        </div>

        <?php
            if($user->user_type == '1' ){
                $GroupeTypes = [$all_groupe_type[1],$all_groupe_type[2]];
                $prive = true;
            }
            else{
                $GroupeTypes = [$all_groupe_type[5]];
                $prive = false;
            }
        ?>

        @include('backend.partage.labels', [ 'GroupeTypes' => $GroupeTypes, 'who' => $who, 'prive' => $prive, 'host_group_type' => $user->label_groupe ])

    </div>

@endif