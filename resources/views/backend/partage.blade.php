@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">{{ trans('action.send') }}</div>
            </div>
            <div class="panel-body">

                {!! Form::open(array( 'url' => 'send' , 'id' => 'sendInvites' , 'class' => 'form-horizontal')) !!}

                <?php
                    $old = old('email'); $value = '';
                    if(isset($email)){$value = $email;}
                    if($old){$value = $old;}
                ?>

                    <div id="tabs_partage">
                        <ul role="tablist" class="nav nav-tabs" id="myTabs">
                            <li class="active" role="presentation">
                                <a aria-expanded="true" aria-controls="home" data-div="simple" data-input="inputEmail" data-toggle="tab" role="tab" id="home-tab" href="#simple">{{ trans('menu.email_simple') }}</a>
                            </li>
                            <li role="presentation" class="">
                                <a aria-controls="multiple" data-toggle="tab" data-div="multiple" data-input="inputMultiple" id="multiple-tab" role="tab" href="#multiple" aria-expanded="false">{{ trans('menu.email_multiple') }}</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div aria-labelledby="simple-tab" id="simple" class="tab-pane fade active in" role="tabpanel">
                                <div class="panel-footer">
                                    <div class="input-group">
                                        <input type="text" id="searchEmail" class="form-control send_input" value="{{ $value }}" placeholder="{{ trans('menu.search') }}">
                                        <input type="hidden" id="inputEmail" class="form-control send_input" name="email" value="{{ $value }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        @if(isset($email))
                                            <input type="hidden" name="exist_partage" value="1">
                                        @endif
                                        <span class="input-group-btn"><button class="btn btn-primary" type="submit">{{ trans('menu.envoyer') }}</button></span>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                            <div aria-labelledby="multiple-tab" id="multiple" class="tab-pane fade" role="tabpanel">
                                <div class="panel-footer">
                                    <div class="input-group">
                                        <input type="text" disabled class="form-control send_input" id="inputMultiple" name="multiple" value="{{ $value }}" placeholder="{{ trans('menu.search_multiple') }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <span class="input-group-btn"><button class="btn btn-primary" type="submit">{{ trans('menu.envoyer') }}</button></span>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="partage" class="row">
                        <div class="col-md-6">
                            <h4><strong><em class="icon-repeat"></em> &nbsp;{{ trans('action.ipartage') }}:</strong></h4>
                            <?php $who = 'host'; ?>
                            @include('backend.partage.host')
                        </div>
                        <div class="col-md-6">
                            <h4><strong><em class="icon-repeat"></em> &nbsp;{{ trans('action.iwant') }}:</strong></h4>
                            <?php $who = 'invited'; ?>
                            @include('backend.partage.invited')
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
                <h4 class="panel-title"><i class="icon-star"></i> &nbsp;{{ trans('menu.demandes') }}</h4>
            </div>
            <div class="panel-body">
                @if(!$demandes->isEmpty())
                    <!-- List group -->
                    <ul class="list-group">
                        @foreach($demandes as $demande)
                            <li class="list-group-item">
                                <strong>{{ $demande->user->email }}</strong>
                                <a href="{{ $demande->url_token  }}" class="btn btn-success pull-right">Accepter</a><br/>
                                <small title="{{ $demande->created_at->format('Y-m-d H:i:s') }}" class="text-muted">
                                    <i class="fa fa-clock-o"></i> &nbsp; {{ $demande->created_at->format('Y-m-d') }}
                                </small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{ trans('menu.nodemandes') }}
                @endif
            </div>
        </div>
    </div><!-- /input-group -->
    <div class="col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h4 class="panel-title"><i class="icon-location"></i> &nbsp;{{ trans('menu.demandesent') }}</h4>
            </div>
            <div class="panel-body">
                @if(!$invites->isEmpty())
                    <!-- List group -->
                    <ul class="list-group">
                        @foreach($invites as $invite)
                            <li class="list-group-item list-partages">
                                <small class="label label-warning" title="{{ $invite->created_at->format('Y-m-d H:i:s') }}">
                                    <i class="fa fa-clock-o"></i> &nbsp;{{ $invite->created_at->format('Y-m-d') }}
                                </small> &nbsp;
                                <strong>{{ $invite->email }}</strong>
                            </li>
                        @endforeach
                    </ul>
                @else
                  {{ trans('menu.noinvites') }}
                @endif
            </div>
        </div>
    </div>
</div>

@stop