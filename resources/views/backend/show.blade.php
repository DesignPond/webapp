@extends('backend.layouts.master')
@section('content')

    <div class="row">
        @include('backend.partials.filter')
    </div>

    @if(!empty($riiinglinks))

        <div class="row">
            @foreach($riiinglinks as $link)

                 <div class="col-lg-4 col-md-4 col-xs-12">
                     <a href="{{ url('user/link/'.$link->id) }}">
                        <div class="panel">
                            <div class="panel-body riiinglink-card">
                                <span class="pull-left">
                                   <?php $photo = (!empty($link->photo) ? $link->photo :'avatar.jpg'); ?>
                                   <img class="img-circle thumb48" alt="Image" src="{{ asset('users/'.$photo) }}">
                                </span>
                                <strong class="title">{{ $link->invite->name }}</strong>
                            </div>
                        </div>
                     </a>
                 </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">{!! $pagination->render() !!}</div>
        </div>

    @elseif(!$pagination && !empty($filtres))
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        @if(isset($filtres['tag']))
                            <h4 class="text-danger">Aucun contact ne correspond au filtre <strong>"{{ $tags[$filtres['tag']] }}"</strong></h4>
                        @endif

                        @if(isset($filtres['search']))
                            <h4 class="text-danger">Aucun contact ne correspond a votre recherche <strong>"{{ $filtres['search'] }}"</strong></h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
             <div class="col-md-12">
                 <div class="panel">
                    <div class="panel-body">
                        <p>Vous n'avez encore aucun contact</p>
                        <p><a href="{{ url('user/partage') }}" class="btn btn-sm btn-success"><small>Envoyer des invitations</small></a></p>
                    </div>
                 </div>
             </div>
        </div>
    @endif

@stop