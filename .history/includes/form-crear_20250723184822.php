<?php
if (!defined('ABSPATH')) exit;

function nr_render_form_nueva_nota() {
    global $wpdb;
    
    $tabla = $wpdb->prefix . 'np_notas';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['np_nueva_nota'])) {
        $titulo = sanitize_text_field($_POST['titulo']);
        $contenido = sanitize_textarea_field($_POST['contenido']);
        $prioridad = sanitize_text_field($_POST['prioridad']);
        $categoria_id = isset($_POST['categoria_nota']) ? intval($_POST['categoria_nota']) : 0;
        
        $wpdb->insert($tabla, [
            'titulo' => $titulo,
            'contenido' => $contenido,
            'prioridad' => $prioridad,
            'categoria_id' => $categoria_id, // Agregar campo categoria_id a la tabla
        ]);
        
        $id = $wpdb->insert_id;
        
        return "<div class='notice-success'><p>✅ Nota creada con ID: <strong>$id</strong></p><p><a href='?ver_nota=$id'>🔍 Ver Nota</a> | <a href='?notas_rapidas_listar'>🔙 Volver a la lista</a></p></div>";
    }
    
    ob_start(); ?>
    
    <h2>📝 Crear nueva nota</h2>
    
    <form method="post">
    
    <input type="hidden" name="np_nueva_nota" value="1">
    
    <table class="form-table">
    <tr>
    <th><label for="titulo">Título</label></th>
    <td><input type="text" name="titulo" id="titulo" required></td>
    </tr>
    
    <tr>
    <th><label for="contenido">Contenido</label></th>
    <td><textarea name="contenido" id="contenido" rows="5"></textarea></td>
    </tr>
    
    <tr>
    <th><label for="prioridad">Prioridad</label></th>
    <td>
    <select name="prioridad">
    <option value="Alta">Alta</option>
    <option value="Media" selected>Media</option>
    <option value="Baja">Baja</option>
    </select>
    </td>
    </tr>
    
    <tr>
    <th scope="row"><label for="categoria_nota">Categoría</label></th>
    <td>
    <select name="categoria_nota" id="categoria_nota">
    <option value="">— Selecciona una categoría —</option>
    
    <?php
    // Verificar si la taxonomía existe
    if (!taxonomy_exists('categoria_nota')) {
        // Usar categorías hardcodeadas como fallback
        $categorias_fallback = [
            1 => 'Urgente',
            2 => 'Importante', 
            3 => 'Pendiente',
            4 => 'Ideas',
            5 => 'Recordatorio'
        ];
        
        foreach ($categorias_fallback as $id => $nombre) {
            echo '<option value="' . esc_attr($id) . '">' . esc_html($nombre) . '</option>';
        }
    } else {
        $categorias = get_terms([
            'taxonomy' => 'categoria_nota',
            'hide_empty' => false
        ]);
        
        if (is_wp_error($categorias) || empty($categorias)) {
            echo '<option value="">No hay categorías disponibles</option>';
        } else {
            foreach ($categorias as $categoria) {
                echo '<option value="' . esc_attr($categoria->term_id) . '">' . esc_html($categoria->name) . '</option>';
            }
        }
    }
    ?>
    </select>
    </td>
    </tr>
    
    </table>
    
    <p><input type="submit" value="Guardar Nota" class="button button-primary"></p>
    
    </form>
    
    <?php
    
    return ob_get_clean();
}