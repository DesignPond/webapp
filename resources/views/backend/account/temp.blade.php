<?php

    $dates = $user->user_groups->filter(function($item) use ($view) {
        return $item->pivot->groupe_id == $view['id'];
    })->first();

    $exist = false; $current = false;

    if($dates)
    {
       $start = \Carbon\Carbon::parse($dates->pivot->start_at)->toDateString();
       $end   = \Carbon\Carbon::parse($dates->pivot->end_at)->toDateString();

       $daterange = $start.' | '.$end;
       $exist     = true;
       $now       = \Carbon\Carbon::now();
       $current   = ($start < $now && $end > $now ? true : false);
    }

?>

<fieldset class="row border accordion-body collapse <?php echo ($exist ? 'in temp-address': ''); ?>" id="collapse_{{ $view['id'] }}">

    <div class="col-md-12 col-xs-12">
        <div class="row">
            <h4 class="title-adresse col-md-9">{{ $view['titre'] }} <small class="text-danger">{{ trans('menu.temporaire') }}</small></h4>

            <div class="col-md-3 alert alert-<?php echo ($current ? 'success' : 'danger' ); ?> text-center" role="alert">
                <?php echo ($current ? 'Affiché chez vos contacts' : 'Période pas en effet' ); ?>
            </div>

        </div>
    </div>

    <div class="col-md-8 col-xs-12">
        <div class="form-group">
            <label class="col-sm-4 control-label" for="exampleInputEmail1">{{ trans('menu.periode') }}</label>
            <div class="col-sm-8">
                <input value="{{ $daterange or '' }}" type="text" name="date[{{ $view['id'] }}]" class="form-control daterange">
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