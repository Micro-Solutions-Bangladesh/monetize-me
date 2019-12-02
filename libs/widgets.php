<?php
class Monetize_Me_Widget_Ads extends WP_Widget {

    function __construct() {
        parent::__construct('monetize-me', __('Monetize Me','monetize-me'), array('description' =>__('Display Ad(s) with Monetize Me','monetize-me') ));
    }

    function widget ($args, $instance) {
        extract($args);
        $instance = wp_parse_args( (array) $instance, array('title' => '', 'text' => '') );

        $adCategory = ( ! empty( $instance['adCategory'] ) ) ? absint( $instance['adCategory'] ) : 0;
        $adAlignment = isset($instance['adAlignment']) ? esc_attr($instance['adAlignment']) : '';
        $adLimit = ( isset( $instance['adLimit'] ) ) ? absint( $instance['adLimit'] ) : 1;
        $postSlug = isset($instance['postSlug']) ? esc_attr($instance['postSlug']) : '';
        $className = isset($instance['className']) ? esc_attr($instance['className']) : '';
        $wrapper = ( isset( $instance['wrapper'] ) ) ? absint( $instance['wrapper'] ) : 1;

        $title = esc_attr( $instance['title'] );
        
        echo  $before_widget;

        if( ! empty( $title ) ) {
            $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
            echo  $before_title . $title . $after_title;
        }

        $shortcode_attrs = '';

        if( ! empty( $slug ) ) {
            $shortcode_attrs = '[mmps id="'.$slug.'"]';
        } else {
            $shortcode_attrs = '[mmps adcategory="'.$adCategory.'" limit="'.$adLimit.'" wrapper="'.$wrapper.'"';

            if ( ! empty( $adAlignment ) ) {
                $shortcode_attrs .= ' adalignment="'.$adAlignment.'"';
            }

            if ( ! empty( $className ) ) {
                $shortcode_attrs .= ' classname="'.$className.'"';
            }

            $shortcode_attrs .= ']';
        }

        if( ! empty( $shortcode_attrs ) ) {
            echo do_shortcode( $shortcode_attrs );
        }

        echo  $after_widget;
        wp_reset_postdata();
    }

    /**
     *
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['adCategory'] = intval( strip_tags($new_instance['adCategory']) );
        $instance['adAlignment'] = strip_tags($new_instance['adAlignment']);
        $instance['adLimit'] = (int) $new_instance['adLimit'];
        $instance['postSlug'] = strip_tags($new_instance['postSlug']);
        $instance['className'] = strip_tags($new_instance['className']);
        $instance['wrapper'] = (int) $new_instance['wrapper'];

        return $instance;
    }

    /**
     *
     */
    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $adCategory = isset( $instance['adCategory'] ) ? intval( esc_attr( $instance['adCategory'] ) ) : '';
        $adAlignment    = isset( $instance['adAlignment'] ) ? esc_attr( $instance['adAlignment'] ) : '';
        $adLimit    = isset( $instance['adLimit'] ) ? absint( $instance['adLimit'] ) : 1;
        $postSlug    = isset( $instance['postSlug'] ) ? esc_attr( $instance['postSlug'] ) : '';
        $className    = isset( $instance['className'] ) ? esc_attr( $instance['className'] ) : '';
        $wrapper    = isset( $instance['wrapper'] ) ? absint( $instance['wrapper'] ) : 1;
?>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'monetize-me' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'adCategory' ) ); ?>">
                <?php _e( 'Ad Category:', 'monetize-me' ); ?>
            </label>

            <?php
            $args = array(
                'taxonomy' => 'adcategory',
                'hide_empty' => true,
            );
            $terms = get_terms ($args);
            $options = array();

            foreach($terms as $i => $row) {
                $options[$row->term_id] = $row->name;
            }

            $attr = 'name="'.esc_attr( $this->get_field_name( 'adCategory' ) ).'" id="'.esc_attr( $this->get_field_id( 'adCategory' ) ).'" class="widefat"';
            echo msbd_draw_select_box( $options, $attr, $adCategory );
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'adAlignment' ) ); ?>"><?php _e( 'Ad alignment:', 'monetize-me' ); ?></label>

            <?php
            $options = array(
                'right-align'=>'Right Alignment', 'left-align'=>'Left Alignment', 'center-align'=>'Center Alignment',
            );

            $attr = 'name="'.esc_attr( $this->get_field_name( 'adAlignment' ) ).'" id="'.esc_attr( $this->get_field_id( 'adAlignment' ) ).'" class="widefat"';
            echo msbd_draw_select_box($options, $attr, $adAlignment);
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'wrapper' ) ); ?>"><?php _e( 'Use Wrapper:', 'monetize-me' ); ?></label>

            <?php
            $options = array(
                '1'=>'Yes', '0'=>'No',
            );

            $attr = 'name="'.esc_attr( $this->get_field_name( 'wrapper' ) ).'" id="'.esc_attr( $this->get_field_id( 'wrapper' ) ).'" class="widefat"';
            echo msbd_draw_select_box($options, $attr, $wrapper);
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'className' ) ); ?>">
                <?php _e( 'Extra CSS Class:', 'monetize-me' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'className' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'className' ) ); ?>" type="text" value="<?php echo $className; ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'adLimit' ) ); ?>">
                <?php _e( 'Ad Limit:', 'monetize-me' ); ?>
            </label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'adLimit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'adLimit' ) ); ?>" type="text" value="<?php echo esc_attr( $adLimit ); ?>" size="3" />
        </p>

        <p>Or,</p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'postSlug' ) ); ?>">
                <?php _e( 'Ad Slug:', 'monetize-me' ); ?>
            </label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'postSlug' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'postSlug' ) ); ?>" type="text" value="<?php echo $postSlug; ?>" />
        </p>
<?php
    }
}
