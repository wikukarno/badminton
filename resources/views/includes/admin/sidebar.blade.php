@if (Auth::user()->role == '0')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">
                <img alt="image" src="{{ asset('assets/images/pbsi.png') }}" style="max-height: 50px"
                    class="header-logo" />
                <span class="logo-name">PBSI</span>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PBSI</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ (request()->is('pages/admin/dashboard') ? 'active' : '') }}">
                <a href="{{ route('0.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/perlombaan') ? 'active' : '') }}">
                <a href="{{ route('0.perlombaan') }}" class="nav-link"><i class="fas fa-medal"></i>
                    <span>Perlombaan</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/verifikasi') ? 'active' : '') }}">
                <a href="{{ route('0.verifikasi') }}" class="nav-link"><i class="fas fa-user-check"></i>
                    <span>Verifikasi</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/wasit') ? 'active' : '') }}">
                <a href="{{ route('0.wasit') }}" class="nav-link"><i class="fas fa-user-shield"></i>
                    <span>Wasit</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/berita') ? 'active' : '') }}">
                <a href="#" class="nav-link"><i class="fas fa-book"></i>
                    <span>Berita</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/pengguna') ? 'active' : '') }}">
                <a href="{{ route('0.pengguna') }}" class="nav-link"><i class="fas fa-users"></i>
                    <span>Data Pengguna</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/akun') ? 'active' : '') }}">
                <a href="{{ route('0.akun') }}" class="nav-link"><i class="fas fa-user"></i>
                    <span>Akun</span></a>
            </li>
        </ul>

        <div class="mt-3 mb-4 p-3 hide-sidebar-mini">
            <a href="#" class="btn btn-danger btn-lg btn-block btn-icon-split" data-toggle="modal"
                data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </aside>
</div>
@endif

@if (Auth::user()->roles == '1')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">
                <img alt="image" src="{{ asset('assets/images/logo.jpg') }}" style="max-height: 50px"
                    class="header-logo" />
                <span class="logo-name">Lurah Sorek Satu</span>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">LSS</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ (request()->is('pages/dashboard/user') ? 'active' : '') }}">
                <a href="{{ route('user.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li
                class="{{ (request()->is('pages/dashboard/user/sku-user') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/sku-user/create') ? 'active' : '') }}">
                <a href="{{ route('sku-user.index') }}" class="nav-link"><i class="fas fa-store"></i>
                    <span>SK Usaha</span></a>
            </li>
            <li
                class="{{ (request()->is('pages/dashboard/user/skp-user') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/skp-user/create') ? 'active' : '') }}">
                <a href="{{ route('skp-user.index') }}" class="nav-link"><i class="fas fa-file"></i>
                    <span>SK Pemakaman</span></a>
            </li>
            <li
                class="{{ (request()->is('pages/dashboard/user/sktm-user') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/sktm-user/create') ? 'active' : '') }}">
                <a href="{{ route('sktm-user.index') }}" class="nav-link"><i class="fas fa-columns"></i>
                    <span>SK Tidak Mampu</span></a>
            </li>

            <li
                class="{{ (request()->is('pages/dashboard/user/ski-user') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/ski-user/create') ? 'active' : '') }}">
                <a href="{{ route('ski-user.index') }}" class="nav-link"><i class="fas fa-info-circle"></i>
                    <span>SK Izin</span></a>
            </li>

            <li
                class="{{ (request()->is('pages/dashboard/user/akun-user') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/akun-user/{id}/edit') ? 'active' : '') }}">
                <a href="{{ route('akun-user.index') }}" class="nav-link"><i class="fas fa-user"></i>
                    <span>Akun</span></a>
            </li>
        </ul>

        <div class="mt-3 mb-4 p-3 hide-sidebar-mini">
            <a href="#" class="btn btn-danger btn-lg btn-block btn-icon-split" data-toggle="modal"
                data-target="#logoutModal">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
    </aside>
</div>
@endif