// Script per far funzionare il tasto "Seleziona tutti" 
function toggleRecipients(btn) {
        const checkboxes = document.querySelectorAll('.recipient-checkbox');
        const isSelectingAll = btn.dataset.state === 'unselected';
        
        checkboxes.forEach(cb => cb.checked = isSelectingAll);
        
        btn.dataset.state = isSelectingAll ? 'selected' : 'unselected';
        btn.innerText = isSelectingAll ? 'Deseleziona tutti' : 'Seleziona tutti';
    }