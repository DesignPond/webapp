@if( !$activity->isEmpty() )

    <div class="panel-body">
        <div class="smoothy">
            <div id="scroll">
                <ul class="timeline-alt">
                    @foreach($activity as $event)

                        <li data-datetime="{{ $event->created_at->formatLocalized('%d %B %Y') }}" class="timeline-separator"></li>
                        <li>
                            <div class="timeline-badge timeline-badge-sm thumb-32 bg-{{ $event->couleur_activite }}"><em class="fa fa-link"></em></div>
                            <div class="timeline-panel">
                                <strong>{{ trans('label.'.$event->user_activite['quoi']) }}</strong>
                                <div class="text-muted"><a href="">{!! $event->user_activite['qui'] !!}</a></div>
                            </div>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <a href="{{ url('user/timeline') }}" class="btn btn-sm btn-info pull-right"><small>{{ trans('action.seeall') }}</small></a><span class="clearfix"></span>
    </div>
@else
    <div class="panel-body">{{ trans('empty.activites') }}</div>
@endif
