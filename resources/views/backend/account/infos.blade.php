<fieldset class="row border">
    <h4>{{ trans('menu.informations') }}</h4>
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

        <input type="hidden" name="info[id]" value="{{ $user->id }}">
        <input type="hidden" name="info[user_type]" value="{{ $user->user_type }}">
    </div>
    <span class="clearfix"></span><br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>

<!-- Configuration search -->
<fieldset class="row border">
    <h4></h4>
    <div class="col-md-8 col-xs-12">

        <div class="form-group">
            <label class="col-sm-4 control-label">{{ trans('menu.search_by') }}</label>
            <div class="col-md-6">
                <?php $name = ($user->user_type == '1' ? trans('menu.firstname').'/'.trans('menu.lastname') : trans('menu.company') ); ?>
                <div class="checkbox">
                    <label><input type="checkbox" name="infos[name_search]" value="1" checked> {{ $name }}</label>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="infos[email_search]" value="1" checked> {{ trans('menu.email') }}</label>
                </div>
            </div>
        </div>

    </div>
    <span class="clearfix"></span><br/>
    <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
</fieldset>