// seleziona tutti i checkbox usando un checkbox con id checkbox-all

document.addEventListener('DOMContentLoaded', function () {
    const checkboxAll = document.getElementById('checkbox-all');
    const individualCheckboxes = document.querySelectorAll('.event-checkbox');  // prendo gli n checkbox
    const deleteBtn = document.getElementById('bulk-delete-btn'); // prendi il bottone di eliminazione (o che attiva il modale per la conferma)
    
    
    function updateDeleteButtonState() {
        // Se in questa pagina non c'è il bottone, esci solo da questa funzione
        if (!deleteBtn) return; 

        // Usa 'individualCheckboxes' per verificare se c'è almeno un elemento selezionato
        const hasChecked = Array.from(individualCheckboxes).some(cb => cb.checked);

        if (hasChecked) {
            deleteBtn.removeAttribute('disabled');
            deleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            deleteBtn.setAttribute('disabled', 'true');
            deleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    if (checkboxAll) {
        checkboxAll.addEventListener('click', function (e) {

            // 1. Controlla se TUTTI i singoli checkbox sono già selezionati
            const allChecked = Array.from(individualCheckboxes).every(cb => cb.checked);

            // 2. Applica la tua logica elastica
            if (allChecked) {
                // Se tutti sono già selezionati -> deselezionali tutti
                individualCheckboxes.forEach(cb => cb.checked = false);
                checkboxAll.checked = false;
            } else {
                // Se non tutti sono selezionati (ce n'è almeno uno vuoto) -> selezionali tutti
                individualCheckboxes.forEach(cb => cb.checked = true);
                checkboxAll.checked = true;
            }

            //  Aggiorna lo stato del bottone dopo il click su "Seleziona Tutti"
            updateDeleteButtonState();
        });

        // Aggiorna lo stato visivo di checkboxAll se l'utente deseleziona un elemento a mano
        individualCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const allChecked = Array.from(individualCheckboxes).every(item => item.checked);
                checkboxAll.checked = allChecked;

                // Aggiorna lo stato del bottone dopo ogni singolo cambio spunta
                updateDeleteButtonState();
            });
        });
    }
});