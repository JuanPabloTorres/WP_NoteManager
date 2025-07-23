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
    
    echo '<div class="row row-cols-1 row-cols-md-2 g-4">';
    
    foreach ($notas as $nota) {
        // Badge de prioridad
        $badge_class = 'secondary';
        
        if ($nota->prioridad === 'Alta') $badge_class = 'danger';
        
        elseif ($nota->prioridad === 'Media') $badge_class = 'warning';
        
        elseif ($nota->prioridad === 'Baja') $badge_class = 'success';
        
        echo '<div class="col">';
        
        echo '<div class="card h-100 shadow-sm border-0">';
        
        echo '<div class="card-body">';
        
        echo '<h5 class="card-title">' . esc_html($nota->titulo) . '</h5>';
        
        echo '<span class="badge bg-' . $badge_class . ' mb-2">' . esc_html($nota->prioridad) . '</span>';
        
        echo '<p class="card-text small text-muted mb-1">🕒 ' . esc_html($nota->fecha) . '</p>';
        
        echo '<div class="d-flex gap-2">';
        
        echo '<a href="?ver_nota=' . esc_attr($nota->id) . '" class="btn btn-outline-primary btn-sm">🔍 Ver</a>';
        
        echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="btn btn-outline-warning btn-sm">✏️ Editar</a>';
        
        echo '<a href="?eliminar_nota=' . esc_attr($nota->id) . '" class="btn btn-outline-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar esta nota?\');">❌ Eliminar</a>';
        
        echo '</div>';
        
        echo '</div>';
        
        echo '</div>';
        
        echo '</div>';
    }
    echo '</div>';
    
    return ob_get_clean();
}

add_shortcode('notas_rapidas_listar', 'nr_shortcode_listar_notas');
