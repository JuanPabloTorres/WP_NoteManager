<?php
if (!defined('ABSPATH')) exit;

function nr_registrar_taxonomia_categoria_nota() {
    $labels = array(
        'name'              => 'Categorías',
        'singular_name'     => 'Categoría',
        'search_items'      => 'Buscar Categorías',
        'all_items'         => 'Todas las Categorías',
        'parent_item'       => 'Categoría Padre',
        'parent_item_colon' => 'Categoría Padre:',
        'edit_item'         => 'Editar Categoría',
        'update_item'       => 'Actualizar Categoría',
        'add_new_item'      => 'Agregar nueva Categoría',
        'new_item_name'     => 'Nuevo nombre de Categoría',
        'menu_name'         => 'Categorías',
    );
    
    $args = array(
        'hierarchical'      => true, // como categorías
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categoria-nota'),
    );
    
    register_taxonomy('categoria_nota', array('nota'), $args);
}
add_action('init', 'nr_registrar_taxonomia_categoria_nota');
