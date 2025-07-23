<?php
add_action('admin_enqueue_scripts', function() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
});
?>
<div class="wrap nr-form-wrap" style="max-width:600px;margin:2rem auto;">
    <h1 class="wp-heading-inline">Agregar Nota Rápida</h1>
    <form method="post">
        <table class="form-table">
            <tr>
                <th><label for="titulo">Título</label></th>
                <td><input type="text" name="titulo" id="titulo" required class="regular-text"
                        placeholder="Ej: Recordatorio de reunión"></td>
            </tr>
            <tr>
                <th><label for="contenido">Contenido</label></th>
                <td><textarea name="contenido" id="contenido" rows="5" class="large-text"
                        placeholder="Escribe tu nota aquí..."></textarea></td>
            </tr>
            <tr>
                <th><label for="prioridad">Prioridad</label></th>
                <td>
                    <select name="prioridad" id="prioridad">
                        <option value="Alta">Alta</option>
                        <option value="Media" selected>Media</option>
                        <option value="Baja">Baja</option>
                    </select>
                        </td>
            </tr>
        </table>
        <?php submit_button('Guardar Nota'); ?>
    </form>
</div>