<?php
if (!defined('ABSPATH')) exit;

// Hook al activar el plugin
function nr_crear_categorias_predeterminadas() {
    // Asegúrate de que la taxonomía esté registrada
    
    
    $categorias = ['Urgente', 'Importante', 'Pendiente', 'Ideas', 'Recordatorio'];
    
    foreach ($categorias as $nombre) {
        
        if (!term_exists($nombre, 'categoria_nota')) {
            
            wp_insert_term($nombre, 'categoria_nota');
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

function nr_plugin_activar() {
    nr_crear_tabla();
    
    nr_crear_categorias_predeterminadas();
}


