@extends('welcome')

@section('title', 'Contact - Plateforme UMRED')

@section('content')
<!-- Header Section -->
<section class="py-12 bg-base-200">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-6">Contactez-nous</h1>
        <div class="breadcrumbs text-sm">
            <ul>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li>Contact</li>
            </ul>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-base-100">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Envoyez-nous un message</h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nom</span>
                            </label>
                            <input type="text" placeholder="Votre nom" class="input input-bordered" />
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Prénom</span>
                            </label>
                            <input type="text" placeholder="Votre prénom" class="input input-bordered" />
                        </div>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" placeholder="votre@email.com" class="input input-bordered" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Sujet</span>
                        </label>
                        <select class="select select-bordered">
                            <option disabled selected>Choisissez un sujet</option>
                            <option>Réservation d'équipement</option>
                            <option>Question générale</option>
                            <option>Problème technique</option>
                            <option>Collaboration de recherche</option>
                            <option>Autre</option>
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Message</span>
                        </label>
                        <textarea class="textarea textarea-bordered h-32" placeholder="Votre message"></textarea>
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary">Envoyer le message</button>
                    </div>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <h2 class="text-2xl font-bold mb-6">Informations de contact</h2>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="bg-primary p-3 rounded-full mr-4">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold">Adresse</h3>
                            <p>UFR Santé, Université de Thiès<br>BP 967, Thiès, Sénégal</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-primary p-3 rounded-full mr-4">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold">Téléphone</h3>
                            <p>+221 33 123 45 67</p>
                            <p>+221 77 456 78 90</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-primary p-3 rounded-full mr-4">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold">Email</h3>
                            <p>contact@umred.sn</p>
                            <p>support@umred.sn</p>
                        </div>
                    </div>
                </div>

                <!-- Opening Hours -->
                <div class="mt-10">
                    <h2 class="text-2xl font-bold mb-6">Horaires d'ouverture</h2>
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <tbody>
                                <tr>
                                    <td>Lundi - Vendredi</td>
                                    <td>8h00 - 18h00</td>
                                </tr>
                                <tr>
                                    <td>Samedi</td>
                                    <td>9h00 - 16h00</td>
                                </tr>
                                <tr>
                                    <td>Dimanche</td>
                                    <td>Fermé</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Map -->
                <div class="mt-10">
                    <h2 class="text-2xl font-bold mb-6">Localisation</h2>
                    <div class="aspect-video bg-base-200 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt text-4xl text-primary mb-2"></i>
                            <p>Carte interactive</p>
                            <p class="text-sm">(Intégrez votre carte Google Maps ici)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
