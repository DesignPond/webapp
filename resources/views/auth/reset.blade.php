@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <!-- START panel-->
        <div class="panel panel-grey">
            <div class="panel-body">
                <h4 class="text-center" style="margin-bottom: 25px;">{{ trans('message.newpassword') }}</h4>

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="email" name="email" placeholder="{{ trans('message.youremail') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans('message.yourpassword') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control"
                                       onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false"
                                       id="password_confirmation" name="password_confirmation" placeholder="{{ trans('message.confirm') }}">
                            </div>
                        </div>
                    </div>

                    {!! Form::honeypot('my_name', 'my_time') !!}

                    <button type="submit" class="btn btn-block btn-info mt-lg">{{ trans('menu.envoyer') }}</button>
                </form>
            </div>
        </div>
    </div>

@stop