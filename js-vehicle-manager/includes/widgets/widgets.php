<?php

	// Add widgets files
	include_once( 'jsvehicle_manager_vehicles_by_cities_widget.php');
	include_once( 'jsvehicle_manager_vehicles_widget.php');
	include_once( 'jsvehicle_manager_pages_widget.php');

	function js_vehicle_manager_register_widgets(){
		register_widget('js_vehicle_manager_vehicles_widget');
		register_widget('js_vehicle_manager_vehicles_by_cities_widget');
		register_widget('js_vehicle_manager_pages_widget');
	}

	add_action('widgets_init','js_vehicle_manager_register_widgets');
?>
