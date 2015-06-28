<fieldset class="row border">
    <h4 class="title-adresse">{{ trans('menu.informations') }}</h4>
    <div class="col-md-8 col-xs-12">
        @if($user->user_type == '1')
            <div class="form-group">
                <label class="col-sm-4 control-label">{{ trans('menu.firstname') }}</label>
                <div class="col-sm-8">
                    <input value="{{ $user->first_name }}" type="text" name="info[first_name]" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">{{ trans('menu.lastname') }}</label>
                <div class="col-sm-8">
                    <input value="{{ $user->last_name }}" type="text" name="info[last_name]" class="form-control">
                </div>
            </div>
            <input type="hidden" name="info[company]" value="">
        @else
            <div class="form-group">
                <label class="col-sm-4 control-label">{{ trans('menu.company') }}</label>
                <div class="col-sm-8">
                    <input value="{{ $user->company }}" type="text" name="info[company]" class="form-control">
                </div>
            </div>
            <input type="hidden" name="info[first_name]" value=""><input type="hidden" name="info[last_name]" value="">
        @endif

        <div class="form-group">
            <label class="col-sm-4 control-label text-danger">&nbsp;</label>
            <div class="col-sm-8">
                <a href="{{ url('password/new') }}" class="btn btn-success btn-sm">{{ trans('message.newpassword') }}</a>
            </div>
        </div>

        <input type="hidden" name="info[id]" value="{{ $user->id }}">
        <input type="hidden" name="info[user_type]" value="{{ $user->user_type }}">
    </div>
    <span class="clearfix"></span><br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>

<!-- Configuration search -->
<fieldset class="row border">
    <h4 class="title-adresse">{{ trans('menu.search_by') }}</h4>
    <div class="col-md-8 col-xs-12">
        <div class="form-group">
            <?php $name = ($user->user_type == '1' ? trans('menu.firstname').'/'.trans('menu.lastname') : trans('menu.company') ); ?>
            <label class="col-sm-4 control-label">{{ $name }}</label>
            <div class="col-md-6">
                <label class="radio-inline"><input type="radio" <?php echo ($user->name_search ? 'checked' : ''); ?> name="info[name_search]" value="1"> {{ trans('action.oui') }}</label>
                <label class="radio-inline"><input type="radio" <?php echo (!$user->name_search ? 'checked' : ''); ?> name="info[name_search]" value="0"> {{ trans('action.non') }}</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">{{ trans('menu.email') }}</label>
            <div class="col-md-6">
                <label class="radio-inline"><input type="radio" <?php echo ($user->email_search ? 'checked' : ''); ?> name="info[email_search]" value="1"> {{ trans('action.oui') }}</label>
                <label class="radio-inline"><input type="radio" <?php echo (!$user->email_search ? 'checked' : ''); ?> name="info[email_search]" value="0"> {{ trans('action.non') }}</label>
            </div>
        </div>
    </div>
    <br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>

<!-- Configuration notifications -->
<fieldset class="row border">
    <h4 class="title-adresse">{{ trans('menu.notification') }}</h4>
    <div class="col-md-8 col-xs-12">
        <div class="form-group">

            <label class="col-sm-4 control-label">{{ trans('menu.email') }} {{ trans('action.chaque') }}</label>
            <div class="col-md-8">
                <label class="radio">
                    <input type="radio" <?php echo ($user->notification_interval == 'day' ? 'checked' : ''); ?> name="info[notification_interval]" value="day">
                    {{ trans('action.day') }}<br/>
                    <span class="text-muted">{{ trans('menu.send_day') }}</span>
                </label>
                <label class="radio">
                    <input type="radio" <?php echo ($user->notification_interval == 'week' ? 'checked' : ''); ?> name="info[notification_interval]" value="week">
                    {{ trans('action.week') }}<br/>
                    <span class="text-muted">{{ trans('menu.send_week') }}</span>
                </label>
                <label class="radio">
                    <input type="radio" <?php echo ($user->notification_interval == 'month' ? 'checked' : ''); ?> name="info[notification_interval]" value="month">
                    {{ trans('action.month') }}<br/>
                    <span class="text-muted">{{ trans('menu.send_month') }}</span>
                </label>
            </div>
        </div>
    </div>
    <br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>