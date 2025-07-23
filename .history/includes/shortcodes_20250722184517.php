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
    
    echo "<h2>📋 Lista de notas</h2><ul>";
    
    foreach ($notas as $nota) {
        echo "<li><strong>" . esc_html($nota->titulo) . "</strong><br>";
        echo "📌 Prioridad: " . esc_html($nota->prioridad) . "<br>";
        echo "🕒 " . esc_html($nota->fecha) . "<br>";
        echo "<a href='?ver_nota=" . esc_attr($nota->id) . "'>🔍 Ver</a> | ";
        echo "<a href='?editar_nota=" . esc_attr($nota->id) . "'>✏️ Editar</a> | ";
        echo "<a href='?eliminar_nota=" . esc_attr($nota->id) . "' onclick=\"return confirm('¿Estás seguro de eliminar esta nota?');\">❌ Eliminar</a>";
        echo "</li><hr>";
    }
    echo "</ul>";
    
    return ob_get_clean();
}

add_shortcode('notas_rapidas_listar', 'nr_shortcode_listar_notas');
