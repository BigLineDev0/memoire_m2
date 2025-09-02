document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-detail-reservation").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("detail-user").textContent = this.dataset.user;
            document.getElementById("detail-telephone").textContent = this.dataset.telephone;
            document.getElementById("detail-labo").textContent = this.dataset.labo;
            document.getElementById("detail-equipements").textContent = this.dataset.equipements;
            document.getElementById("detail-date").textContent = this.dataset.date;
            document.getElementById("detail-horaire").textContent = this.dataset.horaire;

            let statutBadge = document.getElementById("detail-statut");
            statutBadge.textContent = this.dataset.statut;
            if (this.dataset.statut === "confirme") {
                statutBadge.className = "badge bg-success text-white";
            } else if (this.dataset.statut === "en attente") {
                statutBadge.className = "badge bg-warning text-white";
            } else if (this.dataset.statut === "annule") {
                statutBadge.className = "badge bg-danger text-white";
            } else {
                statutBadge.className = "badge bg-secondary text-white";
            }

            document.getElementById("detail-objectif").textContent = this.dataset.objectif;
        });
    });
});
