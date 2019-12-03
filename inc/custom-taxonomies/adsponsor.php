<?php
/**
 * A toxonomy to determine the sponsor of the ad post type
 */
class Monetize_Me_Ad_Sponsor {

    public function __construct() {
        add_action('init', array( $this, 'monetize_me_register_taxonomy'));
    }

    function monetize_me_register_taxonomy() {
        $posttype = array('ad');
        $taxonomy_name = 'adsponsor';

        $labels = array(
            'name' => __('Ad Sponsor', 'monetize-me'),
            'singular_name' => __('Ad Sponsor', 'monetize-me'),
            'search_items' => __('Search Ad Sponsor', 'monetize-me'),
            'all_items' => __('All Ad Sponsors', 'monetize-me'),
            'edit_item' => __('Edit Ad Sponsor', 'monetize-me'),
            'update_item' => __('Update Ad Sponsor', 'monetize-me'),
            'add_new_item' => __('New Sponsor', 'monetize-me'),
        );

        register_taxonomy($taxonomy_name, $posttype, array(
            'labels' => $labels,
            'label' => 'Ad Sponsors',
            'hierarchical' => false,
            'query_var' => true,
            'show_admin_column' => true,
            
            'show_ui' => true,
            'show_in_rest' => true,
            'support' => array('title','editor')
        ));

        flush_rewrite_rules ();
    }

}

new Monetize_Me_Ad_Sponsor();
