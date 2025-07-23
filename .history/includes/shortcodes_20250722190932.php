<?php
if (!defined('ABSPATH')) exit;

// Shortcode para listar todas las notas
function nr_shortcode_listar_notas() {
    
    if (isset($_GET['nueva_nota'])) {
        return nr_render_form_nueva_nota();
    }
    
    global $wpdb;
    
    $tabla = $wpdb->prefix . 'np_notas';
    
    ob_start();
    
    echo "<p><a href='?nueva_nota=1' class='button button-primary'>➕ Agregar Nota</a></p>";
    
    
    // Mostrar una nota específica
    if (isset($_GET['ver_nota'])) {
        
        $id = intval($_GET['ver_nota']);
        
        $nota = $wpdb->get_row("SELECT * FROM $tabla WHERE id = $id");
        
        if ($nota) {
            echo '<div class="notas-rapidas-detalle" style="max-width:600px;margin:2rem auto;border:1px solid #eee;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.03);padding:2rem;">';
            echo '<h2 class="wp-heading-inline" style="margin-top:0;">📄 Detalle de la Nota</h2>';
            echo '<p><strong>Título:</strong> ' . esc_html($nota->titulo) . '</p>';
            echo '<p><strong>Contenido:</strong> ' . nl2br(esc_html($nota->contenido)) . '</p>';
            // Prioridad con badge de color acorde a Astra
            $badge_color = '#6c757d';
            if ($nota->prioridad === 'Alta') $badge_color = '#e53935';
            elseif ($nota->prioridad === 'Media') $badge_color = '#fbc02d';
            elseif ($nota->prioridad === 'Baja') $badge_color = '#43a047';
            echo '<p><strong>Prioridad:</strong> <span style="background:' . esc_attr($badge_color) . ';color:#fff;border-radius:12px;padding:0.25em 0.75em;font-size:0.9em;">' . esc_html($nota->prioridad) . '</span></p>';
            echo '<div style="margin-top:1.5rem;">';
            echo '<a href="?editar_nota=' . esc_attr($id) . '" class="button button-primary" style="margin-right:8px;">✏️ Editar</a>';
            echo '<a href="?notas_rapidas_listar" class="button button-secondary">🔙 Volver</a>';
            echo '</div>';
            echo '</div>';
        } else {
            echo "<p>❌ Nota no encontrada.</p>";
        }
        
        return ob_get_clean();
    }
    
    // Eliminar nota
    if (isset($_GET['eliminar_nota'])) {
        
        $id = intval($_GET['eliminar_nota']);
        
        $wpdb->delete($tabla, ['id' => $id]);
        
        echo "<div class='notice'>🗑️ Nota eliminada correctamente.</div>";
    }
    
    // Mostrar formulario de edición
    if (isset($_GET['editar_nota'])) {
        $id = intval($_GET['editar_nota']);
        $nota = $wpdb->get_row("SELECT * FROM $tabla WHERE id = $id");
        
        if (!$nota) {
            echo "<p>❌ Nota no encontrada.</p>";
            return ob_get_clean();
        }
        
        // Si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['np_editar_nota'])) {
            $titulo    = sanitize_text_field($_POST['titulo']);
            
            $contenido = sanitize_textarea_field($_POST['contenido']);
            
            $prioridad = sanitize_text_field($_POST['prioridad']);
            
            $wpdb->update(
                $tabla,
                [
                    'titulo'    => $titulo,
                    'contenido' => $contenido,
                    'prioridad' => $prioridad
                ],
                ['id' => $id]
            );
            
            echo "<div class='notice notice-success'><p>✅ Nota actualizada correctamente.</p></div>";
            
            echo "<p><a href='?ver_nota={$id}'>🔍 Ver nota actualizada</a></p>";
            
            return ob_get_clean();
        }
        
        // Mostrar formulario con datos
        ?>
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
    
    
    // Mostrar lista si no hay ninguna acción
    $notas = $wpdb->get_results("SELECT * FROM $tabla ORDER BY fecha DESC");
    
    echo '<h2 class="wp-heading-inline mb-4">📋 Lista de notas</h2>';
    
    echo '<ul class="notas-rapidas-list" style="list-style:none; padding:0;">';
    
    foreach ($notas as $nota) {
        // Badge de prioridad con clases Astra (usa colores del tema)
        $badge_color = '#6c757d'; // default
        if ($nota->prioridad === 'Alta') $badge_color = '#e53935';
        elseif ($nota->prioridad === 'Media') $badge_color = '#fbc02d';
        elseif ($nota->prioridad === 'Baja') $badge_color = '#43a047';
        
        echo '<li class="notas-rapidas-item" style="margin-bottom:2rem; border:1px solid #eee; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.03); padding:1.5rem;">';
        echo '<div style="display:flex; align-items:center; justify-content:space-between;">';
        echo '<h3 style="margin:0; font-size:1.25rem;">' . esc_html($nota->titulo) . '</h3>';
        echo '<span style="background:' . esc_attr($badge_color) . '; color:#fff; border-radius:12px; padding:0.25em 0.75em; font-size:0.9em;">' . esc_html($nota->prioridad) . '</span>';
        echo '</div>';
        echo '<p style="margin:0.5em 0 1em 0; color:#555;">' . esc_html($nota->contenido) . '</p>';
        echo '<p style="font-size:0.9em; color:#888; margin-bottom:1em;">🕒 ' . esc_html($nota->fecha) . '</p>';
        echo '<div>';
        echo '<a href="?ver_nota=' . esc_attr($nota->id) . '" class="button button-secondary" style="margin-right:8px;">🔍 Ver</a>';
        echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="button button-primary" style="margin-right:8px;">✏️ Editar</a>';
        echo '<a href="?eliminar_nota=' . esc_attr($nota->id) . '" class="button button-link-delete" style="color:#e53935;" onclick="return confirm(\'¿Estás seguro de eliminar esta nota?\');">❌ Eliminar</a>';
        echo '</div>';
        echo '</li>';
    }
    echo '</ul>';
    
    return ob_get_clean();
}

add_shortcode('notas_rapidas_listar', 'nr_shortcode_listar_notas');