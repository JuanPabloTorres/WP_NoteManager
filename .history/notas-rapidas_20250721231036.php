<?php
/**
* Plugin Name: Notas Rápidas
* Description: Agrega y guarda notas simples desde el panel de administración.
* Version: 1.0.0
* Author: Juan P. Torres
*/

if (!defined('ABSPATH')) {
    exit;
}

// Crear tabla al activar
register_activation_hook(__FILE__, 'nr_crear_tabla');

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
