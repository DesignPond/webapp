@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <a href="{{ url('/') }}"><img style="width: 70%;" src="{{ asset('frontend/images/logo.svg') }}" alt="Image" class="center-block img-rounded" /></a>
    </div>

    <section id="register" class="center-block mt-xl wd-xl auth-login row">

        <div class="col-md-12">
            <a href="{{ url('auth/register_company') }}" class="btn btn-block btn-primary mt-lg">
                <i class="icon-user"></i><br/>
                Créer un Compte Entreprise/Association
            </a>
        </div><!-- morph-button -->
        <strong class="col-md-12 text-center">ou</strong>
        <div class="col-md-12">
            <a href="{{ url('auth/register_private') }}" class="btn btn-block btn-cyan mt-lg">
                <i class="icon-user"></i><br/>
                Créer un compte privé
            </a>
        </div><!-- morph-button -->

    </section>

    <!-- END panel-->

@stop