@extends('backend.layouts.master')
@section('content')

<div class="row">

    @if(!empty($ringlink['data']))

         @include('backend.partials.filter')

             @foreach($ringlink['data'] as $link)

             <?php $tags = (!empty($link['tags']) ? implode(' ',$link['tags']): ''); ?>

             <div class="col-lg-4 col-md-4 col-xs-12 <?php echo $tags; ?>">
                 <a href="{{ url('user/link/'.$link['id']) }}">
                    <div class="panel">
                        <div class="panel-body riiinglink-card">
                            <span class="pull-left">
                               <?php $photo = (!empty($link['invited_photo']) ? $link['invited_photo'] :'avatar.jpg'); ?>
                               <img class="img-circle thumb48" alt="Image" src="{{ asset('users/'.$photo) }}">
                            </span>
                            <strong class="title"><?php echo (!empty($link['invited_name']) ? $link['invited_name'] :'Pas indiqué'); ?></strong>
                        </div>
                    </div>
                 </a>
             </div>
         @endforeach

         <div class="col-md-12">{!! $items->render() !!}</div>

    @else
         <div class="col-md-12">
             <div class="panel">
                <div class="panel-body">
                    <p>Vous n'avez encore aucun contact. <a href="{{ url('user/partage') }}" class="btn btn-sm btn-info"><small>Commencer à envoyer des invitations</small></a>
                    </p>
                </div>
             </div>
         </div>
    @endif

</div>

@stop