@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <a href="{{ url('/') }}"><img style="width: 70%;" src="{{ asset('frontend/images/logo.svg') }}" alt="Image" class="center-block img-rounded" /></a>
    </div>

    <section class="center-block mt-xl wd-xl auth-login row">

        <div class="morph-button morph-button-modal morph-button-modal-2 morph-button-fixed col-md-12">
            <button type="button">Créer un Compte Entreprise/Association</button>
            <div class="morph-content">
                <div>
                    <div class="content-style-form content-style-form-1">
                        <span class="icon icon-close">Fermer</span>
                        <div class="panel panel-grey">
                            <div class="panel-body">
                                <form class="mb-lg" role="form" method="POST" action="/auth/register"><input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group has-feedback">
                                        <input type="text" value="{{ Input::old('company') }}" name="company" placeholder="Nom de l'entreprise/association" class="form-control" />
                                        <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                                    </div>
                                    @include('auth.form')
                                </form>
                                <p class="pt-lg text-center">Déjà inscrit?</p>
                                <a href="{{ url('auth/login') }}" class="btn btn-block btn-info"><strong>Login</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- morph-button -->

        <strong class="col-md-12 text-center">or</strong>

        <div class="morph-button morph-button-modal morph-button-modal-4 morph-button-fixed col-md-12">
            <button type="button">Créer un compte privé</button>
            <div class="morph-content">
                <div>
                    <div class="content-style-form content-style-form-2">
                        <span class="icon icon-close">Fermer</span>
                        <div class="panel panel-grey">
                            <div class="panel-body">
                                <form class="mb-lg" role="form" method="POST" action="/auth/register"><input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group has-feedback">
                                        <input value="{{ Input::old('first_name') }}" type="text" name="first_name" placeholder="Prénom" class="form-control" />
                                        <span class="fa fa-quote-left form-control-feedback text-muted"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input value="{{ Input::old('last_name') }}" type="text" name="last_name" placeholder="Nom" class="form-control" />
                                        <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                                    </div>
                                    @include('auth.form')
                                </form>
                                <p class="pt-lg text-center">Déjà inscrit?</p>
                                <a href="{{ url('auth/login') }}" class="btn btn-block btn-info"><strong>Login</strong></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- morph-button -->

    </section>

    <!-- END panel-->

@stop