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

                    @if(!empty($invited))

                        <?php if(isset($invited[1])){ unset($invited[1]); }  ?>
                        @foreach($invited as $group => $groupe_label)
                            @if(isset($groupes[$group]))
                                <div class="chat-msg">
                                    <div class="panel bg-info panel-small">
                                        <div class="panel-body text-left">{{ $groupes[$group] }}</div>
                                    </div>
                                    <dl class="dl-horizontal">
                                    @foreach($groupe_label as $type_id => $label)
                                        <dt>{{ $types[$type_id] or ''}}</dt>
                                        <dd>{{ $label }}</dd>
                                    @endforeach
                                    </dl>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="border-top: 1px solid #f4f5f5" class="chat-msg">
                             <div class="well-sm">
                                 {{ $ringlink['invited_name'] }} n'a pas encore partagé d'informations
                             </div>
                        </div>
                    @endif
                </li>
            </ul>
        </div>
    </div>