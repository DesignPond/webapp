@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-7">

        @if(!empty($latest))

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Derniers riiinglinks</div>
            </div>
            <!-- List group -->
            <div class="panel-body">

                <ul class="list-group">

                    @foreach($latest as $link)

                        <li class="list-group-item">
                            <div class="media lasted-riiinglink">
                                <div class="pull-left">
                                    <!-- Contact avatar-->
                                    <div class="point-pin">
                                        <?php $photo = (isset($link->photo) ? $link->photo : 'avatar.jpg' ); ?>
                                        <a href="#"><img src="{{ asset('users/'.$photo) }}" alt="riiinglink" class="media-object img-circle thumb32" /></a>
                                    </div>
                                </div>
                                <!-- Contact info-->
                                <div class="media-body">
                                    <div class="media-heading">
                                        <p class="mb-sm">
                                            <strong>
                                                <a href="{{ url('user/link/'.$link->id) }}" class="text-inverse">{{ $link->invite->name }}</a>
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>

                    @endforeach

                </ul>
            </div>
            <div class="panel-footer">
                <a href="{{ url('/user/'.$user->id) }}" class="btn btn-sm btn-info pull-right"><small>Voir tous</small></a><span class="clearfix"></span>
            </div>
        </div>

        @else

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Bienvenue!</div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">Vous n'avez encore aucun riiinglinks</li>
                    <li class="list-group-item">
                        <a href="{{ url('user/partage') }}" class="btn btn-sm btn-info">
                            <small>Commencer à envoyer des invitations</small>
                        </a>
                    </li>
                </ul>
            </div>

        @endif

    </div>
    <div class="col-md-5">

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title bg-info">
                    <em class="icon-clock fa-lg pull-right text-muted"></em>Activités
                </div>
            </div>
            <div class="panel-body">

                <!-- START timeline-->
                @if( !empty($activity) )

                    <div class="smoothy">

                        <div id="scroll">
                            <ul class="timeline-alt">

                                @foreach($activity as $event)
                                    <?php setlocale(LC_ALL, 'fr_FR.UTF-8'); ?>

                                    @if($event->name == 'created_riiinglink')
                                       <li data-datetime="{{ $event->created_at->formatLocalized('%d %B %Y') }}" class="timeline-separator"></li>
                                        <!-- START timeline item-->
                                        <li>
                                            <div class="timeline-badge timeline-badge-sm thumb-32 bg-purple">
                                                <em class="fa fa-link"></em>
                                            </div>
                                            <div class="timeline-panel">
                                                @if($event->user_id == $user->id)
                                                    <strong>Vous avez accepté le partage</strong><div class="text-muted">Avec: <a href="">{{ $event->invited->name }}</a></div>
                                                @else
                                                    <strong>Partage accepté</strong><div class="text-muted">Par: <a href="">{{ $event->host->name or $event->host->company }}</a></div>
                                                @endif
                                            </div>
                                        </li>
                                        @endif
                                     <!-- END timeline item-->
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <a href="{{ url('user/timeline') }}" class="btn btn-sm btn-info"><small>Voir tous</small></a>
                </div>
                @else
                     <p>Aucune activités pour le moment</p>
                </div>
                @endif
                <!-- END timeline-->
            </div>
        </div>

    </div>
</div>


@stop