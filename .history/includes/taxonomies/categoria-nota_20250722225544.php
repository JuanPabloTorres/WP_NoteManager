<?php
if (!defined('ABSPATH')) exit;

function nr_registrar_taxonomia_categoria_nota() {
    register_taxonomy(
        'categoria_nota', // slug de la taxonomía
        'nota',           // tipo de post asociado
        array(
            'labels' => array(
                'name'              => 'Categorías',
                'singular_name'     => 'Categoría',
                'search_items'      => 'Buscar Categorías',
                'all_items'         => 'Todas las Categorías',
                'edit_item'         => 'Editar Categoría',
                'update_item'       => 'Actualizar Categoría',
                'add_new_item'      => 'Agregar Nueva Categoría',
                'new_item_name'     => 'Nueva Categoría',
                'menu_name'         => 'Categorías',
            ),
            'public'            => true,
            'hierarchical'      => true, // como las categorías de WordPress (no etiquetas)
            'show_ui'           => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => array('slug' => 'categoria-nota'),
            )
        );
    }
    add_action('init', 'nr_registrar_taxonomia_categoria_nota');
    