<?php
if (!defined('ABSPATH')) exit;

function nr_render_nota_detalle($nota) {
    ob_start();
    
    // Color según prioridad
    $badge_color = '#6c757d';
    if ($nota->prioridad === 'Alta') $badge_color = '#e53935';
    elseif ($nota->prioridad === 'Media') $badge_color = '#fbc02d';
    elseif ($nota->prioridad === 'Baja') $badge_color = '#43a047';
    
    ?>
    <div class="ast-container" style="max-width: 700px; margin: 2rem auto; padding: 2rem; background: #fff; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.05);">
    <h2 class="wp-heading-inline" style="margin-bottom: 1.5rem;">📄 Detalle de la Nota</h2>
    
    <table class="form-table">
    <tr>
    <th scope="row">Título</th>
    <td><?php echo esc_html($nota->titulo); ?></td>
    </tr>
    <tr>
    <th scope="row">Contenido</th>
    <td><?php echo nl2br(esc_html($nota->contenido)); ?></td>
    </tr>
    <tr>
    <th scope="row">Prioridad</th>
    <td>
    <span style="background: <?php echo esc_attr($badge_color); ?>; color: #fff; border-radius: 12px; padding: 0.25em 0.75em; font-size: 0.9em;">
    <?php echo esc_html($nota->prioridad); ?>
    </span>
    </td>
    </tr>
    <tr>
    <th scope="row">Fecha</th>
    <td><?php echo esc_html($nota->fecha); ?></td>
    </tr>
    </table>
    
    <!-- Botones alineados debajo -->
    <div style="margin-top: 2rem; display: flex; gap: 10px; flex-wrap: wrap;">
    <a href="?editar_nota=<?php echo esc_attr($nota->id); ?>" class="button button-primary">
    ✏️ Editar
    </a>
    <a href="?notas_rapidas_listar" class="button button-secondary">
    🔙 Volver
    </a>
    </div>
    </div>
    <?php
    
    return ob_get_clean();
}
