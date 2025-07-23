<?php
if (!defined('ABSPATH')) exit;

function nr_render_nota_detalle($nota) {
    ob_start();
    
    // Colores por prioridad
    $badge_color = '#6c757d';
    if ($nota->prioridad === 'Alta') $badge_color = '#e53935';
    elseif ($nota->prioridad === 'Media') $badge_color = '#fbc02d';
    elseif ($nota->prioridad === 'Baja') $badge_color = '#43a047';
    
    echo '<div class="notas-rapidas-detalle ast-container" style="max-width: 700px; margin: 2rem auto;">';
    
    echo '<h2 class="wp-heading-inline" style="margin-top: 0;">📄 Detalle de la Nota</h2>';
    
    echo '<table class="form-table" style="margin-top: 1.5rem;">';
    echo '<tr><th scope="row">Título</th><td>' . esc_html($nota->titulo) . '</td></tr>';
    echo '<tr><th scope="row">Contenido</th><td>' . nl2br(esc_html($nota->contenido)) . '</td></tr>';
    echo '<tr><th scope="row">Prioridad</th><td><span style="background:' . esc_attr($badge_color) . ';color:#fff;border-radius:12px;padding:0.25em 0.75em;font-size:0.9em;">' . esc_html($nota->prioridad) . '</span></td></tr>';
    echo '<tr><th scope="row">Fecha</th><td>' . esc_html($nota->fecha) . '</td></tr>';
    echo '</table>';
    
    // Bloque de botones alineados horizontalmente
    echo '<div class="wp-block-buttons" style="margin-top: 2rem; display: flex; gap: 12px; flex-wrap: wrap;">';
    
    echo '<div class="wp-block-button is-style-outline">';
    echo '<a class="wp-block-button__link" href="?editar_nota=' . esc_attr($nota->id) . '">✏️ Editar</a>';
    echo '</div>';
    
    echo '<div class="wp-block-button is-style-outline">';
    echo '<a class="wp-block-button__link" href="?notas_rapidas_listar">🔙 Volver</a>';
    echo '</div>';
    
    echo '</div>'; // Fin botones
    
    echo '</div>'; // Fin contenedor principal
    
    return ob_get_clean();
}
