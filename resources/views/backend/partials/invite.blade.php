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

                <?php
                    $alllabels = [];
                    if(!empty( $ringlink['invited_labels'] ) && !empty($labels)){
                        $alllabels = $ringlink['invited_labels'] + $labels;
                    }
                ?>

                @if(!empty($alllabels))
                    @foreach($ringlink['invited_labels'] as $group => $groupe_label)
                        @if(isset($groupes[$group]))

                            <?php
                                $otherGroupe  = [2 => 4, 3 => 5];
                                $valable = '';
                                $alllabels    = $ringlink['invited_labels'] + $labels;
                                if(isset($otherGroupe[$group])){
                                    $valable = $helper->validityPeriod($invited_user,$otherGroupe[$group]);
                                }

                            ?>

                            <div class="chat-msg">
                                <div class="panel bg-info panel-small">
                                    <div class="panel-body text-left">{{ trans('label.title_'.$group) }}</div>
                                </div>
                                <dl class="dl-horizontal">

                                    @foreach($groupe_label as $type_id => $label_text)
                                        @if(isset($otherGroupe[$group]) && isset($alllabels[$otherGroupe[$group]]) && !empty($alllabels[$otherGroupe[$group]][$type_id]))
                                            <dt>{{ trans('label.label_'.$type_id) }}</dt>
                                            <dd>
                                                {{ $alllabels[$otherGroupe[$group]][$type_id] }}<br/>
                                                <span class="text-warning">{{ $valable }}</span>
                                            </dd>
                                        @elseif(isset($alllabels[$group][$type_id]) && !empty($alllabels[$group][$type_id]) && !empty($label_text))
                                            <dt>{{ trans('label.label_'.$type_id) }}</dt>
                                            <dd>
                                                {{ $label_text }}
                                            </dd>
                                        @endif
                                    @endforeach

                                </dl>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div style="border-top: 1px solid #f4f5f5" class="chat-msg">
                         <div class="well-sm">{{ $ringlink['invited_name'] }} {{ trans('menu.no_partage') }}</div>
                    </div>
                @endif
            </li>
        </ul>
    </div>
</div>

<p class="text-right"><a href="{{ url('user/partage', ['with' => $ringlink['invited_link']]) }}" class="btn btn-primary">{{ trans('action.more_infos') }}</a></p>
