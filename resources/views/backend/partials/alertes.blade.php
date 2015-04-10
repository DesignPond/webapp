
<!-- START Right Navbar-->
<ul class="nav navbar-nav navbar-right">
    <!-- START Alert menu-->
    <li class="dropdown dropdown-list">
        <a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
            <div class="point-pin"><em class="icon-mail fa-fw"></em>
                @if(!$demandes->isEmpty())
                    <div class="point point-success point-lg"></div>
                @endif
            </div>
            <span class="visible-xs-inline ml">Voir Alertes</span>
        </a>

        <!-- START Dropdown menu-->
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            @if(!$demandes->isEmpty())
            <!-- START list item-->
            @foreach($demandes as $demande)
                <li>
                    <a class="p" href="#">
                        <!-- START media preview-->
                        <div class="media">
                            <div class="media-body clearfix">
                                <h5><div class="point point-success point-lg"></div> Demande de partage de&nbsp;</h5>
                                <p class="m0">{{ $demande->user->email }}</p>
                                <p title="{{ $demande->created_at->format('Y-m-d H:i:s') }}" class="m0 text-gray text-sm">{{ $demande->created_at->format('Y-m-d') }}</p>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
                <li class="text-center bt">
                    <a class="p" ui-sref="app.mailbox.folder.list" href="{{ url('user/partage') }}">
                        <small>Voir tous</small>
                    </a>
                </li>
            @else
                <li class="text-center bt">
                    <a class="p" ui-sref="app.mailbox.folder.list" href="{{ url('user/partage') }}">
                        <small>Aucune demande en cours</small>
                    </a>
                </li>
            @endif
        </ul>
    </li>
    <!-- END Alert menu-->
</ul>
<!-- END Right Navbar-->