<?php
/* Update for custom plugins by joomsky */
class JSVM_Updater {

	private $api_key = '';
	private $addon_update_data = array();
	private $addon_update_data_errors = array();
	public $addon_installed_array = '';// it is public static bcz it is being used in extended class

	public $addon_installed_version_data = '';// it is public static bcz it is being used in extended class

	public function __construct() {
		$this->jsUpdateIntilized();

		$transaction_key_array = array();
		$addon_installed_array = array();
		foreach (jsvehiclemanager::$_active_addons AS $addon) {
			$addon_installed_array[] = 'js-vehicle-manager-'.$addon;
			$option_name = 'transaction_key_for_js-vehicle-manager-'.$addon;
			// $transaction_key = get_option($option_name);
			$transaction_key = $GLOBALS['wpdb']->get_var( "SELECT `option_value` FROM " . jsvehiclemanager::$_wpprefixforuser . "options WHERE option_name = '$option_name'");
			if(!in_array($transaction_key, $transaction_key_array)){
				$transaction_key_array[] = $transaction_key;
			}
		}
		$this->addon_installed_array = $addon_installed_array;
		$this->api_key = json_encode($transaction_key_array);
	}

	// class constructor triggers this function. sets up intail hooks and filters to be used.
	public function jsUpdateIntilized(  ) {
		add_action( 'admin_init', array( $this, 'jsAdminIntilization' ) );
		include_once( 'class-js-server-calls.php' );
	}

	// admin init hook triggers this fuction. sets up admin specific hooks and filter
	public function jsAdminIntilization() {

		add_filter( 'site_transient_update_plugins', array( $this, 'jsCheckVersionUpdate' ) );

		add_filter( 'plugins_api', array( $this, 'jsPluginsAPI' ), 10, 3 );

		if ( current_user_can( 'update_plugins' ) ) {
			$this->jsCheckTriggers();
			add_action( 'admin_notices', array( $this, 'jsCheckUpdateNotice' ) );
			add_action( 'after_plugin_row', array( $this, 'jsKeyInput' ) );
		}
	}

	public function jsKeyInput( $file ) {
		$file_array = explode('/', $file);
		$addon_slug = $file_array[0];
		if(strstr($addon_slug, 'js-vehicle-manager-')){
			$addon_name = str_replace('js-vehicle-manager-', '', $addon_slug);
			if(isset($this->addon_update_data[$file]) || !in_array($addon_name, jsvehiclemanager::$_active_addons)){ // Only checking which addon have update version
				$option_name = 'transaction_key_for_js-vehicle-manager-'.$addon_name;
				// $transaction_key = get_option($option_name);
				$transaction_key = $GLOBALS['wpdb']->get_var( "SELECT `option_value` FROM " . jsvehiclemanager::$_wpprefixforuser . "options WHERE option_name = '$option_name'");
				$verify_results = JSVEHICLEMANAGERincluder::getJSModel('premiumplugin')->activate( array(
		            'token'    => $transaction_key,
		            'plugin_slug'    => $addon_name
		        ) );

		        if(isset($verify_results['verfication_status']) && $verify_results['verfication_status'] == 0){
		        	$updateaddon_slug = str_replace("-", " ", $addon_slug);
		        	$message = strtoupper( substr( $updateaddon_slug, 0, 2 ) ).substr(  ucwords($updateaddon_slug), 2 ) .' authentication failed. Please insert valid key for authentication.';
		        	if(isset($this->addon_update_data[$file])){
		        		$message = 'There is new version of '. strtoupper( substr( $updateaddon_slug, 0, 2 ) ).substr(  ucwords($updateaddon_slug), 2 ) .' avaible. Please insert valid activation key for updation.';
		        		remove_action('after_plugin_row_'.$file,'wp_plugin_update_row');
					}
		        	include( 'views/html-key-input.php' );
		        	echo '
					<tr>
						<td class="plugin-update plugin-update colspanchange" colspan="3">
							<div class="update-message notice inline notice-error notice-alt"><p>'. $message .'</p></div>
						</td>
					</tr>';
		        }
			}
		}
	}

	public function jsCheckVersionUpdate( $update_data ) {
		if ( empty( $update_data->checked ) ) {
			return $update_data;
		}
		$response_version_data = get_transient('jsvm_addon_update_temp_data');

		if(isset($_SERVER) &&  $_SERVER['REQUEST_URI'] !=''){
            if(strstr( $_SERVER['REQUEST_URI'], 'plugins.php')) {
				$response_version_data = get_transient('jsvm_addon_update_temp_data_plugins');
			 }
        }

        if($response_version_data === false){
			$response = $this->getPluginVersionData();
			set_transient('jsvm_addon_update_temp_data', $response, HOUR_IN_SECONDS * 6);
			set_transient('jsvm_addon_update_temp_data_plugins', $response, 15);
		}else{
			$response = $response_version_data;
		}
		if ( $response) {
			if(is_object($response) ){
				if(isset($response->addon_response_type) && $response->addon_response_type == 'no_key'){
					foreach ($update_data->checked AS $key => $value) {
						$c_key_array = explode('/', $key);
						$c_key = $c_key_array[0];
						if(isset($response->addon_version_data->{$c_key})){
							if(version_compare( $response->addon_version_data->{$c_key}, $value, '>' )){
								$transient_val = get_transient('jsvm_addon_hide_update_notice');
								if($transient_val === false){
									set_transient('jsvm_addon_hide_update_notice', 1, DAY_IN_SECONDS );
								}
								$this->addon_update_data[$key] = $response->addon_version_data->{$c_key};
							}
						}
					}
				}else{// addon_response_type other than no_key
					foreach ($update_data->checked AS $key => $value) {
						$c_key_array = explode('/', $key);
						$c_key = $c_key_array[0];
						if(isset($response->addon_update_data) && !empty($response->addon_update_data) && isset( $response->addon_update_data->{$c_key})){
							if(version_compare( $response->addon_update_data->{$c_key}->new_version, $value, '>' )){
								$update_data->response[ $key ] = $response->addon_update_data->{$c_key};
								$this->addon_update_data[$key] = $response->addon_update_data->{$c_key};
							}
						}elseif(isset($response->addon_version_data->{$c_key})){
							if(version_compare( $response->addon_version_data->{$c_key}, $value, '>' )){
								$transient_val = get_transient('jsvm_addon_hide_update_expired_key_notice');
								if($transient_val === false){
									set_transient('jsvm_addon_hide_update_expired_key_notice', 1, DAY_IN_SECONDS );
								}
								$this->addon_update_data_errors[$key] = $response->addon_version_data->{$c_key};
								$this->addon_update_data[$key] = $response->addon_version_data->{$c_key};
							}
						}
					}
				}
			}
		}
		if(isset($update_data->checked)){
			$this->addon_installed_version_data = $update_data->checked;
		}
		return $update_data;
	}

