document.addEventListener("DOMContentLoaded", function() {
    
    // Seleziona TUTTI gli input che hanno la classe 'check-file-size'
    const fileInputs = document.querySelectorAll('.check-file-size');
    const maxSize = 50 * 1024 * 1024; // 50 MB in byte

    // Cicla su ogni input trovato e applica la regola
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(event) {
            
            // prendi tutti i file selezionati dall'utente
            const files = event.target.files;
            
            
            // Trova il contenitore genitore di QUESTO specifico input
            const parentGroup = event.target.closest('.file-upload-group');
            
            // Trova il tag <p> dell'errore all'interno di questo genitore
            const errorElement = parentGroup.querySelector('.error-msg');
            
            // Controllo singolarmente che ogni file caricato non superi la massima dimensione  per un singolo file
            let hasOversizedFile = false;
            // Controlla ogni singolo file caricato
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > maxSize) {
                    hasOversizedFile = true;
                    break; // Se ne trovo anche solo uno troppo grande, fermo il ciclo
                }
            }


            if (hasOversizedFile) {
                // Il file è troppo grande: rimuovo la classe hidden (mostro l'errore)
                errorElement.classList.remove('hidden');
                
                // Resetto l'input così non viene inviato al server
                event.target.value = ''; 
                
            } else {
                // Il file va bene (o l'utente ha annullato): aggiungo hidden (nascondo l'errore)
                errorElement.classList.add('hidden');
                
            }
        });
    });
});