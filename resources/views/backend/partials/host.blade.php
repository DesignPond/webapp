@if(!empty($host))

    <?php unset($groupe_type[0]); ?>
    <div class="panel panel-info">
        <div class="panel-body">
            <ul class="chat">

                @if(!empty($groupe_type))
                    <li>
                        <div class="chat-header">
                            <p class="text-muted">{{ trans('menu.infopartage') }}: </p>
                            <h3>{{ $ringlink['invited_name'] }}</h3>
                        </div>
                        <form id="formRiiinglink">
                            <div class="riiinglink-list">
                                <input type="hidden" name="riiinglink_id" value="{{ $ringlink['id'] }}">

                                <?php $visible = [2,3,6]; ?>

                                @foreach($groupe_type as $items)
                                    @if(isset($host[$items['id']]) && isset($groupes_user[$items['id']]))

                                        @if(in_array($items['id'],$visible))
                                            <div class="panel bg-medium-grey panel-small">
                                                <div class="panel-body text-left">
                                                    {{ trans('label.title_'.$items['id']) }}
                                                </div>
                                            </div>

                                            @foreach($items['groupe_type'] as $label)
                                                @include('backend.partials.label-host')
                                            @endforeach
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        </form>
                    </li>
                @endif

            </ul>
        </div>
    </div>
@else

    <div class="panel panel-info">
        <div class="panel-body">
            <div class="well-sm text-center">
                <h4>{{ trans('menu.noinfopartage') }}</h4>
                <p><a href="{{ url('user/'.$user->id.'/edit') }}" class="btn btn-warning">{{ trans('menu.majinfos') }}!</a></p>
            </div>
        </div>
    </div>

@endif