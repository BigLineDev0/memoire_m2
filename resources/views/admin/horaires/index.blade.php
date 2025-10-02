@extends('layouts.app')
@section('title', 'Horaires')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Horaires</h1>
        <div class="d-none d-sm-inline-block">
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal"
                data-target="#addHoraire">
                <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter un Horaire
            </a>
        </div>
    </div>
    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Horaires</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Heure de début</th>
                            <th>heure de Fin</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($horaires as $horaire)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $horaire->debut }}</td>
                                <td>{{ $horaire->fin }}</td>
                                <td>{{ $horaire->created_at->format('d/m/Y à H:i') }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm editHoraireBtn" data-toggle="modal"
                                        data-target="#editHoraire" data-id="{{ $horaire->id }}"
                                        data-debut="{{ $horaire->debut }}" data-fin="{{ $horaire->fin }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.horaires.destroy', $horaire->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Voulez-vous vraiment supprimer ce crenaux ?')"
                                            title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal add Horaires -->
    <div class="modal fade" id="addHoraire" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formAddHoraire" method="POST" action="{{ route('admin.horaires.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un horaire</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Heure Début</label>
                            <input type="time" name="debut" class="form-control" required>
                        </div>


                        <div class="form-group">
                            <label>Heure de Fin</label>
                            <input type="time" name="fin" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Horaire -->
    <div class="modal fade" id="editHoraire" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formEditHoraire" method="POST">
                @csrf
                @method('PUT') <!-- nécessaire pour la mise à jour -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modifier un horaire</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Heure Début</label>
                            <input type="time" name="debut" id="edit-debut" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Heure de Fin</label>
                            <input type="time" name="fin" id="edit-fin" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Modifier</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@include('admin.Horaires.scripts')
