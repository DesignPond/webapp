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
    <title>Dashboard</title>
    <!-- App CSS-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/user.css') }}">
    <link href="{{ asset('backend/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/the-modal.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/vendor/chosen/chosen.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/js/jcrop/jquery.Jcrop.min.css') }}" rel="stylesheet">
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
    <script src="<?php echo asset('backend/js/bootstrap.file-input.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery.inputmask.bundle.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/moment.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/daterangepicker.js');?>"></script>
    <script src="<?php echo asset('backend/js/ng-flow-standalone.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/ng-img-crop.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery.modal.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/slimscroll/jquery.slimscroll.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/app.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/isotope/isotope.js');?>"></script>
    <script src="<?php echo asset('backend/js/riiinglink.js');?>"></script>
    <script src="<?php echo asset('backend/vendor/chosen/chosen.jquery.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/filter.js');?>"></script>

    <script>
        window.FileAPI = {
            debug: false ,
            staticPath: 'backend/js/jquery.fileapi/FileAPI/'
        };
    </script>
    <script src="<?php echo asset('backend/js/FileAPI/FileAPI.min.js');?>"></script>
    <script src="<?php echo asset('backend/js/FileAPI/FileAPI.exif.js');?>"></script>
    <script src="<?php echo asset('backend/js/jquery.fileapi.js');?>"></script>
    <script src="<?php echo asset('backend/js/jcrop/jquery.Jcrop.min.js');?>"></script>
    <script>

        var url  = location.protocol + "//" + location.host+"/";

        $('#userpic').fileapi({
            url: url + 'upload',
            accept: 'image/*',
            data:{_token: $("meta[name='token']").attr('content')},
            imageSize: { minWidth: 200, minHeight: 200 },
            elements: {
                active: { show: '.js-upload', hide: '.js-browse' },
                preview: {
                    el: '.js-preview',
                    width: 200,
                    height: 200
                },
                progress: '.js-progress'
            },
            onComplete: function (evt, uiEvt){
                var file = uiEvt.file;
                $("#flow-img").val(file.name);
                $("#img-thumb").attr("src", url + 'users/' + file.name );
                $("#userpic").css('background-image', 'url(' + url + 'users/' + file.name + ')').css('background-size', 'contain');
                console.log(file.name);
            },
            onSelect: function (evt, ui){
                var file = ui.files[0];
                if( !FileAPI.support.transform ) {
                    alert('Your browser does not support Flash :(');
                }
                else if( file ){
                    $('#popup').modal({
                        closeOnEsc: true,
                        closeOnOverlayClick: false,
                        onOpen: function (overlay){
                            $(overlay).on('click', '.js-upload', function (){
                                $.modal().close();
                                $('#userpic').fileapi('upload');
                            });
                            $('.js-img', overlay).cropper({
                                file: file,
                                bgColor: '#fff',
                                maxSize: [$(window).width()-100, $(window).height()-100],
                                minSize: [200, 200],
                                selection: '90%',
                                onSelect: function (coords){
                                    $('#userpic').fileapi('crop', file, coords);
                                }
                            });
                        }
                    }).open();
                }
            }
        });

    </script>

    <div id="popup" class="popup" style="display: none;">
        <div class="popup__body"><div class="js-img"></div></div>
        <div style="margin: 0 0 5px; text-align: center;">
            <div class="js-upload btn btn_browse btn_browse_small">Upload</div>
        </div>
    </div>
</body>

</html>