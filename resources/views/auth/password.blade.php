@extends('auth.layouts.master')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <!-- START panel-->
        <div class="panel panel-grey">
            <div class="panel-body">
                <p class="text-center pv text-bold">Mot de passe perdu</p>

                {!! Form::open(array( 'method' => 'POST', 'class'  => 'mb-lg', 'url'  => array('password/email'))) !!}

                <p class="text-center">Veuillez saisir votre adresse email.<br/> Un lien permettant de créer un nouveau mot de passe vous sera envoyé par e-mail.</p>
                <div class="form-group has-feedback">
                    <input required type="email" name="email" placeholder="Votre email" autocomplete="off" class="form-control" />
                    <span class="fa fa-envelope form-control-feedback text-muted"></span>
                </div>
                <button type="submit" class="btn btn-danger btn-block">Envoyer</button>

                {!! Form::close() !!}

            </div>
        </div>
    </div>


@stop