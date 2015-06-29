@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <a href="{{ url('/') }}"><i class="icon-arrow-left"></i> &nbsp;{{ trans('action.backto') }}</a>
    </div>

    <section class="center-block mt-xl wd-xl">
        <div class="panel panel-grey">
            <div class="panel-body">
                <p class="text-center pv text-bold">{{ trans('message.createprivate') }}</p>
                <form class="mb-lg" role="form" method="POST" action="/auth/register">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input value="{{ Input::old('first_name') }}" type="text" name="first_name" placeholder="{{ trans('menu.firstname') }}" class="form-control" />
                        <span class="fa fa-quote-left form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input value="{{ Input::old('last_name') }}" type="text" name="last_name" placeholder="{{ trans('menu.lastname') }}" class="form-control" />
                        <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                    </div>
                    <input type="hidden" value="1" name="user_type" id="user_type">
                    @include('auth.form')
                </form>
            </div>
        </div>
    </section>

    <!-- END panel-->

@stop