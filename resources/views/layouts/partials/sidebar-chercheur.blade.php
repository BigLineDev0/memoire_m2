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
    <li class="nav-item {{ request()->routeIs('chercheur.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('chercheur.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('chercheur.reservations.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('chercheur.reservations.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Mes Réservations</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('chercheur.equipements.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('chercheur.equipements.index') }}">
            <i class="fas fa-fw fa-microscope"></i>
            <span>Equipements</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
