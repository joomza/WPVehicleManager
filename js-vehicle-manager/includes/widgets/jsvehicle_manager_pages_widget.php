<?php
/*
 * Widget Car Manager Footer Vehicle Images
 */

class js_vehicle_manager_pages_widget extends WP_Widget {

	
	/* ---------------------------------------------------------------------------
	 * Constructor
	 * --------------------------------------------------------------------------- */
	function __construct(){
		$widget_ops = array( 'classname' => 'jsvm_widget_pages_widget', 'description' => esc_html__( 'Vehicle Manager Pages', 'js-vehicle-manager' ) );
		parent::__construct( 'widget_js_vehicle_manager_pages_widget_options', esc_html__( 'WP Vehicle Manager Pages', 'js-vehicle-manager' ), $widget_ops );
		$this->alt_option_name = 'widget_js_vehicle_manager_pages_widget_options';
	}
	
	
	/* ---------------------------------------------------------------------------
	 * Outputs the HTML for this widget.
	 * --------------------------------------------------------------------------- */
	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		extract( $args, EXTR_SKIP );
		echo wp_kses($before_widget, JSVEHICLEMANAGER_ALLOWED_TAGS);

		$mod = "vehiclemanagerpages";
		switch ($instance['vehiclemanagerpages']) {
			case 1:
				$shortcode = '[jsvehiclemanager_list_vehicles]';
				break;
			case 2:
				$shortcode = '[jsvehiclemanager_vehicle_search]';
				break;
			case 3:
				$shortcode = '[jsvehiclemanager_add_vehicle]';
				break;	
			case 4:
				$shortcode = '[jsvehiclemanager_my_vehicles]';
				break;	
			case 5:
				$shortcode = '[jsvehiclemanager_control_panel]';
				break;	
			case 6:
				$shortcode = '[jsvehiclemanager_compare_vehicles]';
				break;
			case 7:
				$shortcode = '[jsvehiclemanager_shortlisted_vehicles]';
				break;
			case 8:
				$shortcode = '[jsvehiclemanager_vehicles_by_city]';
				break;
			case 9:
				$shortcode = '[jsvehiclemanager_vehicles_by_type]';
				break;
			case 10:
				$shortcode = '[jsvehiclemanager_vehicles_by_make]';
				break;
			case 11:
				$shortcode = '[jsvehiclemanager_sellers_list]';
				break;
			case 12:
				$shortcode = '[jsvehiclemanager_sellers_by_city]';
				break;
			case 13:
				$shortcode = '[jsvehiclemanager_credits_pack]';
				break;
			case 14:
				$shortcode = '[jsvehiclemanager_credits_rate_list]';
				break;
			case 15:
				$shortcode = '[jsvehiclemanager_purchase_history]';
				break;
			case 16:
				$shortcode = '[jsvehiclemanager_credits_log]';
				break;
			case 17:
				$shortcode = '[jsvehiclemanager_vehicle_alerts]';
				break;
			case 18:
				$shortcode = '[jsvehiclemanager_login]';
				break;
			default:
				$shortcode = '[jsvehiclemanager_list_vehicles]';
				break;
		}
		$layoutName = $mod . uniqid();
    	$instance['jsvehiclemanagerpageid'] = jsvehiclemanager::getPageid();
        echo wp_kses($shortcode, JSVEHICLEMANAGER_ALLOWED_TAGS);
		echo wp_kses($after_widget, JSVEHICLEMANAGER_ALLOWED_TAGS);
	}


	/* ---------------------------------------------------------------------------
	 * Deals with the settings when they are saved by the admin.
	 * --------------------------------------------------------------------------- */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['vehiclemanagerpages'] = (int) $new_instance['vehiclemanagerpages'];
		return $instance;
	}

	
	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {
		
		$vehiclemanagerpages = isset( $instance['vehiclemanagerpages'] ) ? absint( $instance['vehiclemanagerpages'] ) : 1;
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'vehiclemanagerpages' ) ); ?>"><?php _e( 'Vehicle Manager Pages', 'js-vehicle-manager' ); ?>:</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vehiclemanagerpages' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vehiclemanagerpages' ) ); ?>" >
					<option value="1" <?php echo ( $vehiclemanagerpages == 1 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('List Vehicle','js-vehicle-manager'); ?></option>
					<option value="2" <?php echo ( $vehiclemanagerpages == 2 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Vehicle Search','js-vehicle-manager'); ?></option>
					<option value="3" <?php echo ( $vehiclemanagerpages == 3 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Add Vehicle','js-vehicle-manager'); ?></option>
					<option value="4" <?php echo ( $vehiclemanagerpages == 4 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('My Vehicles','js-vehicle-manager'); ?></option>
					<option value="5" <?php echo ( $vehiclemanagerpages == 5 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Control Panel','js-vehicle-manager'); ?></option>
					<option value="6" <?php echo ( $vehiclemanagerpages == 6 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Comapre Vehicles','js-vehicle-manager'); ?></option>
					<option value="7" <?php echo ( $vehiclemanagerpages == 7 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Shortlisted Vehicles','js-vehicle-manager'); ?></option>
					<option value="8" <?php echo ( $vehiclemanagerpages == 8 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Vehicles By City','js-vehicle-manager'); ?></option>
					<option value="9" <?php echo ( $vehiclemanagerpages == 9 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Vehicles By Type','js-vehicle-manager'); ?></option>
					<option value="10" <?php echo ( $vehiclemanagerpages == 10 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Vehicles By Make','js-vehicle-manager'); ?></option>
					<option value="11" <?php echo ( $vehiclemanagerpages == 11 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Sellers List','js-vehicle-manager'); ?></option>
					<option value="12" <?php echo ( $vehiclemanagerpages == 12 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Sellers By City','js-vehicle-manager'); ?></option>
					<option value="13" <?php echo ( $vehiclemanagerpages == 13 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Credits Pack','js-vehicle-manager'); ?></option>
					<option value="14" <?php echo ( $vehiclemanagerpages == 14 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Credits Rate List','js-vehicle-manager'); ?></option>
					<option value="15" <?php echo ( $vehiclemanagerpages == 15 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Purchase History','js-vehicle-manager'); ?></option>
					<option value="16" <?php echo ( $vehiclemanagerpages == 16 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Credits Log','js-vehicle-manager'); ?></option>
					<option value="17" <?php echo ( $vehiclemanagerpages == 17 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Vehicle Alert','js-vehicle-manager'); ?></option>
					<option value="18" <?php echo ( $vehiclemanagerpages == 18 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Login','js-vehicle-manager'); ?></option>
				</select>
			</p>
		<?php
	}
}
?>
