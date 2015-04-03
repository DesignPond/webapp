@if(!empty($invited))

    <div class="panel panel-primary">
        <div class="panel-body">

            <ul class="chat">
                <li>

                    <?php
                        if(isset($invited[1]))
                        {
                            $informations = $invited[1];
                            unset($invited[1]);
                        }
                    ?>

                    <div class="row chat-header">
                        <div class="col-md-2">
                            <span class="chat-img"><img class="img-circle thumb64" alt="Image" src="{{ asset('users/'.$ringlink['invited_photo']) }}"></span>
                        </div>
                        <div class="col-md-5">
                            <h4><strong>{{ $ringlink['invited_name'] }}</strong></h4>
                        </div>
                        <div class="col-md-5">
                            <ul id="myTags">
                                <li>Tag1</li>
                                <li>Tag2</li>
                            </ul>
                        </div>
                    </div>

                    @foreach($invited as $group => $groupe_label)
                        @if(isset($groupes[$group]))
                            <div class="chat-msg">
                                <div class="panel bg-info panel-small">
                                    <div class="panel-body text-left">
                                        {{ $groupes[$group] }}
                                    </div>
                                </div>
                                <dl class="dl-horizontal">
                                @foreach($groupe_label as $type_id => $label)
                                    <dt>{{ $types[$type_id] }}</dt>
                                    <dd>{{ $label }}</dd>
                                @endforeach
                                </dl>
                            </div>
                        @endif
                    @endforeach

                </li>
            </ul>

        </div>
    </div>

@endif