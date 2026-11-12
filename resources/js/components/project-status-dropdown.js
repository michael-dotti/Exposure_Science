document.addEventListener('DOMContentLoaded', function () {
    // Seleziona tutti i wrapper dei dropdown presenti nella pagina
    document.querySelectorAll('.status-dropdown-wrapper').forEach(wrapper => {
        const hiddenInput = wrapper.querySelector('.status-hidden-input');
        const currentLabel = wrapper.querySelector('.status-current-label');
        const optionLinks = wrapper.querySelectorAll('.status-option-btn');

        optionLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); // Impedisce il comportamento di default del tag <a> contenuto dentro al componente dropdown-link

                const value = this.getAttribute('data-value');
                const text = this.textContent.trim();

                // Aggiorna valore dell'input nascosto e testo visibile del bottone
                hiddenInput.value = value;
                currentLabel.textContent = text;
            });
        });
    });
});