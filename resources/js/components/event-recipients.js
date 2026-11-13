// Script per far funzionare il tasto "Seleziona tutti" e verificare che l'utente selezioni almeno un destinatario 
document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('toggle-recipients-btn');
        const checkboxes = document.querySelectorAll('.recipient-checkbox');
        const container = document.getElementById('recipients-container');
        const errorMsg = document.getElementById('recipients-client-error');
        
        if (!checkboxes.length) return; // se non c'è nessun input (perché mancano gli user) lo script termina

        // recupera il form genitore in cui si trova il componente
        const form = checkboxes[0].closest('form');

        //1) Gestisce il "Seleziona Tutti"
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const isSelectingAll = toggleBtn.dataset.state === 'unselected';

                checkboxes.forEach(cb => cb.checked = isSelectingAll);

                toggleBtn.dataset.state = isSelectingAll ? 'selected' : 'unselected';
                toggleBtn.innerText = isSelectingAll ? 'Deseleziona tutti' : 'Seleziona tutti';

                // Pulisce l'errore se sono stati selezionati tutti
                if (isSelectingAll){
                    clearError();
                }
            });
        }
        
        // 2) Rimuove l'errore in tempo reale e tiene sincronizzato il pulsante "Seleziona tutti"
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                // Conta quante checkbox sono attualmente spuntate
                const checkedCount = Array.from(checkboxes).filter(c => c.checked).length;
                const totalCount = checkboxes.length;

                // Se ce n'è almeno una spuntata, rimuovi l'errore rosso
                if (checkedCount > 0) {
                    clearError();
                }

                // Sincronizza il pulsante principale
                if (toggleBtn) {
                    if (checkedCount === totalCount) {
                        // Se l'utente le ha spuntate tutte manualmente
                        toggleBtn.dataset.state = 'selected';
                        toggleBtn.innerText = 'Deseleziona tutti';
                    } else {
                        // Se ne manca anche solo una (o sono scese a zero)
                        toggleBtn.dataset.state = 'unselected';
                        toggleBtn.innerText = 'Seleziona tutti';
                    }
                }
            });
        });

        // 3) Validazione prima del submit del form
        if (form) {
            form.addEventListener('submit', (e) => {
                const isAnyChecked = Array.from(checkboxes).some(c => c.checked);

                if (!isAnyChecked) {
                    // Blocca l'invio del form
                    e.preventDefault(); 
                    
                    // Mostra il bordo rosso e il messaggio
                    showError();

                    // Fa uno scroll morbido (smooth) verso il campo per evidenziarlo all'utente
                    container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        }

        function showError() {
            if (container) {
                container.classList.remove('border-default-medium');
                container.classList.add('border-red-500');
            }
            if (errorMsg) {
                errorMsg.classList.remove('hidden');
            }
        }

    function clearError() {
        if (container) {
            container.classList.remove('border-red-500');
            container.classList.add('border-default-medium');
        }
        if (errorMsg) {
            errorMsg.classList.add('hidden');
        }
    }
});