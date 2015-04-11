@if(!empty($host))

    <?php unset($labels[1]); ?>

    <div class="panel panel-info">
        <div class="panel-body">
            <ul class="chat">
                @if(!empty($labels))
                    <li>
                        <div class="chat-header">
                            <p class="text-muted">Données partagées avec: </p>
                            <h3>{{ $ringlink['invited_name'] }}</h3>
                        </div>
                        <form id="formRiiinglink">
                            <div class="riiinglink-list">
                                <input type="hidden" name="riiinglink_id" value="{{ $ringlink['id'] }}">
                                @foreach($labels as $groupe_id => $groupe)
                                    @if(isset($host[$groupe_id]) && isset($groupes_user[$groupe_id]))
                                        <div class="panel bg-gray panel-small">
                                            <div class="panel-body text-left">{{ $groupes_user[$groupe_id] }}</div>
                                        </div>
                                        @foreach($groupe as $label)
                                            @include('backend.partials.label-host')
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>

@endif