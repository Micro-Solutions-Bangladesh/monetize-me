<?php
class MCQAC_Ad {

    private $post_type;

    /**
     * 
     */
    public function __construct() {
        $this->post_type = "ad";

        //
        add_action('init', array($this, 'create_custom_post_type'));

        // Disable Rich Editor for Ad Post Type
        add_filter( 'user_can_richedit', array($this, 'disable_for_cpt_ad') );
    }

    /**
     *
     */
    function disable_for_cpt_ad( $default ) {
        global $post;

        if ($this->post_type == get_post_type( $post ))
            return false;

        return $default;
    }

    /**
     *
     */
    function create_custom_post_type() {
        $posttype = "ad";

        $args = array(
            'public' => false,

            'labels' => array(
                'name' => __('Ads', 'mmp'),
                'singular_name' => __('Ad', 'mmp'),
                'add_new' => _x('New item', 'Add'),
                'add_new_item' => __('New item'),
                'edit_item' => __('Edit item'),
                'new_item' => __('New item'),
                'view_item' => __('View item'),
                'search_items' => __('Search item'),
                'not_found' =>  __('Not found item'),
                'not_found_in_trash' => __('Not found item in trash')
            ),

            'show_ui' => true,
            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-star-filled',
            'supports' => array( 'title', 'editor', 'custom-fields' ),
            'taxonomies' => array( 'adcategory', 'adsponsor' )
        );

        register_post_type($posttype, $args);
        flush_rewrite_rules ();
    }
}

new MCQAC_Ad();

