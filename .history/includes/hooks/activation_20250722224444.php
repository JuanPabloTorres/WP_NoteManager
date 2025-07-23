<?php
if (!defined('ABSPATH')) exit;

// Hook al activar el plugin
function nr_crear_categorias_predeterminadas() {
    // Asegúrate de que la taxonomía esté registrada
    require_once plugin_dir_path(__FILE__) . '/../taxonomies/categoria-nota.php';
    
    $categorias = ['Urgente', 'Importante', 'Pendiente', 'Ideas', 'Recordatorio'];
    
    foreach ($categorias as $nombre) {
        
        if (!term_exists($nombre, 'categoria_nota')) {
            
            wp_insert_term($nombre, 'categoria_nota');
        }
    }
}
