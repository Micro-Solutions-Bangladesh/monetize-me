<?php

/**
 * Register new widget
 */
function monetize_me_custom_widgets_init() {
    register_widget('Monetize_Me_Widget_Ads');
}

add_action('widgets_init', 'monetize_me_custom_widgets_init', 1);


