<?php
if (!defined('ABSPATH')) exit;

function nr_render_nota_detalle($nota) {
    ob_start();
    
    $badge_color = '#6c757d';
    if ($nota->prioridad === 'Alta') $badge_color = '#e53935';
    elseif ($nota->prioridad === 'Media') $badge_color = '#fbc02d';
    elseif ($nota->prioridad === 'Baja') $badge_color = '#43a047';
    
    echo '<div class="notas-rapidas-detalle" style="max-width:600px;margin:2rem auto;">';
    echo '<h2 class="wp-heading-inline" style="margin-top:0;">📄 Detalle de la Nota</h2>';
    echo '<table class="form-table" style="margin-top:1.5rem;">';
    echo '<tr><th scope="row">Título</th><td>' . esc_html($nota->titulo) . '</td></tr>';
    echo '<tr><th scope="row">Contenido</th><td>' . nl2br(esc_html($nota->contenido)) . '</td></tr>';
    echo '<tr><th scope="row">Prioridad</th><td><span style="background:' . esc_attr($badge_color) . ';color:#fff;border-radius:12px;padding:0.25em 0.75em;font-size:0.9em;">' . esc_html($nota->prioridad) . '</span></td></tr>';
    echo '<tr><th scope="row">Fecha</th><td>' . esc_html($nota->fecha) . '</td></tr>';
    echo '</table>';
    // Mueve los botones debajo de la tabla
    echo '<div style="margin-top:2rem;">';
    echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="button button-primary" style="margin-right:8px;">✏️ Editar</a>';
    echo '<a href="?notas_rapidas_listar" class="button button-secondary">🔙 Volver</a>';
    echo '</div>';
    echo '</div>';
    
    return ob_get_clean();
}
