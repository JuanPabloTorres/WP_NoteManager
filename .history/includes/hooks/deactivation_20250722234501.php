<?php

if (!defined('ABSPATH')) exit;

if (!function_exists('nr_plugin_desactivar')) {
    function nr_plugin_desactivar() {
        delete_option('nr_categorias_insertadas');
    }
}


