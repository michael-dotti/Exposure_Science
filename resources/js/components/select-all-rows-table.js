// seleziona tutti i checkbox usando un checkbox con id checkbox-all

document.addEventListener('DOMContentLoaded', function () {
    const checkboxAll = document.getElementById('checkbox-all');
    const individualCheckboxes = document.querySelectorAll('.event-checkbox');  // prendo gli n checkbox

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
        });

        // Aggiorna lo stato visivo di checkboxAll se l'utente deseleziona un elemento a mano
        individualCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                const allChecked = Array.from(individualCheckboxes).every(item => item.checked);
                checkboxAll.checked = allChecked;
            });
        });
    }
});