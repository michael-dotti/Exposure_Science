//TODO: DA COMPLETARE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
// profile_image == imageUpload 
// image_preview = imagePreview

// prendo gli elementi su cui devo andare a lavorare
const imageUpload = document.getElementById('profile_image');
const imagePreview = document.getElementById('image_preview');

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
}