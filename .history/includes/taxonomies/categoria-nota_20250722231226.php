<?php
if (!defined('ABSPATH')) exit;

function nr_registrar_taxonomia_categoria_nota() {
    $labels = [
        'name'              => 'Categorías',
        'singular_name'     => 'Categoría',
        'search_items'      => 'Buscar categorías',
        'all_items'         => 'Todas las categorías',
        'edit_item'         => 'Editar categoría',
        'update_item'       => 'Actualizar categoría',
        'add_new_item'      => 'Agregar nueva categoría',
        'new_item_name'     => 'Nuevo nombre de categoría',
        'menu_name'         => 'Categorías de Nota',
    ];
    
    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'categoria-nota'],
    ];
    
    register_taxonomy('categoria_nota', ['np_nota'], $args);
}

add_action('init', 'nr_registrar_taxonomia_categoria_nota');
