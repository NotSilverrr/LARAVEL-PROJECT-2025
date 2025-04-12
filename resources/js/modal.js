// add listenr to all modal buttons and open modal
document.querySelectorAll('.modal-button').forEach(button => {
    button.addEventListener('click', function() {
        const modalId = this.getAttribute('data-modal-name');
        const columnId = this.getAttribute('data-column-id');
        const modal = document.getElementById(modalId);
        if (modal) {
            // ✅ On injecte l'id de la colonne dans l'input hidden
            const hiddenInput = modal.querySelector('#column_id');
            if (hiddenInput) {
                hiddenInput.value = columnId;
            }

            // 👇 on affiche la modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    });
});
// add listener to all modal close buttons and close modal
document.querySelectorAll('.modal-close').forEach(button => {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        if (modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    });
});