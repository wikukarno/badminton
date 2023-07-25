@if (Auth::user()->role == '0')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">
                <img alt="image" src="{{ asset('assets/images/pbsi.png') }}" style="max-height: 50px"
                    class="header-logo" />
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

            <li class="{{ (request()->is('pages/admin/perlombaan-admin') ? 'active' : '') }}">
                <a href="{{ route('perlombaan-admin.index') }}" class="nav-link"><i class="fas fa-medal"></i>
                    <span>Perlombaan</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/pertandingan') ? 'active' : '') }}">
                <a href="{{ route('0.pertandingan.index') }}" class="nav-link"><i class="fas fa-medal"></i>
                    <span>Pertandingan</span></a>
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
                <a href="{{ route('berita.index') }}" class="nav-link"><i class="fas fa-book"></i>
                    <span>Berita</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/pengurus') ? 'active' : '') }}">
            <a href="{{ route('pengurus.index') }}" class="nav-link"><i class="fas fa-users"></i>
                    <span>Pengurus</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/pengguna') ? 'active' : '') }}">
                <a href="{{ route('0.pengguna') }}" class="nav-link"><i class="fas fa-users"></i>
                    <span>Data Pengguna</span></a>
            </li>

            <li class="{{ (request()->is('pages/admin/akun-admin') ? 'active' : '') }}">
                <a href="{{ route('akun-admin.index') }}" class="nav-link"><i class="fas fa-user"></i>
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

@if (Auth::user()->role == '1')
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">
                <img alt="image" src="{{ asset('assets/images/pbsi.png') }}" style="max-height: 50px" class="header-logo" />
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">PBSI</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ (request()->is('pages/user') ? 'active' : '') }}">
                <a href="{{ route('1.dashboard') }}" class="nav-link"><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li
                class="{{ (request()->is('pages/user/perlombaan') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/sku-user/create') ? 'active' : '') }}">
                <a href="{{ route('perlombaan.index') }}" class="nav-link"><i class="fas fa-medal"></i>
                    <span>Perlombaan</span></a>
            </li>

            <li
                class="{{ (request()->is('pages/user/akun') ? 'active' : '') }} {{ (request()->is('pages/dashboard/user/akun-user/{id}/edit') ? 'active' : '') }}">
                <a href="{{ route('akun.index') }}" class="nav-link"><i class="fas fa-user"></i>
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