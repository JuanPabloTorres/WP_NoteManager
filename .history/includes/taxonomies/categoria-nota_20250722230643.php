<?php
if (!defined('ABSPATH')) exit;

function nr_registrar_taxonomia_categoria_nota() {
    register_taxonomy('categoria_nota', 'np_nota', [
        'labels' => [
            'name'              => 'Categorías de Notas',
            'singular_name'     => 'Categoría de Nota',
            'search_items'      => 'Buscar Categorías',
            'all_items'         => 'Todas las Categorías',
            'edit_item'         => 'Editar Categoría',
            'update_item'       => 'Actualizar Categoría',
            'add_new_item'      => 'Añadir nueva Categoría',
            'new_item_name'     => 'Nuevo nombre de Categoría',
            'menu_name'         => 'Categorías',
        ],
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'public'            => true,
        'rewrite'           => ['slug' => 'categoria-nota'],
    ]);
}
add_action('init', 'nr_registrar_taxonomia_categoria_nota');
