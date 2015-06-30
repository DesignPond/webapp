<aside id="collapseSidebar" class="bg-navbar collapse navbar-collapse"><!-- START Sidebar-->
    <!-- START Sidebar-->
    <div class="sidebar-wrapper">
        <div class="sidebar">
            <div class="sidebar-nav">
                <!-- START sidebar buttons-->
                <div class="sidebar-buttons">
                    <div class="text-center">
                        <img id="userPhoto" class="mb center-block img-circle img-responsive thumb64" alt="" src="{{ asset('users/'.$user->user_photo) }}">
                        <h4 class="text-bold m0 ng-binding">{{ $user->name }}</h4>
                    </div>
                </div>
                <!-- START sidebar nav-->
                <ul class="nav">
                    <li><hr></li>
                    <!-- Iterates over all sidebar items-->

                    <li class="<?php echo (Request::is('user/'.$user->id.'/edit') ? 'active' : '' ); ?>">
                        <a href="{{ url('user/'.$user->id.'/edit') }}">
                            <em class="sidebar-item-icon icon-box"></em>
                            <span>{{ trans('menu.mesdonnes') }}</span>
                        </a>
                    </li>
                    <li class="<?php echo ( Request::is('user/'.$user->id) ||  Request::is('user/link/*') ? 'active' : '' ); ?>">
                        <a href="{{ url('/user/'.$user->id) }}">
                            <em class="sidebar-item-icon icon-book"></em>
                            <span>{{ trans('menu.contacts') }}</span>
                        </a>
                    </li>
                    <li class="<?php echo (Request::is('user/partage') ? 'active' : '' ); ?>">
                        <a href="{{ url('/user/partage') }}">
                            <em class="sidebar-item-icon icon-maximize"></em>
                            <span>{{ trans('menu.partages') }}</span>
                        </a>
                    </li>
                    <li class="<?php echo (Request::is('user') ? 'active' : '' ); ?>">
                        <a href="{{ url('/user') }}">
                            <em class="sidebar-item-icon icon-head"></em>
                            <span>{{ trans('menu.activites') }}</span>
                        </a>
                    </li>
                    <li><hr></li>
                    <li>
                        <a href="{{ url('logout') }}" title="Tables" class="ng-scope">
                            <em class="sidebar-item-icon icon-power"></em><span>{{ trans('menu.logout') }}</span>
                        </a>
                    </li>
                </ul>
                <!-- END sidebar nav-->
            </div>
        </div>
        <span id="copyright">&copy; RiiingMe <?php echo date('Y'); ?></span>
    </div>
    <!-- END Sidebar-->
</aside>