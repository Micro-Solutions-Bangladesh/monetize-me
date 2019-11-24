<?php
/**
 * Plugin Name: Monetize Me
 * Plugin URI: https://mcqacademy.com/
 * Description: Monetize Me plugin will help webmaster to manage monetize scripts and display using shortcodes and widgets.
 * Author: microsolutions, shahalom
 * Author URI: https://MicroSolutionsBD.com/
 * Version: 1.0.0
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package monetize-me
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once('inc/functions.php');
require_once('libs/msbd-helper-functions.php');
require_once('inc/custom-post-types/ad.php');

// require_once('libs/meta-boxes.php');
require_once('libs/widgets.php');

require_once('inc/custom-taxonomies/adcategory.php');
require_once('inc/custom-taxonomies/adsponsor.php');
// require_once('inc/custom-taxonomies/adwidth.php'); // Depricated
// require_once('inc/custom-taxonomies/adheight.php'); // Depricated

class Monetize_Me_Main {
    public $version = '1.0.0';

    function __construct() {
        //
        add_action('widgets_init', array( $this, 'custom_widgets_init' ), 1);

        //
        add_shortcode( 'mmps', array( $this, 'monetize_me_shortcode_func' ) );
    }

    /**
     *
     */
    function custom_widgets_init() {
        /* register new widget */
        register_widget('Monetize_Me_Widget_Ads');
    }

    public function monetize_me_shortcode_func ($atts = null, $content = null) {
        global $wp;

        // Prepare data
        $atts = shortcode_atts( array(
            'class'      => 'left', //right, center, left
            // 'title'      => '', // Not used any where
            'id'    => '',
            'stype' => 'adsense', //Sponsor Type
            'type'  => 'mix',
            'width' => '',
            'height'    => '',
            'limit' => 1,
            'wrapper' => 1
        ), $atts );

       $height = intval($atts['height']);
       $width = intval($atts['width']);
       $stype = msbd_sanitization($atts['stype']);
       $limit = (intval($atts['limit']) > 0) ? intval($atts['limit']) : 1;

        if ($width<1) {
            $width = 'responsive';
            $height = 'responsive';
        }

        $stype = explode(',', $stype);
        $width = explode(',', $width);
        $height = array($height);

        $args = array(
            'post_type' => 'ad',
            'post_status' => 'publish',

            'tax_query' => array(),

            'meta_query' => array(
                'relation' => 'AND'
            ),

            'posts_per_page' => intval( $limit ),
            'orderby'        => 'rand',
        );

        if(!empty($atts['id'])) { //Query by Slug
            $args['name'] = $atts['id'];
        } else {
            $args['tax_query']['relation'] = 'AND';

            $args['tax_query'][] = array(
                'taxonomy' => 'adsponsor',
                'field' => 'slug',
                'terms' => $stype,
            );

            $args['tax_query'][] = array(
                'taxonomy' => 'adwidth',
                'field' => 'slug',
                'terms' => $width,
            );

            $args['tax_query'][] = array(
                'taxonomy' => 'adheight',
                'field' => 'slug',
                'terms' => $height,
            );

            $meta_query = array();
            $meta_query[] = array(
                'key' => 'mmp_type',
                'value' => $atts['type'],
                'type' => 'CHAR',
                'compare' => 'LIKE'
            );

            $args['meta_query'] = $meta_query;
        }

        ob_start();

        $ads = new WP_Query( $args );

        $servable_ads = array();
        $servable_ad_count = 0;

        if ($ads->have_posts()) {
            while( $ads->have_posts()) {
                $ads->the_post();

                $servable_ad_count++;
                $servable_ads[] = get_the_content();

                $count_view = intval( get_post_meta(get_the_ID(), 'mmp_count_view', true) );
                $count_view++;
                update_post_meta(get_the_ID(), 'mmp_count_view', $count_view);

                if ($servable_ad_count>=$limit) {
                    break;
                }
            }

            for ($x = $servable_ad_count; $x<$limit; $x++) {
                $servable_ad = $servable_ads[0];
                $servable_ads[] = $servable_ad;
            }
        }

        if ($atts['wrapper']==1) {
            echo '<div class="ads-section'.msbd_asf($atts['class']).'">'.implode("", $servable_ads).'</div>';
        } else {
            echo implode("", $servable_ads);
        }

        wp_reset_postdata();

        return ob_get_clean();

    }
} // End of Class Main

new Monetize_Me_Main();



/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'src/init.php';




// Activation Hook
require_once('inc/activation-hook.php');
register_activation_hook(__FILE__, array('Monetize_Me_Activation', 'plugin_activated'));

/* end of file main.php */
