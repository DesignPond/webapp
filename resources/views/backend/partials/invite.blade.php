@include('backend.partials.tags')

    <div class="panel panel-primary">
        <div class="panel-body">
            <ul class="chat">
                <li>
                    <div class="row chat-header">
                        <div class="col-md-2">
                            <span class="chat-img"><img class="img-circle thumb64" alt="Image" src="{{ asset('users/'.$ringlink['invited_photo']) }}"></span>
                        </div>
                        <div class="col-md-10">
                            <h4 class="chat-header-name"><strong>{{ $ringlink['invited_name'] }}</strong></h4>
                        </div>
                    </div>

                    @if(!empty($labels))

                        @foreach($labels as $group => $groupe_label)
                            @if(isset($groupes[$group]))

                                <?php $temp = (in_array($group,[3,4]) ? true : false);  ?>
                                <div class="chat-msg">
                                    <div class="panel bg-info panel-small">
                                        <div class="panel-body text-left">
                                            {{ trans('label.title_'.$group) }}
                                            @if($temp)
                                                <br/>
                                                <span class="text-muted">Valable
                                                <?php
                                                    $dates = $invited_user->filter(function ($item) use ($group) {
                                                        return $item->pivot->groupe_id == $group;
                                                    })->first();

                                                    if ($dates)
                                                    {
                                                        $start = \Carbon\Carbon::parse($dates->pivot->start_at)->formatLocalized('%d %B %Y');
                                                        $end   = \Carbon\Carbon::parse($dates->pivot->end_at)->formatLocalized('%d %B %Y');

                                                        echo ' du '.$start.' au '.$end.'</span>';
                                                    }
                                                ?>
                                            @endif
                                        </div>
                                    </div>
                                    <dl class="dl-horizontal">
                                        @foreach($groupe_label as $type_id => $label)
                                            @if(!empty($label))
                                                <dt>{{ trans('label.label_'.$type_id) }}</dt>
                                                <dd>{{ $label }}</dd>
                                            @endif
                                        @endforeach
                                    </dl>
                                </div>
                            @endif
                        @endforeach

                    @else
                        <div style="border-top: 1px solid #f4f5f5" class="chat-msg">
                             <div class="well-sm">
                                 {{ $ringlink['invited_name'] }} {{ trans('menu.no_partage') }}
                             </div>
                        </div>
                    @endif
                </li>
            </ul>
        </div>
    </div>