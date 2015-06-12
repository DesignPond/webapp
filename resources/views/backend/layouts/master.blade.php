<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<html lang="en"  data-ng-app="singular" >
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="app, responsive, angular, bootstrap, dashboard, admin">
    <meta name="token" content="<?php echo csrf_token(); ?>">
    <meta name="token_id" content="<?php echo base64_encode($user->id); ?>">
    <title>RiiingMe</title>

    <!-- App CSS-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/timeline.css') }}">
    <link href="{{ asset('backend/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/the-modal.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/chosen/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/js/FileAPI/jcrop/jquery.Jcrop.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/feather/webfont/feather-webfont/feather.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/intlTelInput.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/jquery.tagit.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('backend/css/media.css') }}">
</head>

<body class="layout-boxed">
    <div class="app-container">

        @include('backend.partials.header')

        @include('backend.partials.navbar')

        <section>
            <div class="app">

                @include('partials.message')

                <!-- Contenu -->
                @yield('content')
                <!-- Fin contenu -->

            </div>

        </section>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="<?php echo asset('backend/js/bootstrap/bootstrap.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/moment.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/daterangepicker.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/intlTelInput.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/jquery-birthday-picker.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/jquery.inputmask.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/notify.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/jquery.infinitescroll.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/jquery.validate.min.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/tag-it.min.js');?>"></script>

    <script> var new_tag_txt = '{{ trans('menu.new_tag') }}'; </script>
    <script> var delete_link = '{{ trans('message.delete_link') }}'; </script>

    <script src="<?php echo asset('backend/js/main.js');?>"></script>
    <script src="<?php echo asset('backend/js/timeline.js');?>"></script>

    <!-- Filter -->
    <script src="<?php echo asset('backend/vendor/isotope/isotope.js');?>"></script>
    <script src="<?php echo asset('backend/js/filter/filter.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/chosen/chosen.jquery.min.js');?>"></script>
    <!-- Riinglink -->
    <script src="<?php echo asset('backend/js/riiinglink.js');?>"></script>

    <!-- Upload and crop -->
    <script src="<?php echo asset('backend/js/jquery/jquery.modal.js');?>"></script>
    <script>
        window.FileAPI = {
            debug: false , staticPath: 'backend/js/jquery.fileapi/FileAPI/'
        };
    </script>
    <script src="<?php echo asset('backend/js/tel-input.js');?>"></script>
    <script src="<?php echo asset('backend/js/FileAPI/FileAPI.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/FileAPI/FileAPI.exif.js');?>"></script>
    <script src="<?php echo asset('backend/js/FileAPI/jquery.fileapi.js');?>"></script>
    <script src="<?php echo asset('backend/js/FileAPI/jcrop/jquery.Jcrop.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/FileAPI/upload.js');?>"></script>

    <div id="popup" class="popup" style="display: none;">
        <div class="popup__body"><div class="js-img"></div></div>
        <div style="margin: 0 0 5px; text-align: center;">
            <div class="js-upload btn btn_browse btn_browse_small">Upload</div>
        </div>
    </div>

</body>
</html>