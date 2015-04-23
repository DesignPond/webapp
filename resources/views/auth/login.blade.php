@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <!-- START panel-->
        <div class="panel panel-grey">
            <div class="panel-body">
                <p class="text-center pv text-bold">{{ trans('action.login') }}</p>

                {!! Form::open(array( 'method' => 'POST', 'class'  => 'mb-lg', 'url'  => array('auth/login'))) !!}

                    <div class="form-group has-feedback">
                        <input required type="email" name="email" placeholder="{{ trans('message.youremail') }}" autocomplete="off" class="form-control" />
                        <span class="fa fa-envelope form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input required type="password" name="password" placeholder="{{ trans('message.yourpassword') }}" class="form-control" />
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                    </div>
                    <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                            <input type="checkbox" name="cookie" value="1" />
                            <span class="fa fa-check"></span>{{ trans('message.rememberme') }}
                        </label>
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-block btn-info mt-lg">{{ trans('action.login') }}</button>

                {!! Form::close() !!}

                <p class="text-center text-muted">Ou</p>
                <a href="{{ url('auth/register') }}" class="btn btn-block btn-primary"><strong>{{ trans('message.createaccount') }}</strong></a>
            </div>
        </div>
        <!-- EBD panel-->
        <div class="text-center mt">
            <a href="{{ url('password/email') }}" class="text-muted">{{ trans('message.lostpassword') }}?</a>
        </div>
    </div>

@stop