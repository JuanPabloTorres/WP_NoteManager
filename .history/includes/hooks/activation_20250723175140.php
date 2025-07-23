<?php
if (!defined('ABSPATH')) exit;

// Hook al activar el plugin
function nr_crear_categorias_predeterminadas() {
    $categorias = [
        'Urgente' => 'Tareas que requieren atención inmediata',
        'Importante' => 'Notas de prioridad alta pero no urgente',
        'Pendiente' => 'Actividades aún por completar',
        'Ideas' => 'Pensamientos o conceptos futuros',
        'Recordatorio' => 'Notas simples para recordar algo'
    ];
    
    foreach ($categorias as $nombre => $descripcion) {
        if (!term_exists($nombre, 'categoria_nota')) {
            wp_insert_term($nombre, 'categoria_nota', [
                'description' => $descripcion
            ]);
        }
    }
}

function nr_crear_tabla() {
    
    global $wpdb;
    
    $tabla = $wpdb->prefix . 'np_notas';
    
    $charset = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $tabla (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        titulo varchar(255) NOT NULL,
        contenido text NOT NULL,
        prioridad varchar(50) DEFAULT 'Media',
        fecha datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset;";
    
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    
    dbDelta($sql);
}

// Hook de activación del plugin
function nr_plugin_activar() {
    nr_crear_tabla();
    
    nr_crear_categorias_predeterminadas();
    
    if (!get_option('nr_categorias_insertadas')) {
        
        
        update_option('nr_categorias_insertadas', true);
    }
}
register_activation_hook(__FILE__, 'nr_plugin_activar');



