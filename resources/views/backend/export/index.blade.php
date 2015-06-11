@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading panel-small">
                    <div class="panel-title">
                        {{ trans('menu.export') }}
                    </div>
                </div>
                <form action="{{ url('export/generate') }}" method="post" class="form-horizontal">
                    <div class="panel-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"> {{ trans('menu.who') }}</label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label><input checked id="allContacts" type="checkbox"> {{ trans('menu.export_all') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"></label>
                            <div class="col-sm-10 list_checkbox" id="tags_list">
                                <p class="text-danger"><strong>{{ trans('menu.export_tags') }}</strong></p>
                                @if(!empty($tags))
                                    @foreach($tags as $tag_id => $tag)
                                        <div class="checkbox">
                                            <label><input value="{{ $tag_id }}" name="tags[]" type="checkbox"> {{ $tag }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">{{ trans('menu.quoi') }}</label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label><input checked id="allLabels" type="checkbox"> {{ trans('menu.export_all_info') }}</label><br/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"></label>
                            <div class="col-sm-5 list_checkbox" id="types_list">
                                <p class="text-danger"><strong>{{ trans('menu.export_choix') }}</strong></p>
                                @if(!empty($types))
                                    <?php unset($types[12]); ?>
                                    @foreach($types as $type_id => $type)
                                        <div class="checkbox">
                                            <label><input value="{{ $type_id }}" name="labels[]" type="checkbox">
                                                {{ trans('label.label_'.$type_id) }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-sm-5 list_checkbox" id="groupe_list">
                                <p class="text-danger">&nbsp;</p>
                                @if(!empty($groupes))
                                    <?php unset($groupes[1],$groupes[4],$groupes[5]); ?>
                                    @foreach($groupes as $groupe_id => $groupe)
                                        <div class="checkbox">
                                            <label><input value="{{ $groupe_id }}" name="groupes[]" type="checkbox">
                                                {{ trans('label.title_'.$groupe_id) }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <hr/>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ trans('menu.format') }}</label>
                            <div class="col-sm-5">

                                <select class="form-control" name="format">
                                    <option value="xls">Excel [xls]</option>
                                    <option value="csv">CSV</option>
                                    @if($configs)
                                        <optgroup label="Etiquettes">
                                            @foreach($configs as $code => $config)
                                                <option value="pdf|{{$code}}">{{ $config['etiquettes'] }} par page</option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                </select>

                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary" type="submit">{{ trans('menu.export_title') }}</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop