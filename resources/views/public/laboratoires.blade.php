@extends('welcome')

@section('title', 'Laboratoires - Plateforme UMRED')

@section('content')
<!-- Header Section -->
<section class="py-16 bg-primary text-primary-content relative">
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary to-primary/80"></div>
        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
             alt="Laboratoire de Parasitologie-Bactériologie"
             class="w-full h-full object-cover mix-blend-overlay opacity-20">
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <h1 class="text-4xl font-bold mb-6">Nos Laboratoires</h1>
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li>Laboratoires</li>
            </ul>
        </div>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="py-8 bg-base-100">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="form-control w-full md:w-1/2">
                <div class="input-group">
                    <input type="text" placeholder="Rechercher un laboratoire..." class="input input-bordered w-full" />
                </div>
            </div>
            <div class="form-control w-full md:w-1/3">
                <select class="select select-bordered">
                    <option disabled selected>Trier par</option>
                    <option>Nom (A-Z)</option>
                    <option>Équipements (croissant)</option>
                    <option>Équipements (décroissant)</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- Laboratories Grid -->
<section class="py-12 bg-base-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
             @foreach($laboratoires as $labo)
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                    <figure class="w-full relative">
                        @if ($labo->photo === null || $labo->photo === '')
                        <img src="{{ asset('images/laboratoires/default.jpg') }}" alt="{{ $labo->nom }}"
                            class="w-full h-48 object-cover" />
                        @else
                            <img src="{{ asset('storage/laboratoires/' . $labo->photo) }}" alt="{{ $labo->nom }}" class="w-full h-48 object-cover">
                        @endif

                        <div class="absolute top-4 right-4 badge badge-primary badge-lg p-3 shadow-md">
                            <i class="fas fa-tools mr-1"></i>
                            {{ $labo->equipements_count }} équipement{{ $labo->equipements_count > 1 ? 's' : ''}}
                        </div>
                    </figure>
                    <div class="card-body">
                        <h2 class="card-title text-lg">{{ $labo->nom }}</h2>
                        <div class="flex items-center mt-2">
                            @if($labo->statut === 'actif')
                                <div class="badge badge-success badge-sm gap-2">
                                    <i class="fas fa-circle"></i>
                                    Disponible
                                </div>
                            @else
                                <div class="badge badge-warning badge-sm gap-2">
                                    <i class="fas fa-circle"></i>
                                    Occupé
                                </div>
                            @endif
                        </div>
                        <p class="flex items-center text-sm mt-2">
                            <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                            {{ $labo->localisation }}
                        </p>
                        <p class="mt-3 text-sm line-clamp-3">
                            {{ Str::limit($labo->description, 100) }}
                        </p>

                        <div class="card-actions mt-4">
                            @if($labo->statut === 'actif')
                                @auth
                                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'technicien')
                                        <a href="" class="btn btn-secondary w-full">Voir les détails</a>
                                    @else
                                        <a href="{{ route('reservations.create', $labo) }}" class="btn btn-primary w-full">Réserver ce laboratoire</a>
                                    @endif
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn-outline btn-primary w-full">Se connecter pour réserver</a>
                                @endguest
                            @else
                                <button class="btn btn-disabled w-full">Non disponible</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <!-- Pagination -->
        <div class="flex justify-center mt-12">
            <div class="btn-group">
                {{ $laboratoires->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
