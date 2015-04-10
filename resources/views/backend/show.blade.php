@extends('backend.layouts.master')
@section('content')

<div class="row">

    @if(!empty($riiinglinks))

        @include('backend.partials.filter')

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

        <div class="col-md-12">{!! $pagination->render() !!}</div>

    @else
         <div class="col-md-12">
             <div class="panel">
                <div class="panel-body">
                    <p>Vous n'avez encore aucun contact</p>
                    <p><a href="{{ url('user/partage') }}" class="btn btn-sm btn-success"><small>Envoyer des invitations</small></a></p>
                </div>
             </div>
         </div>
    @endif

</div>

@stop