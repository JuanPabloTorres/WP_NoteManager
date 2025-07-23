<?php
if (!defined('ABSPATH')) exit;

// 📌 Hook para registrar la taxonomía al iniciar WordPress
add_action('init', 'nr_registrar_taxonomia_categoria_nota');

function nr_registrar_taxonomia_categoria_nota() {
    $labels = [
        'name'              => 'Categorías de Nota',
        'singular_name'     => 'Categoría de Nota',
        'search_items'      => 'Buscar Categorías',
        'all_items'         => 'Todas las Categorías',
        'edit_item'         => 'Editar Categoría',
        'update_item'       => 'Actualizar Categoría',
        'add_new_item'      => 'Agregar nueva Categoría',
        'new_item_name'     => 'Nombre de nueva Categoría',
        'menu_name'         => 'Categorías'
    ];
    
    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'categoria-nota'],
    ];
    
    register_taxonomy('categoria_nota', ['np_nota'], $args);
}
