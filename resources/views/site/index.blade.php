@extends('layouts.master')
@section('content')

<div class="container">
    <section class="row">
        <div class="col-md-6">
            <p class="text-center"><img src="<?php echo asset('frontend/images/illustration-web.svg');?>" alt="illustration"></p>
        </div>
        <div class="col-md-6 ">
            <div class="text-center intro parent">
                <div class="child">
                    <h3 class="serviceName">Vos données sécurisés</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis.
                        Pellentesque cursus arcu id magna euismod in elementum purus molestie.</p>
                        <a class="btn btn-info btn-xl btn-blue" href="{{ url('register') }}">S'inscrire</a>
                        <a class="btn btn-default btn-xl" href="{{ url('auth/login') }}">Login</a>
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
                    <h3 class="serviceName">Accessible dans le monde entier</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer lorem quam, adipiscing condimentum tristique vel, eleifend sed turpis.
                        Pellentesque cursus arcu id magna euismod in elementum purus molestie.</p>
                        <a class="btn btn-info btn-xl btn-blue" href="{{ url('register') }}">S'inscrire</a>
                        <a class="btn btn-default btn-xl" href="{{ url('auth/login') }}">Login</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <p class="text-center"><img src="<?php echo asset('frontend/images/world.svg');?>" alt="illustration"></p>
        </div>
    </section>
</div>

@stop