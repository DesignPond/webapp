@if(!empty($host))

    <div class="panel panel-info">
        <div class="panel-body">

            <ul class="chat">
                <li>
                    @if(!empty($labels))

                        <?php $informations = $labels[1]; unset($labels[1]); ?>

                        <div class="row chat-header">
                            <div class="col-md-12" style="position: relative;">
                                <h4>Mes données partagées</h4>
                                <p id="saved" class="text-success">Mise à jour ok</p>
                            </div>
                        </div>

                        <form id="formRiiinglink">
                            <div class="riiinglink-list">
                                <input type="hidden" name="riiinglink_id" value="{{ $ringlink['id'] }}">

                                @foreach($labels as $groupe_id => $groupe)

                                    @if(isset($host[$groupe_id]) && isset($groupes_user[$groupe_id]))
                                        <div class="chat-msg">
                                            <div class="panel bg-gray panel-small">
                                                <div class="panel-body text-left">
                                                    {{ $groupes_user[$groupe_id] }}
                                                </div>
                                            </div>

                                            @foreach($groupe as $label)
                                                @include('backend.partials.label-host')
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