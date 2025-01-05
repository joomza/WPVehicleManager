<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVEHICLEMANAGERdeactivation {

    static function jsvehiclemanager_deactivate() {
        wp_clear_scheduled_hook('jsvehiclemanager_cronjobs_action');
        $id = jsvehiclemanager::getPageid();
        $db = new jsvehiclemanagerdb();
        $query = "UPDATE `#__posts` SET post_status = 'draft' WHERE ID = " . $id;
        $db->setQuery($query);
        $db->query();

        //Delete capabilities
        $role = get_role( 'administrator' );
        $role->remove_cap( 'jsvm_vehicle_manager' );
    }

    static function jsvehiclemanager_tables_to_drop() {
        global $wpdb;
        $tables = array(
           $wpdb->prefix."js_vehiclemanager_activitylog",
           $wpdb->prefix."js_vehiclemanager_adexpiries",
           $wpdb->prefix."js_vehiclemanager_cities",
           $wpdb->prefix."js_vehiclemanager_conditions",
           $wpdb->prefix."js_vehiclemanager_config",
           $wpdb->prefix."js_vehiclemanager_countries",
           $wpdb->prefix."js_vehiclemanager_currencies",
           $wpdb->prefix."js_vehiclemanager_cylinders",
           $wpdb->prefix."js_vehiclemanager_emailtemplates",
           $wpdb->prefix."js_vehiclemanager_emailtemplates_config",
           $wpdb->prefix."js_vehiclemanager_fieldsordering",
           $wpdb->prefix."js_vehiclemanager_fueltypes",
           $wpdb->prefix."js_vehiclemanager_makes",
           $wpdb->prefix."js_vehiclemanager_mileages",
           $wpdb->prefix."js_vehiclemanager_models",
           $wpdb->prefix."js_vehiclemanager_modelyears",
           $wpdb->prefix."js_vehiclemanager_users",
           $wpdb->prefix."js_vehiclemanager_states",
           $wpdb->prefix."js_vehiclemanager_system_errors",
           $wpdb->prefix."js_vehiclemanager_transmissions",
           $wpdb->prefix."js_vehiclemanager_vehicleimages",
           $wpdb->prefix."js_vehiclemanager_vehicles",
           $wpdb->prefix."js_vehiclemanager_vehicletypes",
           $wpdb->prefix."js_vehiclemanager_zip",
           $wpdb->prefix."js_vehiclemanager_jsvmsessiondata",
        );
        return $tables;
    }

}

?>
