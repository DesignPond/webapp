<?php
    $daterange = '';
    $exist     = false;

    if(isset($view_dates[$view['id']]))
    {
        $daterange = $view_dates[$view['id']]['start'].' | '.$view_dates[$view['id']]['end'];
        $exist     = true;
    }
?>

<fieldset class="row border accordion-body collapse <?php echo ($exist ? 'in': ''); ?>" id="collapse_{{ $view['id'] }}">
    <h4 class="title-adresse">{{ $view['titre'] }} <small class="text-danger">{{ trans('menu.temporaire') }}</small></h4>
    <div class="col-md-8 col-xs-12">
        <div class="form-group">
            <label class="col-sm-4 control-label" for="exampleInputEmail1">{{ trans('menu.periode') }}</label>
            <div class="col-sm-8">
                <input value="{{ $daterange }}" type="text" name="date[{{ $view['id'] }}]" class="form-control daterange">
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