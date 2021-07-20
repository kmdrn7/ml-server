<!-- Header -->
<div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
    <div class="mdk-header__content">
        <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-dark  pr-0" id="navbar" data-primary>
            <div class="container-fluid p-0">
                <!-- Navbar toggler -->
                <button class="navbar-toggler navbar-toggler-right d-block d-md-none" type="button" data-toggle="sidebar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Navbar Brand -->
                <a href="{{ route('admin.dashboard.index') }}" class="navbar-brand ">
                    @if (File::exists(public_path('storage/app_logo.png')))
                        <img class="navbar-brand-icon" src="{{ asset('storage/app_logo.png') }}" height="40" alt="EP" style="background-color: white; padding: 2px 10px; border-radius: 4px">
                    @endif
                    <span style="border-bottom: 2px solid whitesmoke; padding-bottom: 5px; margin-left: 8px">ML Server Admin Dashboard</span>
                </a>

                <ul class="nav navbar-nav mr-2 ml-auto d-none d-sm-flex">
                    <li class="text-white">Tanggal : {{ now()->formatLocalized('%d %B %Y') }} </li>
                </ul>

                {{-- <ul class="nav navbar-nav d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a href="#notifications_menu" class="nav-link dropdown-toggle" data-toggle="dropdown"
                            data-caret="false">
                            <i class="material-icons nav-icon navbar-notifications-indicator">notifications</i>
                        </a>
                        <div id="notifications_menu" class="dropdown-menu dropdown-menu-right navbar-notifications-menu">
                            <div class="dropdown-item d-flex align-items-center py-2">
                                <span class="flex navbar-notifications-menu__title m-0">Notifications</span>
                                <a href="javascript:void(0)" class="text-muted"><small>Clear all</small></a>
                            </div>
                            <div class="navbar-notifications-menu__content" data-simplebar>
                                <div class="py-2">
                                    <div class="dropdown-item d-flex">
                                        <div class="mr-3">
                                            <a href="#">
                                                <div class="avatar avatar-xs" style="width: 32px; height: 32px;">
                                                    <span class="avatar-title bg-purple rounded-circle"><i class="material-icons icon-16pt">person_add</i></span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="flex">
                                            New user <a href="#">Peter Parker</a> signed up.<br>
                                            <small class="text-muted">1 hour ago</small>
                                        </div>
                                    </div>
                                    <div class="dropdown-item d-flex">
                                        <div class="mr-3">
                                            <a href="#">
                                                <div class="avatar avatar-xs" style="width: 32px; height: 32px;">
                                                    <span class="avatar-title rounded-circle">JD</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="flex">
                                            <a href="#">Big Joe</a> <small class="text-muted">wrote:</small><br>
                                            <div>Hey, how are you? What about our next meeting</div>
                                            <small class="text-muted">2 minutes ago</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:void(0);" class="dropdown-item text-center navbar-notifications-menu__footer">View All</a>
                        </div>
                    </li>
                </ul> --}}

                <ul class="nav navbar-nav d-none d-sm-flex navbar-height align-items-center">
                    <li class="nav-item dropdown">
                        <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
                            <img style="margin-top: 0px" src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "&s=40"; ?>" class="rounded-circle" width="32" alt="Frontted">
                            <span class="ml-1 d-flex-inline">
                                <span class="text-light">{{ Auth::user()->username }}</span>
                            </span>
                        </a>
                        <div id="account_menu" class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-item-text dropdown-item-text--lh">
                                <div><strong>{{ Auth::user()->nama }}</strong></div>
                                <div>{{ Auth::user()->email }}</div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item active" href="{{ admin('') }}">Dashboard</a>
                            <a class="dropdown-item" href="{{ admin('') }}">My profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- // END Header -->
