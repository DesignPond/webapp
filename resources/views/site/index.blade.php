@extends('site.layouts.master')
@section('content')

<div class="container">
    <section class="row">
        <div class="col-md-6">
            <p class="text-center"><img src="<?php echo asset('frontend/images/illustration-web.svg');?>" alt="illustration"></p>
        </div>
        <div class="col-md-6 ">
            <div class="text-center intro parent">
                <div class="child">
                    <h3 class="serviceName">{{ trans('text.secure') }}</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis.
                        Pellentesque cursus arcu id magna euismod in elementum purus molestie.</p>
                        <a class="btn btn-default btn-xl" href="{{ url('auth/register') }}">{{ trans('action.inscription') }}</a>
                        <a class="btn btn-default btn-xl" href="{{ url('auth/login') }}">{{ trans('action.login') }}</a>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="line-divider"></div>
<div class="container">
    <section class="row">
        <div class="col-md-6 ">
            <div class="text-center intro parent">
                <div class="child">
                    <h3 class="serviceName">{{ trans('text.accessible') }}</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis.
                        Pellentesque cursus arcu id magna euismod in elementum purus molestie.</p>
                        <a class="btn btn-default btn-xl" href="{{ url('auth/register') }}">{{ trans('action.inscription') }}</a>
                        <a class="btn btn-default btn-xl" href="{{ url('auth/login') }}">{{ trans('action.login') }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <p class="text-center"><img src="<?php echo asset('frontend/images/world.svg');?>" alt="illustration"></p>
        </div>
    </section>
</div>

@stop