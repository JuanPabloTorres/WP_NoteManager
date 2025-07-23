<?php
if (!defined('ABSPATH')) exit;

// Shortcode para listar todas las notas
function nr_shortcode_listar_notas() {
    global $wpdb;
    
    $tabla = $wpdb->prefix . 'np_notas';
    
    ob_start();
    
    // Mostrar una nota específica
    if (isset($_GET['ver_nota'])) {
        
        $id = intval($_GET['ver_nota']);
        
        $nota = $wpdb->get_row("SELECT * FROM $tabla WHERE id = $id");
        
        if ($nota) {
            echo "<h2>📄 Detalle de la Nota</h2>";
            
            echo "<p><strong>Título:</strong> " . esc_html($nota->titulo) . "</p>";
            
            echo "<p><strong>Contenido:</strong> " . nl2br(esc_html($nota->contenido)) . "</p>";
            
            echo "<p><strong>Prioridad:</strong> " . esc_html($nota->prioridad) . "</p>";
            
            echo "<p><a href='?editar_nota={$id}'>✏️ Editar</a> | <a href='?notas_rapidas_listar'>🔙 Volver</a></p>";
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
