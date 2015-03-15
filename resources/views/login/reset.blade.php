@extends('layouts.app')
@section('content')

    {{ Form::open(array('method'=> 'POST', 'action' => 'RemindersController@postReset')) }}

        <div class="panel-body">
            <h4 class="text-center" style="margin-bottom: 25px;">Définir un nouveau mot de passe</h4>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control" id="email" name="email" placeholder="email">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="mot de passe">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="confirmer le mot de passe">
                    </div>
                </div>
            </div>

        </div>
        <div class="panel-footer">
            <div class="pull-right">
                <input type="hidden" name="token" value="{{ $token }}">
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </div>
        </div>

    {{ Form::close() }}

@stop