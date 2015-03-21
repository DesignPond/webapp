@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-7">

        @if(!empty($ringlinks))

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Derniers riiinglinks</div>
            </div>
            <!-- List group -->
            <div class="panel-body">
                <ul class="list-group">

                    @foreach($ringlinks as $ringlink)

                        <li class="list-group-item">
                            <div class="media lasted-riiinglink">
                                <div class="pull-left">
                                    <!-- Contact avatar-->
                                    <div class="point-pin">
                                        <?php $photo = (!empty($ringlink['invited_photo']) ? $ringlink['invited_photo'] : 'avatar.jpg' ); ?>
                                        <a href="#"><img src="{{ asset('users/'.$photo) }}" alt="riiinglink" class="media-object img-circle thumb32" /></a>
                                    </div>
                                </div>
                                <!-- Contact info-->
                                <div class="media-body">
                                    <div class="media-heading">
                                        <?php $nom = (!empty($ringlink['invited_name']) ? $ringlink['invited_name'] : '<small class="text-muted">Non indiqué</small>' ); ?>
                                        <p class="mb-sm">
                                            <strong><a href="{{ url('user/link/'.$ringlink['id']) }}" class="text-inverse">{{ $nom }}</a></strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>

                    @endforeach

                </ul>
            </div>
            <div class="panel-footer">
                <a href="{{ url('/user/'.$user->id) }}" class="btn btn-sm btn-info pull-right">
                    <small>Voir tous</small>
                </a>
                <span class="clearfix"></span>
            </div>
        </div>

        @else

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Bienvenue!</div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item">
                        Vous n'avez encore aucun riiinglinks
                    </li>
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
                        <scrollable>

                            <ul class="timeline-alt">
                                @foreach($activity as $event)

                                    <li data-datetime="{{ $event['event']->created_at->format('jS F') }}" class="timeline-separator"></li>

                                    @if($event['type'] == 'invite' && !empty($event['event']))
                                        <!-- START timeline item-->
                                        <li>
                                            <div class="timeline-badge timeline-badge-sm thumb-32 bg-purple">
                                                <em class="fa fa-link"></em>
                                            </div>
                                            <div class="timeline-panel">
                                                <strong>Partage envoyé</strong><div class="text-muted">A: <a href="">{{ $event['event']->email }}</a></div>
                                            </div>
                                        </li>
                                    @endif
                                <!-- END timeline item-->
                                @endforeach
                            </ul>
                        </scrollable>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="#" class="btn btn-sm btn-info"><small>Voir tous</small></a>
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