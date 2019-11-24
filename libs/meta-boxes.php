<?php
/* ===========================
 *    Meta Boxe for mcq custom type
 ===========================*/

function monetize_me_ad_type_meta_box() {
    add_meta_box( 'monetize-me-cpt-general-settings', __( 'General Settings', 'monetize-me' ), 'monetize_me_custom_type_general_settings_markup_callback', 'ad' );
}
add_action( 'add_meta_boxes', 'monetize_me_ad_type_meta_box' );

/**
 *
 */
function monetize_me_custom_type_general_settings_markup_callback() {
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'monetize_me_custom_type_general_settings_markup_nonce' );

    $monetize_me_type = get_post_meta($post->ID, 'mmp_type', true);
    $monetize_me_count_view = intval( get_post_meta($post->ID, 'mmp_count_view', true) );
    ?>
    <div class="mcqa-form-wrapper">
        <div class="row question-metas">

            <div class="row form-row">
                <div class="col-sm-4">
                    <label for="mmp_type">Ad Type</label>
                </div>
                <div class="col-sm-8">
                    <?php
                    $monetize_me_options = array(
                        "mix" => "Mix Ad",
                        "img" => "Image Ad",
                        "text" => "Text Ad",
                        "link" => "Links Ad",
                        "feed" => "Feed Ad",
                        "article" => "Article Ad"
                    );
                    $attr = 'name="mmp_type" id="mmp_type"';
                    echo msbd_draw_select_box($monetize_me_options, $attr, $monetize_me_type);
                    ?>
                </div>
            </div>

            <div class="row form-row">
                <div class="col-sm-4">
                    <label for="mmp_count_view">Scripte served total</label>
                </div>
                <div class="col-sm-8">
                    <input type="text" name="mmp_count_view" id="mmp_count_view" value="<?php echo $monetize_me_count_view; ?>" readonly />
                </div>
            </div>
        </div>
    </div><!-- / .mcqa-form-wrapper -->
    <?php
}

function monetize_me_custom_type_general_settings_save( $post_id ) {
    global $post;
    $slugs = array('ad');

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
        return;
    }

    if ( !is_object($post) || !in_array( $post->post_type, $slugs )  ) {
        return;
    }

    // TODO check nonce

    $monetize_me_type = msbd_sanitization($_REQUEST['mmp_type']);
    update_post_meta( $post_id, 'mmp_type', $monetize_me_type );

    $monetize_me_count_view = intval( get_post_meta($post_id, 'mmp_count_view', true) );
    update_post_meta( $post_id, 'mmp_count_view', $monetize_me_count_view );
}
add_action('save_post', 'monetize_me_custom_type_general_settings_save');

/* end of file meta-boxes.php */
