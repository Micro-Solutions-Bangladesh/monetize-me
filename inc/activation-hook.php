<?php
class Monetize_Me_Activation {


    /**
     * Initializes the plugin.
     *
     */
    public function __construct() {

    }


    /**
     * Plugin activation hook.
     *
     */
    public static function plugin_activated() {
        /**
         *
         */
        // monetize_me_capabilities_to_role();

        /**
         *
         */
        // set_capabilities_for_adheight_taxonomy();

        /**
         *
         */
        // set_capabilities_for_adwidth_taxonomy();

        /**
         *
         */
        // set_capabilities_for_adsponsor_taxonomy();
    }
}

// Nothing done in construtor yet
new Monetize_Me_Activation();

/**
 *
 */
function monetize_me_capabilities_to_role() {
    $posttype = "ad";

    $customCaps = array(
        'read'                  => true,
        'read_'.$posttype              => true,
        'edit_'.$posttype             => true,
        'delete_'.$posttype           => true,
        'edit_'.$posttype.'s'            => true,
        'edit_others_'.$posttype.'s'     => true,
        'publish_'.$posttype.'s'         => true,
        'read_private_'.$posttype.'s'    => true,
        'delete_'.$posttype.'s'          => true,
        'delete_private_'.$posttype.'s'  => true,
        'delete_published_'.$posttype.'s'    => true,
        'delete_others_'.$posttype.'s'       => true,
        'edit_private_'.$posttype.'s'        => true,
        'edit_published_'.$posttype.'s'      => true,
    );

    $role = get_role('administrator');

    if ( !is_null( $role) ) { // Check role exists
        // Iterate through our custom capabilities, adding them to this role if they are enabled
        foreach ( $customCaps as $capability => $enabled ) {
            if($enabled)
                $role->add_cap( $capability );
        }
    }
}


/**
 * Set capabilities for adheight taxonomy to Administrator
 *
 */
function set_capabilities_for_adheight_taxonomy() {
    $customCaps = array(
        'assign_adheight'          => true,
        'edit_adheight'            => true,
        'delete_adheight'          =>true,
        'manage_adheight'          => true,
    );

    msbdc_add_custom_caps('administrator', $customCaps);
}

/**
 * Set capabilities for adwidth taxonomy to Administrator
 *
 */
function set_capabilities_for_adwidth_taxonomy() {
    $customCaps = array(
        'assign_adwidth'          => true,
        'edit_adwidth'            => true,
        'delete_adwidth'          =>true,
        'manage_adwidth'          => true,
    );

    msbdc_add_custom_caps('administrator', $customCaps);
}

/**
 * Set capabilities for adsponsor taxonomy to Administrator
 *
 */
function set_capabilities_for_adsponsor_taxonomy() {
    $customCaps = array(
        'assign_adsponsor'          => true,
        'edit_adsponsor'            => true,
        'delete_adsponsor'          =>true,
        'manage_adsponsor'          => true,
    );

    msbdc_add_custom_caps('administrator', $customCaps);
}
