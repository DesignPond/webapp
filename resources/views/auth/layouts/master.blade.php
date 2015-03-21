<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<html lang="fr">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="Riiingme">
    <title>Riiingme</title>

    <!-- App CSS-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/user.css') }}">
    <link href="{{ asset('backend/vendor/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/feather/webfont/feather-webfont/feather.css') }}" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</head>

<body class="layout-boxed">
    <div class="container">

        <section>
            <div class="app">

                <div class="center-block mt-xl wd-xl">
                    @include('partials.message')
                </div>

                <!-- Contenu -->
                @yield('content')
                <!-- Fin contenu -->

            </div>
        </section>

        @include('partials.footer')

    </div>
    <script src="<?php echo asset('backend/js/main.js');?>"></script>
</body>

</html>