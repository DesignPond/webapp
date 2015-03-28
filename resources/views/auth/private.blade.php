@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <a href="{{ url('/') }}"><img style="width: 70%;" src="{{ asset('frontend/images/logo.svg') }}" alt="Image" class="center-block img-rounded" /></a>
        <p><br/><a href="{{ url('auth/register') }}"><i class="icon-arrow-left"></i> &nbsp;Retour</a></p>
    </div>

    <section class="center-block mt-xl wd-xl">
        <div class="panel panel-grey">
            <div class="panel-body">
                <form class="mb-lg" role="form" method="POST" action="/auth/register">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input value="{{ Input::old('first_name') }}" type="text" name="first_name" placeholder="Prénom" class="form-control" />
                        <span class="fa fa-quote-left form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input value="{{ Input::old('last_name') }}" type="text" name="last_name" placeholder="Nom" class="form-control" />
                        <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                    </div>
                    <input type="hidden" value="1" name="user_type" id="user_type">
                    @include('auth.form')
                </form>
                <p class="pt-lg text-center">Déjà inscrit?</p>
                <a href="{{ url('auth/login') }}" class="btn btn-block btn-info"><strong>Login</strong></a>
            </div>
        </div>
    </section>

    <!-- END panel-->

@stop