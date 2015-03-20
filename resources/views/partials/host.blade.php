@if(!empty($host))

    <div class="panel panel-info">
        <div class="panel-body">

            <ul class="chat">
                <li>
                    @if(!empty($labels))

                        <?php $informations = $labels[1]; unset($labels[1]); ?>

                        <div class="row chat-header">
                            <div class="col-md-2">
                                <span class="chat-img"><img class="img-circle thumb48" alt="Image" src="{{ asset('users/'.$ringlink['host_photo']) }}"></span>
                            </div>
                            <div class="col-md-10">
                                <h4><a class="text-inverse" href="#"><strong>{{ $ringlink['host_name'] }}</strong></a></h4>
                                <h5><a class="text-inverse" href="mailto:{{ $ringlink['host_email'] }}"><em class="icon-mail"></em> &nbsp;{{ $ringlink['host_email'] }}</a></h5>
                            </div>
                        </div>

                        <form id="formRiiinglink">
                            <div class="riiinglink-list">
                                <input type="hidden" name="riiinglink_id" value="{{ $ringlink['id'] }}">

                                @foreach($labels as $groupe_id => $groupe)

                                    @if(isset($host[$groupe_id]) && isset($groupes_user[$groupe_id]))
                                        <div class="chat-msg">
                                            <div class="panel bg-info panel-small">
                                                <div class="panel-body text-center">
                                                    {{ $groupes_user[$groupe_id] }}
                                                </div>
                                            </div>

                                            @foreach($groupe as $label)
                                                @include('partials.label-host')
                                            @endforeach

                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </form>

                    @endif
                </li>
            </ul>

        </div>
    </div>

@endif