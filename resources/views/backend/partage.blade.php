@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Envoyer une demande</div>
            </div>
            <div class="panel-body">

                {!! Form::open(array( 'url' => 'send' , 'class' => 'form-horizontal')) !!}

                    <div class="panel-footer">
                        <div class="input-group">
                            <input type="text" id="searchEmail" required class="form-control" name="email" placeholder="Envoyer à cette email">
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go!</button>
                            </span>
                        </div><!-- /input-group -->
                    </div>

                    <div id="partage" class="row">
                        <div class="col-md-6">
                            <h4><strong><em class="icon-repeat"></em> &nbsp;Je partage les informations suivantes:</strong></h4>
                            <?php $who = 'host'; ?>
                            @include('backend.partials.partage')
                        </div>
                        <div class="col-md-6">
                            <h4><strong><em class="icon-repeat"></em> &nbsp;Je souhaite obtenir les informations suivantes:</strong></h4>
                            <?php $who = 'invited'; ?>
                            @include('backend.partials.partage')
                        </div>
                    </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="icon-location"></i> &nbsp;Demandes reçues</h4>
            </div>
            <div class="panel-body">
                @if(!$invites->isEmpty())
                    <!-- List group -->
                    <ul class="list-group">
                        @foreach($invites as $invite)
                            <li class="list-group-item">
                                <div class="row">
                                    <p class="col-md-8">
                                        <strong><a class="text-inverse" href="#">{{ $invite->invite->email }}</a></strong><br/>
                                        <small class="text-muted">{{ $invite->created_at->format('Y-m-d H:i:s') }}</small>
                                    </p>
                                    <p class="col-md-4 text-right">
                                        <a href="#" class="btn btn-success btn-sm">Accepter</a>
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="panel-body"><p>Encore aucune invitations en cours</p></div>
                @endif
            </div>
        </div>
    </div><!-- /input-group -->
    <div class="col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="icon-location"></i> &nbsp;Demandes envoyés</h4>
            </div>
            <div class="panel-body">
                @if(!$invites->isEmpty())
                    <!-- List group -->
                    <ul class="list-group">
                        @foreach($invites as $invite)
                            <li class="list-group-item">
                                <div class="row">
                                    <p class="mb-sm col-md-7">
                                        <strong><a class="text-inverse" href="#">{{ $invite->invite->email }}</a></strong><br/>
                                        <small class="text-muted">{{ $invite->created_at->format('Y-m-d H:i:s') }}</small>
                                    </p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="panel-body"><p>Encore aucune invitations en cours</p></div>
                @endif
            </div>
        </div>
    </div>
</div>

@stop