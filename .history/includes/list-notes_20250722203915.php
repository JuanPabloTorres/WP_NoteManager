<?php

function nr_render_list_notes($notas) {
    ob_start();
    
    if (empty($notas)) {
        echo "<p>No hay notas disponibles.</p>";
        return ob_get_clean();
    }
    
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
        
        echo '<div style="margin-top:1rem; display:flex; gap:0.5rem; flex-wrap:wrap;">';
        echo '<a href="?ver_nota=' . esc_attr($nota->id) . '" class="button button-secondary">🔍 Ver</a>';
        echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="button button-primary">✏️ Editar</a>';
        echo '<a href="#" class="button button-delete-nota" data-id="' . esc_attr($nota->id) . '" style="color:#e53935;">❌ Eliminar</a>';
        echo '</div>';
        
        echo '</li>';
    }
    
    echo '</ul>';
    
    echo '
    <div id="nr-modal-confirm" class="nr-modal" style="display:none;" role="dialog" aria-labelledby="nr-modal-title" aria-describedby="nr-modal-desc" aria-hidden="true">
        <div class="nr-modal-backdrop" aria-hidden="true"></div>
        <div class="nr-modal-wrapper">
            <div class="nr-modal-content">
                <div class="nr-modal-header">
                    <div class="nr-modal-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 9V13M12 17H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <button type="button" class="nr-modal-close" id="nr-modal-close" aria-label="Cerrar modal">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5L5 15M5 5L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="nr-modal-body">
                    <h3 id="nr-modal-title" class="nr-modal-title">Confirmar eliminación</h3>
                    <p id="nr-modal-desc" class="nr-modal-description">¿Estás seguro de que deseas eliminar esta nota? Esta acción no se puede deshacer.</p>
                </div>
                <div class="nr-modal-footer">
                    <button type="button" id="nr-cancel-delete" class="nr-btn nr-btn-secondary">
                        <span>Cancelar</span>
                    </button>
                    <button type="button" id="nr-confirm-delete" class="nr-btn nr-btn-danger">
                        <span>Sí, eliminar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>';
    
    return ob_get_clean();
}

// add_action('wp_enqueue_scripts', function() {
//     wp_enqueue_script(
//         'notas-rapidas-js',
//         plugin_dir_url(__FILE__) . 'assets/notas-rapidas.js',
//         ['jquery'],
//         null,
//         true
//     );
// });