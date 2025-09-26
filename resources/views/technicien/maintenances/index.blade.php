@extends('layouts.app')
@section('title', 'Maintenances')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-4 text-gray-800">Gestion des Maintenances</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
            data-target="#planifierModal">
            <i class="fas fa-calendar-plus fa-sm text-white-50"></i> Planifier Maintenance
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Liste des Maintenance (<span id="resultCount">4</span>)
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom Equipement</th>
                            <th>Technicien</th>
                            <th>Date Prévue</th>
                            <th>Description</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maintenances as $maintenance)
                            <tr>
                                <td>{{ $maintenance->equipement->nom }}
                                    <br>
                                    <small class="badge badge-info text-white">
                                        {{ $maintenance->equipement->statut }}
                                    </small>
                                </td>
                                <td>{{ $maintenance->user->prenom }} {{ $maintenance->user->name }}</td>
                                <td>
                                    @if ($maintenance->statut === 'en_cours')
                                        {{ $maintenance->date_prevue->format('d/m/Y') }}
                                    @else
                                        <span class="badge badge-secondary text-white">Terminé le

                                            {{ $maintenance->created_at->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    {{ $maintenance->description ?? '-' }}
                                </td>
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
                                <td>

                                    @if ($maintenance->statut === 'en_cours')
                                        <!-- Terminer -->
                                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal"
                                            data-target="#marquerTermineeModal{{ $maintenance->id }}">
                                            <i class="fas fa-check"></i>
                                        </a>

                                        <!-- Annuler -->
                                        <form action="{{ route('technicien.maintenances.annuler', $maintenance->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Annuler cette maintenance ?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif

                                   
                                </td>
                            </tr>
                            <!-- Modal Marquer Terminer -->
                            <div class="modal fade" id="marquerTermineeModal{{ $maintenance->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="formPlanifier" method="POST"
                                        action="{{ route('technicien.maintenances.terminer', $maintenance->id) }}">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Terminer Maintenance -
                                                    {{ $maintenance->equipement->nom }}</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Message</label>
                                                    <textarea name="description" class="form-control"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Terminer</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Planifier -->
    <div class="modal fade" id="planifierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formPlanifier" method="POST" action="{{ route('technicien.maintenances.planifier') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Planifier Maintenance</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label>Equipements</label>
                            <select name="equipement_id" class="form-control" required>
                                <option value="">-- Sélectionner un équipement --</option>
                                @foreach ($equipements as $equipement)
                                    <option value="{{ $equipement->id }}">{{ $equipement->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date prévue</label>
                            <input type="date" name="date_prevue" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Planifier</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
