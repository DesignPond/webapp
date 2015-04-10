<header data-ng-class="app.theme.topbar" class="ng-scope bg-white"><!-- START Top Navbar-->
    <nav class="navbar topnavbar ng-scope" data-ng-controller="HeaderNavController" role="navigation">
        <!-- START navbar header-->
        <div class="navbar-header bg-inverse" data-ng-class="app.theme.brand">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img class="brand-logo" alt="App Logo" src="{{ asset('backend/images/logo.png') }}">
                <img class="brand-logo-collapsed" alt="App Logo" src="{{ asset('backend/images/logo-single.svg') }}">
            </a>
            <!-- Mobile buttons-->
            <div class="mobile-toggles">
                <!-- Button to show/hide the header menu on mobile. Visible on mobile only.-->
                <a class="menu-toggle" data-ng-click="toggleHeaderMenu()" no-persist="no-persist" toggle-state="hmenu-toggled">
                    <em class="fa fa-cog"></em>
                </a>
                <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
                <a class="sidebar-toggle" no-persist="no-persist" toggle-state="aside-toggled">
                    <em class="fa fa-navicon"></em>
                </a>
            </div>
        </div>
        <!-- END navbar header-->
        <!-- START Nav wrapper-->
        <div class="nav-wrapper collapse navbar-collapse" collapse="headerMenuCollapsed" style="height: 0px;">
            @include('backend.partials.alertes')
        </div>
        <!-- END Nav wrapper-->

    </nav>
    <!-- END Top Navbar-->
</header>