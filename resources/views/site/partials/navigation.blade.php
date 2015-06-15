<div class="container">
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img style="display: block;width: 120px;" alt="Riiingme" src="{{ asset('frontend/images/logo.svg') }}">
                </a>
                <ul class="nav navbar-nav">
                    <?php $locale = \Session::get('locale'); ?>
                    <li class="<?php echo (!isset($locale) || $locale == 'fr' ? 'active' : ''); ?>">
                        <a href="{{ url('setlang/fr') }}"><img src="{{ asset('backend/images/flags/France.png') }}"></a>
                    </li>
                    <li class="<?php echo ($locale == 'en' ? 'active' : ''); ?>">
                        <a href="{{ url('setlang/en') }}"><img src="{{ asset('backend/images/flags/United-kingdom.png') }}"></a>
                    </li>
                </ul>
            </div>
            <p class="navbar-text navbar-right">{{ trans('menu.deja_inscrit') }} &nbsp;&nbsp; <a href="{{ url('auth/login') }}" class="navbar-link btn btn-sm btn-default">{{ trans('action.login') }}</a></p>
        </div>
    </nav>
</div><!-- end of all wrapper -->