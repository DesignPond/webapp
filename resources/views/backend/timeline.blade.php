@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3>Activités</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul id="timeline-content" class="timeline" data-total="{{ $total }}">
                @include('backend.partials.activite')
            </ul>
        </div>
    </div>

@stop