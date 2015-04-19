@extends('backend.layouts.master')
@section('content')

    <?php $helper = new \App\Riiingme\Helpers\Helper(); ?>

        <?php
            if(isset($user->user_groups)){
                foreach($user->user_groups as $user_group){
                    $groupe_dates[$user_group->id]['start'] = $user_group->start;
                    $groupe_dates[$user_group->id]['end']   = $user_group->end;
                }
            }
        ?>

        <div class="row">
            <div class="col-md-12">

                {!! Form::open(array( 'url' => 'user/labels' , 'id' => 'editForm',  'class' => 'form-horizontal form-edit')) !!}

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">{{ trans('menu.vosdonnees') }}</div>
                    </div>
                    <div class="panel-body">

                        <?php
                            $informations = $groupe_type[0];
                            $image_label  = $informations['groupe_type'][1];
                            unset($groupe_type[0]);
                        ?>

                        <h4>{{ trans('menu.photo') }}</h4>
                        <fieldset class="row">
                            <div class="col-md-8">

                                @if(isset($labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['label']))
                                    <?php
                                        $image    = $labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['label'];
                                        $image_id = $labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['id'];
                                    ?>
                                    <input type="hidden" name="edit[{{$image_id}}]" id="flow-img" data-label_id="{{$image_id}}" value="{{$image}}">
                                @else
                                    <?php $image = 'avatar.jpg';?>
                                    <input type="hidden" name="label[1][12]" id="flow-img">
                                @endif

                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                    <div class="col-sm-8">
                                        <div id="userpic" class="userpic" style="background-image: url('{{ asset('users/'.$image) }}'); background-size:contain;">
                                            <div class="btn js-fileapi-wrapper">
                                                <div class="js-browse">
                                                    <span class="btn btn-info btn-sm">{{ trans('action.change') }}</span>
                                                    <input name="file" type="file">
                                                </div>
                                                <div class="js-upload" style="display: none;">
                                                    <div class="progress progress-success"><div class="js-progress bar"></div></div>
                                                    <span class="btn-txt">Uploading</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </fieldset>

                        <fieldset class="row border">
                            <h4>{{ trans('menu.informations') }}</h4>
                            <div class="col-md-8 col-xs-12">
                                @if($user->user_type == '1')
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{ trans('menu.firstname') }}</label>
                                        <div class="col-sm-8">
                                            <input value="{{ $user->first_name }}" type="text" name="info[first_name]" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{ trans('menu.lastname') }}</label>
                                        <div class="col-sm-8">
                                            <input value="{{ $user->last_name }}" type="text" name="info[last_name]" class="form-control">
                                        </div>
                                    </div>
                                    <input type="hidden" name="info[company]" value="">
                                @else
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">{{ trans('menu.company') }}</label>
                                        <div class="col-sm-8">
                                            <input value="{{ $user->company }}" type="text" name="info[company]" class="form-control">
                                        </div>
                                    </div>
                                    <input type="hidden" name="info[first_name]" value=""><input type="hidden" name="info[last_name]" value="">
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Login</label>
                                    <div class="col-sm-8">
                                        <input value="{{ $user->email }}" type="text" name="info[email]" class="form-control">
                                    </div>
                                </div>
                                <input type="hidden" name="info[id]" value="{{ $user->id }}">
                                <input type="hidden" name="info[user_type]" value="{{ $user->user_type }}">
                            </div>
                            <span class="clearfix"></span><br/>
                            <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
                        </fieldset>

                        @foreach($groupe_type as $groupe)

                            <?php
                                $temp = ($status[$groupe['id']] == 'temporaire' ? true : false);
                                $daterange = '';
                                $exist     = false;
                                if(isset($groupe_dates[$groupe['id']]))
                                {
                                    $daterange = $groupe_dates[$groupe['id']]['start'].' | '.$groupe_dates[$groupe['id']]['end'];
                                    $exist     = true;
                                }
                            ?>

                            @if($temp)

                               <fieldset class="row border accordion-body collapse <?php echo ($exist ? 'in': ''); ?>" id="collapse_{{ $groupe['id'] }}">
                                    <h4 class="title-adresse">{{ $groupe['titre'] }} <small class="text-danger">{{ trans('menu.temporaire') }}</small></h4>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" for="exampleInputEmail1">{{ trans('menu.periode') }}</label>
                                            <div class="col-sm-8">
                                                <input value="{{ $daterange }}" type="text" name="date[{{ $groupe['id'] }}]" class="form-control daterange">
                                            </div>
                                        </div>
                            @else
                                <fieldset class="row border">
                                    <h4 class="title-adresse">{{ $groupe['titre'] }}</h4>
                                    <div class="col-md-8 col-xs-12">
                            @endif

                                @foreach($groupe['groupe_type'] as $types)

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="input-id-1">{{ $types['titre'] }}</label>
                                        <div class="col-sm-8 col-xs-12">
                                            <?php
                                                $type  = $types['pivot']['type_id'];
                                                $group = $types['pivot']['groupe_id'];
                                            ?>
                                            @if(isset($labels[$group][$type]['label']))
                                                <?php echo $helper->generateInput($type, $group ,true,['id' => $labels[$group][$type]['id'] , 'text' => $labels[$group][$type]['label'] ]); ?>
                                            @else
                                                <?php echo $helper->generateInput($type, $group ,false); ?>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-4 col-xs-12">
                                @if(!$temp && !$exist)

                                    <?php  $collapsible = ($user->user_type == '1' ? $groupe['id'] + 2 : $groupe['id'] + 1); ?>

                                    <a class="btn btn-info btn-sm btn-collapse" data-toggle="collapse" href="#collapse_{{ $collapsible }}" aria-expanded="false" aria-controls="collapseExample">
                                       {{ trans('menu.indiquer') }} <span>{{ $groupe['titre'] }}</span> {{ trans('menu.temporaire') }}
                                    </a>
                                @endif
                            </div>
                            <span class="clearfix"></span><br/>
                            <button class="btn btn-primary btn-sm pull-right" type="submit">{{ trans('action.save') }}</button>
                            </fieldset>
                        @endforeach

                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


@stop