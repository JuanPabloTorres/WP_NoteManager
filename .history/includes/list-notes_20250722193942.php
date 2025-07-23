<?php

function nt_render_list_notes($notas) {
    ob_start();
    
    if (empty($notas)) {
        echo "<p>No hay notas disponibles.</p>";
        
        return ob_get_clean();
    }
    
    echo '<ul class="list-unstyled">';
    
    foreach ($notas as $nota) {
        $color = [
            'Alta' => '#e53935',
            'Media' => '#fbc02d',
            'Baja' => '#43a047'
        ];
        $badge = $color[$nota->prioridad] ?? '#6c757d';
        
        echo '<li class="mb-3 p-3 border rounded shadow-sm" style="background: #f9f9f9;">';
        echo '<h3 class="h5">' . esc_html($nota->titulo) . '</h3>';
        echo '<p>' . nl2br(esc_html($nota->contenido)) . '</p>';
        echo '<span class="badge" style="background-color: ' . esc_attr($badge) . '; color: #fff;">' . esc_html($nota->prioridad) . '</span>';
        echo '<div class="mt-2">';
        echo '<a href="?ver_nota=' . esc_attr($nota->id) . '" class="btn btn-secondary btn-sm">🔍 Ver</a> ';
        echo '<a href="?editar_nota=' . esc_attr($nota->id) . '" class="btn btn-primary btn-sm">✏️ Editar</a> ';
        echo '<a href="?eliminar_nota=' . esc_attr($nota->id) . '" class="btn btn-danger btn-sm">🗑️ Eliminar</a>';
        echo '</div>';
        echo '</li>';
    }
    
    echo '</ul>';
    
    return ob_get_clean();
}