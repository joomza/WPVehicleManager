<?php
/*
 * Widget Car Manager Footer Vehicle Images
 */

class js_vehicle_manager_vehicles_widget extends WP_Widget {


	/* ---------------------------------------------------------------------------
	 * Constructor
	 * --------------------------------------------------------------------------- */
	function __construct(){
		$widget_ops = array( 'classname' => 'jsvm_widget_vehicles_widget', 'description' => esc_html__( 'Show vehicle.', 'js-vehicle-manager' ) );
		parent::__construct( 'widget_js_vehicle_manager_vehicles_widget_options', esc_html__( 'WP Vehicle Manager Vehicles', 'js-vehicle-manager' ), $widget_ops );
		$this->alt_option_name = 'widget_js_vehicle_manager_vehicles_widget_options';
	}


	/* ---------------------------------------------------------------------------
	 * Outputs the HTML for this widget.
	 * --------------------------------------------------------------------------- */
	function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) $args['widget_id'] = null;
		extract( $args, EXTR_SKIP );
		echo wp_kses($before_widget, JSVEHICLEMANAGER_ALLOWED_TAGS);

		$vehicles = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getVehiclesWidgetData($instance['typeofvehicles'], $instance['numberofvehicles']);

		$mod = 'latestvehicles';
    	if ($instance['typeofvehicles'] == 2) {
    	    $mod = 'featuredvehicles';
    	}
    	$layoutName = $mod . uniqid();
    	$instance['jsvehiclemanagerpageid'] = jsvehiclemanager::getPageid();
		$html = JSVEHICLEMANAGERincluder::getJSModel('widget')->getVehiclesWidgetHTMl($vehicles,$instance['jsvehiclemanagerpageid'],$instance['heading'],$instance['description'],$instance['number_of_columns'],$layoutName);
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
		$instance['typeofvehicles'] = (int) $new_instance['typeofvehicles'];
		$instance['number_of_columns'] = (int) $new_instance['number_of_columns'];
		$instance['numberofvehicles'] = (int) $new_instance['numberofvehicles'];

		return $instance;
	}


	/* ---------------------------------------------------------------------------
	 * Displays the form for this widget on the Widgets page of the WP Admin area.
	 * --------------------------------------------------------------------------- */
	function form( $instance ) {

		$heading = isset( $instance['heading']) ? esc_attr( $instance['heading'] ) : esc_html__('Latest Vehicles','js-vehicle-manager');
		$description = isset( $instance['description']) ? esc_attr( $instance['description'] ) : '';
		$typeofvehicles = isset( $instance['typeofvehicles'] ) ? absint( $instance['typeofvehicles'] ) : 1;
		$number_of_columns = isset( $instance['number_of_columns'] ) ? absint( $instance['number_of_columns'] ) : 1;
		$numberofvehicles = isset( $instance['numberofvehicles'] ) ? absint( $instance['numberofvehicles'] ) : 6;
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>"><?php _e( 'heading', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'heading' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'heading' ) ); ?>" type="text" value="<?php echo esc_attr( $heading ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"><?php _e( 'description', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>" />
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'typeofvehicles' ) ); ?>"><?php _e( 'Type Of Vehicles', 'js-vehicle-manager' ); ?>:</label>
				<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'typeofvehicles' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'typeofvehicles' ) ); ?>" >
					<option value="1" <?php echo ( $typeofvehicles == 1 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Latest vehicles','js-vehicle-manager'); ?></option>
					<option value="2" <?php echo ( $typeofvehicles == 2 ) ? 'selected="selected"' : false; ?>><?php echo esc_html__('Featured vehicles','js-vehicle-manager'); ?></option>
				</select>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'number_of_columns' ) ); ?>"><?php _e( 'Number of Columns', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number_of_columns' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number_of_columns' ) ); ?>" type="text" value="<?php echo esc_attr( $number_of_columns ); ?>" size="3"/>
			</p>

			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'numberofvehicles' ) ); ?>"><?php _e( 'Number of Vehicles', 'js-vehicle-manager' ); ?>:</label>
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'numberofvehicles' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'numberofvehicles' ) ); ?>" type="text" value="<?php echo esc_attr( $numberofvehicles ); ?>" size="3"/>
			</p>

		<?php
	}
}
?>
