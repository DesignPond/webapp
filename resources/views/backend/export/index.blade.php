@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">

            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-title">
                        {{ trans('menu.export') }}
                    </div>
                </div>
                <div class="panel-body">
                    <form action="{{ url('export/contacts') }}" method="post" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Quoi</label>
                            <div class="col-sm-10">
                                <div class="checkbox">
                                    <label><input type="checkbox"> Tous mes contacts</label>
                                </div>
                            </div>
                        </div>

                        <hr/>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Que certaines infos</label>

                            @if(!empty($types))
                                <?php  unset($types[12]); $chuncks = array_chunk($types,6); ?>
                                @foreach($chuncks as $all_type)
                                    <div class="col-sm-5">
                                        @foreach($all_type as $type_id => $type)
                                            <div class="checkbox">
                                                <label><input value="{{ $type_id }}" name="labels[]" type="checkbox"> {{ $type }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary" type="submit">{{ trans('menu.export_title') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop