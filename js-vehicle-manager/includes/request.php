<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERrequest {
    /*
     * Check Request from both the Get and post method
     */

    static function getVar($variable_name, $method = null, $defaultvalue = null, $typecast = null) {
        $value = null;
        if ($method == null) {
            if (isset($_GET[$variable_name])) {
               if(is_array($_GET[$variable_name])){
                    $value = Self::recursive_sanitize_text_field($_GET[$variable_name]);
                }else{
                    $value = sanitize_text_field($_GET[$variable_name]);
                }
            } elseif (isset($_POST[$variable_name])) {
               if(is_array($_POST[$variable_name])){
                    $value = Self::recursive_sanitize_text_field($_POST[$variable_name]);
                }else{
                    $value = sanitize_text_field($_POST[$variable_name]);
                }
            } elseif (get_query_var($variable_name)) {
                $value = get_query_var($variable_name);
            } elseif (isset(jsvehiclemanager::$_data['sanitized_args'][$variable_name]) && jsvehiclemanager::$_data['sanitized_args'][$variable_name] != '') {
                $value = jsvehiclemanager::$_data['sanitized_args'][$variable_name];
            }
        } else {
            $method = strtolower($method);
            switch ($method) {
                case 'post':
                    if (isset($_POST[$variable_name]))
                        $value = sanitize_text_field($_POST[$variable_name]);
                    break;
                case 'get':
                    if (isset($_GET[$variable_name]))
                        $value = sanitize_text_field($_GET[$variable_name]);
                    break;
            }
        }
        if ($typecast != null) {
            $typecast = strtolower($typecast);
            switch ($typecast) {
                case "int":
                    $value = (int) $value;
                    break;
                case "string":
                    $value = (string) $value;
                    break;
            }
        }
        if ($value == null)
            $value = $defaultvalue;
        //echo print_r($value); exit;
        return $value;
    }

    /*
     * Check Request from both the Get and post method
     */

    static function get($method = null) {
        $array = null;
        if ($method != null) {
            $method = strtolower($method);
            switch ($method) {
                case 'post':
                    $array = Self::recursive_sanitize_text_field($_POST);
                    break;
                case 'get':
                    $array = Self::recursive_sanitize_text_field($_GET);
                    break;
            }
        }
        return $array;
    }

    /*
     * Check Request from both the Get and post method
     */

    static function getLayout($layout, $method , $defaultvalue) {
        $layoutname = null;
        if ($method != null) {
            $method = strtolower($method);
            switch ($method) {
                case 'post':
                    $layoutname = sanitize_text_field($_POST[$layout]);
                    break;
                case 'get':
                    $layoutname = sanitize_text_field($_GET[$layout]);
                    break;
            }
        } else {
            if (isset($_POST[$layout]))
                $layoutname = sanitize_text_field($_POST[$layout]);
            elseif (isset($_GET[$layout]))
                $layoutname = sanitize_text_field($_GET[$layout]);
            elseif (get_query_var($layout))
                $layoutname = get_query_var($layout);
            elseif (isset(jsvehiclemanager::$_data['sanitized_args'][$layout]) && jsvehiclemanager::$_data['sanitized_args'][$layout] != '')
                $layoutname = jsvehiclemanager::$_data['sanitized_args'][$layout];
        }
        if ($layoutname == null) {
            $layoutname = $defaultvalue;
        }
        if (is_admin()) {
            $layoutname = 'admin_' . $layoutname;
        }
        return $layoutname;
    }
    static function recursive_sanitize_text_field($array) {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = Self::recursive_sanitize_text_field($value);
            }
            else {
                $value = sanitize_text_field( $value );
            }
        }

        return $array;
    }

}

?>