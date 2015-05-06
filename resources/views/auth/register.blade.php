@extends('auth.layouts.master')
@section('content')

    <section id="register" class="center-block mt-xl wd-xl auth-login row">
        <div class="col-md-12">
            <a href="{{ url('auth/register_private') }}" class="btn btn-block btn-cyan mt-lg">
                <i class="fa fa-user"></i><br/>
                {{ trans('action.create') }} <span>{{ trans('menu.prive') }}</span>
            </a>
        </div>
        <strong class="col-md-12 text-center">ou</strong>
        <div class="col-md-12">
            <a href="{{ url('auth/register_company') }}" class="btn btn-block btn-primary mt-lg">
                <i class="fa fa-users"></i><br/>
                {{ trans('action.create') }} <span>{{ trans('menu.company') }}</span>
            </a>
        </div>
    </section>

@stop