@extends('layouts.app')
@section('title', 'Laboratoires')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Laboratoires</h1>
        <a href="{{ route('admin.laboratoires.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouveau Laboratoire
        </a>
    </div>
    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Laboratoires</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Localisation</th>
                            <th>Equipements</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laboratoires as $laboratoire)
                            <tr>
                                <td>
                                    @if (strlen($laboratoire->nom) > 20)
                                        {{ Str::limit($laboratoire->nom, 20, '...') }}
                                    @else
                                        {{ $laboratoire->nom }}
                                    @endif
                                </td>
                                <td>{{ $laboratoire->localisation }}</td>
                                <td>{{ $laboratoire->equipements->count() }}</td>
                                <td>
                                    @if ($laboratoire->statut == 'actif')
                                        <span class="badge bg-success text-white">Disponible</span>
                                    @elseif ($laboratoire->statut == 'inactif')
                                        <span class="badge bg-danger text-white">Indisponible</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="#"
                                        class="btn-detail-labo btn btn-info" data-id="{{ $laboratoire->id }}"
                                        data-nom="{{ $laboratoire->nom }}"
                                        data-description="{{ $laboratoire->description }}"
                                        data-localisation="{{ $laboratoire->localisation }}"
                                        data-statut="{{ $laboratoire->statut }}" data-photo="{{ $laboratoire->photo }}"
                                        data-created_at="{{ $laboratoire->created_at->format('d/m/Y à H:i') }}"
                                        data-updated_at="{{ $laboratoire->updated_at->format('d/m/Y à H:i') }}"
                                        data-toggle="modal" data-target="#modal-detail-labo" title="Voir détails">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.laboratoires.edit', $laboratoire->id) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.laboratoires.destroy', $laboratoire->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cet laboratoire ?')"
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

    <!-- ========== Modal de détails laboratoire ========== -->
    <div class="modal fade" id="modal-detail-labo" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalDetailLaboLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-sm border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDetailLaboLabel">Détails du laboratoire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Photo -->
                        <div class="col-md-4 text-center">
                            <img id="detail-labo-photo" src="" alt="Photo du laboratoire"
                                class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                        <!-- Infos -->
                        <div class="col-md-8">
                            <h4 id="detail-labo-nom" class="text-primary"></h4>
                            <p><strong>Description :</strong> <span id="detail-labo-description"></span></p>
                            <p><strong>Localisation :</strong> <span id="detail-labo-localisation"></span></p>
                            <p><strong>Statut :</strong> <span id="detail-labo-statut" class="badge"></span></p>
                            <p><strong>Créé le :</strong> <span id="detail-labo-created-at"></span>
                                par
                                <span class="text-muted">{{ auth()->user()->prenom }} {{ auth()->user()->name }}</span>
                            </p>
                            <p id="updated-at-wrapper" class="d-none">
                                <strong>Dernière modification :</strong> <span id="detail-labo-updated-at"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.laboratoires.scripts')
