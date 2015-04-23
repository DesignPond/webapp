@extends('auth.layouts.master')
@section('content')

    <section class="row">
        <div class="col-md-6 col-md-offset-3 mt-xl">
            <div class="panel panel-grey">
                <div class="panel-body">

                    <h3><strong>Activation!</strong></h3>
                    <p>Veuillez confirmer votre adresse email avec le lien qui vous à été envoyé.</p><br/>
                    <p><a href="{{ url('sendActivationLink') }}" class="btn btn-warning">Renvoyer le lien</a></p>

                </div>
            </div>
        </div><!-- morph-button -->
    </section>

@stop