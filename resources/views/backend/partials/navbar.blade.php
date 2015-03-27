<aside class="bg-inverse"><!-- START Sidebar-->
    <!-- START Sidebar-->
    <div class="sidebar-wrapper">
        <div class="sidebar">
            <div class="sidebar-nav">

                <!-- START sidebar buttons-->
                <div class="sidebar-buttons">
                    <div class="">
                        <img id="userPhoto" class="mb center-block img-circle img-responsive thumb64" alt="" src="{{ asset('users/'.$user->user_photo) }}">
                        <div class="text-center">
                            <h4 class="text-bold m0 ng-binding">{{ $user->name }}</h4>
                        </div>
                    </div>
                </div>

                <!-- END sidebar buttons-->
                <!-- START sidebar nav-->
                <ul class="nav">
                    <!-- Iterates over all sidebar items-->
                    <li class="nav-heading">
                        <span class="text-muted">Navigation</span>
                    </li>
                    <li class="<?php echo (Request::is('user') ? 'active' : '' ); ?>">
                        <a title="Dashboard" href="{{ url('/user') }}">
                            <em class="sidebar-item-icon icon-head"></em>
                            <span>Activités</span>
                        </a>
                    </li>
                    <li class="<?php echo (Request::is('user/'.$user->id.'/edit') ? 'active' : '' ); ?>">
                        <a title="Dashboard" href="{{ url('user/'.$user->id.'/edit') }}">
                            <em class="sidebar-item-icon icon-box"></em>
                            <span>Mes données</span>
                        </a>
                    </li>
                    <li class="<?php echo ( Request::is('user/'.$user->id) ||  Request::is('user/link/*') ? 'active' : '' ); ?>">
                        <a title="Components" href="{{ url('/user/'.$user->id) }}">
                            <em class="sidebar-item-icon icon-book"></em>
                            <span>Contacts</span>
                        </a>
                    </li>
                    <li class="<?php echo (Request::is('user/partage') ? 'active' : '' ); ?>">
                        <a title="Components" href="{{ url('/user/partage') }}">
                            <em class="sidebar-item-icon icon-maximize"></em>
                            <span>Partages</span>
                        </a>
                    </li>
                    <li><hr></li>
                    <li>
                        <a href="{{ url('logout') }}" title="Tables" class="ng-scope">
                            <em class="sidebar-item-icon icon-power"></em><span>Log out</span>
                        </a>
                    </li>

                </ul>
                <!-- END sidebar nav-->
            </div>
        </div>
    </div>
    <!-- END Sidebar-->
    <!-- END Sidebar-->
</aside>