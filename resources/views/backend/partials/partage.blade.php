<?php unset($groupe_type[0]); ?>

@if(!empty($groupe_type))

    <div class="well">
        <div class="row">
            <div class="col-md-6">
                <div class="checkbox"><label><input checked disabled type="checkbox">Prénom</label></div>
            </div>
            <div class="col-md-6">
                <div class="checkbox"><label><input checked disabled type="checkbox">Nom</label></div>
            </div>
        </div>
        <br/>
        <div class="row">
            @foreach($groupe_type as $groupe)
                @if($status[$groupe['id']] == 'principal')
                    <div class="col-md-6">
                        <h5><strong>{{ $groupe['titre'] }}</strong></h5>

                        @foreach($groupe['groupe_type'] as $type)
                            <div class="checkbox">
                                <label><input name="partage_{{ $who }}[{{ $groupe['id'] }}][]" value="{{ $type['id'] }}" type="checkbox"> {{ $type['titre'] }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        </div>
    </div>

@endif