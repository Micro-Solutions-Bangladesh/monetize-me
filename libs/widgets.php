<?php
class Monetize_Me_Widget_Ads extends WP_Widget {

    function __construct() {
        parent::__construct('monetize_me_ad_posts', __('Show Advertisement','monetize-me'), array('description' =>__('Display Ads','monetize-me') ));
    }

    function widget ($args, $instance) {
        extract($args);
        $instance = wp_parse_args( (array) $instance, array('title' => '', 'text' => '') );

        $title = esc_attr( $instance['title'] );
        $slug = esc_attr( $instance['slug'] );
        $stype = isset($instance['stype']) ? esc_attr($instance['stype']) : '';
        $cclass = isset($instance['cclass']) ? esc_attr($instance['cclass']) : '';
        $type = esc_attr( $instance['type'] );
        $width = ( ! empty( $instance['width'] ) ) ? absint( $instance['width'] ) : 0;
        $height = ( ! empty( $instance['height'] ) ) ? absint( $instance['height'] ) : 0;
        $number = ( intval( $instance['number'] ) > 0 ) ? intval( $instance['number'] ) : 1;

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo  $before_widget;

        if ($title) {
            echo  $before_title . $title . $after_title;
        }

        $shortcode_attrs = '';

        if(!empty($slug)) {
            $shortcode_attrs = '[mmps id="'.$slug.'"]';
        } else if (!empty($type) && !empty($width) && !empty($height)) {
            $shortcode_attrs = '[mmps width="'.$width.'" height="'.$height.'" type="'.$type.'" limit="'.$number.'"';

            if (!empty($stype)) {
                $shortcode_attrs .= ' stype="'.$stype.'"';
            }

            if (!empty($cclass)) {
                $shortcode_attrs .= ' class="'.$cclass.'"';
            }

            $shortcode_attrs .= ']';
        }

        //echo '<div class="required-attr-not-found">'.$shortcode_attrs.'</div>';

        if (!empty($shortcode_attrs)) {
            echo do_shortcode($shortcode_attrs);
        } else {
            echo '<div class="required-attr-not-found"></div>';
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
        $instance['slug'] = strip_tags($new_instance['slug']);
        $instance['type'] = strip_tags($new_instance['type']);
        $instance['stype'] = strip_tags($new_instance['stype']);
        $instance['cclass'] = strip_tags($new_instance['cclass']);

        $instance['width'] = (int) $new_instance['width'];
        $instance['height'] = (int) $new_instance['height'];
        $instance['number'] = (int) $new_instance['number'];

        return $instance;
    }

    /**
     *
     */
    function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $width    = isset( $instance['width'] ) ? absint( $instance['width'] ) : 0;
        $height    = isset( $instance['height'] ) ? absint( $instance['height'] ) : 0;
        $type    = isset( $instance['type'] ) ? esc_attr( $instance['type'] ) : '';
        $stype    = isset( $instance['stype'] ) ? esc_attr( $instance['stype'] ) : '';
        $cclass    = isset( $instance['cclass'] ) ? esc_attr( $instance['cclass'] ) : '';
        $slug    = isset( $instance['slug'] ) ? esc_attr( $instance['slug'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 1;
?>
        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'monetize-me' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'stype' ) ); ?>"><?php _e( 'Sponsor Type:', 'monetize-me' ); ?></label>

            <?php
            $args = array(
                'taxonomy' => 'adsponsor',
                'hide_empty' => false,
            );
            $terms = get_terms ($args);
            $options = array();

            foreach($terms as $i => $row) {
                $options[$row->slug] = $row->name;
            }

            $attr = 'name="'.esc_attr( $this->get_field_name( 'stype' ) ).'" id="'.esc_attr( $this->get_field_id( 'stype' ) ).'" class="widefat"';
            echo msbd_draw_select_box($options, $attr, $stype);
            ?>
        </p>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php _e( 'Type:', 'monetize-me' ); ?></label>
        <?php
        $options = array( "mix" => "Mix Ad", "img" => "Image Ad", "text" => "Text Ad", "link" => "Links Ad" );
        $attr = 'name="'.esc_attr( $this->get_field_name( 'type' ) ).'" id="'.esc_attr( $this->get_field_id( 'type' ) ).'" class="widefat"';
        echo msbd_draw_select_box($options, $attr, $type);
        ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>"><?php _e( 'Width:', 'monetize-me' ); ?></label>
            <?php
            $args = array(
                'taxonomy' => 'adwidth',
                'hide_empty' => false,
            );
            $terms = get_terms ($args);
            $options = array();

            foreach($terms as $i => $row) {
                $options[$row->slug] = $row->name;
            }

            $attr = 'name="'.esc_attr( $this->get_field_name( 'width' ) ).'" id="'.esc_attr( $this->get_field_id( 'width' ) ).'" class="widefat"';
            echo msbd_draw_select_box($options, $attr, $width);
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php _e( 'Height:', 'monetize-me' ); ?></label>

            <?php
            $args = array(
                'taxonomy' => 'adheight',
                'hide_empty' => false,
            );
            $terms = get_terms ($args);
            $options = array();

            foreach($terms as $i => $row) {
                $options[$row->slug] = $row->name;
            }

            $attr = 'name="'.esc_attr( $this->get_field_name( 'height' ) ).'" id="'.esc_attr( $this->get_field_id( 'height' ) ).'" class="widefat"';
            echo msbd_draw_select_box($options, $attr, $height);
            ?>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'cclass' ) ); ?>"><?php _e( 'Ad alignment:', 'monetize-me' ); ?></label>

            <?php
            $options = array('center'=>'Center', 'left'=>'Left', 'right'=>'Right');

            $attr = 'name="'.esc_attr( $this->get_field_name( 'cclass' ) ).'" id="'.esc_attr( $this->get_field_id( 'cclass' ) ).'" class="widefat"';
            echo msbd_draw_select_box($options, $attr, $cclass);
            ?>
        </p>


        <p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of ads to show:', 'monetize-me' ); ?></label>
        <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

        <p>Or,</p>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'slug' ) ); ?>"><?php _e( 'Slug:', 'monetize-me' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slug' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slug' ) ); ?>" type="text" value="<?php echo $slug; ?>" /></p>
<?php
    }
}
