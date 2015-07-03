@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-7">

        @if(!$latest->isEmpty())

        <div class="panel panel-primary">
            <div class="panel-heading"><div class="panel-title">{{ trans('menu.lastcontact') }}</div></div>
            <!-- List group -->
            <div class="panel-body">
                <ul class="list-group">
                    @foreach($latest as $link)
                        <li class="list-group-item">
                            <div class="media lasted-riiinglink">
                                <div class="pull-left">
                                    <!-- Contact avatar-->
                                    <div class="point-pin">
                                        <a href="#"><img src="{{ asset('users/'.$link->photo) }}" alt="riiinglink" class="media-object img-circle thumb32" /></a>
                                    </div>
                                </div>
                                <!-- Contact info-->
                                <div class="media-body">
                                    <div class="media-heading">
                                        <p class="mb-sm"><strong><a href="{{ url('user/link/'.$link->id) }}" class="text-inverse">{{ $link->invite->name }}</a></strong></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="panel-footer">
                <a href="{{ url('/user/'.$user->id) }}" class="btn btn-sm btn-info pull-right"><small>{{ trans('action.seeall') }}</small></a><span class="clearfix"></span>
            </div>
        </div>

        @else

            <div class="panel panel-primary">
                <div class="panel-heading"><div class="panel-title">{{ trans('menu.welcome') }} {{ $user->name }}!</div></div>
                <ul class="list-group">
                    @if($user->labels->isEmpty())
                        <li class="list-group-item">
                            <div class="media">
                                <a class="media-left media-middle text-muted" href="#"><em class="fa fa-home fa-2x"></em></a>
                                <div class="media-body">
                                    <p class="text-bold">
                                        <span>{{ trans('empty.noinfo') }}</span>
                                        <a href="{{ url('user/'.$user->id) }}" class="btn btn-primary pull-right">{{ trans('action.maj') }}</a>
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <div class="media">
                            <a class="media-left media-middle text-muted" href="#"><em class="fa fa-paper-plane fa-2x"></em></a>
                            <div class="media-body">
                                <p class="text-bold">
                                    <span>{{ trans('empty.contact') }}</span>
                                    <a href="{{ url('user/partage') }}" class="btn btn-success pull-right">{{ trans('action.partager') }}</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        @endif

    </div>

    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title"><em class="icon-clock fa-lg pull-right"></em>{{ trans('menu.activites') }}</div>
            </div>
                <!-- START Activites-->

                @include('backend.partials.activites')

                <!-- END Activites-->
            </div>
        </div>

    </div>
</div>


@stop