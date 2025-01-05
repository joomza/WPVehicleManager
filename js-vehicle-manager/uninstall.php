<?php

/**
 * WP Vehicle Manager
 *
 * Uninstalling WP Vehicle Manager tables, and pages.
 *
 * @author 		Ahmed Bilal
 * @category 	Core
 * @package 	WP Vehicle Manager/Uninstaller
 * @version     1.0.3
 */
if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();
global $wpdb;
include_once 'includes/deactivation.php';
if(function_exists('is_multisite') && is_multisite()){
	$blogs = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    foreach($blogs as $blog_id){
        switch_to_blog( $blog_id );
		$tablestodrop = JSVEHICLEMANAGERdeactivation::jsvehiclemanager_tables_to_drop();
        foreach($tablestodrop as $tablename){
            $wpdb->query( "DROP TABLE IF EXISTS ".$tablename );
        }
        restore_current_blog();
    }
}else{
	$tablestodrop = JSVEHICLEMANAGERdeactivation::jsvehiclemanager_tables_to_drop();
	foreach($tablestodrop as $tablename){
        $wpdb->query( "DROP TABLE IF EXISTS ".$tablename );
    }
}
