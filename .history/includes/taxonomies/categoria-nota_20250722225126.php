<?php
if (!defined('ABSPATH')) exit;

function nr_registrar_taxonomia_categoria_nota() {
    register_taxonomy(
        'categoria_nota',
        'nota',
        array(
            'label' => 'Categorías',
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'categoria-nota'),
            )
        );
    }
    add_action('init', 'nr_registrar_taxonomia_categoria_nota');
    