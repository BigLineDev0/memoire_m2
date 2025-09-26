@extends('layouts.app')
@section('title', 'Equipements')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Equipements</h1>
    </div>

    {{-- Message de succès --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="row">
            <div class="col-md-8 mb-2">
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
                    <option value="disponible">Disponible</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="reserve">Réservé</option>
                </select>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Equipements (<span id="resultCount">{{ count($equipements) }}</span>)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="25%">Nom Equipement</th>
                            <th width="10%" class="text-center">Nb. Labos</th>
                            <th width="40%">Laboratoires</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($equipements as $equipement)
                            <tr data-labo-ids="{{ $equipement->laboratoires->pluck('id')->implode(',') }}"
                                data-statut="{{ strtolower($equipement->statut) }}">

                                <!-- Nom de l'équipement -->
                                <td>
                                    <strong>{{ $equipement->nom }}</strong> <br>
                                    @php
                                        $statutColors = [
                                            'disponible' => 'success',
                                            'maintenance' => 'danger',
                                            'reserve' => 'warning'
                                        ];
                                        $color = $statutColors[strtolower($equipement->statut)] ?? 'secondary';
                                    @endphp
                                    <small class="badge bg-{{ $color }} text-white ">
                                        {{ ucfirst($equipement->statut) }}
                                    </small>
                                </td>

                                <!-- Nombre de laboratoires -->
                                <td class="text-center">
                                    <span class="badge bg-secondary text-white fs-6">
                                        {{ $equipement->laboratoires->count() }}
                                    </span>
                                </td>

                                <!-- Laboratoires avec système "Show More" -->
                                <td>
                                    @php
                                        $visibleCount = 2;
                                        $totalCount = $equipement->laboratoires->count();
                                        $visibleLabos = $equipement->laboratoires->take($visibleCount);
                                        $hiddenLabos = $equipement->laboratoires->skip($visibleCount);
                                    @endphp

                                    @if($totalCount == 0)
                                        <span class="text-muted fst-italic">Aucun laboratoire</span>
                                    @else
                                        <!-- Laboratoires visibles -->
                                        @foreach($visibleLabos as $lab)
                                            <span class="badge bg-info text-white me-1 mb-1">{{ $lab->nom }}</span>
                                        @endforeach

                                        <!-- Badge "+X autres" avec tooltip -->
                                        @if($totalCount > $visibleCount)
                                            <span class="badge bg-secondary text-white  position-relative"
                                                  style="cursor: help;"
                                                  data-bs-toggle="tooltip"
                                                  data-bs-placement="top"
                                                  data-bs-html="true"
                                                  title="<strong>Autres laboratoires :</strong><br>{{ $hiddenLabos->pluck('nom')->implode('<br>') }}">
                                                +{{ $totalCount - $visibleCount }} autre{{ $totalCount - $visibleCount > 1 ? 's' : '' }}
                                            </span>

                                            <!-- Bouton modal pour voir tous (optionnel) -->
                                            <button type="button" class="btn btn-sm btn-outline-info ms-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#laboModal{{ $equipement->id }}"
                                                    title="Voir tous les laboratoires">
                                                <i class="fas fa-eye fa-xs"></i>
                                            </button>
                                        @endif
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="text-center">

                                    <a href="#"
                                        class="btn-detail-equipement btn btn-sm btn-info" data-id="{{ $equipement->id }}"
                                        data-nom="{{ $equipement->nom }}"
                                        data-description="{{ $equipement->description }}"
                                        data-statut="{{ $equipement->statut }}"
                                        data-created_at="{{ $equipement->created_at->format('d/m/Y à H:i') }}"
                                        data-updated_at="{{ $equipement->updated_at->format('d/m/Y à H:i') }}"
                                        data-laboratoires="{{ $equipement->laboratoires->pluck('nom')->implode('|') }}"
                                        data-toggle="modal" data-target="#modal-detail-equipement"

                                        title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('chercheur.equipements.alert', $equipement) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Alerter">
                                        <i class="fas fa-bell"></i>
                                    </a>

                                </td>
                            </tr>

                            <!-- Modal pour voir tous les laboratoires -->
                            @if($equipement->laboratoires->count() > $visibleCount)
                                <div class="modal fade" id="laboModal{{ $equipement->id }}" tabindex="-1"
                                     aria-labelledby="laboModalLabel{{ $equipement->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="laboModalLabel{{ $equipement->id }}">
                                                    Laboratoires - {{ $equipement->nom }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($equipement->laboratoires as $lab)
                                                        <span class="badge bg-info fs-6 p-2">{{ $lab->nom }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Fermer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

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

    <!-- ========== Modal de détails équipement ========== -->
    <div class="modal fade" id="modal-detail-equipement" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="modalDetailEquipLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content shadow border-0">

                <!-- En-tête -->
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDetailEquipLabel">Détails de l'équipement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Corps -->
                <div class="modal-body">
                    <div class="row">

                        <div class="col-12">
                            <h4 id="detail-labo-nom" class="text-primary fw-bold mb-3"></h4>

                            <p>
                                <strong>Description :</strong><br>
                                <span id="detail-labo-description" class="text-muted"></span>
                            </p>

                            <p>
                                <strong>Statut :</strong>
                                <span id="detail-labo-statut" class="badge badge-info px-2 py-1"></span>
                            </p>

                            <p>
                                <strong>Laboratoires associés :</strong><br>
                                <span id="detail-labo-laboratoires" class="text-muted"></span>
                            </p>

                            <p>
                                <strong>Créé le :</strong>
                                    <span id="detail-labo-created-at" class="text-muted"></span>
                                </strong>
                            </p>

                            <p id="updated-at-wrapper" class="d-none">
                                <strong>Dernière modification :</strong>
                                <span id="detail-labo-updated-at" class="text-muted"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts améliorés -->
    <script>
        // Initialisation des tooltips Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Fonction de filtrage améliorée
        function filterTable() {
            const laboFilter = document.getElementById("laboFilter").value;
            const statutFilter = document.getElementById("statutFilter").value;
            const rows = document.querySelectorAll("#dataTable tbody tr[data-labo-ids]");
            let visibleCount = 0;

            rows.forEach(row => {
                const laboIds = row.getAttribute("data-labo-ids").split(',').filter(id => id !== '');
                const statut = row.getAttribute("data-statut");

                // Vérifier le filtre laboratoire
                const laboMatch = laboFilter === "" || laboIds.includes(laboFilter);

                // Vérifier le filtre statut
                const statutMatch = statutFilter === "" || statut === statutFilter;

                // Afficher la ligne si elle correspond aux deux filtres
                const shouldShow = laboMatch && statutMatch;

                if (shouldShow) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            });

            // Mettre à jour le compteur de résultats
            document.getElementById('resultCount').textContent = visibleCount;

            // Afficher un message si aucun résultat
            const noResultsRow = document.querySelector('#dataTable tbody tr:not([data-labo-ids])');
            if (visibleCount === 0 && !noResultsRow) {
                const tbody = document.querySelector('#dataTable tbody');
                tbody.innerHTML += `
                    <tr id="noResultsRow">
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fas fa-search fa-2x mb-2 d-block"></i>
                            Aucun équipement ne correspond aux filtres sélectionnés
                        </td>
                    </tr>
                `;
            } else if (visibleCount > 0) {
                const noResultsRow = document.getElementById('noResultsRow');
                if (noResultsRow) {
                    noResultsRow.remove();
                }
            }
        }

        // Fonction pour réinitialiser les filtres
        function resetFilters() {
            document.getElementById("laboFilter").value = "";
            document.getElementById("statutFilter").value = "";
            filterTable();
        }

        // Fonction pour exporter en CSV (bonus)
        function exportToCSV() {
            const rows = document.querySelectorAll("#dataTable tbody tr[data-labo-ids]");
            let csvContent = "Nom,Laboratoires,Statut\n";

            rows.forEach(row => {
                if (row.style.display !== "none") {
                    const cells = row.querySelectorAll("td");
                    const nom = cells[0].textContent.trim();
                    const labos = Array.from(cells[2].querySelectorAll('.badge'))
                                      .map(badge => badge.textContent.trim())
                                      .filter(text => !text.includes('+'))
                                      .join(';');
                    const statut = cells[3].textContent.trim();
                    csvContent += `"${nom}","${labos}","${statut}"\n`;
                }
            });

            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'equipements_filtered.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
    </script>

@endsection
@include('chercheur.equipements.scripts')
