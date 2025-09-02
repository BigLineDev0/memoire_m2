@extends('layouts.app')
@section('title', 'Equipements')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Maintenances</h1>
    </div>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="row">
            <div class="col-md-12 mb-2">
                <select id="laboFilter" class="form-control">
                    <option value="">Filtrer par Technicien</option>
                    <option value="Ousmane">Ousmane</option>
                    <option value="Mamadou">Mamadou</option>
                    <option value="Awa">Awa</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Equipements en Maintenance (<span id="resultCount">{{ count($equipements) }}</span>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="25%">Nom Equipement</th>
                            <th width="25%">Technicen</th>
                            <th width="15%" class="text-center">Date Prévue</th>
                            <th width="15%">Statut</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipements as $equipement)
                            <tr>

                                <!-- Nom de l'équipement -->
                                <td>
                                    <strong>{{ $equipement->nom }}</strong> <br>
                                    <small class="badge bg-danger text-white ">
                                        {{ $equipement->statut }}
                                    </small>
                                </td>

                                <!-- Nombre de laboratoires -->
                                <td class="text-center">
                                    Ousmane
                                </td>


                                <td>
                                    -
                                </td>

                                <td>
                                    -
                                </td>

                                <!-- Actions -->
                                <td class="text-center">

                                    <a href="#" class="btn btn-sm btn-info"
                                        data-toggle="modal" data-target="#modal-detail-equipement"
                                        title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href=""
                                        class="btn btn-sm btn-warning"
                                        title="Planifier">
                                        <i class="fas fa-calendar-plus"></i>
                                    </a>
                                    <a href=""
                                        class="btn btn-sm btn-success"
                                        title="Marquer">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    Aucun équipement trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
