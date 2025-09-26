<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UMRED</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('technicien.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('technicien.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('technicien.maintenances.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('technicien.maintenances.index') }}">
            <i class="fas fa-fw fa-microscope"></i>
            <span>Gestion des maintenances</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('technicien.equipements.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('technicien.equipements.index') }}">
            <i class="fas fa-fw fa-microscope"></i>
            <span>Équipements maintenance</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
