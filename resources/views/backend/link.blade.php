@extends('backend.layouts.master')
@section('content')

<?php
    $host    = $ringlink['label'];
    $invited = $ringlink['invited_labels'];
    $helper  = new \App\Riiingme\Helpers\Helper;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <a href="{{ url('user/'.$user->id) }}" class="btn btn-xs btn-primary">Retour à la liste</a>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <button type="button" class="btn btn-danger btn-xs pull-right">Détruire le partage</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php unset($groupes[1]); ?>

<div class="row">
    <div class="col-md-8 col-xs-12 partage">
        @include('backend.partials.invite')
    </div>
    <div class="col-md-4 col-xs-12 partage">
        @include('backend.partials.host')
    </div>
</div>

@stop