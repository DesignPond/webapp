<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js IE lt-ie9 lt-ie8 lt-ie7"></html><![endif]-->
<!--[if IE 7]><html class="no-js IE lt-ie9 lt-ie8"></html><![endif]-->
<!--[if IE 8]><html class="no-js IE lt-ie9"></html><![endif]-->
<!--[if gt IE 8]><html class="no-js IE gt-ie8"></html><![endif]-->
<!--[if !IE]><!--><html class="no-js"><!--<![endif]-->
<head>

    <!-- title -->
    <title>RiiingMe</title>

    <!-- meta tags -->
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1,maximum-scale=1" name="viewport">
    <meta content="@Designpond" name="author">
    <meta content="Riiingme" name="Service de partage de données">

    <!-- fav icon -->
    <link href="<?php echo asset('frontend/images/favicon.png');?>" rel="shortcut icon">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700italic,700,800,800italic,300italic,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <!-- css => style sheet -->
    <link href="<?php echo asset('frontend/css/main.css');?>" media="screen" rel="stylesheet" type="text/css">

</head>

<body>

    <!-- Navigation -->
    @include('site.partials.navigation')

    <!-- Contenu -->
    @yield('content')
    <!-- Fin contenu -->

    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
