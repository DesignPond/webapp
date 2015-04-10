<?php setlocale(LC_ALL, 'fr_FR.UTF-8'); ?>
   @if(!$activity->isEmpty())
       <?php
           $time  = '';
           $class = '';
           $month = '';
       ?>
       @foreach($activity as $activite)

       <?php

           if( $time != $activite->created_at->toDateString() )
           {
               $class = ($class == '' ? 'timeline-inverted' : '');
           }

           if($activite->user_id == $user->id)
           {
               $partage = '<strong>Vous avez accepté le partage</strong><div class="text-primary">Avec: '.  $activite->invited->name .'</div>';
               $color   = 'primary';
           }
           else
           {
               $partage = '<strong>Partage accepté</strong><div class="text-primary">Par: '. $activite->host->name or $activite->host->company.'</div>';
               $color   = 'success';
           }

           if( $month != $activite->created_at->month )
           {
               echo '<li data-datetime="'.$activite->created_at->formatLocalized('%B %Y') .'" class="timeline-separator"></li>';

           }

       ?>

       <li class="<?php echo $class; ?>">
            <div class="timeline-badge bg-{!! $color !!}"><i class="fa fa-link"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">{!! $partage !!}</h4>
                </div>
                <div class="timeline-body">
                    <p><small class="text-muted">{!! $activite->created_at->formatLocalized('%d %B %Y') !!}</small></p>
                </div>
            </div>
        </li>

        <?php $time  = $activite->created_at->toDateString();  ?>
        <?php $month = $activite->created_at->month; ?>

    @endforeach
@endif



