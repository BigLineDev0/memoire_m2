document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editHoraireBtn");
    const form = document.getElementById("formEditHoraire");
    const debutInput = document.getElementById("edit-debut");
    const finInput = document.getElementById("edit-fin");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function () {
            const id = this.dataset.id;
            const debut = this.dataset.debut;
            const fin = this.dataset.fin;

            // Mettre les valeurs dans le formulaire
            debutInput.value = debut;
            finInput.value = fin;

            // Mettre l'action du formulaire dynamiquement
            form.action = `/admin/horaires/${id}`;
        });
    });
});