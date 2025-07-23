<?php
if (!defined('ABSPATH')) exit;

function nr_registrar_post_type_np_nota() {
    $labels = [
        'name'               => 'Notas',
        'singular_name'      => 'Nota',
        'menu_name'          => 'Notas Rápidas',
        'name_admin_bar'     => 'Nota',
        'add_new'            => 'Agregar nueva',
        'add_new_item'       => 'Agregar nueva nota',
        'new_item'           => 'Nueva nota',
        'edit_item'          => 'Editar nota',
        'view_item'          => 'Ver nota',
        'all_items'          => 'Todas las notas',
        'search_items'       => 'Buscar notas',
        'not_found'          => 'No se encontraron notas',
        'not_found_in_trash' => 'No hay notas en la papelera'
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'show_in_rest'       => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'nota'],
        'supports'           => ['title', 'editor'],
        'menu_icon'          => 'dashicons-edit',
    ];

    register_post_type('np_nota', $args);
}

add_action('init', 'nr_registrar_post_type_np_nota');
