@extends('backend.layouts.master')
@section('content')

<?php
    $host      = $ringlink['label'];
    $invited   = $ringlink['invited_labels'];
    $helper    = new \App\Riiingme\Helpers\Helper;
   // $hasLabels = array_map('array_keys',$ringlink['host_labels']);
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6 col-xs-6">
                        <a href="{{ url('user/'.$user->id) }}" class="btn btn-xs btn-primary">{{ trans('action.back') }}</a>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <button type="button" class="btn btn-danger btn-xs pull-right">{{ trans('action.destroy') }}</button>
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