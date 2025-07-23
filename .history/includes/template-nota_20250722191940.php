<?php
if (!defined('ABSPATH')) exit;

function nr_render_nota_detalle($nota) {
    ob_start();
    
    $badge_color = '#6c757d';
    if ($nota->prioridad === 'Alta') $badge_color = '#e53935';
    elseif ($nota->prioridad === 'Media') $badge_color = '#fbc02d';
    elseif ($nota->prioridad === 'Baja') $badge_color = '#43a047';
    
    echo '<div class="notas-rapidas-detalle" style="max-width:600px;margin:2rem auto;border:1px solid #eee;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.03);padding:2rem;">';
    echo '<h2 class="wp-heading-inline" style="margin-top:0;">📄 Detalle de la Nota</h2>';
    echo '<p><strong>Título:</strong> ' . esc_html($nota->titulo) . '</p>';
    echo '<p><strong>Contenido:</strong> ' . nl2br(esc_html($nota->contenido)) . '</p>';
    echo '<p><strong>Prioridad:</strong> <span style="background:' . esc_attr($badge_color) . ';color:#fff;border-radius:12px;padding:0.25em 0.75em;font-size:0.9em;">' . esc_html($nota->prioridad) . '</span></p>';
    echo '<div style="margin-top:1.5rem;">';
    echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="button button-primary" style="margin-right:8px;">✏️ Editar</a>';
    echo '<a href="?notas_rapidas_listar" class="button button-secondary">🔙 Volver</a>';
    echo '</div>';
    echo '</div>';
    
    return ob_get_clean();
}
