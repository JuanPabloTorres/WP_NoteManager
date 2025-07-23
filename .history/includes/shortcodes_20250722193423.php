<?php
if (!defined('ABSPATH')) exit;

// Incluir archivos funcionales
require_once plugin_dir_path(__FILE__) . 'form-crear.php';
require_once plugin_dir_path(__FILE__) . 'form-editar.php';
require_once plugin_dir_path(__FILE__) . 'template-nota.php';

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
        echo "<div class='notice'>🗑️ Nota eliminada correctamente.</div>";
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
    
    echo '<ul style="list-style:none; padding:0;">';
    
    foreach ($notas as $nota) {
        $color = [
            'Alta' => '#e53935',
            'Media' => '#fbc02d',
            'Baja' => '#43a047'
        ];
        $badge = $color[$nota->prioridad] ?? '#6c757d';
        
        echo '<li style="margin-bottom:2rem; border:1px solid #eee; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.03); padding:1.5rem;">';
        echo '<div style="display:flex; align-items:center; justify-content:space-between;">';
        echo '<h3 style="margin:0;">' . esc_html($nota->titulo) . '</h3>';
        echo '<span style="background:' . esc_attr($badge) . '; color:#fff; border-radius:12px; padding:0.25em 0.75em;">' . esc_html($nota->prioridad) . '</span>';
        echo '</div>';
        echo '<p style="margin:0.5em 0 1em; color:#555;">' . esc_html($nota->contenido) . '</p>';
        echo '<p style="font-size:0.9em; color:#888;">🕒 ' . esc_html($nota->fecha) . '</p>';
        echo '<div>';
        
        echo '<div style="margin-top:1rem; display:flex; gap:0.5rem; flex-wrap:wrap;">';
        echo '<a href="?ver_nota=' . esc_attr($nota->id) . '" class="button button-secondary">🔍 Ver</a>';
        echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="button button-primary">✏️ Editar</a>';
        echo '<a href="?eliminar_nota=' . esc_attr($nota->id) . '" onclick="return confirm(\'¿Estás seguro de eliminar esta nota?\');" class="button" style="color:#e53935;">❌ Eliminar</a>';
        echo '</div>';
        
        echo '</li>';
    }
    
    echo '</ul>';
    
    return ob_get_clean();
}

add_shortcode('notas_rapidas_listar', 'nr_shortcode_listar_notas');
