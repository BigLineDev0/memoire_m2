@extends('layouts.app')
@section('title', 'Tableau de bord')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tableau de bord</h1>
        <a href="{{ route('admin.rapport') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Génerer Rapport
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Laboratoires -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laboratoires
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_laboratories'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipements -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Equipements
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_equipments'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-microscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Réservations -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Réservations
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $stats['total_reservations'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenances -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Maintenances
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['active_maintenances'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tools fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Utilisateurs
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_users'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Réservations du jour -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Réservations du jour: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h6>
                </div>
                <div class="card-body">
                    @if ($recent_reservations->isEmpty())
                        <p class="text-muted">Aucune réservation aujourd'hui.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Laboratoire & Équipements</th>
                                        <th>Horaires</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recent_reservations as $reservation)
                                        <tr>
                                            <td>
                                                <strong>{{ $reservation->user->prenom }} {{ $reservation->user->name }}</strong><br>
                                                <small class="text-muted">{{ $reservation->user->telephone ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $reservation->laboratoire->nom }}</strong><br>
                                                <small class="text-muted">
                                                    {{ $reservation->equipements->pluck('nom')->join(', ') ?: 'Aucun' }}
                                                </small>
                                            </td>
                                            <td>
                                                @foreach ($reservation->horaires as $horaire)
                                                    <span class="badge bg-primary text-white mb-2">
                                                        {{ $horaire->debut }} - {{ $horaire->fin }}
                                                    </span><br>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                {{ $reservation->created_at->format('d/m/Y à H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenances du jour -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Maintenances du jour : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</h6>
                </div>
                <div class="card-body">
                    @if ($recent_maintenances->isEmpty())
                        <p class="text-muted">Aucune maintenance aujourd'hui.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Technicien</th>
                                        <th>Équipement</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recent_maintenances as $maintenance)
                                        <tr>
                                            <td>{{ $maintenance->user->prenom }} {{ $maintenance->user->name }}</td>
                                            <td>{{ $maintenance->equipement->nom }}</td>
                                            <td>{{ $maintenance->created_at->format('d/m/Y à H:i') }}</td>
                                            <td>
                                                @if ($maintenance->statut === 'en_cours')
                                                    <span class="badge badge-warning text-white">En Cours</span>
                                                @elseif ($maintenance->statut === 'termine')
                                                    <span class="badge badge-success text-white">Terminée</span>
                                                @elseif ($maintenance->statut === 'annule')
                                                    <span class="badge badge-danger text-white">Annulée</span>
                                                @else
                                                    <span class="badge badge-secondary text-white">Inconnue</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
