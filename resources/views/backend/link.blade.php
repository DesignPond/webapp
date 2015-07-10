@extends('backend.layouts.master')
@section('content')

<?php
    $host      = $ringlink['label'];
    $invited   = $ringlink['invited_labels'];
    $helper    = new \App\Riiingme\Helpers\Helper;
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <a href="{{ url('user') }}" class="btn btn-xs btn-primary btn-action-link">{{ trans('action.back') }}</a>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <a href="{{ url('destroyLink/'.$ringlink_id) }}" data-action="{{ $ringlink['invited_name'] }}" class="btn btn-danger btn-xs btn-action-link pull-right deleteAction">{{ trans('action.destroy') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    unset($groupes[1]);
    if(isset($host[1])){unset($host[1]);};
?>

<div class="row">
    <div class="col-md-8 col-xs-12 partage">
        @include('backend.partials.invite')
    </div>
    <div class="col-md-4 col-xs-12 partage">
        @include('backend.partials.host')
    </div>
</div>

@stop