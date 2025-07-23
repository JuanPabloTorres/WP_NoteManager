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
        'not_found'         => 'No se encontraron categorías',
        'parent_item'       => 'Categoría padre',
        'parent_item_colon' => 'Categoría padre:',
    ];
    
    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'show_tagcloud'     => true,
        'query_var'         => true,
        'public'            => true,
        'rewrite'           => ['slug' => 'categoria-nota'],
        'capabilities'      => [
            'manage_terms' => 'edit_posts',
            'edit_terms'   => 'edit_posts',
            'delete_terms' => 'edit_posts',
            'assign_terms' => 'edit_posts',
        ],
    ];
    
    // Cambia 'np_nota' por el nombre correcto de tu post type
    register_taxonomy('categoria_nota', ['nota'], $args);
}

// Asegúrate de que se registre después del post type
add_action('init', 'nr_registrar_taxonomia_categoria_nota', 20);




