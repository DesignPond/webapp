@if(isset($user->label_groupe) && !empty($user->label_groupe))

<?php
    $host_group_type = $user->label_groupe;
    unset($host_group_type[1]);

?>

    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <div class="checkbox">
                    <label class="text-primary">
                        <input id="partageCheckAll" class="partageCheckAll" data-who="{{ $who }}" type="checkbox">Tout sélectionner/desélectionner
                    </label>
                </div>
                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="checkbox"><label><input checked disabled type="checkbox">Prénom</label></div>
            </div>
            <div class="col-md-6">
                <div class="checkbox"><label><input checked disabled type="checkbox">Nom</label></div>
            </div>
        </div>
        <div class="row">

            @foreach($host_group_type as $groupe_id => $groupe)
                @if($groupe_id == 2 || $groupe_id == 3)
                    <div class="col-md-6">
                        <h5><strong>{{ $groupes[$groupe_id] }}</strong></h5>
                        @foreach($groupe as $type_id => $type)
                            <div class="checkbox {{ $who }}">
                                <label>
                                    <input name="partage_{{ $who }}[{{ $groupe_id }}][{{ $type_id }}]" value="{{ $type }}" type="checkbox">
                                    {{ $types[$type] }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach

        </div>
    </div>

@endif