<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">UMRED</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('admin.laboratoires.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.laboratoires.index') }}">
            <i class="fas fa-fw fa-flask"></i>
            <span>Laboratoires</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('admin.equipements.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.equipements.index') }}">
            <i class="fas fa-fw fa-microscope"></i>
            <span>Equipements</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.reservations.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Réservations</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('admin.maintenances.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.maintenances.index') }}">
            <i class="fas fa-fw fa-tools"></i>
            <span>Maintenances</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item {{ request()->routeIs('admin.utilisateurs.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.utilisateurs.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Utilisateurs</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Rapports</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
