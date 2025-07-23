<?php
if (!defined('ABSPATH')) exit;

function nr_render_form_editar_nota($id) {
    global $wpdb;
    $tabla = $wpdb->prefix . 'np_notas';

    $nota = $wpdb->get_row($wpdb->prepare("SELECT * FROM $tabla WHERE id = %d", $id));
    if (!$nota) {
        return "<p>❌ Nota no encontrada.</p>";
    }

    // Procesar edición
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['np_editar_nota'])) {
        $titulo    = sanitize_text_field($_POST['titulo']);
        $contenido = sanitize_textarea_field($_POST['contenido']);
        $prioridad = sanitize_text_field($_POST['prioridad']);

        $wpdb->update($tabla, [
            'titulo'    => $titulo,
            'contenido' => $contenido,
            'prioridad' => $prioridad
        ], ['id' => $id]);

        return "<div class='notice notice-success'><p>✅ Nota actualizada.</p></div><p><a href='?ver_nota=$id'>🔍 Ver nota</a></p>";
    }

    // Mostrar formulario con datos
    ob_start(); ?>
    <h2>✏️ Editar Nota</h2>
    <form method="post">
        <input type="hidden" name="np_editar_nota" value="1">
        <table class="form-table">
            <tr>
                <th><label for="titulo">Título</label></th>
                <td><input type="text" name="titulo" value="<?php echo esc_attr($nota->titulo); ?>" required></td>
            </tr>
            <tr>
                <th><label for="contenido">Contenido</label></th>
                <td><textarea name="contenido" rows="5"><?php echo esc_textarea($nota->contenido); ?></textarea></td>
            </tr>
            <tr>
                <th><label for="prioridad">Prioridad</label></th>
                <td>
                    <select name="prioridad">
                        <option value="Alta" <?php selected($nota->prioridad, 'Alta'); ?>>Alta</option>
                        <option value="Media" <?php selected($nota->prioridad, 'Media'); ?>>Media</option>
                        <option value="Baja" <?php selected($nota->prioridad, 'Baja'); ?>>Baja</option>
                    </select>
                </td>
            </tr>
        </table>
        <p><input type="submit" value="Actualizar Nota" class="button button-primary"></p>
    </form>
    <?php
    return ob_get_clean();
}
