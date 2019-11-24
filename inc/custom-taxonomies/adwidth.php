<?php
class Monetize_Me_Adwidth {

    /**
     *
     */
    public function __construct() {
        add_action('init',    array( $this, 'monetize_me_register_taxonomies_adwidth'));
    }

    /**
     *
     */
    function monetize_me_register_taxonomies_adwidth() {
        $posttype = array('ad');
        $taxonomy_name = 'adwidth';

        $labels = array(
            'name' => 'Advertisements Width',
            'singular_name' => 'Advertisement Width',
            'search_items' => 'Advertisement Width',
            'all_items' => 'Advertisements Width',
            'edit_item' => 'Edit item',
            'update_item' => 'Update item',
            'add_new_item' => 'Add New'
        );

        register_taxonomy($taxonomy_name, $posttype, array(
            'labels' => $labels,
            'label' => 'Advertisement Width',
            'hierarchical' => false,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'ad-width',
            ),
            'show_admin_column' => true,
            'capabilities' => array (
                'manage_terms' => 'manage_'.$taxonomy_name,
                'edit_terms' => 'edit_'.$taxonomy_name,
                'delete_terms' => 'delete_'.$taxonomy_name,
                'assign_terms' => 'assign_'.$taxonomy_name
            ),
            'show_ui' => true,
            'support' => array('title','editor')
        ));

        flush_rewrite_rules ();
    }

}

new Monetize_Me_Adwidth();
