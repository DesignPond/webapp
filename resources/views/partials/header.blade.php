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
            <!-- START Left navbar-->
            <ul class="nav navbar-nav">
                <li>
                    <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
                    <a class="hidden-xs" data-ng-click="app.sidebar.isCollapsed = !app.sidebar.isCollapsed" href="#">
                        <em class="fa fa-caret-left" data-ng-class="app.sidebar.isCollapsed ? 'fa-caret-right':'fa-caret-left'"></em>
                    </a>
                </li>
            </ul>
            <!-- END Left navbar-->
            <!-- START Right Navbar-->
            <ul class="nav navbar-nav navbar-right">
                <!-- START Alert menu-->
                <li class="dropdown dropdown-list">
                    <a class="dropdown-toggle" dropdown-animate="" href="#" aria-haspopup="true" aria-expanded="false">
                        <div class="point-pin">
                            <em class="icon-mail fa-fw"></em>
                            <div class="point point-success point-lg"></div>
                        </div>
                        <span class="visible-xs-inline ml">View Alerts</span>
                    </a>
                    <!-- START Dropdown menu-->
                    <ul class="dropdown-menu fadeInLeft2 animated" offcanvas-dropdown="">
                        <!-- START list item-->
                        <li data-ng-click="cancel($event)" data-ng-init="offcontent1 = true">
                            <a class="p" data-ng-click="offcontent1 = false" href="#">
                                <!-- START media preview-->
                                <div class="media">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <div class="point point-success point-lg"></div>
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="m0">Francis Butler</p>
                                        <p class="m0 text-gray text-sm">5 minutes ago</p>
                                    </div>
                                </div>
                            </a>
                            <!-- START offcanves content-->
                            <div class="offcanvas-content p ng-hide" data-ng-click="cancel($event)" data-ng-hide="offcontent1">
                                <div class="offcanvas-toggle pull-right text-gray">
                                    <em class="fa fa-times" data-ng-click="offcontent1 = true"></em>
                                </div>
                                <div class="media mt0 mb clearfix">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <div class="point point-success point-lg"></div>
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="m0">Clifford Bell</p>
                                        <p class="m0 text-gray text-sm">5 minutes ago</p>
                                    </div>
                                </div>
                                <p>
                                    <em>Donec ornare dui non eros dapibus ullamcorper. Cras nunc velit, bibendum
                                        vel imperdiet eget, posuere nec diam. Sed vel elementum ante.</em>
                                </p>
                            </div>
                        </li>
                        <!-- START list item-->
                        <li class="bt" data-ng-click="cancel($event)" data-ng-init="offcontent2 = true">
                            <a class="p" data-ng-click="offcontent2 = false" href="#">
                                <!-- START media preview-->
                                <div class="media">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <div class="point point-warning point-lg"></div>
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="m0">Arron Sutton</p>
                                        <p class="m0 text-gray text-sm">45 minutes ago</p>
                                    </div>
                                </div>
                            </a>
                            <!-- START offcanves content-->
                            <div class="offcanvas-content p ng-hide" data-ng-click="cancel($event)" data-ng-hide="offcontent2">
                                <div class="offcanvas-toggle pull-right text-gray">
                                    <em class="fa fa-times" data-ng-click="offcontent2 = true"></em>
                                </div>
                                <div class="media mt0 mb clearfix">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <div class="point point-warning point-lg"></div>
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="m0">Clifford Bell</p>
                                        <p class="m0 text-gray text-sm">45 minutes ago</p>
                                    </div>
                                </div>
                                <p>
                                    <em>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</em>
                                </p>
                            </div>
                        </li>
                        <!-- START list item-->
                        <li class="bt" data-ng-click="cancel($event)" data-ng-init="offcontent3 = true">
                            <a class="p" data-ng-click="offcontent3 = false" href="#">
                                <!-- START media preview-->
                                <div class="media">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <div class="point point-danger point-lg"></div>
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="m0">Wallace Thompson</p>
                                        <p class="m0 text-gray text-sm">yesterday</p>
                                    </div>
                                </div>
                            </a>
                            <!-- START offcanves content-->
                            <div class="offcanvas-content p ng-hide" data-ng-click="cancel($event)" data-ng-hide="offcontent3">
                                <div class="offcanvas-toggle pull-right text-gray">
                                    <em class="fa fa-times" data-ng-click="offcontent3 = true"></em>
                                </div>
                                <div class="media mt0 mb clearfix">
                                    <div class="pull-left">
                                        <div class="point-pin">
                                            <div class="point point-danger point-lg"></div>
                                        </div>
                                    </div>
                                    <div class="media-body clearfix">
                                        <p class="m0">Clifford Bell</p>
                                        <p class="m0 text-gray text-sm">yesterday</p>
                                    </div>
                                </div>
                                <p>
                                    <em>Etiam porttitor consectetur lectus, in adipiscing nisi bibendum eu. Phasellus sed dui massa, vitae dapibus augue. Proin non lacinia sapien. Nam enim libero, lacinia a tristique a, accumsan sed purus.</em>
                                </p>
                            </div>
                        </li>
                        <!-- START last list item-->
                        <li class="text-center bt" data-ng-init="offcontent3 = true">
                            <a class="p" ui-sref="app.mailbox.folder.list" href="#/app/mailbox/folder/">
                                <small>View All</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- END Alert menu-->
            </ul>
            <!-- END Right Navbar-->
        </div>
        <!-- END Nav wrapper-->

    </nav>
    <!-- END Top Navbar-->
</header>