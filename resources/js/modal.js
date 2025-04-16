// Ouvrir une modal avec des paramètres dynamiques
document.querySelectorAll('.modal-button').forEach(button => {
    button.addEventListener('click', function() {
        console.log('click');
        const modalId = this.getAttribute('data-modal-name');
        const modal = document.getElementById(modalId);
        console.log(modal);

        if (modal) {
            // Parcourir tous les attributs data-* pour les injecter dans les inputs de la modal
            [...this.attributes].forEach(attr => {
                console.log(attr);
                if (attr.name.startsWith('data-') && attr.name !== 'data-modal-name') {
                    const field = attr.name.replace('data-', '');
                    console.log(field);
                    const input = modal.querySelector(`[name="${field}"]`);
                    console.log(input);
                    if (input) {
                        input.value = attr.value;
                    }
                }
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });
});

// Fermer la modal (bouton de fermeture)
document.querySelectorAll('.modal-close').forEach(button => {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    });
});

// Fermer la modal en cliquant en dehors du contenu
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    });
});

// Fermer avec la touche "Escape"
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        });
    }
});
