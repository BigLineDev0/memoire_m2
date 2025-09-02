@extends('layouts.app')
@section('title', 'Utilisateurs')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Utilisateurs</h1>
        <a href="{{ route('admin.utilisateurs.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Ajouter un utilisateur
        </a>
    </div>
    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="row w-100">
            <div class="col-md-4 mb-2">
                <select id="roleFilter" class="form-control" onchange="filterTable()">
                    <option value="">Filtrer par Rôle</option>
                    <option value="admin">Admin</option>
                    <option value="chercheur">Chercheur</option>
                    <option value="technicien">Technicien</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select id="statutFilter" class="form-control" onchange="filterTable()">
                    <option value="">Filtrer par Statut Compte</option>
                    <option value="active">Actif</option>
                    <option value="suspendu">Suspendu</option>
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Utilisateurs (<span id="userCount">{{ count($utilisateurs) }}</span>)</h6>
        </div>
        <div class="card-body">
            <div id="noResults" class="alert alert-warning text-center fw-bold" style="display:none;">
                Aucune utilisateur trouvée
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Utilisateur</th>
                            <th>Adresse</th>
                            <th>Role</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($utilisateurs as $utilisateur)
                            <tr  data-role="{{ $utilisateur->role }}" data-statut="{{ $utilisateur->status }}">
                                <td>
                                    @if ($utilisateur->photo)
                                        <img src="{{ asset('storage/' . $utilisateur->photo) }}" alt="Photo de {{ $utilisateur->nom }}"
                                            class="img-fluid rounded" style="max-height: 50px;">
                                    @else
                                        <img src="{{ asset('images/utilisateurs/default-user.svg') }}" alt="Photo par défaut"
                                            class="img-fluid rounded" style="max-height: 50px;">
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $utilisateur->prenom }} {{ $utilisateur->name }}</strong>
                                    <br>
                                    <a href="mailto:{{ $utilisateur->email }}">{{ $utilisateur->email }}</a><br>
                                    <small class="text-muted">{{ $utilisateur->telephone ?? 'N/A' }}</small>
                                </td>

                                <td>{{ $utilisateur->adresse }}</td>
                                <td>
                                    <span class="badge badge-info text-white">{{ ucfirst($utilisateur->role) }}</span>
                                </td>
                                <td>
                                    <span class="badge text-white {{ $utilisateur->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($utilisateur->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#"
                                        class="btn-detail-user btn btn-info"
                                        data-toggle="modal"
                                        data-target="#modal-detail-user"
                                        title="Voir détails"
                                        data-prenom="{{ $utilisateur->prenom }}"
                                        data-nom="{{ $utilisateur->name }}"
                                        data-email="{{ $utilisateur->email }}"
                                        data-telephone="{{ $utilisateur->telephone ?? '-' }}"
                                        data-adresse="{{ $utilisateur->adresse ?? '-' }}"
                                        data-role="{{ $utilisateur->role }}"
                                        data-status="{{ $utilisateur->status }}"
                                        data-photo="{{ $utilisateur->photo ? asset('storage/'.$utilisateur->photo) : asset('images/default.png') }}"
                                        data-created="{{ $utilisateur->created_at->format('d/m/Y H:i') }}"
                                        data-updated="{{ $utilisateur->updated_at->format('d/m/Y H:i') }}">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.utilisateurs.edit', $utilisateur->id) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.utilisateurs.destroy', $utilisateur->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
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

    <!-- ========== Modal de détails utilisateur ========== -->
    <div class="modal fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-labelledby="modalDetailUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-sm border-0">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDetailUserLabel">Détails de l’utilisateur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Photo -->
                        <div class="col-md-4 text-center">
                            <img id="detail-user-photo" src="" alt="Photo de l’utilisateur"
                                class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                        </div>
                        <!-- Infos -->
                        <div class="col-md-8">
                            <h4 id="detail-user-nom" class="text-primary"></h4>
                            <p><strong>Email :</strong> <span id="detail-user-email"></span></p>
                            <p><strong>Téléphone :</strong> <span id="detail-user-telephone"></span></p>
                            <p><strong>Adresse :</strong> <span id="detail-user-adresse"></span></p>
                            <p><strong>Rôle :</strong> <span id="detail-user-role" class="badge bg-info text-white"></span></p>
                            <p><strong>Statut compte:</strong> <span id="detail-user-status" class="badge text-white"></span></p>
                            <p><strong>Créé le :</strong> <span id="detail-user-created"></span></p>
                            <p><strong>Dernière modification :</strong> <span id="detail-user-updated"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function filterTable() {
            const roleValue = document.getElementById('roleFilter').value;
            const statutValue = document.getElementById('statutFilter').value;
            const rows = document.querySelectorAll('#dataTable tbody tr');
            let visibleCount = 0;

            rows.forEach(row => {
                const rowRole = row.getAttribute('data-role');
                const rowStatut = row.getAttribute('data-statut');

                const showRole = roleValue === '' || rowRole === roleValue;
                const showStatut = statutValue === '' || rowStatut.toLowerCase() === statutValue.toLowerCase();

                if (showRole && showStatut) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            document.getElementById('userCount').innerText = visibleCount;

            document.getElementById('noResults').style.display =
                visibleCount === 0 ? 'block' : 'none';
        }

        function resetFilters() {
            document.getElementById('roleFilter').value = '';
            document.getElementById('statutFilter').value = '';
            filterTable();
        }

        // exécuter au chargement
        filterTable();
    </script>
@endsection
@include('admin.utilisateurs.scripts')
