<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard') }}">SMK TRIDHARMA MAROS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard') }}">SMK TRIDHARMA MAROS</a>
        </div>

        <ul class="sidebar-menu">

            <li class="menu-header">Dashboard</li>

            <li class="nav-item  {{ $menu == 'dashboard' ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link "><i
                        class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            @if (session('role') == 'admin')
                <li class="nav-item dropdown {{ $menu == 'pegawai' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i>
                        <span>Master Data</span></a>
                    <ul class="dropdown-menu">

                        <li class="{{ $menu == 'pegawai' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('pegawai.index') }}">
                                Data Pegawai
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item dropdown {{ $menu == 'indikator' || 'indikator_level' ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i class="fas fa-sitemap"></i>
                        <span>Data Indikator</span></a>
                    <ul class="dropdown-menu">

                        <li class="{{ $menu == 'indikator' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('indikator.index') }}">
                                Data Indikator
                            </a>
                        </li>
                        <li class="{{ $menu == 'indikator_level' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('indikator_level.index') }}">
                                Data Level Indikator
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="{{ $menu == 'agenda' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('agenda.index') }}">
                        <i class="fas fa-wallet"></i> <span>Data Agenda</span>
                    </a>
                </li>


                <li class="{{ $menu == 'akun' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('akun.index') }}">
                        <i class="fas fa-user"></i> <span>Data Akun</span>
                    </a>
                </li>

                <li class="menu-header">Landing Page</li>

            @endif

            @if (session('role') == 'user')

                <li class="{{ $menu == 'midtrans' ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('midtrans.index') }}">
                        <i class="fas fa-wallet"></i> <span>Data Transaksi</span>
                    </a>
                </li>
                <li class="menu-header">Landing Page</li>

            @endif
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </aside>
</div>