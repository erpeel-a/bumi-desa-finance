<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire">
                    </i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Master Content</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Unit</span></a>
                <ul class="dropdown-menu">
                    @foreach ($unitMenu as $menu)
                    <li><a class="nav-link" href="">{{ $menu->name }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a class="nav-link" href="">
                    <i class="far fa-square"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="menu-header">Master Data</li>
            <li class="{{ request()->is('units*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('units.index') }}"><i class="fas fa-fire">
                    </i> <span>Daftar Unit</span>
                </a>
            </li>
        </ul>

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-lg btn-block btn-icon-split">
                    <i class="fas fa-rocket"></i> Logout
                </button>
            </form>
        </div>
    </aside>
</div>