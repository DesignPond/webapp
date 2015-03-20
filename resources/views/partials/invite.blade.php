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
                            <span class="chat-img"><img class="img-circle thumb48" alt="Image" src="{{ asset('users/'.$ringlink['invited_photo']) }}"></span>
                        </div>
                        <div class="col-md-10">
                            <h4><a class="text-inverse" href="#"><strong>{{ $ringlink['invited_name'] }}</strong></a></h4>
                            <h5><a class="text-inverse" href="mailto:{{ $ringlink['invited_email'] }}"><em class="icon-mail"></em> &nbsp;{{ $ringlink['invited_email'] }}</a></h5>
                        </div>
                    </div>

                    @foreach($invited as $group => $groupe_label)
                        @if(isset($groupes[$group]))
                            <div class="chat-msg">
                                <div class="panel bg-info panel-small">
                                    <div class="panel-body text-center">
                                        {{ $groupes[$group] }}
                                    </div>
                                </div>
                                @foreach($groupe_label as $type_id => $label)
                                    @include('partials.label-invite')
                                @endforeach
                            </div>
                        @endif
                    @endforeach

                </li>
            </ul>

        </div>
    </div>

@endif