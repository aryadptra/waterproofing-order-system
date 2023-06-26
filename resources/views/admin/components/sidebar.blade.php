<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Waterproofing </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">SM</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="@if (Request::segment(2) == 'dashboard') active @endif"><a class="nav-link"
                    href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Master Data</li>
            <li class="@if (Request::segment(2) == 'service') active @endif"><a class="nav-link"
                    href="{{ route('admin.service.index') }}"><i class="fas fa-tools"></i>
                    <span>Layanan</span></a>
            </li>
            <li class="@if (Request::segment(2) == 'order') active @endif"><a class="nav-link"
                    href="{{ route('admin.order.index') }}"><i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span></a>
            </li>
        </ul>
    </aside>
</div>
