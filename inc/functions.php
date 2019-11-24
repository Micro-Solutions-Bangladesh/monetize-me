<?php

function get_ad_category_value_label_pairs() {
    $rs = array();
    $terms = get_terms(array(
        'taxonomy' => 'adcategory',
        // 'hide_empty' => true,
    ));

    foreach( $terms as $i => $row ) {
        $rs[] = array(
            "label" => $row->name,
            "value" => $row->term_id,
        );
    }

    return $rs;
}


// function monetize_me_render_serverside_handler($adCategory, $sponsorType, $postSlug) {
//     return "<p>adCategory: {$adCategory} == sponsorType: {$sponsorType} == postSlug: {$postSlug}</p>";
// }