	public function jsPluginsAPI( $false, $action, $args ) {

		if (!isset( $args->slug )) {
			return false;
		}

		if(strstr($args->slug, 'js-vehicle-manager-')){
			$response = $this->jsGetPluginInfo($args->slug);
			if ($response) {
				$response->sections = json_decode(json_encode($response->sections),true);
				$response->banners = json_decode(json_encode($response->banners),true);
				$response->contributors = json_decode(json_encode($response->contributors),true);
				// echo '<pre>';print_r($response);exit;
				return $response;
			}
		}else{
			return false;// to handle the case of plugins that need to check version data from wordpress repositry.
		}
	}

	public function jsGetPluginInfo($addon_slug) {

		$option_name = 'transaction_key_for_'.$addon_slug;
		// $transaction_key = get_option($option_name);
		$transaction_key = $GLOBALS['wpdb']->get_var( "SELECT `option_value` FROM " . jsvehiclemanager::$_wpprefixforuser . "options WHERE option_name = '$option_name'");

		if(!$transaction_key){
			die('transient');
			return false;
		}

		$plugin_file_path = ABSPATH.'wp-content/plugins/'.$addon_slug.'/'.$addon_slug.'.php';
		$plugin_data = get_plugin_data($plugin_file_path);

		$response = jsvmServerCalls::jsvmPluginInformation( array(
			'plugin_slug'    => $addon_slug,
			'version'        => $plugin_data['Version'],
			'token'    => $transaction_key,
			// 'domain'          => site_url()
			'domain'          => network_site_url()
		) );

		if ( isset( $response->errors ) ) {
			$this->handle_errors( $response->errors );
		}

		// If everything is okay return the $response
		if ( isset( $response ) && is_object( $response ) && $response !== false ) {
			return $response;
		}

		return false;
	}

	// does changes according to admin triggers.
	private function jsCheckTriggers() {

		if ( isset($_POST['jsvm_addon_array_for_token']) && ! empty( $_POST[ 'jsvm_addon_array_for_token' ])){
			$transaction_key = '';
			$addon_name = '';
			foreach ($_POST['jsvm_addon_array_for_token'] as $key => $value) {
				if(isset($_POST[$value.'_transaction_key']) && $_POST[$value.'_transaction_key'] != ''){
					$transaction_key = $_POST[$value.'_transaction_key'];
					$addon_name = $value;
					break;
				}
			}
			if($transaction_key != ''){
				$token = $this->jsvmGetTokenFromTransactionKey( $transaction_key,$addon_name);
				if($token){
					foreach ($_POST['jsvm_addon_array_for_token'] as $key => $value) {
						update_option('transaction_key_for_'.$value,$token);
					}
				}else{
					$vtext = __('Somthing went wrong','js-vehicle-manager');
					update_option( 'jsvm-addon-key-error-message', $vtext);
				}
			}
		}else{
			foreach ($this->addon_installed_array as $key) {
				if ( ! empty( $_GET[ 'dismiss-jsvm-addon-update-notice-'.$key] ) ) {
					set_transient('dismiss-jsvm-addon-update-notice-'.$key, 1, DAY_IN_SECONDS );
				}
			}
		}
	}

	public function jsCheckUpdateNotice( $file ) {
		include_once( 'views/html-update-availble.php' );
		// if ( sizeof( $this->errors ) === 0 && ! get_option( $this->plugin_slug . '_hide_update_notice' ) ) {
		// }
	}

	public function getPluginVersionData() {
			$response = jsvmServerCalls::jsvmPluginUpdateCheck($this->api_key);

			if ( isset( $response->errors ) ) {
				$this->jsHandleErrors( $response->errors );
			}

			// Set version variables
			if ( isset( $response ) && is_object( $response ) && $response !== false ) {
				return $response;
			}
		return false;
	}

	public function getPluginLatestVersionData() {
		$response = jsvmServerCalls::jsvmGetLatestVersions();
		// Set version variables
		if ( isset( $response ) && is_array( $response ) && $response !== false ) {
			return $response;
		}
		return false;
	}

	public function jsvmGetTokenFromTransactionKey($transaction_key,$addon_name) {
		$response = jsvmServerCalls::jsvmGenerateToken($transaction_key,$addon_name);
		// Set version variables
		if (is_array($response) && isset($response['verfication_status']) && $response['verfication_status'] == 1 ) {
			return $response['token'];
		}else{
			$error_message = __('Somthing went wrong','js-vehicle-manager');
			if(is_array($response) && isset($response['error'])){
				$error_message = $response['error'];
			}
			update_option( 'jsvm-addon-key-error-message', $error_message);
		}
		return false;
	}
}
?>
