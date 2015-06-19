@include('backend.partials.tags')

<?php
/*-echo '<pre>';
print_r($labels);
echo '</pre>';
-*/
?>

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

                            <?php
                                $temp = (in_array($group,[4,5]) ? true : false);
                                $isGroupe  = [4 => 2, 5 => 3];
                                $alllabels = $ringlink['invited_labels'];
                                $valable   = '';
                            ?>

                            <div class="chat-msg">
                                <div class="panel bg-info panel-small">
                                    <div class="panel-body text-left">
                                        {{ trans('label.title_'.$group) }}
                                    </div>
                                </div>
                                <dl class="dl-horizontal">

                                    <?php $valable = $helper->validityPeriod($invited_user,$group); ?>

                                    @foreach($group_type_data[$group] as $type_data_id)

                                        @if( isset($groupe_label[$type_data_id]) && !empty($groupe_label[$type_data_id]) )
                                            <dt>{{ trans('label.label_'.$type_data_id) }}</dt>
                                            <dd>
                                                {{ $groupe_label[$type_data_id] }}<br/>
                                                <span class="text-warning">{{ $valable }}</span>
                                            </dd>

                                        @elseif($temp && isset($isGroupe[$group]) && isset($alllabels[$isGroupe[$group]][$type_data_id]) && !empty($group_type_data[$isGroupe[$group]][$type_data_id]) )
                                            <dt>{{ trans('label.label_'.$type_data_id) }}</dt>
                                            <dd>
                                                {{ $alllabels[$isGroupe[$group]][$type_data_id] }}
                                            </dd>

                                        @endif
                                    @endforeach

                                    {{--
                                    @foreach($groupe_label as $type_id => $label)
                                        @if(!empty($label))
                                            <dt>{{ trans('label.label_'.$type_id) }}</dt>
                                            <dd>{{ $label }}</dd>
                                        @endif
                                    @endforeach
                                    --}}

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