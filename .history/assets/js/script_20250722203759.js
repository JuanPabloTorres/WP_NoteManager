jQuery(document).ready(function($) {
    let noteId = null;

    // Show modal with smooth animation
    function showModal() {
        const modal = $('#nr-modal-confirm');
        modal.show().addClass('show');
        $('body').addClass('modal-open').css('overflow', 'hidden');
        
        // Focus management for accessibility
        modal.find('#nr-modal-close').focus();
        
        // Trap focus within modal
        trapFocus(modal);
    }

    // Hide modal with smooth animation
    function hideModal() {
        const modal = $('#nr-modal-confirm');
        modal.removeClass('show');
        $('body').removeClass('modal-open').css('overflow', '');
        
        setTimeout(() => {
            modal.hide();
        }, 300);
        
        // Return focus to trigger element
        $('.button-delete-nota[data-id="' + noteId + '"]').focus();
    }

    // Trap focus within modal for accessibility
    function trapFocus(modal) {
        const focusableElements = modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        const firstElement = focusableElements.first();
        const lastElement = focusableElements.last();

        modal.on('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement[0]) {
                        lastElement.focus();
                        e.preventDefault();
                    }
                } else {
                    if (document.activeElement === lastElement[0]) {
                        firstElement.focus();
                        e.preventDefault();
                    }
                }
            }
        });
    }

    // Handle delete button click
    $('.button-delete-nota').click(function(e) {
        e.preventDefault();
        noteId = $(this).data('id');
        showModal();
    });

    // Handle cancel button
    $('#nr-cancel-delete').click(function(e) {
        e.preventDefault();
        hideModal();
    });

    // Handle close button
    $('#nr-modal-close').click(function(e) {
        e.preventDefault();
        hideModal();
    });

    // Handle confirm delete
    $('#nr-confirm-delete').click(function(e) {
        e.preventDefault();
        if (noteId) {
            // Add loading state
            $(this).prop('disabled', true).html('<span>Eliminando...</span>');
            window.location.href = '?eliminar_nota=' + noteId;
        }
    });

    // Handle backdrop click
    $('.nr-modal-backdrop').click(function(e) {
        if (e.target === this) {
            hideModal();
        }
    });

    // Handle escape key
    $(document).keydown(function(e) {
        if (e.key === 'Escape' && $('#nr-modal-confirm').hasClass('show')) {
            hideModal();
        }
    });

    // Prevent body scroll when modal is open
    $('body').on('touchmove', function(e) {
        if ($('body').hasClass('modal-open')) {
            e.preventDefault();
        }
    });
});
