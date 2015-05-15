
<div class="row">
    @if($prive)
        <div class="col-md-6 checkbox">
            <label><input checked disabled type="checkbox">{{ trans('menu.firstname') }}</label>
        </div>
        <div class="col-md-6 checkbox">
            <label><input checked disabled type="checkbox">{{ trans('menu.lastname') }}</label>
        </div>
    @else
        <div class="col-md-12 checkbox">
            <label><input checked disabled type="checkbox">{{ trans('menu.entreprise') }}</label>
        </div>
    @endif
</div>
<div class="row">

    @foreach($GroupeTypes as $groupe)

        {{ $groupe['id'] }}

        <div class="col-md-6">
            <h5><strong>{{ $groupe['titre'] }}</strong></h5>

            @foreach($groupe['groupe_type'] as $type)
                @if(isset($host_group_type[$groupe['id']]) && !empty($host_group_type))
                    @if( in_array($type['id'], $host_group_type[$groupe['id']] ))
                        <div class="checkbox {{ $who }}">
                            <label><input name="partage_{{ $who }}[{{ $groupe['id'] }}][]" value="{{ $type['id'] }}" type="checkbox">{{ $type['titre'] }}</label>
                        </div>
                    @endif
                @else
                    @if($who != 'host')
                        <div class="checkbox {{ $who }}">
                            <label><input name="partage_{{ $who }}[{{ $groupe['id'] }}][]" value="{{ $type['id'] }}" type="checkbox">{{ $type['titre'] }}</label>
                        </div>
                    @endif
                @endif
            @endforeach

        </div>
    @endforeach

</div>