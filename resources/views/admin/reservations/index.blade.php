@extends('layouts.app')
@section('title', 'Réservations')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Réservations</h1>
        <a href="{{ route('admin.reservations.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle Réservation
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="row w-100">
            <div class="col-md-4 mb-2">
                <select id="laboFilter" class="form-control" onchange="filterTable()">
                    <option value="">Filtrer par Laboratoire</option>
                    @foreach($laboratoires as $labo)
                        <option value="{{ $labo->id }}">{{ $labo->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select id="statutFilter" class="form-control" onchange="filterTable()">
                    <option value="">Filtrer par Statut</option>
                    <option value="confirme">Confirmée</option>
                    <option value="en attente">En attente</option>
                    <option value="annule">Annulée</option>
                </select>
            </div>
            <div class="col-md-4 mb-2 d-flex">
                <button type="button" class="btn btn-secondary w-100" onclick="resetFilters()">
                    <i class="fas fa-undo"></i> Réinitialiser
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Réservations (<span id="reservationCount">{{ count($reservations) }}</span>)</h6>
        </div>
        <div class="card-body">
            <div id="noResults" class="alert alert-warning text-center fw-bold" style="display:none;">
                Aucune réservation trouvée
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Utilisateur</th>
                            <th>Laboratoire & Équipements</th>
                            <th>Horaires</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr data-labo="{{ $reservation->laboratoire_id }}" data-statut="{{ $reservation->statut }}">
                                {{-- Utilisateur --}}
                                <td>
                                    <strong>{{ $reservation->user->prenom }} {{ $reservation->user->name }}</strong><br>
                                    <small class="text-muted">{{ $reservation->user->telephone ?? 'N/A' }}</small>
                                </td>

                                {{-- Laboratoire + équipements --}}
                                <td>
                                    <strong>{{ $reservation->laboratoire->nom }}</strong><br>
                                    <small class="text-muted">
                                        {{ $reservation->equipements->pluck('nom')->implode(', ') }}
                                    </small>
                                </td>

                                {{-- Horaires --}}
                                <td>
                                    @foreach ($reservation->horaires as $horaire)
                                        <span class="badge bg-primary text-white mb-2">
                                            {{ $horaire->debut }} - {{ $horaire->fin }}
                                        </span><br>
                                    @endforeach
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}
                                    </small>
                                </td>

                                {{-- Statut --}}
                                <td>
                                    @php
                                        $badges = [
                                            'confirme' => 'success',
                                            'en attente' => 'warning',
                                            'annule' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $badges[$reservation->statut] ?? 'secondary' }} text-white">
                                        {{ ucfirst($reservation->statut) }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    {{-- Voir détails --}}
                                    <a href="#" class="btn btn-sm btn-info btn-detail-reservation" data-toggle="modal"
                                        data-target="#modal-detail-reservation"
                                        data-user="{{ $reservation->user->prenom }} {{ $reservation->user->name }}"
                                        data-telephone="{{ $reservation->user->telephone ?? '-' }}"
                                        data-labo="{{ $reservation->laboratoire->nom }}"
                                        data-equipements="{{ $reservation->equipements->pluck('nom')->join(', ') }}"
                                        data-date="{{ $reservation->date->format('d/m/Y') }}"
                                        data-horaire="{{ $reservation->horaires->map(fn($h) => $h->debut . '-' . $h->fin)->join(', ') }}"
                                        data-statut="{{ $reservation->statut }}"
                                        data-objectif="{{ $reservation->objectif ?? 'Non renseigné' }}" title="Voir détails">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    {{-- Modifier uniquement si la réservation n'est pas annulée --}}
                                    @if($reservation->statut !== 'annule')
                                        <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                            class="btn btn-sm btn-warning" title="Modifier"
                                            {{ $reservation->date->isPast() ? 'disabled' : '' }}>
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    {{-- Annuler --}}
                                    @if($reservation->statut !== 'annule')
                                        <form action="{{ route('admin.reservations.cancel', $reservation->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-primary" title="Annuler"
                                                {{ $reservation->date->isPast() ? 'disabled' : '' }}>
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucune réservation trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Détails Réservation -->
    @include('admin.reservations.partials.modal-detail')

    <script>
        function filterTable() {
            const laboValue = document.getElementById('laboFilter').value;
            const statutValue = document.getElementById('statutFilter').value;
            const rows = document.querySelectorAll('#dataTable tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const rowLabo = row.getAttribute('data-labo');
                const rowStatut = row.getAttribute('data-statut');

                const showLabo = laboValue === '' || rowLabo === laboValue;
                const showStatut = statutValue === '' || rowStatut.toLowerCase() === statutValue.toLowerCase();

                if (showLabo && showStatut) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('reservationCount').innerText = visibleCount;

            document.getElementById('noResults').style.display =
                visibleCount === 0 ? 'block' : 'none';
        }

        function resetFilters() {
            document.getElementById('laboFilter').value = '';
            document.getElementById('statutFilter').value = '';
            filterTable();
        }

        // exécuter au chargement
        filterTable();
    </script>
@endsection
@include('admin.reservations.scripts')
