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

// Agregar menú al admin
add_action('admin_menu', 'nr_agregar_menu_admin');

function nr_agregar_menu_admin() {
    add_menu_page(
        'Notas Rápidas',
        'Notas Rápidas',
        'manage_options',
        'notas-rapidas',
        'nr_formulario_nota',
        'dashicons-welcome-write-blog',
        26
    );
}

function nr_formulario_nota() {
    ?>
    <div class="wrap">
    <h1>Agregar Nota Rápida</h1>
    <form method="post">
    <table class="form-table">
    <tr>
    <th><label for="titulo">Título</label></th>
    <td><input type="text" name="titulo" id="titulo" required></td>
    </tr>
    <tr>
    <th><label for="contenido">Contenido</label></th>
    <td><textarea name="contenido" id="contenido" rows="5" cols="50"></textarea></td>
    </tr>
    <tr>
    <th><label for="prioridad">Prioridad</label></th>
    <td>
    <select name="prioridad" id="prioridad">
    <option value="Alta">Alta</option>
    <option value="Media" selected>Media</option>
    <option value="Baja">Baja</option>
    </select>
    </td>
    </tr>
    </table>
    <?php submit_button('Guardar Nota'); ?>
    </form>
    </div>
    <?php
    
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
    }
    
    