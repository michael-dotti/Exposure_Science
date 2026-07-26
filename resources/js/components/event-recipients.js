// Script per far funzionare il tasto "Seleziona tutti" e verificare che l'utente selezioni almeno un destinatario 
document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('toggle-recipients-btn');
        const checkboxes = document.querySelectorAll('.recipient-checkbox');
        const container = document.getElementById('recipients-container');
        const errorMsg = document.getElementById('recipients-client-error');
        
        if (!checkboxes.length) return; // se non c'è nessun input (perché mancano gli user) lo script termina

        // recupera il form genitore in cui si trova il componente
        const form = checkboxes[0].closest('form');

        //1) Gestisce il "Seleizona Tutti"
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
        
        // 2) RImuove l'errore in tempo reale non appena l'utente seleziona una checkbox
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const isAnyCheked = Array.from(checkboxes).some(c => c.checked);
                if (isAnyCheked) {
                    clearError();
                }
            })
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

                    // Fai uno scroll morbido verso il campo per evidenziarlo all'utente
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