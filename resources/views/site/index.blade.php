@extends('site.layouts.master')
@section('content')

<div class="container">
    <section class="row">
        <div class="col-md-6">
            <h3>{{ trans('text.secure') }}</h3>
            <p>{{ trans('text.texte_annuaire') }}</p>
            <p class="text-center" id="illustration">
                <img src="<?php echo asset('frontend/images/illustration.svg');?>" alt="illustration">
            </p>
        </div>
        <div class="col-md-6 ">
            <h4 class="text-center">Créer un compte :</h4>
            <section id="register" class="center-block auth-login row">
                <div class="col-md-12">
                    <a href="{{ url('auth/register_private') }}" class="btn btn-block btn-cyan mt-lg">
                        <i class="fa fa-user"></i><br/>
                        {{ trans('action.create') }} <span>{{ trans('menu.prive') }}</span>
                    </a>
                </div>
                <strong class="col-md-12 text-center">{{ trans('action.ou') }}</strong>
                <div class="col-md-12">
                    <a href="{{ url('auth/register_company') }}" class="btn btn-block btn-primary mt-lg">
                        <i class="fa fa-users"></i><br/>
                        {{ trans('action.create') }} <span>{{ trans('menu.company') }}</span>
                    </a>
                </div>
            </section>

        </div>
    </section>
</div>

@stop