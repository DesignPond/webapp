<header class="bg-white"><!-- START Top Navbar-->
    <nav class="navbar topnavbar" role="navigation">
        <!-- START navbar header-->
        <div class="navbar-header bg-navbar">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="brand-logo" alt="App Logo" src="{{ asset('backend/images/logo-riiingme.svg') }}">
            </a>

            <!-- Mobile buttons-->
            <div class="mobile-toggles">
                <!-- Button to show/hide the header menu on mobile. Visible on mobile only.-->
                <a class="menu-toggle" data-toggle="collapse" href="#collapseAlertes"><em class="fa fa-bell"></em></a>
                <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                <a class="sidebar-toggle" data-toggle="collapse" href="#collapseSidebar"><em class="fa fa-navicon"></em></a>
            </div>

        </div>
        <!-- END navbar header-->

        <!-- START Nav wrapper-->
        <div class="nav-wrapper collapse navbar-collapse" id="collapseAlertes" style="height: 0px;">
            <div class="nav-shadow">
                <ul class="nav navbar-nav navbar-left nav-language">
                    <?php $locale = \Session::get('locale'); ?>
                    <li class="<?php echo (!isset($locale) || $locale == 'fr' ? 'active' : ''); ?>">
                        <a href="{{ url('setlang/fr') }}">Français</a>
                    </li>
                    <li class="<?php echo ($locale == 'en' ? 'active' : ''); ?>">
                        <a href="{{ url('setlang/en') }}">English</a>
                    </li>
                </ul>
                @include('backend.partials.alertes')
                <span class="clearfix"></span>
            </div>
        </div>
        <!-- END Nav wrapper-->

    </nav>
    <!-- END Top Navbar-->
</header>