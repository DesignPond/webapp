@extends('layouts.dashboard')
@section('content')

    <?php $helper = new \App\Riiingme\Helpers\Helper(); ?>
    <div class="row" flow-init flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]" flow-files-submitted="$flow.upload()">
        <div class="col-md-12">

            {!! Form::open(array( 'url' => 'user/labels' , 'class' => 'form-horizontal')) !!}

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

                    <h4>Photo</h4>

                    <fieldset class="row">
                        <div class="col-md-8">
                            @if(isset($labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['label']))
                                <?php
                                $image    = $labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['label'];
                                $image_id = $labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['id'];
                                ?>
                                <input type="hidden" name="edit[{{$image_id}}]" ng-if="$flow.files.length" value="{[{ $flow.files[0].name }]}">
                            @else
                                <?php $image = 'avatar.jpg';?>
                                <input type="hidden" name="label[1][13][]" value="{[{ $flow.files[0].name }]}">
                            @endif

                            <div class="form-group">
                                <div class="col-md-4">
                                    <div ng-show="$flow.files.length"><img class="mb center-block img-circle img-responsive thumb64" flow-img="$flow.files[0]" /></div>
                                    <div><img class="mb center-block img-responsive thumb64" ng-hide="$flow.files.length" src="{{ asset('users/'.$image) }}" /></div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="uploadBtn">
                                        <span class="btn btn-sm btn-warning" ng-show="!$flow.files.length" flow-btn flow-attrs="{accept:'image/*'}">Sélectionner une autre photo</span>
                                        <span class="btn btn-sm btn-danger"  ng-show="$flow.files.length" ng-click="$flow.cancel()">Supprimer</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <h4>Informations</h4>

                    <fieldset class="row">
                        <div class="col-md-8">

                            @if($user->user_type == 'private')
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Prénom</label>
                                    <div class="col-sm-8">
                                        <input value="{{ $user->first_name }}" type="text" name="info[first_name]" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Nom</label>
                                    <div class="col-sm-8">
                                        <input value="{{ $user->last_name }}" type="text" name="info[last_name]" class="form-control">
                                    </div>
                                </div>
                                <input type="hidden" name="info[company]" value="">
                            @else
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Entreprise/association</label>
                                    <div class="col-sm-8">
                                        <input value="{{ $user->company }}" type="text" name="info[company]" class="form-control">
                                    </div>
                                </div>
                                <input type="hidden" name="info[first_name]" value=""><input type="hidden" name="info[last_name]" value="">
                            @endif
                            <div class="form-group">
                                <label class="col-sm-4 control-label">E-mail principal</label>
                                <div class="col-sm-8">
                                    <input value="{{ $user->email }}" type="text" name="info[email]" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="info[id]" value="{{ $user->id }}">
                            <input type="hidden" name="info[user_type]" value="{{ $user->user_type }}">
                        </div>
                    </fieldset>

                    @foreach($groupe_type as $groupe)

                        <h4>{{ $groupe['titre'] }}</h4>

                        <fieldset class="row">

                            <?php $temp = ($status[$groupe['id']] == 'temporaire' ? true : false); ?>

                            <div class="col-md-8">

                                @foreach($groupe['groupe_type'] as $types)
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-id-1">{{ $types['titre'] }}</label>
                                        <div class="col-sm-8">

                                            <?php
                                                $type  = $types['pivot']['type_id'];
                                                $class = $helper->labelClass($type);
                                            ?>

                                            @if(isset($labels[$types['pivot']['groupe_id']][$types['pivot']['type_id']]['label']))
                                                <?php
                                                    $label = $labels[$types['pivot']['groupe_id']][$types['pivot']['type_id']]['label'];
                                                    $id    = $labels[$types['pivot']['groupe_id']][$types['pivot']['type_id']]['id'];
                                                ?>
                                                <input value="{{ $label }}" type="text" name="edit[{{$id}}]" class="form-control {{$class}}">
                                            @else
                                                <input value="" type="text" name="label[{{ $types['pivot']['groupe_id'] }}][{{ $types['pivot']['type_id'] }}][]" class="form-control {{$class}}">
                                            @endif

                                        </div>
                                    </div>
                                @endforeach

                            </div>

                           @if($temp)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Adresse valable durant la période</label>
                                    <input value="" type="text" name="daterange_{{ $groupe['id'] }}" class="form-control">
                                </div>
                            </div>
                            @endif

                        </fieldset>

                    @endforeach

                </div>
                <div class="panel-footer"><button class="btn btn-primary" type="submit">Go!</button></div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>

@stop