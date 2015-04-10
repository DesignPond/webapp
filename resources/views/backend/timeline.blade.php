@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3>Activités</h3>
            <ul id="timeline-content" class="timeline" data-total="{{ $total }}">
                @include('backend.partials.activite')
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="timelineLoader"></div>
            <a id="updateTimeline" class="btn btn-default">Afficher plus d'activités</a>
        </div>
    </div>

@stop