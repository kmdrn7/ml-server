<div class="mdk-drawer js-mdk-drawer" id="default-drawer" data-align="start">
    <div class="mdk-drawer__content">
        <div class="d-flex align-items-center sidebar-p-a border-bottom sidebar-account" style="background-color: #f7f8f9">
            <a href="{{ admin('') }}" class="flex d-flex align-items-center text-underline-0 text-body">
                <span class="avatar mr-3">
                    <img src="<?= "https://www.gravatar.com/avatar/" . md5(strtolower(trim(Auth::user()->email))) . "&s=40"; ?>" alt="avatar" class="avatar-img rounded-circle">
                </span>
                <span class="flex d-flex flex-column">
                    <strong>{{ Auth::user()->nama }}</strong>
                    <small class="text-muted text-uppercase">Admin</small>
                </span>
            </a>
        </div>
        <div class="sidebar sidebar-light sidebar-left simplebar" data-simplebar>
            <div class="sidebar-heading sidebar-m-t" id="sidebar-dashboard">Dashboard</div>
            <ul class="sidebar-menu" id="components_menu">
                <li class="sidebar-menu-item {{ $idh=='dashboard'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.dashboard.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dashboard</i>
                        <span class="sidebar-menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ $idh=='realtime-sensor'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.realtime-sensor.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">timeline</i>
                        <span class="sidebar-menu-text">Realtime Sensor</span>
                    </a>
                </li>
            </ul>

            {{-- <div class="sidebar-heading sidebar-m-t" id="sidebar-master">Home</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item {{ $idh=='data-klinik'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.pharmacy.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">business</i>
                        <span class="sidebar-menu-text">Klinik</span>
                    </a>
                </li>
            </ul> --}}

            {{-- <div class="sidebar-heading sidebar-m-t" id="sidebar-transaction">Transaction</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item {{ $idh=='data-pesanan'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.order.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">date_range</i>
                        <span class="sidebar-menu-text">Pesanan Layanan</span>
                    </a>
                </li>
            </ul> --}}

            <div class="sidebar-heading sidebar-m-t" id="sidebar-management">Management</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item {{ $idh=='data-sensor'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.sensor.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">device_hub</i>
                        <span class="sidebar-menu-text">Sensor</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading sidebar-m-t" id="sidebar-utilitas">Utilitas</div>
            <ul class="sidebar-menu" id="utilitas_menu">
                <li class="sidebar-menu-item {{ $idh=='data-admin'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.admin.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">lock</i>
                        <span class="sidebar-menu-text">Admin</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ $idh=='cache-manager'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.cache.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">save</i>
                        <span class="sidebar-menu-text">Cache</span>
                    </a>
                </li>
                <li class="sidebar-menu-item {{ $idh=='konfigurasi'?'active open':'' }}">
                    <a class="sidebar-menu-button" href="{{ route('admin.config.index') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">build</i>
                        <span class="sidebar-menu-text">Konfigurasi</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-button" href="{{ route('admin.logout') }}">
                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">close</i>
                        <span class="sidebar-menu-text">Logout</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-heading" style="padding-top: 50px">&nbsp;</div>
        </div>
    </div>
</div>
