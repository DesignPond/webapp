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
    <title>Dashboard</title>
    <!-- App CSS-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/user.css') }}">
    <link href="{{ asset('backend/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/chosen/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/feather/webfont/feather-webfont/feather.css') }}" rel="stylesheet">

</head>

<body class="layout-boxed" flow-prevent-drop data-ng-class="{ 'layout-fixed' : app.layout.isFixed, 'aside-collapsed' : app.sidebar.isCollapsed, 'layout-boxed' : app.layout.isBoxed, 'aside-slide' : app.sidebar.slide, 'in-app': $state.includes('app')}">

    <div class="app-container">

        @include('partials.header')

        @include('partials.navbar')

        <section>
            <div class="app">

                @include('partials.message')

                <!-- Contenu -->
                @yield('content')
                <!-- Fin contenu -->
            </div>
        </section>

        @include('partials.footer')

    </div>

    <script src="<?php echo asset('backend/js/base.js');?>"></script>

    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script src="<?php echo asset('backend/js/jquery.inputmask.bundle.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/moment.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/daterangepicker.js');?>"></script>
    <script src="<?php echo asset('backend/js/ng-flow-standalone.min.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/app.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/isotope/isotope.js');?>"></script>
    <script src="<?php echo asset('backend/js/riiinglink.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/chosen/chosen.jquery.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/filter.js');?>"></script>


</body>

</html>