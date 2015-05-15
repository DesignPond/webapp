@extends('backend.layouts.master')
@section('content')

    <?php $helper = new \App\Riiingme\Helpers\Helper(); ?>

        <?php
            if(isset($user->user_groups))
            {
                foreach($user->user_groups as $user_group)
                {
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

                            @include('backend.account.photo')
                            @include('backend.account.infos')

                            @if($user->user_type == '1')

                                @include('backend.account.prive', ['view' => $groupe_type[1], 'prive' => true])
                                @include('backend.account.temp',  ['view' => $groupe_type[3], 'prive' => false])

                                @include('backend.account.prive', ['view' => $groupe_type[2], 'prive' => false])
                                @include('backend.account.temp',  ['view' => $groupe_type[4], 'prive' => false])

                            @endif

                            @if($user->user_type == '2')
                                @include('backend.account.company', ['view' => $groupe_type[1], 'prive' => true])
                            @endif
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


@stop