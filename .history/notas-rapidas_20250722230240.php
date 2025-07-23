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

require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

require_once plugin_dir_path(__FILE__) . 'includes/taxonomies/categoria-nota.php';

require_once plugin_dir_path(__FILE__) . 'includes/hooks/activation.php';

require_once plugin_dir_path(__FILE__) . 'includes/hooks/crear-tabla.php';

// Hooks
register_activation_hook(__FILE__, 'nr_plugin_activar');

// register_activation_hook(__FILE__, 'nr_crear_categorias_predeterminadas');





function nr_enqueue_assets() {
    wp_enqueue_style('nr-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    
    wp_enqueue_script('nr-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'nr_enqueue_assets');






