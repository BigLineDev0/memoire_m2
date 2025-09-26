@extends('welcome')

@section('title', 'À propos - Plateforme UMRED')

@section('content')
<!-- Header Section -->
<section class="py-12 bg-base-200">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-6">À propos de l'UMRED</h1>
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li>À propos</li>
            </ul>
        </div>
    </div>
</section>

<!-- About Content -->
<section class="py-16 bg-base-100">
    <div class="container mx-auto px-6">
        <div class="hero bg-base-200 rounded-2xl p-8 mb-16">
            <div class="hero-content flex-col lg:flex-row">
                <img src="https://images.unsplash.com/photo-1560472355-536de3962603?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="max-w-sm rounded-lg shadow-2xl" />
                <div class="lg:ml-12">
                    <h1 class="text-5xl font-bold">UMRED</h1>
                    <p class="py-6 text-xl">Université Mixte de Recherche d'Exploration et de Diagnostic</p>
                    <p>Un centre d'excellence pour la recherche en santé au service de la communauté universitaire et médicale de Thiès et au-delà.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <div>
                <h2 class="text-3xl font-bold mb-6">Notre Mission</h2>
                <p class="mb-4">L'UMRED a pour mission de promouvoir l'excellence en recherche translationnelle en fournissant des plateformes technologiques de pointe, en facilitant la collaboration interdisciplinaire et en formant la prochaine génération de chercheurs en santé.</p>
                <p>Notre unité mixte de recherche sert de pont entre la recherche fondamentale et les applications cliniques, avec un accent particulier sur les défis de santé spécifiques à notre région.</p>
            </div>
            <div>
                <h2 class="text-3xl font-bold mb-6">Notre Vision</h2>
                <p class="mb-4">Devenir un centre de référence en Afrique de l'Ouest pour la recherche en diagnostic et exploration médicale, en favorisant l'innovation et l'excellence scientifique au service de la santé des populations.</p>
                <p>Nous aspirons à créer un écosystème de recherche dynamique qui attire les talents et les partenariats internationaux tout en répondant aux besoins locaux en matière de santé.</p>
            </div>
        </div>

        <!-- Values Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-12">Nos Valeurs</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card bg-base-200 shadow-lg">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary p-4 rounded-full mb-4">
                            <i class="fas fa-flask text-white text-3xl"></i>
                        </div>
                        <h3 class="card-title">Excellence Scientifique</h3>
                        <p>Nous nous engageons à maintenir les plus hauts standards de rigueur scientifique et d'intégrité dans toutes nos recherches.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-lg">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary p-4 rounded-full mb-4">
                            <i class="fas fa-handshake text-white text-3xl"></i>
                        </div>
                        <h3 class="card-title">Collaboration</h3>
                        <p>Nous favorisons les partenariats interdisciplinaires et intersectoriels pour maximiser l'impact de notre recherche.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-lg">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary p-4 rounded-full mb-4">
                            <i class="fas fa-graduation-cap text-white text-3xl"></i>
                        </div>
                        <h3 class="card-title">Formation</h3>
                        <p>Nous nous investissons dans la formation de la prochaine génération de chercheurs et de professionnels de santé.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-center mb-12">Notre Équipe</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="card bg-base-200 shadow-lg">
                    <figure class="px-6 pt-6">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Pr. Amadou Diallo</h3>
                        <p class="text-sm">Directeur de l'UMRED</p>
                        <p>Spécialiste en biologie moléculaire avec plus de 15 ans d'expérience en recherche.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-lg">
                    <figure class="px-6 pt-6">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Dr. Fatou Ndiaye</h3>
                        <p class="text-sm">Responsable Recherche</p>
                        <p>Expert en microbiologie et maladies infectieuses, coordinatrice de plusieurs projets internationaux.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-lg">
                    <figure class="px-6 pt-6">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Dr. Ibrahima Sarr</h3>
                        <p class="text-sm">Responsable Équipements</p>
                        <p>Ingénieur biomédical, gestionnaire des plateformes technologiques de l'UMRED.</p>
                    </div>
                </div>
                <div class="card bg-base-200 shadow-lg">
                    <figure class="px-6 pt-6">
                        <div class="avatar">
                            <div class="w-24 rounded-full">
                                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" />
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Dr. Aïssatou Diop</h3>
                        <p class="text-sm">Chargée de Formation</p>
                        <p>Coordinatrice des programmes de formation continue et d'encadrement des jeunes chercheurs.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partners Section -->
        <div>
            <h2 class="text-3xl font-bold text-center mb-12">Partenaires</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <div class="bg-base-200 rounded-lg p-6 h-24 flex items-center justify-center">
                    <p class="text-lg font-bold">Université de Thiès</p>
                </div>
                <div class="bg-base-200 rounded-lg p-6 h-24 flex items-center justify-center">
                    <p class="text-lg font-bold">Ministère de la Santé</p>
                </div>
                <div class="bg-base-200 rounded-lg p-6 h-24 flex items-center justify-center">
                    <p class="text-lg font-bold">OMS</p>
                </div>
                <div class="bg-base-200 rounded-lg p-6 h-24 flex items-center justify-center">
                    <p class="text-lg font-bold">Institut Pasteur</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
