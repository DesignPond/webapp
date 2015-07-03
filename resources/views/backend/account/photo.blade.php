<h4 class="title-adresse">{{ trans('menu.photo') }}</h4>

<fieldset class="row">
    <div class="col-md-8">

        <?php $image = 'avatar.jpg';?>

        @if(isset($groupe_type[0]))

            <?php $image_label = $groupe_type[0]['groupe_type'][1]; ?>

            @if(isset($labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['label']))
                <?php
                    $image    = $labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['label'];
                    $image_id = $labels[$image_label['pivot']['groupe_id']][$image_label['pivot']['type_id']]['id'];
                ?>
                <input type="hidden" name="edit[{{$image_id}}]" id="flow-img" data-label_id="{{$image_id}}" value="{{$image}}">
            @endif
        @endif

        <div class="form-group">
            <div class="col-md-4"></div>
            <div class="col-sm-8">
                <?php $rand = rand(1,123); ?>
                <div id="userpic" class="userpic" style="background-image: url('{{ asset('users/'.$image) }}?{{ $rand }}');">
                    <div class="btn js-fileapi-wrapper">
                        <div class="js-browse">
                            <span class="btn btn-info btn-sm">{{ trans('action.change') }}</span>
                            <input name="file" type="file">
                        </div>
                        <div class="js-upload" style="display: none;">
                            <div class="progress progress-success"><div class="js-progress bar"></div></div>
                            <span class="btn-txt">{{ trans('menu.uploading') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>