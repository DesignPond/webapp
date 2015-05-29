<div class="container">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img style="display: block;width: 120px;" alt="Riiingme" src="{{ asset('frontend/images/logo.svg') }}">
                </a>
            </div>
            <p class="navbar-text navbar-right">{{ trans('menu.deja_inscrit') }}&nbsp;&nbsp; <a href="{{ url('auth/login') }}" class="navbar-link btn btn-sm btn-primary">{{ trans('action.login') }}</a></p>
        </div>
    </nav>
</div><!-- end of all wrapper -->