<!-- Modal Détails Réservation -->
<div class="modal fade" id="modal-detail-reservation" tabindex="-1" aria-labelledby="modalDetailReservationLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalDetailReservationLabel">Détails de la réservation</h5> <button
                    type="button" class="close" data-dismiss="modal" aria-label="Fermer"> <span
                        aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <p><strong>Utilisateur :</strong> <span id="detail-user"></span></p>
                        <p><strong>Téléphone :</strong> <span id="detail-telephone"></span></p>
                        <p><strong>Laboratoire :</strong> <span id="detail-labo"></span></p>
                        <p><strong>Équipements :</strong> <span id="detail-equipements"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date :</strong> <span id="detail-date"></span></p>
                        <p><strong>Horaire :</strong> <span id="detail-horaire"></span></p>
                        <p><strong>Statut :</strong> <span id="detail-statut" class="badge"></span></p>
                        <p><strong>Objectif :</strong> <span id="detail-objectif"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
