<?php

/**
 * 
 */
function monetize_me_shortcode_mmps_handler( $atts ) {      
    $atts = shortcode_atts( array(
        // 'title'      => '', // Not used any where
        'stype' => 'adsense', //Sponsor Type [depricated]
        'type'  => 'mix', // [depricated]
        'width' => '', // [depricated]
        'height'    => '', // [depricated]

        'adalignment' => '',
        'adcategory' => 0,
        'limit' => 1,
        'wrapper' => 1,
        'id'    => '', // postSlug
        'class' => 'left', //right, center, left
        'classname' => '',
    ), $atts );

    $adAlignment = ( isset( $atts['adalignment'] ) ? $atts['adalignment'] : "" );

    if( empty ( $adAlignment )  && ( isset( $atts['class'] ) && ! empty( $atts['class'] ) ) ) {
        $adAlignment = $atts['class'] . "-align";
    }

    $adCategory = ( isset( $atts['adcategory'] ) ? (int) $atts['adcategory'] : 0 );
    $postSlug = ( isset( $atts['id'] ) ? $atts['id'] : "" );
    $isWrapper = ( isset( $atts['wrapper'] ) ? intval( $atts['wrapper'] ) : 1 );
    $className = ( isset( $atts['classname'] ) ? $atts['classname'] : "" );
    $limit = ( isset( $atts['limit'] ) ? intval( $atts['limit'] ) : 1 );

    $data = array(
        'adAlignment' => $adAlignment,
        'adCategory' => $atts['adcategory'],
        'postSlug' => $postSlug,
        'isWrapper' => $isWrapper,
        'className' => $className, // New for Gutenberg Advance Option
        'limit' => $limit,
    );

    return monetize_me_shortcode_mmps( $data );
}

add_shortcode( 'mmps', 'monetize_me_shortcode_mmps_handler' );
