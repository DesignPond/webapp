@extends('layouts.dashboard')
@section('content')

    <div class="row" flow-init flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]" flow-files-submitted="$flow.upload()">
        <div class="col-md-10 col-md-push-1">

            {{ Form::open(array( 'methode' => 'post', 'url' => 'user/labels' , 'class' => 'form-horizontal')) }}

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">Vos données</div>
                </div>
                <div class="panel-body">

                    <?php
                        $informations = $groupe_type[0];
                        $image_label  = $informations['groupe_type'][1];
                        unset($groupe_type[0]);
                    ?>

                    <h4>{{ $informations['titre'] }}</h4>

                    <fieldset>

                        <div class="form-group">
                            <div class="col-md-2">
                                <div ng-show="$flow.files.length"><img class="mb center-block img-circle img-responsive thumb64" flow-img="$flow.files[0]" /></div>
                            </div>
                            <label class="col-sm-2 control-label" for="input-id-1">{{ $image_label['titre'] }}</label>
                            <div class="col-sm-8">
                                <div class="uploadBtn">
                                    <span class="btn btn-xs btn-info" ng-hide="$flow.files.length" flow-btn flow-attrs="{accept:'image/*'}">Selectionner image</span>
                                    <span class="btn btn-xs btn-warning" ng-show="$flow.files.length" flow-btn flow-attrs="{accept:'image/*'}">Changer</span>
                                    <span class="btn btn-xs btn-danger" ng-show="$flow.files.length" ng-click="$flow.cancel()">Supprimer</span>
                                </div>
                                <div ng-hide="!$flow.files.length"><img src="{{ asset('users/avatar.jpg') }}" /></div>
                                <input type="hidden" name="label[1][13][]"  value="{[{ $flow.files[0].name }]}">
                            </div>
                        </div>

                    </fieldset>

                    @foreach($groupe_type as $groupe)

                        <h4>{{ $groupe['titre'] }}</h4>

                        <fieldset>
                            @foreach($groupe['groupe_type'] as $types)
                                <div class="form-group">
                                    <label class="col-sm-4 control-label" for="input-id-1">{{ $types['titre'] }}</label>
                                    <div class="col-sm-8">
                                        <input value="" type="text" name="label[{{ $types['pivot']['groupe_id'] }}][{{ $types['pivot']['type_id'] }}][]" class="form-control">
                                    </div>
                                </div>
                            @endforeach
                        </fieldset>

                    @endforeach

                </div>
                <div class="panel-footer"><button class="btn btn-primary" type="submit">Go!</button></div>
            </div>
            {{ Form::close() }}

        </div>
    </div>

@stop