<?php
class MCQAC_Ad {

    private $post_type;

    /**
     * Initializes the plugin.
     *
     * To keep the initialization fast, only add filter and action
     * hooks in the constructor.
     */
    public function __construct() {
        $this->post_type = "ad";

        //
        add_action('init', array($this, 'create_custom_post_type'));

        // Disable Rich Editor for Ad Post Type
        add_filter( 'user_can_richedit', array($this, 'disable_for_cpt') );
    }

    /**
     *
     */
    function disable_for_cpt( $default ) {
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

            // "exclude_from_search" => false,
            // "publicly_queryable" => false,
            'show_ui' => true,
            // "show_in_nav_menus" => false,
            "show_in_rest" => true,

            // "capabilities" => $capabilities,
            "map_meta_cap" => true,

            'hierarchical' => false,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-star-filled',
            'supports' => array( 'title', 'editor', 'custom-fields' ),
            'taxonomies' => array( '' )
        );

        register_post_type($posttype, $args);
        flush_rewrite_rules ();
    }
}

new MCQAC_Ad();




// class MCQAC_Ad {

//     private $post_type;

//     /**
//      * Initializes the plugin.
//      *
//      * To keep the initialization fast, only add filter and action
//      * hooks in the constructor.
//      */
//     public function __construct() {
//         $this->post_type = "ad";

//         //
//         add_action('init', array($this, 'create_custom_post_type'));

//         // Disable Rich Editor for Ad Post Type
//         add_filter( 'user_can_richedit', array($this, 'disable_for_cpt') );
//     }

//     /**
//      *
//      */
//     function disable_for_cpt( $default ) {
//         global $post;

//         if ($this->post_type == get_post_type( $post ))
//             return false;

//         return $default;
//     }

//     /**
//      *
//      */
//     function create_custom_post_type() {
//         $posttype = "ad";

//         $capabilities = array (
//             // Meta capabilities
//             "read_post" => "read_{$posttype}",
//             "edit_post" => "edit_{$posttype}",
//             "delete_post" => "delete_{$posttype}",

//             // Primitive capabilities used outside of map_meta_cap():
//             "edit_posts"        => "edit_{$posttype}s",
//             "edit_others_posts"        => "edit_others_{$posttype}s",
//             "publish_posts"        => "publish_{$posttype}s",
//             "read_private_posts"        => "read_private_{$posttype}s",

//             // Primitive capabilities used within map_meta_cap():
//             "read" => "read",
//             "delete_posts "          => "delete_{$posttype}s ",
//             "delete_private_posts"        => "delete_private_{$posttype}s",
//             "delete_published_posts"        => "delete_published_{$posttype}s",
//             "delete_others_posts"          => "delete_others_{$posttype}s",
//             "edit_private_posts"        => "edit_private_{$posttype}s",
//             "edit_published_posts"        => "edit_published_{$posttype}s",
//         );

//         $args = array(
//             'public' => false,
//             'show_ui' => true,

//             'labels' => array(
//                 'name' => __('Ads', 'mmp'),
//                 'singular_name' => __('Ad', 'mmp'),
//                 'add_new' => _x('New item', 'Add'),
//                 'add_new_item' => __('New item'),
//                 'edit_item' => __('Edit item'),
//                 'new_item' => __('New item'),
//                 'view_item' => __('View item'),
//                 'search_items' => __('Search item'),
//                 'not_found' =>  __('Not found item'),
//                 'not_found_in_trash' => __('Not found item in trash')
//             ),

//             "capabilities" => $capabilities,
//             "map_meta_cap" => true,

//             'hierarchical' => false,
//             'menu_position' => 5,
//             'menu_icon' => 'dashicons-star-filled',
//             'supports' => array( 'title', 'editor' ),
//         );

//         register_post_type($posttype, $args);
//         flush_rewrite_rules ();
//     }
// }

// new MCQAC_Ad();
