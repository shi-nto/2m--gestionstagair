function calculateDuration() {
    const dateDebut = document.getElementById('date_debut').value;
    const dateFin = document.getElementById('date_fin').value;
    const dureeDiv = document.getElementById('duree');
    
    if (dateDebut && dateFin) {
        const debut = new Date(dateDebut);
        const fin = new Date(dateFin);

        if (debut >= fin) {
            alert('La date de début doit être antérieure à la date de fin.');
            dureeDiv.textContent = '';
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

        if(months >= 3){
            alert("Le stagiaire à stager 3 mois ou plus");
        }

        dureeDiv.textContent = `${months} mois et ${days} jours`;
    }
}