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
            <li class="@if (Request::segment(1) == 'dashboard') active @endif"><a class="nav-link"
                    href="{{ route('user.dashboard') }}"><i class="fas fa-home"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="@if (Request::segment(1) == 'order') active @endif"><a class="nav-link"
                    href="{{ route('user.order.index') }}"><i class="fas fa-shopping-cart"></i>
                    <span>Pesanan</span></a>
            </li>
        </ul>
    </aside>
</div>
