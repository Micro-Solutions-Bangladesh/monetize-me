<?php
class Monetize_Me_Adheight {

    /**
     *
     */
    public function __construct() {
        add_action('init',    array( $this, 'monetize_me_register_taxonomies_adheight'));
    }

    /**
     *
     */
    function monetize_me_register_taxonomies_adheight() {
        $posttype = array('ad');
        $taxonomy_name = 'adheight';

        $labels = array(
            'name' => 'Advertisements Height',
            'singular_name' => 'Advertisement Height',
            'search_items' => 'Advertisement Height',
            'all_items' => 'Advertisements Height',
            'edit_item' => 'Edit item',
            'update_item' => 'Update item',
            'add_new_item' => 'Add New'
        );

        register_taxonomy($taxonomy_name, $posttype, array(
            'labels' => $labels,
            'label' => 'Advertisement Height',
            'hierarchical' => false,
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'ad-height',
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

new Monetize_Me_Adheight();
