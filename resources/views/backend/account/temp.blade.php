<?php

    $dates = $user->user_groups->filter(function($item) use ($view) {
        return $item->pivot->groupe_id == $view['id'];
    })->first();

    $exist = false; $current = false;

    if($dates)
    {
        $start = \Carbon\Carbon::parse($dates->pivot->start_at);
        $end   = \Carbon\Carbon::parse($dates->pivot->end_at);

        $startRange =  $start;
        $endRange   =  $end;

        $daterange = $startRange->format('d/m/Y').' | '.$endRange->format('d/m/Y');
        $exist     = true;
        $now       = \Carbon\Carbon::now();
        $current   = ( ($start < $now) && ($end > $now) ? true : false);
    }

?>

<fieldset class="row border accordion-body collapse <?php echo ($exist ? 'in temp-address': ''); ?>" id="collapse_{{ $view['id'] }}">

    <div class="col-md-12 col-xs-12">
        <div class="row">
            <h4 class="title-adresse col-md-12">{{ trans('label.title_'.$view['id']) }}
                <i class="text-danger">{{ trans('menu.temporaire') }}</i>
                <?php echo ($current ? trans('menu.affiche_temp') : trans('menu.non_affiche_temp') ); ?>
            </h4>
        </div>
    </div>

    <div class="col-md-8 col-xs-12">
        <div class="form-group">
            <label class="col-sm-4 control-label">{{ trans('menu.periode') }}</label>
            <div class="col-sm-8">
                <input value="{{ $daterange or '' }}" type="text" data-groupe="{{ $view['id'] }}" name="date[{{ $view['id'] }}]" class="form-control daterange">
            </div>
        </div>
        @foreach($view['groupe_type'] as $types)
            <div class="form-group">
                <label class="col-sm-4 control-label" for="input-id-1">{{ $types['titre'] }}</label>
                <div class="col-sm-8 col-xs-12">
                    <?php
                        $type  = $types['pivot']['type_id'];
                        $group = $types['pivot']['groupe_id'];
                    ?>
                    @if(isset($labels[$group][$type]['label']))
                        <?php echo $helper->generateInput($type, $group ,true,['id' => $labels[$group][$type]['id'] , 'text' => $labels[$group][$type]['label'] ]); ?>
                    @else
                        <?php echo $helper->generateInput($type, $group ,false); ?>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-4 col-xs-12"></div>
    <span class="clearfix"></span><br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>