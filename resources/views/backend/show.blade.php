@extends('backend.layouts.master')
@section('content')

    @if(!empty($ringlink['data']))

        @include('backend.partials.filter')

        <?php  $filter = array('famille','amis','professionnel');  ?>

        <div class="isotope">
            <div class="row">
             @foreach($ringlink['data'] as $link)
                <div class="col-lg-6 col-md-6 col-xs-12 element-item">
                    <div class="panel panel-info">
                        <div class="panel-body">
                            <ul class="chat row">
                                <li class="link clearfix">
                                  <span class="chat-img pull-left">
                                      <?php $photo = (!empty($link['invited_photo']) ? $link['invited_photo'] :'avatar.jpg'); ?>
                                     <img class="img-circle thumb48" alt="Image" src="{{ asset('users/'.$photo) }}">
                                  </span>
                                  <div class="clearfix">
                                    <div class="chat-header">
                                        <a class="text-inverse" href="{{ url('user/link/'.$link['id']) }}">
                                            <?php $name = (!empty($link['invited_name']) ? $link['invited_name'] :'Pas indiqué'); ?>
                                            <strong class="title">{{ $name }}</strong>
                                        </a>
                                        <small class="pull-right text-muted">
                                            <a class="mr btn btn-xs btn-oval btn-info" href="{{ url('user/link/'.$link['id']) }}">Voir</a>
                                        </small>
                                    </div>
                                  </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
             </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                {!! $items->render() !!}
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Vous n'avez encore aucun contact</p>
                        <p>
                            <a href="{{ url('user/partage') }}" class="btn btn-sm btn-info">
                                <small>Commencer à envoyer des invitations</small>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

@stop