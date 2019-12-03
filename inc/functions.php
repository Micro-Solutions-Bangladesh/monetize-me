<?php
/**
 * 
 */
function monetize_me_taxonomy_name_id_pairs( $tax, $emptySelectOption = true ) {
    $rs = array();
    $terms = get_terms(array(
        'taxonomy' => $tax,
        'hide_empty' => $emptySelectOption,
    ));

    foreach( $terms as $i => $row ) {
        if( empty( $rs ) ) {
            $rs[] = array(
                "label" => "-- select --",
                "value" => 0,
            );
        }
        $rs[] = array(
            "label" => $row->name,
            "value" => $row->term_id,
        );
    }

    return $rs;
}

/**
 * 
 */
function monetize_me_ad_category_pairs( $emptySelectOption = true ) {
    return monetize_me_taxonomy_name_id_pairs( 'adcategory', $emptySelectOption );
}

/**
 * 
 */
function monetize_me_ad_sponsor_pairs( $emptySelectOption = true ) {
    return monetize_me_taxonomy_name_id_pairs( 'adsponsor', $emptySelectOption );
}



/**
 * 
 */
function monetize_me_gutenberg_serverside_handler($atts) {
    return monetize_me_shortcode_mmps( $atts );
}

/**
 * 
 */
function monetize_me_shortcode_mmps( $atts ) {
    global $wp;

    $isWrapper = ( isset( $atts['isWrapper'] ) && ( $atts['isWrapper'] == 'true' || $atts['isWrapper'] == '1' )  ) ? true : false;

    $limit = (intval($atts['limit']) > 0) ? intval($atts['limit']) : 1;
    $adAlignment = isset( $atts['adAlignment'] ) ? $atts['adAlignment'] : '';
    $postSlug = isset( $atts['postSlug'] ) ? $atts['postSlug'] : '';
    $adCategory = isset( $atts['adCategory'] ) ? explode( ",", $atts['adCategory'] ) : array();
    
    $adSponsor = ( isset( $atts['adSponsor'] ) && ( $atts['adSponsor'] !== '0' ) ) ? explode( ",", $atts['adSponsor'] ) : array();

    $className = isset( $atts['className'] ) ? $atts['className'] : ''; // Advanced class name

    if( ! empty ( $className ) ) {
        $adAlignment .= " " . $className;
    }

    $args = array(
        'post_type' => 'ad',
        'post_status' => 'publish',

        'tax_query' => array(),

        'posts_per_page' => $limit,
        'orderby'        => 'rand',
    );

    if( !empty($postSlug) ) { //Query by Slug
        $args['name'] = $postSlug;
    } else {
        $args['tax_query'][] = array(
            'taxonomy' => 'adcategory',
            'field' => 'term_id',
            'terms' => $adCategory,
        );

        if ( ! empty( $adSponsor ) ) {
            $args['tax_query']['relation'] = 'AND';

            $args['tax_query'][] = array(
                'taxonomy' => 'adsponsor',
                'field' => 'term_id',
                'terms' => $adSponsor,
            );
        }
    }

    $query = new WP_Query( $args );
    $servable_ads = array();
    $servable_ad_count = 0;

    // The Loop
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $servable_ad_count++;
            
            if( $isWrapper ) {
                $servable_ads[] = "<div class=\"ad-wrapper\">" . get_the_content() . "</div>";
            } else {
                $servable_ads[] = get_the_content();
            }

            if ($servable_ad_count >= $limit) {
                break;
            }
        }
    }

    $rs = "";
    $test = '';// print_r($adSponsor, true);

    if( !empty( $servable_ads ) ) {
        // if ( $isWrapper ) {
            $rs = '<div class="monetize-me'. msbd_asf( $adAlignment ).'">' . implode("", $servable_ads) . "{$test}</div>";
        // } else {
        //     $rs = implode("", $servable_ads);
        // }
    } else {
        $rs = "<div class=\"monetize-me center-align\">Ad Setting Require A Change!{$test}</div>";
    }

    wp_reset_postdata();

    return $rs;
}

