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

function nr_enqueue_assets() {
    wp_enqueue_style('nr-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('nr-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'nr_enqueue_assets');

// Agregar menú al admin
// add_action('admin_menu', 'nr_agregar_menu_admin');

// function nr_agregar_menu_admin() {
//     add_menu_page(
//         'Notas Rápidas',
//         'Notas Rápidas',
//         'manage_options',
//         'notas-rapidas',
//         'nr_formulario_nota',
//         'dashicons-welcome-write-blog',
//         26
//     );
// }

function nr_formulario_nota() {
    // Incluir CSS para responsividad
    echo '<style>
    .nr-form-wrap { max-width: 600px; margin: 0 auto; }
    @media (max-width: 600px) {
        .form-table, .form-table th, .form-table td { display: block; width: 100%; }
        .form-table th { margin-top: 15px; }
    }
    </style>';
    
    // Procesar el formulario antes de mostrar el HTML
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo'])) {
        global $wpdb;
        
        $titulo    = sanitize_text_field($_POST['titulo']);
        
        $contenido = sanitize_textarea_field($_POST['contenido']);
        
        $prioridad = sanitize_text_field($_POST['prioridad']);
        
        $wpdb->insert(
            $wpdb->prefix . 'np_notas',
            [
                'titulo'    => $titulo,
                'contenido' => $contenido,
                'prioridad' => $prioridad,
                ]
            );
            
            $id = $wpdb->insert_id;
            
            echo '<div class="notice notice-success"><p>✅ Nota creada con ID: <strong>' . esc_html($id) . '</strong></p></div>';
        }
        
        // Mostrar el formulario desde el template
        include plugin_dir_path(__FILE__) . 'templates/form-nota.php';
    }
    
    