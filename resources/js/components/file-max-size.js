document.addEventListener("DOMContentLoaded", function() {
    
    // Seleziona TUTTI gli input che hanno la classe 'check-file-size'
    const fileInputs = document.querySelectorAll('.check-file-size');
    const maxSize = 50 * 1024 * 1024; // 50 MB in byte

    // Cicla su ogni input trovato e applica la regola
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            
            // Trova il contenitore genitore di QUESTO specifico input
            const parentGroup = event.target.closest('.file-upload-group');
            
            // Trova il tag <p> dell'errore all'interno di questo genitore
            const errorElement = parentGroup.querySelector('.error-msg');

            if (file && file.size > maxSize) {
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