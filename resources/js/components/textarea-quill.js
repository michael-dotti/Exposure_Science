document.addEventListener('DOMContentLoaded', function() {
    // Seleziona tutti i wrapper dei componenti Quill presenti nella pagina, in caso ce ne siano più di uno
    const wrappers = document.querySelectorAll('.quill-wrapper');

    // Per ogni editor di testo, inizializza un'istanza di Quill e gestisci il submit del form associato
    wrappers.forEach(wrapper => { 
        const container = wrapper.querySelector('.quill-container');
        const hiddenInput = wrapper.querySelector('.quill-hidden-input');
        const form = wrapper.closest('form'); // Trova il form in cui è contenuto questo specifico editor

        // Sicurezza: se gli elementi non esistono o Quill non è caricato globalmente, salta
        if (!container || !hiddenInput || !window.Quill) return;

        // Inizializza Quill su questo specifico contenitore
        const quill = new window.Quill(container, {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'clean']
                ]
            },
            placeholder: 'Scrivi qui il tuo testo...'
        });

        // Se l'editor si trova dentro un form, intercettiamo il submit di QUEL form
        if (form) {
            form.addEventListener('submit', function() {
                let htmlCode = quill.root.innerHTML;
                
                // Se l'editor è vuoto, Quill restituisce <p><br></p>, lo puliamo
                if (htmlCode === '<p><br></p>') {
                    htmlCode = '';
                }
                
                // Sincronizza il valore nell'input nascosto di questo specifico editor
                hiddenInput.value = htmlCode;
            });
        }
    });
});