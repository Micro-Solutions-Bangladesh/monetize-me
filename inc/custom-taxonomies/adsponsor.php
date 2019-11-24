<?php
class Monetize_Me_Adsponsor {

    /**
     *
     */
    public function __construct() {
        add_action('init',    array( $this, 'monetize_me_register_taxonomies_adsponsor'));
    }

    /**
     *
     */
    function monetize_me_register_taxonomies_adsponsor() {
        $posttype = array('ad');
        $taxonomy_name = 'adsponsor';

        $labels = array(
            'name' => 'Ad Sponsor',
            'singular_name' => 'Ad Sponsor',
            'search_items' => 'Ad Sponsor',
            'all_items' => 'Ad Sponsor',
            'edit_item' => 'Edit item',
            'update_item' => 'Update item',
            'add_new_item' => 'Add New'
        );

        register_taxonomy($taxonomy_name, $posttype, array(
            'labels' => $labels,
            'label' => 'Ad Sponsor',
            'hierarchical' => true,
            'query_var' => true,
            // 'rewrite' => array(
            //     'slug' => 'ad-sponsor',
            // ),
            'show_admin_column' => true,
            // 'capabilities' => array (
            //     'manage_terms' => 'manage_'.$taxonomy_name,
            //     'edit_terms' => 'edit_'.$taxonomy_name,
            //     'delete_terms' => 'delete_'.$taxonomy_name,
            //     'assign_terms' => 'assign_'.$taxonomy_name
            // ),
            'show_ui' => true,
            // 'rest_base' => $taxonomy_name,
            'show_in_rest' => false,
            // 'rest_controller_class' => 'WP_REST_Terms_Controller',
            'support' => array('title','editor')
        ));

        flush_rewrite_rules ();
    }

}

new Monetize_Me_Adsponsor();
