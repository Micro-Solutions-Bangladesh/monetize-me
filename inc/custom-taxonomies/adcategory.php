<?php
class Monetize_Me_Ad_Settings {

    public function __construct() {
        add_action('init', array( $this, 'monetize_me_register_taxonomy'));
    }

    function monetize_me_register_taxonomy() {
        $posttype = array('ad');
        $taxonomy_name = 'adcategory';

        $labels = array(
            'name' => __('Ad Category', 'monetize-me'),
            'singular_name' => __('Ad Category', 'monetize-me'),
            'search_items' => __('Search Ad Category', 'monetize-me'),
            'all_items' => __('All Ad Categories', 'monetize-me'),
            'edit_item' => __('Edit Ad Category', 'monetize-me'),
            'update_item' => __('Update Ad Category', 'monetize-me'),
            'add_new_item' => __('New Ad Category', 'monetize-me'),
        );

        register_taxonomy($taxonomy_name, $posttype, array(
            'labels' => $labels,
            'label' => 'Ad Categories',
            'hierarchical' => false,
            'query_var' => true,
            // 'rewrite' => array(
            //     'slug' => 'adcategory',
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
            'show_in_rest' => true,
            // 'rest_controller_class' => 'WP_REST_Terms_Controller',
            'support' => array('title','editor')
        ));

        flush_rewrite_rules ();
    }

}

new Monetize_Me_Ad_Settings();
