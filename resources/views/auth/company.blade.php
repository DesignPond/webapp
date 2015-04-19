@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <a href="{{ url('auth/register') }}"><i class="icon-arrow-left"></i> &nbsp;Retour</a>
    </div>

    <section class="center-block mt-xl wd-xl">
        <div class="panel panel-grey">
            <div class="panel-body">
                <p class="text-center pv text-bold">Création du compte Entreprise/Association</p>
                <form class="mb-lg" role="form" method="POST" action="/auth/register">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group has-feedback">
                        <input type="text" value="{{ Input::old('company') }}" name="company" placeholder="Nom de l'entreprise/association" class="form-control" />
                        <span class="fa fa-quote-right form-control-feedback text-muted"></span>
                    </div>
                    <input type="hidden" value="2" name="user_type" id="user_type">

                    {!! Form::honeypot('my_name', 'my_time') !!}

                    @include('auth.form')
                </form>
                <p class="pt-lg text-center">Déjà inscrit?</p>
                <a href="{{ url('auth/login') }}" class="btn btn-block btn-info"><strong>Login</strong></a>
            </div>
        </div>
    </section>

    <!-- END panel-->

@stop