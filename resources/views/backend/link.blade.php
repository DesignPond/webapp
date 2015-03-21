@extends('backend.layouts.master')
@section('content')

<?php
    $host    = $ringlink['label'];
    $invited = $ringlink['invited_labels'];

/*
echo '<pre>';
print_r($host);
echo '</pre>';

echo '<pre>';
print_r($host);
echo '</pre>';*/

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <a href="{{ url('user/'.$user->id) }}" class="btn btn-sm btn-primary">Retour à la liste</a>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <button type="button" class="btn btn-danger btn-sm pull-right">Détruire le partage</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php unset($groupes[1]); ?>

<div class="row">
    <div class="col-md-6 col-xs-12 partage">
        @include('backend.partials.host')
    </div>
    <div class="col-md-6 col-xs-12 partage">
        @include('backend.partials.invite')
    </div>
</div>

@stop