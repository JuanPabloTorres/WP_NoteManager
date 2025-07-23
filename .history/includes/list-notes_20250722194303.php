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