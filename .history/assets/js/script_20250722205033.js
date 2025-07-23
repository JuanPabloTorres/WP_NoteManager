jQuery(document).ready(function($) {
    let noteId = null;
    let triggerButton = null;

    // Mostrar el modal con animación
    function showModal(title) {
        const modal = $('#nr-modal-confirm');
        $('#nr-note-title').text(title); // ✅ actualiza el título dinámico
        modal.show().addClass('show');
        $('body').addClass('modal-open').css('overflow', 'hidden');

        // Enfocar botón de cerrar
        modal.find('#nr-modal-close').focus();

        // Accesibilidad: trampa de foco
        trapFocus(modal);
    }

    // Ocultar el modal suavemente
    function hideModal() {
        const modal = $('#nr-modal-confirm');
        modal.removeClass('show');
        $('body').removeClass('modal-open').css('overflow', '');

        setTimeout(() => {
            modal.hide();
        }, 300);

        // Devuelve el foco al botón que disparó
        if (triggerButton) triggerButton.focus();
    }

    // Trampa de foco para accesibilidad
    function trapFocus(modal) {
        const focusable = modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        const first = focusable.first();
        const last = focusable.last();

        modal.on('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey && document.activeElement === first[0]) {
                    last.focus();
                    e.preventDefault();
                } else if (!e.shiftKey && document.activeElement === last[0]) {
                    first.focus();
                    e.preventDefault();
                }
            }
        });
    }

    // Clic en botón de eliminar
    $('.button-delete-nota').on('click', function(e) {
        e.preventDefault();
        noteId = $(this).data('id');
        const noteTitle = $(this).data('title') || '(sin título)';
        triggerButton = $(this); // guarda referencia para devolver foco

        showModal(noteTitle);
    });

    // Botón cancelar
    $('#nr-cancel-delete').on('click', function(e) {
        e.preventDefault();
        hideModal();
    });

    // Botón cerrar
    $('#nr-modal-close').on('click', function(e) {
        e.preventDefault();
        hideModal();
    });

    // Confirmar eliminación
    $('#nr-confirm-delete').on('click', function(e) {
        e.preventDefault();
        if (noteId) {
            $(this).prop('disabled', true).html('<span>Eliminando…</span>');
            window.location.href = '?eliminar_nota=' + noteId;
        }
    });

    // Clic fuera del modal (fondo)
    $('.nr-modal-backdrop').on('click', function(e) {
        if (e.target === this) {
            hideModal();
        }
    });

    // Cerrar con tecla Escape
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#nr-modal-confirm').hasClass('show')) {
            hideModal();
        }
    });

    // Prevenir scroll en móviles cuando modal está abierto
    $('body').on('touchmove', function(e) {
        if ($('body').hasClass('modal-open')) {
            e.preventDefault();
        }
    });
});
