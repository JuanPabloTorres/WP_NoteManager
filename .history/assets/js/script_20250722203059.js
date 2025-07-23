jQuery(document).ready(function($) {
    let noteId = null;

    $('.button-delete-nota').click(function(e) {
        e.preventDefault();
        noteId = $(this).data('id');
        $('#nr-modal-confirm').fadeIn();
    });

    $('#nr-cancel-delete').click(function(e) {
        e.preventDefault();
        $('#nr-modal-confirm').fadeOut();
    });

    $('#nr-confirm-delete').click(function(e) {
        e.preventDefault();
        if (noteId) {
            window.location.href = '?eliminar_nota=' + noteId;
        }
    });
});
