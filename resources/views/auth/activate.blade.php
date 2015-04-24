@extends('auth.layouts.master')
@section('content')

    <section class="row">
        <div class="center-block mt-xl wd-xl">
            <div class="panel panel-grey">
                <div class="panel-body">

                    <h3><strong>{{ trans('message.activation') }}</strong></h3>
                    <p>{{ trans('message.confirmer') }}</p><br/>
                    <p><a href="{{ url('sendActivationLink') }}" class="btn btn-warning">{{ trans('message.renvoyer') }}</a></p>

                </div>
            </div>
        </div><!-- morph-button -->
    </section>

@stop