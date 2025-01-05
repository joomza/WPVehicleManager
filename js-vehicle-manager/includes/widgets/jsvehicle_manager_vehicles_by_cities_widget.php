<?php
/*
 * Widget Car Manager Footer Vehicle Images
 */

class js_vehicle_manager_vehicles_by_cities_widget extends WP_Widget {

	
	/* ---------------------------------------------------------------------------
	 * Constructor
	 * --------------------------------------------------------------------------- */
	function __construct(){
		$widget_ops = array( 'classname' => 'jsvm_widget_vehicles_by_cities_widget', 'description' => esc_html__( 'Show vehicles by cities', 'js-vehicle-manager' ) );
		parent::__construct( 'widget_js_vehicle_manager_vehicles_by_cities_widget_options', esc_html__( 'WP Vehicle Manager Vehicles By Cities', 'js-vehicle-manager' ), $widget_ops );
		$this->alt_option_name = 'widget_js_vehicle_manager_vehicles_by_cities_widget_options';
	}
	
	
	/* ---------------------------------------------------------------------------
	 * Outputs the HTML for this widget.
	 * --------------------------------------------------------------------------- */
	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		extract( $args, EXTR_SKIP );
		echo wp_kses($before_widget, JSVEHICLEMANAGER_ALLOWED_TAGS);

    	$instance['jsvehiclemanagerpageid'] = jsvehiclemanager::getPageid();
		
		$cities = JSVEHICLEMANAGERincluder::getJSModel('city')->getVehiclebyCitiesForWidget($instance['numberofcities']);
    	$mod = 'vehiclesbycities';
    	$layoutName = $mod . uniqid();

    	//echo '<pre>';print_r($cities);echo '</pre>';exit();
		$html = JSVEHICLEMANAGERincluder::getJSModel('widget')->getVehiclesByCitiesWidgetHTMl($cities,$instance['jsvehiclemanagerpageid'],$instance['heading'],$instance['description'],$instance['number_of_columns'],$layoutName);

		echo wp_kses($html, JSVEHICLEMANAGER_ALLOWED_TAGS);

		echo wp_kses($after_widget, JSVEHICLEMANAGER_ALLOWED_TAGS);
	}


	/* ---------------------------------------------------------------------------
	 * Deals with the settings when they are saved by the admin.
	 * --------------------------------------------------------------------------- */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['heading'] = strip_tags ($new_instance['heading']);
		$instance['description'] = strip_tags( $new_instance['description'] );
		//$instance['shownumberofvehiclespercity'] = (int) $new_instance['shownumberofvehiclespercity'];
		$instance['number_of_columns'] = (int) $new_instance['number_of_columns'];
		$instance['numberofcities'] = (int) $new_instance['numberofcities'];
		
		return $instance;
	}

	
	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {
		
		$heading = isset( $instance['heading']) ? esc_attr( $instance['heading'] ) : esc_html__('Vehicles By Cities','js-vehicle-manager');
		$description = isset( $instance['description']) ? esc_attr( $instance['description'] ) : '';
		//$shownumberofvehiclespercity = isset( $instance['shownumberofvehiclespercity'] ) ? absint( $instance['shownumberofvehiclespercity'] ) : 1;
		$number_of_columns = isset( $instance['number_of_columns'] ) ? absint( $instance['number_of_columns'] ) : 3;
		$numberofcities = isset( $instance['numberofcities'] ) ? absint( $instance['numberofcities'] ) : 6;
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php _e( 'heading', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>" />
			</p>
			
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'description', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
			</p>
			<?php /*
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'shownumberofvehiclespercity' ) ); ?>"><?php _e( 'Type Of Vehicles', 'js-vehicle-manager' ); ?>:</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'shownumberofvehiclespercity' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'shownumberofvehiclespercity' ) ); ?>" >
					<option value="1" <?php echo ( $shownumberofvehiclespercity == 1 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Latest vehicles','js-vehicle-manager'); ?></option>
					<option value="2" <?php echo ( $shownumberofvehiclespercity == 2 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Featured vehicles','js-vehicle-manager'); ?></option>
				</select>
			</p>
			*/?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_columns' ) ); ?>"><?php _e( 'Number of Columns', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_of_columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_columns' ) ); ?>" type="text" value="<?php echo esc_attr( $number_of_columns ); ?>" size="3"/>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'numberofcities' ) ); ?>"><?php _e( 'Number of Vehicles', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'numberofcities' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'numberofcities' ) ); ?>" type="text" value="<?php echo esc_attr( $numberofcities ); ?>" size="3"/>
			</p>
			
		<?php
	}
}
?>
