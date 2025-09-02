document.addEventListener('DOMContentLoaded', function () {
    const detailButtons = document.querySelectorAll('.btn-detail-user');

    detailButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Photo (image par défaut si vide)
            const photo = this.dataset.photo && this.dataset.photo.trim() !== ''
                ? this.dataset.photo
                : '/images/utilisateurs/default-user.svg'; // mets ton chemin d'image par défaut
            document.getElementById('detail-user-photo').src = photo;

            // Infos texte
            document.getElementById('detail-user-nom').textContent = (this.dataset.prenom || '') + ' ' + (this.dataset.nom || '');
            document.getElementById('detail-user-email').textContent = this.dataset.email || '';
            document.getElementById('detail-user-telephone').textContent = this.dataset.telephone || '';
            document.getElementById('detail-user-adresse').textContent = this.dataset.adresse || '';
            document.getElementById('detail-user-role').textContent = this.dataset.role || '';

            // Statut avec badge coloré
            const statusBadge = document.getElementById('detail-user-status');
            statusBadge.textContent = this.dataset.status || '';
            statusBadge.className = 'badge ' + ((this.dataset.status === 'active') ? 'bg-success' : 'bg-danger');

            // Dates
            document.getElementById('detail-user-created').textContent = this.dataset.created || '';
            document.getElementById('detail-user-updated').textContent = this.dataset.updated && this.dataset.updated.trim() !== ''
                ? this.dataset.updated
                : 'Jamais modifié'; // si vide -> rien affiché
        });
    });
});
