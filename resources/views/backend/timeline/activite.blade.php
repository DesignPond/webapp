<?php setlocale(LC_ALL, 'fr_FR.UTF-8'); ?>
   @if(!$activity->isEmpty())

       <?php  $time  = '';  $class = ''; $month = ''; ?>

       @foreach($activity as $activite)

       <?php

           if( $time != $activite->created_at->toDateString() )
           {
               $class = ($class == '' ? 'timeline-inverted' : '');
           }

           if( $month != $activite->created_at->month )
           {
               echo '<li data-datetime="'.$activite->created_at->formatLocalized('%B %Y') .'" class="timeline-separator"></li>';
           }

       ?>

       <li class="<?php echo $class; ?>">
            <div class="timeline-badge bg-{!! $activite->couleur_activite !!}"><i class="fa fa-link"></i></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4 class="timeline-title">
                        <strong>{{ trans('label.'.$activite->user_activite['quoi']) }}</strong>
                        <div class="text-primary">{!! $activite->user_activite['qui'] !!}</div>
                    </h4>
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



