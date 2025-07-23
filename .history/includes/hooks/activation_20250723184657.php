<?php
if (!defined('ABSPATH')) exit;

// Hook al activar el plugin
function nr_crear_categorias_predeterminadas() {
    // Primero asegurarse de que la taxonomía esté registrada
    if (!taxonomy_exists('categoria_nota')) {
        // Registrar la taxonomía temporalmente para la activación
        register_taxonomy('categoria_nota', 'nota_rapida', array(
            'public' => true,
            'hierarchical' => true,
        ));
    }
    
    $categorias = [
        'Urgente' => 'Tareas que requieren atención inmediata',
        'Importante' => 'Notas de prioridad alta pero no urgente',
        'Pendiente' => 'Actividades aún por completar',
        'Ideas' => 'Pensamientos o conceptos futuros',
        'Recordatorio' => 'Notas simples para recordar algo'
    ];
    
    foreach ($categorias as $nombre => $descripcion) {
        if (!term_exists($nombre, 'categoria_nota')) {
            $result = wp_insert_term($nombre, 'categoria_nota', [
                'description' => $descripcion
            ]);
            
            // Debug: verificar si hay errores
            if (is_wp_error($result)) {
                error_log('Error creando categoría ' . $nombre . ': ' . $result->get_error_message());
            }
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
    
    if (!get_option('nr_categorias_insertadas')) {
        nr_crear_categorias_predeterminadas();
        update_option('nr_categorias_insertadas', true);
    }
}

register_activation_hook(__FILE__, 'nr_plugin_activar');



