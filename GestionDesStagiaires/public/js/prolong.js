function calculateDuration() {
    const dateDebut = document.getElementById('date_debut').value;
    const dateFin = document.getElementById('date_fin').value;
    const oldDateFin = document.getElementById('date_fin_old').value;

    if (dateDebut && dateFin) {
        const debut = new Date(dateDebut);
        const fin = new Date(dateFin);
        const old = new Date(oldDateFin);

        if (debut >= fin) {
            alert('La date de début doit être antérieure à la date de fin.');
            document.getElementById('date_fin').value = ''; // Clear the date input
            return;
        } else if (old >= fin) {
            alert("La nouvelle date de fin doit être supérieure à l'ancienne date de fin.");
            document.getElementById('date_fin').value = ''; // Clear the date input
            return;
        }

        let months = (fin.getFullYear() - debut.getFullYear()) * 12;
        months -= debut.getMonth();
        months += fin.getMonth();
        if (fin.getDate() < debut.getDate()) {
            months--;
        }

        let days = fin.getDate() - debut.getDate();
        if (days < 0) {
            const prevMonth = new Date(fin.getFullYear(), fin.getMonth(), 0);
            days += prevMonth.getDate();
        }

        if (months >= 3) {
            alert("Le stagiaire a stage 3 mois ou plus.");
        }
    }
}
