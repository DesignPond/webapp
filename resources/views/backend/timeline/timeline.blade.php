@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <h3>{{ trans('menu.activites') }}</h3>
            <ul id="timeline-content" class="timeline" data-total="{{ $total }}">
                @include('backend.timeline.activite')
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="timelineLoader"></div>
            <a id="updateTimeline" class="btn btn-default">{{ trans('action.moreactivites') }}</a>
        </div>
    </div>

@stop