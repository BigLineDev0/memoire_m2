@extends('layouts.app')
@section('title', 'Modifier Réservation')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Modifier Réservation</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- Utilisateur & Labo --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Utilisateur</label>
                        <select name="user_id" class="form-control" required>
                            <option value="">-- Choisir --</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}"
                                    {{ $reservation->user_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->prenom }} {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label>Laboratoire</label>
                        <select id="laboratoire" name="laboratoire_id" class="form-control" required>
                            <option value="">-- Choisir --</option>
                            @foreach ($laboratoires as $lab)
                                <option value="{{ $lab->id }}"
                                    {{ $reservation->laboratoire_id == $lab->id ? 'selected' : '' }}
                                       data-equipements='@json($lab->equipements)'>
                                    {{ $lab->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Équipements --}}
                <div class="mb-3">
                    <label class="d-block mb-2">Équipements</label>
                    <div id="equipements-container" class="row">
                        <div class="col-12 text-muted">Sélectionnez un laboratoire + une date</div>
                    </div>
                </div>

                {{-- Date + Horaires --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Date</label>
                        <input type="date" name="date" id="date" min="{{ date('Y-m-d') }}" value="{{ $reservation->date->format('Y-m-d') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="d-block mb-2">Horaires</label>
                        <div id="horaires-container" class="row">
                            <div class="col-12 text-muted">Sélectionnez une date et un laboratoire</div>
                        </div>
                    </div>
                </div>

                {{-- Objectif --}}
                <div class="mb-3">
                    <label>Objectif (optionnel)</label>
                    <textarea name="objectif" class="form-control" rows="2">{{ $reservation->objectif }}</textarea>
                </div>

                {{-- Boutons --}}
                <button class="btn btn-success">Valider</button>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
    {{-- JS pour charger dynamiquement --}}
<script>
    const laboSelect = document.getElementById('laboratoire');
    const dateInput = document.getElementById('date');
    const eqContainer = document.getElementById('equipements-container');
    const hContainer = document.getElementById('horaires-container');

    const selectedEquipements = @json($reservation->equipements->pluck('id'));
    const selectedHoraires = @json($reservation->horaires->pluck('id'));

    laboSelect.addEventListener('change', loadData);
    dateInput.addEventListener('change', loadData);

    function loadData() {
        let laboId = laboSelect.value;
        let date = dateInput.value;
        if (!laboId || !date) return;

        // Charger équipements
        fetch(`/admin/equipements-disponibles?laboratoire_id=${laboId}&date=${date}&reservation_id={{ $reservation->id }}`)
            .then(r => r.json())
            .then(data => {
                eqContainer.innerHTML = '';
                data.forEach(e => {
                    let col = document.createElement('div');
                    col.classList.add('col-md-4');
                    let checked = selectedEquipements.includes(e.id) ? 'checked' : '';
                    col.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="equipements[]" value="${e.id}" id="eq${e.id}"
                                ${checked} ${e.disponible || checked ? '' : 'disabled'}>
                            <label class="form-check-label ${e.disponible || checked ? '' : 'text-danger'}" for="eq${e.id}">
                                ${e.nom} ${e.disponible || checked ? '' : '(réservé)'}
                            </label>
                        </div>`;
                    eqContainer.appendChild(col);
                });
            });

        // Charger horaires
        fetch(`/admin/horaires-disponibles?laboratoire_id=${laboId}&date=${date}&reservation_id={{ $reservation->id }}`)
            .then(r => r.json())
            .then(data => {
                hContainer.innerHTML = '';
                data.forEach(h => {
                    let col = document.createElement('div');
                    col.classList.add('col-md-6');
                    let checked = selectedHoraires.includes(h.id) ? 'checked' : '';
                    col.innerHTML = `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="horaires[]" value="${h.id}" id="h${h.id}"
                                ${checked} ${h.disponible || checked ? '' : 'disabled'}>
                            <label class="form-check-label ${h.disponible || checked ? '' : 'text-danger'}" for="h${h.id}">
                                ${h.debut} - ${h.fin} ${h.disponible || checked ? '' : '(réservé)'}
                            </label>
                        </div>`;
                    hContainer.appendChild(col);
                });
            });
    }

    // Charger direct au premier affichage
    loadData();
</script>


@endsection
