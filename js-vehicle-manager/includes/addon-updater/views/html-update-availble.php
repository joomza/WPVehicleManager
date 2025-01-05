<?php
if(!empty($this->addon_installed_array)){
	$new_transient_flag = 0;
	//delete_transient('jsvm_addon_update_flag');
	$response = get_transient('jsvm_addon_update_flag');
	if(!$response){
		$response = $this->getPluginLatestVersionData();
		set_transient('jsvm_addon_update_flag',$response,HOUR_IN_SECONDS * 6);
		$new_transient_flag = 1;
	}
	if(!empty($response)){
		foreach ($this->addon_installed_array as $addon) {
			$response_ver_check = str_replace('-', '', $addon);
			if(!isset($response[$response_ver_check])){
				continue;
			}
			$plugin_file_path = ABSPATH.'wp-content/plugins/'.$addon.'/'.$addon.'.php';

			$plugin_data = get_plugin_data($plugin_file_path);
			$transient_val = get_transient('dismiss-jsvm-addon-update-notice-'.$addon);
			if($new_transient_flag == 1){
				delete_transient('dismiss-jsvm-addon-update-notice-'.$addon);
			}
			if(!$transient_val){
				if (version_compare( $response[$response_ver_check], $plugin_data['Version'], '>' ) ) { ?>
					<div class="updated">
						<p class="wpjm-updater-dismiss" style="float:right;"><a href="<?php echo esc_url( add_query_arg( 'dismiss-jsvm-addon-update-notice-' . sanitize_title( $addon ), '1' ) ); ?>"><?php _e( 'Hide notice' ); ?></a></p>
						<p><?php printf( '<a href="%s">New Version is avaible</a> for "%s".', admin_url('plugins.php'), esc_html( $plugin_data['Name'] ) ); ?></p>
					</div>
				<?php }
			}
		}
	}

}

if(get_option( 'jsvm-addon-key-error-message', '' ) != ''){
	echo '<div class="notice notice-error is-dismissible"><p>'. get_option( 'jsvm-addon-key-error-message') .'</p></div>';
	delete_option( 'jsvm-addon-key-error-message' );
}
?>
