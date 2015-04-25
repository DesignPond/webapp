<fieldset class="row border">
    <h4 class="title-adresse">{{ $view['titre'] }}</h4>
    <div class="col-md-8 col-xs-12">

        @if($prive)
            <?php unset($view['groupe_type'][0]); ?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Email</label>
                <div class="col-sm-8 col-xs-12">
                    <input value="{{ $user->email }}" type="text" name="info[email]" class="form-control">
                    <p class="help-block"><small>vaut aussi comme adresse de login</small></p>
                </div>
            </div>
        @endif

        @foreach($view['groupe_type'] as $types)

            <?php
                $type  = $types['pivot']['type_id'];
                $group = $types['pivot']['groupe_id'];
            ?>

            <div class="form-group">
                <label class="col-sm-4 control-label">{{ $types['titre'] }}</label>
                <div class="col-sm-8 col-xs-12">
                    @if(isset($labels[$group][$type]['label']))
                        <?php echo $helper->generateInput($type, $group ,true,['id' => $labels[$group][$type]['id'] , 'text' => $labels[$group][$type]['label'] ]); ?>
                    @else
                        <?php echo $helper->generateInput($type, $group ,false); ?>
                    @endif
                </div>
            </div>

        @endforeach
    </div>
    <div class="col-md-4 col-xs-12">
        <?php $collapsible = $view['id'] + 2 ; ?>
        <a class="btn btn-info btn-sm btn-collapse" data-toggle="collapse" href="#collapse_{{ $collapsible }}" aria-expanded="false" aria-controls="collapseExample">
            {{ trans('menu.indiquer') }} <span>{{ $view['titre'] }}</span> {{ trans('menu.temporaire') }}
        </a>
    </div>
    <span class="clearfix"></span><br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>