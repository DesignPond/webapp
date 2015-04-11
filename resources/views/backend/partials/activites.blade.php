@if( !$activity->isEmpty() )

    <div class="panel-body">
        <div class="smoothy">
            <div id="scroll">
                <ul class="timeline-alt">
                    @foreach($activity as $event)

                        <li data-datetime="{{ $event->created_at->formatLocalized('%d %B %Y') }}" class="timeline-separator"></li>
                        <li>
                            <div class="timeline-badge timeline-badge-sm thumb-32 bg-{{ $event->type_activite['color'] }}"><em class="fa fa-link"></em></div>
                            <div class="timeline-panel">
                                <strong>{{ $event->type_activite['quoi'] }}</strong>
                                <div class="text-muted"><a href="">{{ $event->type_activite['qui'] }}</a></div>
                            </div>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <a href="{{ url('user/timeline') }}" class="btn btn-sm btn-info pull-right"><small>Voir tous</small></a><span class="clearfix"></span>
    </div>
@else
    <div class="panel-body">Aucune activités pour le moment</div>
@endif
