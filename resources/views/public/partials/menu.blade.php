<nav class="navbar bg-base-200 shadow-md px-6 py-4 sticky top-0 z-50">
    <!-- Logo -->
    <div class="flex-1">
        <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl">
            <img src="{{ asset('assets/img/logo/UMRED.png') }}" alt="Logo UMRED" class="h-10 mr-2">
        </a>
    </div>

    <!-- Menu Mobile -->
    <div class="flex-none lg:hidden">
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </label>
            <ul tabindex="0"
                class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">

                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('laboratoires') }}">Laboratoires</a></li>
                <li><a href="{{ route('about') }}">À propos</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>

                @guest
                    <li><a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-outline btn-primary">S'inscrire</a></li>
                @endguest

                @auth
                    <li><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                    <li class="menu-title">{{ auth()->user()->prenom }} {{ auth()->user()->name }}</li>
                    <li><a href="{{ route('profile.edit') }}">Profil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Se déconnecter</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>

    <!-- Menu Desktop -->
    <div class="hidden lg:flex ml-auto space-x-2">
        <a href="{{ route('home') }}"
           class="btn btn-ghost {{ request()->routeIs('home') ? 'btn-active' : '' }}">Accueil</a>
        <a href="{{ route('laboratoires') }}"
           class="btn btn-ghost {{ request()->routeIs('laboratoires') ? 'btn-active' : '' }}">Laboratoires</a>
        <a href="{{ route('about') }}"
           class="btn btn-ghost {{ request()->routeIs('about') ? 'btn-active' : '' }}">À propos</a>
        <a href="{{ route('contact') }}"
           class="btn btn-ghost {{ request()->routeIs('contact') ? 'btn-active' : '' }}">Contact</a>

        @guest
            <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            <a href="{{ route('register') }}" class="btn btn-outline btn-primary">S'inscrire</a>
        @endguest

        @auth
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="btn btn-accent">Tableau de bord</a>

            <!-- Dropdown utilisateur -->
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost avatar flex items-center space-x-2">
                    <div class="w-10 rounded-full">
                        <img alt="Avatar"
                             src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp' }}" />
                    </div>
                    <span>{{ auth()->user()->prenom }} {{ auth()->user()->name }}</span>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                    <li><a href="{{ route('profile.edit') }}">Profil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Se déconnecter</button>
                        </form>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
