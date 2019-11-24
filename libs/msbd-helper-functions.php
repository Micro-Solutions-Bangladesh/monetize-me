<?php

    /***********************************************************
                                    SANITIZATIONS
     ***********************************************************/

if ( !function_exists('msbd_sanitization') ) {
    /*
     * @ $field_type = text, email, number, html, no_html, custom_html, html_js default text
     */
    function msbd_sanitization($data, $field_type='text', $oArray=array()) {
        $output = '';

        switch($field_type) {
            case 'number':
                $output = sanitize_text_field($data);
                $output = intval($output);
                break;

            case 'boolean':
                $var_permitted_values = array('y', 'n', 'true', 'false', '1', '0', 'yes', 'no');
                $output = in_array($data, $var_permitted_values) ? $data : 0;//returned false if not valid
                break;

            case 'email':
                $output = sanitize_email($data);
                $output = is_email($output);//returned false if not valid
                break;

            case 'textarea':
                $output = esc_textarea($data);
                break;

            case 'html':
                $output = wp_kses_post($data);
                break;

            case 'custom_html':
                $allowedTags = isset($oArray['allowedTags']) ? $oArray['allowedTags'] : "";
                $output = wp_kses($data, $allowedTags);
                break;

            case 'no_html':
                $output = strip_tags( $data );
                //$output = stripslashes( $output );
                break;

            case 'html_js':
                $output = $data;
                break;

            case 'text':
            default:
                $output = sanitize_text_field($data);
                break;
        }

        return $output;
    }
}




if ( !function_exists('msbd_current_url') ) {
    /**
     * get URL function
     **/
    function msbd_current_url($atts) {
        // if multisite has been set to true
        if (isset($atts['multisite'])) {
            global $wp;
            $url = add_query_arg($_SERVER['QUERY_STRING'], '', home_url($wp->request));
            return esc_url($url);
        }

        // add http
        $urlCurrentPage = 'http';

        // add s to http if required
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $urlCurrentPage .= "s";
        }

        // add colon and forward slashes
        $urlCurrentPage .= "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

        // return url
        return esc_url($urlCurrentPage);
    }
}



if ( !function_exists('msbd_asf') ) {
    /**
     * asf = add space first
     *
     * @return string
     */
    function msbd_asf( $atts ) {
        if(is_array($atts)) {
            return ( $atts['class'] ) ? ' ' . trim( $atts['class'] ) : '';
        } else {
            return !empty( $atts ) ? ' ' . trim( $atts ) : '';
        }
    }
}


if (!function_exists('msbdc_add_custom_caps')) {
    /**
     *
     */
    function msbdc_add_custom_caps($role, $customCaps=array()) {
        $role = get_role( $role );

        if ( !is_null( $role) ) { // Check role exists
            // Iterate through our custom capabilities, adding them to this role if they are enabled
            foreach ( $customCaps as $capability => $enabled ) {
                if($enabled)
                    $role->add_cap( $capability );
            }
        }
    }
}


if ( !function_exists('msbd_draw_select_box') ) {
    /**
     *
     */
    function msbd_draw_select_box($options, $att, $selVal='') {
        $html = '<select'.msbd_asf($att).'>';

        foreach($options as $i=>$v) {
            if($selVal==$i)
                $html .= '<option value="'.$i.'" selected="selected">'.$v.'</option>';
            else
                $html .= '<option value="'.$i.'">'.$v.'</option>';
        }

        $html .= '</select>';

        return $html;
    }
}

if ( !function_exists('draw_position_select_box') ) {
    /**
     *
     */
    function draw_position_select_box($att, $selVal='') {
        $record = array(
            "after"   => "After",
            "before"     => "Before",
            "both"     => "After and Before"
        );

        $html = '<select '.$att.'>';

        foreach($record as $i=>$v) {
            if($selVal==$i)
                $html .= '<option value="'.$i.'" selected="selected">'.$v.'</option>';
            else
                $html .= '<option value="'.$i.'">'.$v.'</option>';
        }

        $html .= '</select>';

        return $html;
    }
}


if ( !function_exists('draw_yes_no_select_box') ) {
    /**
     *
     */
    function draw_yes_no_select_box($att, $selVal='', $sorting="desc") {
        $record = array(
            "yes"   => "Yes",
            "no"     => "No"
        );

        if($sorting=="asc") {
            ksort($record);
        }

        $html = '<select '.$att.'>';

        foreach($record as $i=>$v) {
            if($selVal==$i)
                $html .= '<option value="'.$i.'" selected="selected">'.$v.'</option>';
            else
                $html .= '<option value="'.$i.'">'.$v.'</option>';
        }

        $html .= '</select>';

        return $html;
    }
}

