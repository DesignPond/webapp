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
    <title>Dashboard</title>
    <!-- App CSS-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/user.css') }}">
    <link href="{{ asset('backend/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/the-modal.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/chosen/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/js/FileAPI/jcrop/jquery.Jcrop.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/feather/webfont/feather-webfont/feather.css') }}" rel="stylesheet">

</head>

<body class="layout-boxed" flow-prevent-drop data-ng-class="{ 'layout-fixed' : app.layout.isFixed, 'aside-collapsed' : app.sidebar.isCollapsed, 'layout-boxed' : app.layout.isBoxed, 'aside-slide' : app.sidebar.slide, 'in-app': $state.includes('app')}">

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

        @include('backend.partials.footer')

    </div>

    <script src="<?php echo asset('backend/js/base.js');?>"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="<?php echo asset('backend/js/bootstrap/bootstrap.file-input.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery/jquery.inputmask.bundle.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/moment.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/daterangepicker.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/app.js');?>"></script>
    <script src="<?php echo asset('backend/js/main.js');?>"></script>
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
            debug: false ,
            staticPath: 'backend/js/jquery.fileapi/FileAPI/'
        };
    </script>
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