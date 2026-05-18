
document.addEventListener('DOMContentLoaded', () => { // eseguie il codice dopo che tutti i componenti della pagina sono stati caricati
    // prendo gli elementi su cui devo andare a lavorare
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('image_preview');
    const previewContainer = document.getElementById('previewContainer');
    const deleteButton = document.getElementById('deleteButton');
    const deleteButtonWrapper = document.getElementById('deleteButtonWrapper');
    const removePhotoInput = document.getElementById('remove_photo');


    // Controllo iniziale: se c'è già un'immagine valida precaricata mostra i componenti
    if (imagePreview) {
        const currentSrc = imagePreview.getAttribute('src');
        // Si assicura che il src esista, non sia vuoto e non sia un link del browser alla pagina stessa
        if (currentSrc && currentSrc.trim() !== '' && currentSrc !== window.location.href) {
            if (previewContainer) previewContainer.classList.remove('hidden');
            if (deleteButtonWrapper) deleteButtonWrapper.classList.remove('hidden');
        }
    }

    // verifico se l'oggetto imageUpload (l'input dell'immagine) viene usato
    imageUpload.addEventListener('change', handleFileSelect);

    function handleFileSelect(event) {
        // prendo il file (l'immagine) caricata 
        const file = event.target.files[0];

        // se nessun file è stato selezionato, resetto la preview
        if(!file) {
            resetPreview();
            return;
        }

        // verifico, tramite una funzione creata da noi, se il file è del tipo corretto
        if (!isValidImageFile(file)) {
            alert('Please select a valid image file (JPG, PNG, GIF, etc.)');
            resetPreview();
            return;
        }

        // se l'utente ha selezionare un file valido, azzero il flag di rimozione
        removePhotoInput.value = '0';

        // metodo creato per aggiornare la preview dell'immagine
        displayPreview(file);
    }

    // resetto il valore di src per l'immagine e il valore di input
    function resetPreview() {
        imagePreview.src = '';
        imageUpload.value = '';

        // Nascondo il cerchio della preview e il pulsante elimina
        previewContainer.classList.add('hidden');
        deleteButtonWrapper.classList.add('hidden');
    }

    function isValidImageFile(file){
        // verifico che l'immagine non sia troppo pesante
        const MAX_SIZE_MB = 5; // 5MB
        const maxSizeBytes = MAX_SIZE_MB * 1024 * 1024;
        if(file.size > maxSizeBytes){
            alert(`Il file "${file.name}" e' troppo grande. Dimensioni massime: ${MAX_SIZE_MB}MB.`);
            return false;
        } 

        // verifica se il MIME type del file inizia con 'image/'
        const isImage = file.type.startsWith('image/');

        // verifoco anche l'estensione del file (opzionale)
        const fileExtension = file.name.split('.').pop().toLowerCase();
        const validExtensions = ['jpg','jpeg','png','gif','bmp','webp'];
        const hasValidExtension = validExtensions.includes(fileExtension);

        // ritorna true solo se sia il MIME type che l'estensione sono validi
        return isImage && hasValidExtension;
    }

    // aggiorna valore del display in base a quello che l'utente ha inserito
    function displayPreview(file){
        // creo un'istanza di FileReader 
        const reader = new FileReader();

        // Definisci cosa succede quando il file è letto
        reader.onload = function(e){
            // setta il src dell'immagine come l'url dell'immagine inserita dall'utente
            imagePreview.src = e.target.result;

            // Mostro la preview dell'immagine e il pulsante elimina
            previewContainer.classList.remove('hidden');
            deleteButtonWrapper.classList.remove('hidden');
        };

        // Nel raro caso in cui FileReader fallisca (es: immagine troppo grande), gestisco l'errore
        reader.onerror = function (){
            alert(`Errore nella lettura del file: ${file.name}. Riprovare.`);
            resetPreview();
        }

        // leggi il file come un data URL (base64-encoded string)
        reader.readAsDataURL(file);
    }

    // event listener per il tasto "elimina"
    deleteButton.addEventListener('click', () =>{
        // 1) ripristina l'immagine di default nella preview
        resetPreview();

        // 2) segnala al controller che vogliamo rimuovere l'immagine profilo
        removePhotoInput.value = '1'; 

    });


});
