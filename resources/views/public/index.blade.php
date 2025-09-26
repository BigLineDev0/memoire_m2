@extends('welcome')

@section('title', 'Accueil - Plateforme UMRED')

@section('content')
<!-- Hero Section -->
<section class="hero min-h-screen" style="background-image: url(https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80);">
    <div class="hero-overlay bg-opacity-60"></div>
    <div class="hero-content text-center text-neutral-content">
        <div class="max-w-2xl">
            <h1 class="mb-5 text-5xl font-bold">Plateforme de gestion UMRED</h1>
            <p class="mb-5">Gestion centralisée des rendez-vous, équipements et ressources pour le laboratoire UMRED de l'UFR Santé de Thiès</p>
            <a href="{{ route('laboratoires') }}" class="btn btn-primary">Réserver un équipement</a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-base-100">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Nos services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card bg-base-200 shadow-xl">
                <figure class="px-10 pt-10">
                    <i class="fas fa-calendar-check text-6xl text-primary"></i>
                </figure>
                <div class="card-body items-center text-center">
                    <h3 class="card-title">Gestion de rendez-vous</h3>
                    <p>Planifiez et gérez facilement vos rendez-vous pour l'utilisation des équipements de laboratoire.</p>
                </div>
            </div>
            <div class="card bg-base-200 shadow-xl">
                <figure class="px-10 pt-10">
                    <i class="fas fa-microscope text-6xl text-primary"></i>
                </figure>
                <div class="card-body items-center text-center">
                    <h3 class="card-title">Réservation d'équipements</h3>
                    <p>Accédez à notre catalogue d'équipements et réservez ceux dont vous avez besoin pour vos recherches.</p>
                </div>
            </div>
            <div class="card bg-base-200 shadow-xl">
                <figure class="px-10 pt-10">
                    <i class="fas fa-chart-line text-6xl text-primary"></i>
                </figure>
                <div class="card-body items-center text-center">
                    <h3 class="card-title">Suivi des ressources</h3>
                    <p>Surveillez l'utilisation des ressources et optimisez votre temps de recherche.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Laboratories Section -->
<section class="py-16 bg-base-200">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4">Nos Laboratoires Disponibles</h2>
        <p class="text-center text-lg mb-12 max-w-2xl mx-auto">Découvrez nos laboratoires les plus populaires équipés des technologies les plus avancées pour la recherche</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($laboratoires as $labo)
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                    <figure class="w-full relative">
                        @if ($labo->photo === null || $labo->photo === '')
                        <img src="{{ asset('images/laboratoires/default.jpg') }}" alt="{{ $labo->nom }}"
                            class="w-full h-48 object-cover" />
                        @else
                            <img src="{{ asset('storage/' . $labo->photo) }}" alt="{{ $labo->nom }}" class="w-full h-48 object-cover">
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

        <div class="text-center mt-12">
            <a href="{{ route('laboratoires') }}" class="btn btn-outline btn-primary">
                Voir tous les laboratoires
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-16 bg-base-100">
    <div class="container mx-auto px-6">
        <div class="stats shadow w-full grid grid-cols-1 md:grid-cols-4">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <i class="fas fa-lab text-4xl"></i>
                </div>
                <div class="stat-title">Laboratoires</div>
                <div class="stat-value text-primary">{{ $stats['total_laboratories'] }}</div>
                <div class="stat-desc">Unités spécialisées</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-secondary">
                    <i class="fas fa-tools text-4xl"></i>
                </div>
                <div class="stat-title">Équipements</div>
                <div class="stat-value text-secondary">{{ $stats['total_equipments'] }}</div>
                <div class="stat-desc">Disponibles à la réservation</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-accent">
                    <i class="fas fa-users text-4xl"></i>
                </div>
                <div class="stat-title">Utilisateurs</div>
                <div class="stat-value text-accent">{{ $stats['total_users'] }}</div>
                <div class="stat-desc">Chercheurs et étudiants</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-info">
                    <i class="fas fa-calendar text-4xl"></i>
                </div>
                <div class="stat-title">Réservations</div>
                <div class="stat-value text-info">{{ $stats['total_reservations'] }}</div>
                <div class="stat-desc">Ce mois-ci</div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-base-200">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Ce que disent nos utilisateurs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="avatar mr-4">
                            <div class="w-12 rounded-full">
                                <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold">Dr. Mohamed Diop</h4>
                            <p class="text-sm">Chercheur en Biologie</p>
                        </div>
                    </div>
                    <p class="italic">"La plateforme UMRED a révolutionné ma façon de travailler. Je peux maintenant réserver facilement les équipements dont j'ai besoin pour mes recherches."</p>
                    <div class="rating rating-sm mt-4">
                        <input type="radio" name="rating-4" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-4" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-4" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-4" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-4" class="mask mask-star" checked disabled />
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="avatar mr-4">
                            <div class="w-12 rounded-full">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold">Dr. Aïssatou Fall</h4>
                            <p class="text-sm">Doctorante en Chimie</p>
                        </div>
                    </div>
                    <p class="italic">"Grâce à ce système de réservation, j'économise un temps précieux. L'interface est intuitive et me permet de planifier mes expériences à l'avance."</p>
                    <div class="rating rating-sm mt-4">
                        <input type="radio" name="rating-5" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-5" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-5" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-5" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-5" class="mask mask-star" disabled />
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="avatar mr-4">
                            <div class="w-12 rounded-full">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold">Pr. Souleymane Ndiaye</h4>
                            <p class="text-sm">Directeur de Recherche</p>
                        </div>
                    </div>
                    <p class="italic">"La gestion des ressources de notre laboratoire n'a jamais été aussi simple. Cette plateforme est un atout précieux pour notre institution."</p>
                    <div class="rating rating-sm mt-4">
                        <input type="radio" name="rating-6" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-6" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-6" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-6" class="mask mask-star" checked disabled />
                        <input type="radio" name="rating-6" class="mask mask-star" checked disabled />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-primary text-primary-content mb-12">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Prêt à commencer?</h2>
        <p class="mb-8 max-w-2xl mx-auto">Rejoignez notre plateforme pour accéder à tous nos équipements et services de laboratoire.</p>
        <div class="flex justify-center gap-4 flex-col sm:flex-row">
            <a href="{{ route('laboratoires') }}" class="btn btn-secondary btn-lg">Explorer les laboratoires</a>
            <a href="{{ route('contact') }}" class="btn btn-accent btn-lg">Nous contacter</a>
        </div>
    </div>
</section>

@endsection
