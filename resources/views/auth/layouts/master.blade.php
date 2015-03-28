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
    <link href="{{ asset('backend/vendor/fontawesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/feather/webfont/feather-webfont/feather.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/user.css') }}" />

</head>

<body>
    <div class="container">
        <section>
            <div>

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

</body>

</html>