<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Dashboard</div>
                <a class="nav-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Master Content</div>
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                    Unit
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse{{ request()->is('unit-report*') ? ' show' : '' }}" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @foreach ($unitMenu as $menu)
                        <a class="nav-link" href="{{ route('unit.index', $menu->slug) }}">{{ $menu->name }}</a>
                        @endforeach
                    </nav>
                </div>
                <a class="nav-link">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-download"></i></div>
                    Laporan
                </a>
                <div class="sb-sidenav-menu-heading">Master Data</div>
                <a class="nav-link{{ request()->is('units*') ? ' active' : '' }}" href="{{ route('units.index') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-list-alt"></i></div>
                    Daftar Unit
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->name }}
        </div>
    </nav>
</div>