<?php
if (!defined('ABSPATH')) exit;

// Incluir archivos funcionales
require_once plugin_dir_path(__FILE__) . 'form-crear.php';
require_once plugin_dir_path(__FILE__) . 'form-editar.php';
require_once plugin_dir_path(__FILE__) . 'template-nota.php';
require_once plugin_dir_path(__FILE__) . 'list-notes.php';

function nr_shortcode_listar_notas() {
    global $wpdb;
    $tabla = $wpdb->prefix . 'np_notas';
    ob_start();
    
    // 👉 Mostrar formulario para nueva nota
    if (isset($_GET['nueva_nota'])) {
        return nr_render_form_nueva_nota();
    }
    
    // 👉 Mostrar nota individual
    if (isset($_GET['ver_nota'])) {
        $id = intval($_GET['ver_nota']);
        $nota = $wpdb->get_row("SELECT * FROM $tabla WHERE id = $id");
        if ($nota) {
            return nr_render_nota_detalle($nota);
        } else {
            echo "<p>❌ Nota no encontrada.</p>";
            return ob_get_clean();
        }
    }
    
    // 👉 Eliminar nota
    if (isset($_GET['eliminar_nota'])) {
        $id = intval($_GET['eliminar_nota']);
        $wpdb->delete($tabla, ['id' => $id]);
        echo "<div class='notice notice-success is-dismissible' style='margin:1em 0;padding:1em;border-left:4px solid #46b450;background:#f6fff7;color:#222;font-size:1.1em;'>
    🗑️ Nota eliminada correctamente.
    <button type='button' class='notice-dismiss' onclick='this.parentElement.style.display=\"none\";' aria-label='Cerrar' value='Cerrar'></button>
</div>";
    }
    
    // 👉 Editar nota
    if (isset($_GET['editar_nota'])) {
        $id = intval($_GET['editar_nota']);
        return nr_render_form_editar_nota($id);
    }
    
    // 👉 Mostrar botón y listado de todas las notas
    echo "<p><a href='?nueva_nota=1' class='button button-primary'>➕ Agregar Nota</a></p>";
    
    echo '<h2 class="wp-heading-inline">📋 Lista de notas</h2>';
    
    $notas = $wpdb->get_results("SELECT * FROM $tabla ORDER BY fecha DESC");
    
    
    
    
    echo nr_render_list_notes($notas);
    
    
    
    return ob_get_clean();
}

add_shortcode('notas_rapidas_listar', 'nr_shortcode_listar_notas');
