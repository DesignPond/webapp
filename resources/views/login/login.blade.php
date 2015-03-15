@extends('layouts.app')
@section('content')

    <div class="center-block mt-xl wd-xl">
        <!-- START panel-->
        <div class="panel panel-grey">
            <div class="panel-heading text-center">
                <a href="{{ url('/') }}">
                    <img style="width: 70%;" src="{{ asset('frontend/images/logo.svg') }}" alt="Image" class="center-block img-rounded" />
                </a>
            </div>
            <div class="panel-body">
                <p class="text-center pv text-bold">LOGIN</p>

                    {{ Form::open(array(
                        'method'        => 'POST',
                        'class'         => 'mb-lg',
                        'url'           => array('login')))
                    }}
                    <div class="form-group has-feedback">
                        <input required type="email" name="email" placeholder="Votre email" autocomplete="off" class="form-control" />
                        <span class="fa fa-envelope form-control-feedback text-muted"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input required type="password" name="password" placeholder="Votre mot de passe" class="form-control" />
                        <span class="fa fa-lock form-control-feedback text-muted"></span>
                    </div>
                    <div class="checkbox c-checkbox pull-left mt0">
                        <label>
                            <input type="checkbox" name="cookie" value="1" />
                            <span class="fa fa-check"></span>Remember me
                        </label>
                    </div>
                    <br/>
                    <button type="submit" class="btn btn-block btn-info mt-lg">Login</button>
                {{ Form::close() }}
                <p class="text-center text-muted">Ou</p>
                <a href="{{ url('register') }}" class="btn btn-block btn-primary">
                    <strong>Créer un compte</strong>
                </a>
            </div>
        </div>
        <div class="text-center mt">
            <a href="{{ action('RemindersController@getRemind') }}" class="text-muted">Mot de passe perdu?</a>
        </div>

    </div>

@stop