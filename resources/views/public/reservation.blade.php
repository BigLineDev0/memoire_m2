@extends('welcome')

@section('title', 'Réservation')

@section('content')
    <!-- Header Section -->
    <section class="py-16 bg-primary text-primary-content relative">
        <div class="absolute inset-0 z-0 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-primary to-primary/80"></div>
            <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                alt="{{ $laboratoire->nom }}" class="w-full h-full object-cover mix-blend-overlay opacity-20">
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <h1 class="text-4xl font-bold mb-4">Réserver le {{ $laboratoire->nom }}</h1>
            <div class="breadcrumbs text-sm">
                <ul>
                    <li><a href="{{ route('home') }}" class="text-primary-content/80 hover:text-white">Accueil</a></li>
                    <li><a href="{{ route('laboratoires') }}"
                            class="text-primary-content/80 hover:text-white">Laboratoires</a></li>
                    <li class="text-white">Réservation</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- Error Messages -->
    <div class="container mx-auto px-6 py-10">
        @if ($errors->any())
            <div role="alert" class="alert alert-error alert-soft">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    <!-- Reservation Form Section -->
    <section class="py-16 bg-base-100">
        <div class="container mx-auto px-6">
            <form id="reservation-form" method="POST" action="{{ route('reservations.store', $laboratoire) }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="laboratoire_id" value="{{ $laboratoire->id }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Form Column -->
                    <div class="lg:col-span-2">
                        <div class="bg-base-100 rounded-2xl shadow-lg p-6 md:p-8 border border-base-300">
                            <h2 class="text-2xl font-bold mb-6 pb-3 border-b border-base-300">Formulaire de réservation</h2>

                            <!-- Equipments -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <div class="bg-primary/10 p-2 rounded-lg mr-3">
                                        <i class="fas fa-tools text-primary"></i>
                                    </div>
                                    Sélection des équipements
                                </h3>
                                <p class="text-sm text-base-content/70 mb-4">
                                    Sélectionnez une date pour voir les équipements disponibles
                                </p>
                                <div id="equipements-container" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                            </div>

                            <!-- Date -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <div class="bg-primary/10 p-2 rounded-lg mr-3">
                                        <i class="fas fa-calendar-day text-primary"></i>
                                    </div>
                                    Date de réservation
                                </h3>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">Sélectionnez une date</span>
                                    </label>
                                    <input type="date" id="reservation-date" name="date"
                                        class="input input-bordered w-full" min="{{ date('Y-m-d') }}" />
                                </div>
                            </div>

                            <!-- Horaires -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <div class="bg-primary/10 p-2 rounded-lg mr-3">
                                        <i class="fas fa-clock text-primary"></i>
                                    </div>
                                    Créneaux horaires disponibles
                                </h3>
                                <p class="text-sm text-base-content/70 mb-4">
                                    Sélectionnez une date pour voir les créneaux disponibles
                                </p>
                                <div id="horaires-container" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                            </div>

                            <!-- Objectif -->
                            <div class="mb-8">
                                <h3 class="text-xl font-semibold mb-4 flex items-center">
                                    <div class="bg-primary/10 p-2 rounded-lg mr-3">
                                        <i class="fas fa-bullseye text-primary"></i>
                                    </div>
                                    Objectif de la réservation (optionnel)
                                </h3>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Décrivez brièvement l'objectif de votre utilisation du
                                            laboratoire</span>
                                    </label>
                                    <textarea class="textarea textarea-bordered h-32 w-full" id="reservation-objective" name="objectif"
                                        placeholder="Ex: Analyse d'échantillons pour recherche sur les parasites intestinaux...">
                                    </textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-control mt-10">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg w-full">
                                    <span id="btnText">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        Confirmer la réservation
                                    </span>
                                    <span id="btnLoader" class="loading loading-spinner loading-md hidden"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Column -->
                    <div class="lg:col-span-1">
                        <div class="bg-base-100 rounded-2xl shadow-xl p-6 md:p-8 border border-base-300 sticky top-6">
                            <h2 class="text-2xl font-bold mb-6 pb-3 border-b border-base-300 flex items-center">
                                <i class="fas fa-receipt mr-2"></i>
                                Récapitulatif
                            </h2>

                            <!-- Laboratoire -->
                            <div class="card bg-base-200/40 mb-6 shadow-sm border border-base-300/30">
                                <div class="card-body p-4 flex items-center">
                                    <div class="bg-primary/10 p-3 rounded-lg mr-4">
                                        <i class="fas fa-flask text-primary text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-lg">{{ $laboratoire->nom }}</p>
                                        <p class="text-sm text-base-content/70">{{ $laboratoire->localisation }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Équipements -->
                            <div class="card bg-base-200/40 mb-6 shadow-sm border border-base-300/30">
                                <div class="card-body p-4">
                                    <h3 class="font-semibold text-lg mb-3 flex items-center">
                                        <i class="fas fa-tools mr-2 text-primary"></i>
                                        Équipements sélectionnés
                                    </h3>
                                    <div id="selected-equipments" class="space-y-2">
                                        <p class="text-base-content/60 text-sm text-center py-4">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Aucun équipement sélectionné
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Date et horaires -->
                            <div class="card bg-base-200/40 mb-6 shadow-sm border border-base-300/30">
                                <div class="card-body p-4">
                                    <h3 class="font-semibold text-lg mb-3 flex items-center">
                                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>
                                        Détails de la réservation
                                    </h3>
                                    <div class="space-y-3 text-sm">
                                        <div id="selected-date" class="flex justify-between items-center py-2">
                                            <span class="text-base-content/70 flex items-center">
                                                <i class="fas fa-calendar-day mr-2"></i>
                                                Date :
                                            </span>
                                            <span class="badge badge-ghost">Non sélectionnée</span>
                                        </div>
                                        <div id="selected-times" class="space-y-2">
                                            <p class="text-base-content/60 text-sm text-center py-2">
                                                <i class="fas fa-clock mr-1"></i>
                                                Aucun créneau sélectionné
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Objectif -->
                            <div class="card bg-base-200/40 mb-6 shadow-sm border border-base-300/30">
                                <div class="card-body p-4">
                                    <h3 class="font-semibold text-lg mb-3 flex items-center">
                                        <i class="fas fa-bullseye mr-2 text-primary"></i>
                                        Objectif
                                    </h3>
                                    <div id="reservation-objective-preview" class="text-sm text-base-content/70 italic">
                                        Aucun objectif spécifié
                                    </div>
                                </div>
                            </div>

                            <!-- Informations importantes -->
                            <div class="bg-primary/5 border border-primary/10 rounded-lg p-4 mt-6">
                                <h4 class="font-semibold text-sm mb-2 text-primary flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Informations importantes
                                </h4>
                                <ul class="text-xs space-y-1 text-base-content/70">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-primary mt-0.5 mr-2 text-xs"></i>
                                        <span>Modification possible jusqu'à 24h avant</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Modal de confirmation -->
            <input type="checkbox" id="reservationModal" class="modal-toggle"
                @if (session('reservation_success')) checked @endif />

            <div class="modal modal-bottom sm:modal-middle">
                <div
                    class="modal-box p-0 rounded-2xl shadow-2xl max-w-md max-h-[90vh] bg-base-100 overflow-hidden border border-base-300/20 flex flex-col">

                    <!-- Header épuré (toujours visible) -->
                    <div class="p-6 pb-4 border-b border-base-300/20 flex-shrink-0">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-success/10 shadow-sm">
                                <i class="fas fa-check-circle text-success text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-2xl text-success">Réservation confirmée</h3>
                                <p class="text-sm text-base-content/70 mt-1">Votre réservation a été enregistrée avec
                                    succès</p>
                            </div>
                        </div>
                    </div>

                    @if (session('reservation_success'))
                        @php $data = session('reservation_success'); @endphp

                        <!-- Contenu principal (scrollable) -->
                        <div class="flex-1 overflow-y-auto p-6 space-y-5">
                            <!-- Informations de réservation -->
                            <div class="space-y-4">
                                <!-- Laboratoire avec icône -->
                                <div class="bg-base-200/30 rounded-xl p-4">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <i class="fas fa-flask text-primary text-lg"></i>
                                        <span class="font-semibold text-base-content/80 text-lg">Laboratoire</span>
                                    </div>
                                    <span
                                        class="font-medium text-base-content text-lg pl-8 block bg-gradient-to-r from-primary/10 to-transparent py-2 px-3 rounded-lg">
                                        {{ $data['laboratoire'] }}
                                    </span>
                                </div>

                                <!-- Date avec icône -->
                                <div class="bg-base-200/30 rounded-xl p-4">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <i class="fas fa-calendar-alt text-secondary text-lg"></i>
                                        <span class="font-semibold text-base-content/80 text-lg">Date</span>
                                    </div>
                                    <span
                                        class="font-medium text-base-content text-lg pl-8 block bg-gradient-to-r from-secondary/10 to-transparent py-2 px-3 rounded-lg">
                                        {{ \Carbon\Carbon::parse($data['date'])->format('d/m/Y') }}
                                    </span>
                                </div>

                                <!-- Équipements -->
                                <div class="bg-base-200/30 rounded-xl p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <i class="fas fa-microscope text-accent text-lg"></i>
                                        <span class="font-semibold text-base-content/80 text-lg">Équipements</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 pl-8">
                                        @foreach ($data['equipements'] as $equipement)
                                            <span
                                                class="badge badge-accent badge-lg py-3 px-4 rounded-lg shadow-sm border-0 bg-accent/10 text-accent-content">
                                                <i class="fas fa-cube mr-1 text-xs"></i>{{ $equipement }}
                                            </span>
                                        @endforeach
                                        @if (empty($data['equipements']))
                                            <span class="badge badge-ghost badge-lg py-3 px-4 rounded-lg">Non
                                                spécifié</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Horaires -->
                                <div class="bg-base-200/30 rounded-xl p-4">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <i class="fas fa-clock text-info text-lg"></i>
                                        <span class="font-semibold text-base-content/80 text-lg">Horaires</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2 pl-8">
                                        @foreach ($data['horaires'] as $horaire)
                                            <span
                                                class="badge badge-info badge-lg py-3 px-4 rounded-lg shadow-sm border-0 bg-info/10 text-info-content">
                                                <i class="fas fa-clock mr-1 text-xs"></i>{{ $horaire }}
                                            </span>
                                        @endforeach
                                        @if (empty($data['horaires']))
                                            <span class="badge badge-ghost badge-lg py-3 px-4 rounded-lg">Non
                                                spécifié</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Objectif -->
                                <div class="bg-base-200/30 rounded-xl p-4">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <i class="fas fa-bullseye text-warning text-lg"></i>
                                        <span class="font-semibold text-base-content/80 text-lg">Objectif</span>
                                    </div>
                                    <p
                                        class="text-base-content/80 text-sm pl-8 bg-warning/5 rounded-lg p-4 border-l-4 border-warning/30 italic leading-relaxed">
                                        {{ $data['objectif'] ?: 'Non spécifié' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Note d'information -->
                            <div
                                class="mt-4 bg-gradient-to-r from-primary/5 to-info/5 rounded-xl p-4 text-sm border border-primary/20 shadow-sm">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-info-circle text-primary text-lg mt-0.5"></i>
                                    <div>
                                        <p class="text-base-content/80 font-medium mb-2">
                                            Vous pouvez vérifier ou modifier votre réservation dans votre espace tableau de
                                            bord.
                                        </p>
                                        <a href="{{ route('chercheur.reservations.index') }}"
                                            class="btn btn-primary btn-outline btn-sm shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105 mt-2">
                                            <i class="fas fa-external-link-alt mr-2"></i>
                                            Accéder à mes réservations
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    <!-- Actions (toujours visible en bas) -->
                    <div
                        class="modal-action p-6 pt-0 flex-shrink-0 border-t border-base-300/20 bg-base-100/80 backdrop-blur-sm">
                        <label for="reservationModal"
                            class="btn btn-success btn-wide shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-check mr-2"></i>Compris, merci !
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- Info Section -->
    <section class="py-16 bg-base-200 mb-12">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Informations importantes</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card bg-base-100 shadow-lg border border-base-300">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary/10 p-4 rounded-full mb-4">
                            <i class="fas fa-clock text-primary text-3xl"></i>
                        </div>
                        <h3 class="card-title mb-2">Horaires d'ouverture</h3>
                        <p>Le laboratoire est ouvert du lundi au vendredi de 8h à 19h et le samedi de 9h à 16h.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-lg border border-base-300">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary/10 p-4 rounded-full mb-4">
                            <i class="fas fa-exclamation-circle text-primary text-3xl"></i>
                        </div>
                        <h3 class="card-title mb-2">Annulation</h3>
                        <p>Les réservations peuvent être annulées jusqu'à 24h avant le créneau réservé.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-lg border border-base-300">
                    <div class="card-body items-center text-center">
                        <div class="bg-primary/10 p-4 rounded-full mb-4">
                            <i class="fas fa-user-shield text-primary text-3xl"></i>
                        </div>
                        <h3 class="card-title mb-2">Formation requise</h3>
                        <p>Une formation est obligatoire avant toute utilisation des équipements spécialisés.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Script recap -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('reservation-date');
        const objectiveInput = document.getElementById('reservation-objective');

        const selectedEquipmentsContainer = document.getElementById('selected-equipments');
        const selectedDateContainer = document.getElementById('selected-date');
        const selectedTimesContainer = document.getElementById('selected-times');
        const objectivePreview = document.getElementById('reservation-objective-preview');

        // Icônes par équipement
        const equipmentIcons = {
            'microscope': 'fa-microscope',
            'centrifugeuse': 'fa-cogs',
            'automate': 'fa-robot',
            'hotte': 'fa-wind'
        };

        // Traduction noms
        function getEquipmentName(value) {
            const names = {
                'microscope': 'Microscope électronique',
                'centrifugeuse': 'Centrifugeuse réfrigérée',
                'automate': 'Automate d\'analyse bactérienne',
                'hotte': 'Hotte à flux laminaire'
            };
            return names[value] || value;
        }

        // Mise à jour du résumé
        function updateSummary() {
            // ⚡ Toujours récupérer les checkboxes actualisées
            const equipmentCheckboxes = document.querySelectorAll('input[name="equipements[]"]');
            const timeSlotCheckboxes = document.querySelectorAll('input[name="horaires[]"]');

            // --- Équipements ---
            const selectedEquipments = Array.from(equipmentCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if (selectedEquipments.length > 0) {
                selectedEquipmentsContainer.innerHTML = selectedEquipments.map(equipment => `
                    <div class="flex items-center justify-between py-1">
                        <div class="flex items-center">
                            <div class="bg-primary/10 p-2 rounded-md mr-3">
                                <i class="fas ${equipmentIcons[equipment] || 'fa-toolbox'} text-primary"></i>
                            </div>
                            <span class="text-sm">${getEquipmentName(equipment)}</span>
                        </div>
                    </div>
                `).join('');
            } else {
                selectedEquipmentsContainer.innerHTML = `
                    <p class="text-base-content/60 text-sm text-center py-4">
                        <i class="fas fa-info-circle mr-1"></i>
                        Aucun équipement sélectionné
                    </p>
                `;
            }

            // --- Date ---
            if (dateInput.value) {
                const date = new Date(dateInput.value);
                const formattedDate = date.toLocaleDateString('fr-FR', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                selectedDateContainer.innerHTML = `
                    <span class="text-base-content/70 flex items-center">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Date :
                    </span>
                    <span class="badge badge-primary">${formattedDate}</span>
                `;
            } else {
                selectedDateContainer.innerHTML = `
                    <span class="text-base-content/70 flex items-center">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Date :
                    </span>
                    <span class="badge badge-ghost">Non sélectionnée</span>
                `;
            }

            // --- Horaires ---
            const selectedTimeSlots = Array.from(timeSlotCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            if (selectedTimeSlots.length > 0) {
                selectedTimesContainer.innerHTML = selectedTimeSlots.map(slot => `
                    <div class="flex justify-between items-center py-1 border-b border-base-300/30 last:border-b-0">
                        <span class="text-base-content/70 flex items-center">
                            <i class="fas fa-clock mr-2"></i>
                            Créneau :
                        </span>
                        <span class="badge badge-primary badge-outline">${slot}</span>
                    </div>
                `).join('');
            } else {
                selectedTimesContainer.innerHTML = `
                    <p class="text-base-content/60 text-sm text-center py-2">
                        <i class="fas fa-clock mr-1"></i>
                        Aucun créneau sélectionné
                    </p>
                `;
            }

            // --- Objectif ---
            if (objectiveInput.value.trim()) {
                objectivePreview.textContent = objectiveInput.value;
            } else {
                objectivePreview.textContent = 'Aucun objectif spécifié';
            }
        }

        // Écouteurs
        dateInput.addEventListener('change', updateSummary);
        objectiveInput.addEventListener('input', updateSummary);

        // Event delegation pour checkboxes dynamiques
        document.addEventListener('change', function(e) {
            if (e.target.matches('input[name="equipements[]"], input[name="horaires[]"]')) {
                updateSummary();
            }
        });

        // Init
        updateSummary();
    });
</script>


    <!-- script pour charger equipements et horaires -->
    <script>
        const dateInput = document.getElementById('reservation-date');
        const eqContainer = document.getElementById('equipements-container');
        const hContainer = document.getElementById('horaires-container');

        dateInput.addEventListener('change', loadData);

        function loadData() {
            let date = dateInput.value;
            if (!date) return;

            // Charger équipements
            fetch(`/reservations/{{ $laboratoire->id }}/equipements-disponibles?date=${date}`)
                .then(r => r.json())
                .then(data => {
                    eqContainer.innerHTML = '';
                    data.forEach(e => {
                        eqContainer.innerHTML += `
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="equipements[]" value="${e.id}" id="eq${e.id}"
                                    ${e.disponible ? '' : 'disabled'}>
                                <label class="form-check-label ${e.disponible ? '' : 'text-error'}" for="eq${e.id}">
                                    ${e.nom} ${e.disponible ? '' : '(réservé)'}
                                </label>
                            </div>
                        </div>`;
                    });
                    updateSummary();
                });

            // Charger horaires
            fetch(`/reservations/{{ $laboratoire->id }}/horaires-disponibles?date=${date}`)
                .then(r => r.json())
                .then(data => {
                    hContainer.innerHTML = '';
                    data.forEach(h => {
                        hContainer.innerHTML += `
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="horaires[]" value="${h.id}" id="h${h.id}"
                                    ${h.disponible ? '' : 'disabled'}>
                                <label class="form-check-label ${h.disponible ? '' : 'text-error'}" for="h${h.id}">
                                    ${h.debut} - ${h.fin} ${h.disponible ? '' : '(réservé)'}
                                </label>
                            </div>
                        </div>`;
                    });
                    updateSummary();
                });
        }
    </script>

    {{-- script loader et modal --}}
    <script>
        const form = document.getElementById('reservation-form');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoader = document.getElementById('btnLoader');

        form.addEventListener('submit', () => {
            // Désactiver le bouton
            submitBtn.disabled = true;

            // Masquer le texte et afficher le loader
            btnText.textContent = "Envoi en cours...";
            btnLoader.classList.remove('hidden');
        });
    </script>

    <style>
        .equipment-item label,
        .time-slot-item label {
            transition: all 0.2s ease;
        }

        .equipment-item label:hover,
        .time-slot-item label:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .sticky {
            position: sticky;
            align-self: start;
        }

        textarea {
            min-height: 8rem;
            resize: none
        }
    </style>
@endsection
