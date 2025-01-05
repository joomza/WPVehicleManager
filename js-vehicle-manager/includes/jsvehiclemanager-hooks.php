<?php
if (!defined('ABSPATH'))
    die('Restricted Access');


// Updates login failed to send user back to the custom form with a query var
add_action( 'wp_login_failed', 'jsvehiclemanager_login_failed', 10, 2 );
// Updates authentication to return an error when one field or both are blank
add_filter( 'authenticate', 'jsvehiclemanager_authenticate_username_password', 30, 3);

function jsvehiclemanager_login_failed( $username ){
    $referrer = wp_get_referer();
    if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer, 'wp-admin') ){
        if (isset($_POST['wp-submit'])){
            $msgkey = JSVEHICLEMANAGERincluder::getJSModel('jsvehiclemanager')->getMessagekey();
            JSVEHICLEMANAGERmessages::setLayoutMessage(__("Username / password is incorrect","js-vehicle-manager"), 'error' ,$msgkey);
            wp_redirect(jsvehiclemanager::makeUrl(array('jsvmme'=>'jsvehiclemanager', 'jsvmlt'=>'login','jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid())));
            exit;
        }else{
            return;
        }
    }
}

function jsvehiclemanager_authenticate_username_password( $user, $username, $password ){
    if ( is_a($user, 'WP_User') ) {
        return $user;
    }
    if (isset($_POST['wp-submit']) && (empty($_POST['pwd']) || empty($_POST['log']))){
        return false;
    }
    return $user;
}



add_action('admin_head', 'jsvehiclemanager_custom_css_add');

function jsvehiclemanager_custom_css_add() {
    echo '<link rel="stylesheet" href="' . JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/adminmenu.css' . '" type="text/css" media="all" />';
}

// --------------------------Colorpickers for widgets--------
// load colorpicker scripts
add_action('admin_enqueue_scripts', 'jsvm_my_custom_load');

function jsvm_my_custom_load() {
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    //our styles
    wp_enqueue_style('jsvehiclemanager-widgetscss', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jsvehiclemanager_widgets.css');
    // wp_enqueue_script('jsvehiclemanager-widgetsjs', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/jsvehiclemanager_widgets.js');
}

// --------Tiny mce buttons--------


foreach ( array('post.php','post-new.php') as $hook ) {
     add_action( "admin_head-$hook", 'jsvehiclemanager_tinymce_button_lang' );
}

/**
 * Localize Script
 */
function jsvehiclemanager_tinymce_button_lang() {

        $list_pages = '[';
        $pages = get_pages();
        foreach($pages AS $page){
            $list_pages .= "{text: '".addslashes($page->post_title)."' , value : '$page->ID'},";;
        }
        $list_pages .= ']';
    ?>
    <!-- TinyMCE Shortcode Plugin -->
    <script type='text/javascript'>
    var jslang = {
        'main_vmpages_title': '<?php echo __("Vehicle manager pages","js-vehicle-manager"); ?>',
        'main_vmpages_text': '<?php echo __("Vehicle manager pages","js-vehicle-manager"); ?>',
        'window_vmpages_title': '<?php echo __("Create shortcode for","js-vehicle-manager") . ' ' . __("vehicle manager","js-vehicle-manager") . ' ' . __("pages","js-vehicle-manager"); ?>',
        'selectpage': '<?php echo __("Select page","js-vehicle-manager"); ?>',
        'message': '<?php echo __("Message","js-vehicle-manager"); ?>',

        'main_fv_title': '<?php echo __("Featured vehicle","js-vehicle-manager"); ?>',
        'main_fv_text': '<?php echo __("Featured vehicle","js-vehicle-manager"); ?>',
        'window_fv_title': '<?php echo __("Create shortcode for","js-vehicle-manager") . ' ' . __("Featured vehicle","js-vehicle-manager"); ?>',
        'detailpage' : '<?php echo __("Select detail page" , "js-vehicle-manager"); ?>',
        'slidestyle' : '<?php echo __("Sliding style" , "js-vehicle-manager"); ?>',
        'wholeslide' : '<?php echo __("Whole Slide" , "js-vehicle-manager"); ?>',
        'singleslide' : '<?php echo __("Single Slide" , "js-vehicle-manager"); ?>',
        'slidespeed' : '<?php echo __("Slide speed" , "js-vehicle-manager"); ?>',
        'noofvehicles' : '<?php echo __("Number of vehicles" , "js-vehicle-manager"); ?>',
        'noofcities' : '<?php echo __("Number of Cities" , "js-vehicle-manager"); ?>',
        'heading' : '<?php echo __("Heading" , "js-vehicle-manager"); ?>',
        'description' : '<?php echo __("Description" , "js-vehicle-manager"); ?>',

        'box_style' : '<?php echo __("Box Style" , "js-vehicle-manager"); ?>',
        'list_style' : '<?php echo __("List Style" , "js-vehicle-manager"); ?>',


        'main_newv_title' : '<?php echo __("Newest vehicle","js-vehicle-manager"); ?>',
        'main_newv_text' : '<?php echo __("Newest vehicle","js-vehicle-manager"); ?>',
        'window_newv_title' : '<?php echo __("Create shortcode for","js-vehicle-manager") . ' ' . __("newest vehicle","js-vehicle-manager"); ?>',
        'styleone' : '<?php echo __("Style","js-vehicle-manager")." 1"; ?>',
        'styletwo' : '<?php echo __("Style","js-vehicle-manager")." 2"; ?>',
        'stylethree' : '<?php echo __("Style","js-vehicle-manager")." 3"; ?>',
        'stylefour' : '<?php echo __("Style","js-vehicle-manager")." 4"; ?>',

        'main_vsearch_title': '<?php echo __("Vehicle search","js-vehicle-manager"); ?>',
        'main_vsearch_text': '<?php echo __("Vehicle search","js-vehicle-manager"); ?>',
        'window_vsearch_title': '<?php echo __("Create shortcode for","js-vehicle-manager") . ' ' . __("vehicle search","js-vehicle-manager"); ?>',

        'searchvehiclestyle': '<?php echo __("Vehicle search style","js-vehicle-manager"); ?>',
        'title': '<?php echo __("Title","js-vehicle-manager"); ?>',
        'shortdescription': '<?php echo __("Description","js-vehicle-manager"); ?>',
        'backgroundimage': '<?php echo __("Background image","js-vehicle-manager"); ?>',
        'selectbgimage': '<?php echo __("Select background image","js-vehicle-manager"); ?>',
        'selectimage': '<?php echo __("Select image","js-vehicle-manager"); ?>',



        'listvehicles' : '<?php echo __("List Vehicles", "js-vehicle-manager"); ?>',
        'searchvehicles' : '<?php echo __("Search Vehicles", "js-vehicle-manager"); ?>',
        'addvehicle' : '<?php echo __("Add Vehicle", "js-vehicle-manager"); ?>',
        'myvehicles' : '<?php echo __("My Vehicles", "js-vehicle-manager"); ?>',
        'myprofile' : '<?php echo __("My Profile", "js-vehicle-manager"); ?>',
        'comparevehicles' : '<?php echo __("Compare Vehicles", "js-vehicle-manager"); ?>',
        'vehicledetail' : '<?php echo __("Vehicle Detail", "js-vehicle-manager"); ?>',
        'shortlistedvehicles' : '<?php echo __("Shortlisted Vehicles", "js-vehicle-manager"); ?>',
        'vehiclesbycity' : '<?php echo __("Vehicles by City", "js-vehicle-manager"); ?>',
        'sellersbycity' : '<?php echo __("Sellers by City", "js-vehicle-manager"); ?>',
        'vehiclesbytype' : '<?php echo __("Vehicles by Type", "js-vehicle-manager"); ?>',
        'vehiclesbymake' : '<?php echo __("Vehicles by Make", "js-vehicle-manager"); ?>',
        'sellerlist' : '<?php echo __("Seller List", "js-vehicle-manager"); ?>',
        'sellerdetail' : '<?php echo __("Seller Detail", "js-vehicle-manager"); ?>',
        'creditspack' : '<?php echo __("Credits Pack", "js-vehicle-manager"); ?>',
        'creditsratelist' : '<?php echo __("Credits Rate List", "js-vehicle-manager"); ?>',
        'purchasehistory' : '<?php echo __("Purchase History", "js-vehicle-manager"); ?>',
        'creditslog' : '<?php echo __("Credits Log", "js-vehicle-manager"); ?>',
        'vehiclealert' : '<?php echo __("Vehicle alert", "js-vehicle-manager"); ?>',
        'login' : '<?php echo __("Login", "js-vehicle-manager"); ?>',
        'thankyou' : '<?php echo __("Thank you", "js-vehicle-manager"); ?>',

        'main_vehicles_title': '<?php echo __("Vehicles","js-vehicle-manager"); ?>',
        'main_vehicles_text': '<?php echo __("Vehicles","js-vehicle-manager"); ?>',
        'window_vehicles_title': '<?php echo __("Create shortcode for","js-vehicle-manager") . ' ' . __("vehicles","js-vehicle-manager"); ?>',

        'main_vehiclesbycities_title': '<?php echo __("Vehicles By Cities","js-vehicle-manager"); ?>',
        'main_vehiclesbycities_text': '<?php echo __("Vehicles By Cities","js-vehicle-manager"); ?>',
        'window_vehiclesbycities_title': '<?php echo __("Create shortcode for","js-vehicle-manager") . ' ' . __("vehicles By Cities","js-vehicle-manager"); ?>',

        'typeofvehicles' : '<?php echo __("Type Of Vehicles", "js-vehicle-manager"); ?>',
        'latestvehicles' : '<?php echo __("Latest Vehicles", "js-vehicle-manager"); ?>',
        'featuredvehicles' : '<?php echo __("Featured Vehicles", "js-vehicle-manager"); ?>',
        'number_of_columns' : '<?php echo __("Number Of Columns", "js-vehicle-manager"); ?>',

        'one_column' : '<?php echo __("One Column", "js-vehicle-manager"); ?>',
        'two_column' : '<?php echo __("Two Columns", "js-vehicle-manager"); ?>',
        'three_column' : '<?php echo __("Three Columns", "js-vehicle-manager"); ?>',
        'four_column' : '<?php echo __("Four Columns", "js-vehicle-manager"); ?>',
        'five_column' : '<?php echo __("Five Columns", "js-vehicle-manager"); ?>',
        'six_column' : '<?php echo __("Six Columns", "js-vehicle-manager"); ?>',

    };

    var list_vmpages = <?php echo $list_pages; ?>;

    </script>
    <!-- TinyMCE Shortcode Plugin -->
    <?php
}

// add tinyMce custom buttons
add_action('admin_head', 'jsvehiclemanager_add_my_tc_button');

function jsvehiclemanager_add_my_tc_button() {
    global $typenow;
    // check user permissions
    if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
        return;
    }

    // verify the post type
    if (!in_array($typenow, array('post', 'page')))
        return;
    // check if WYSIWYG is enabled
    if (get_user_option('rich_editing') == true) {
        add_filter("mce_external_plugins", "jsvehiclemanager_add_tinymce_plugin");
        add_filter('mce_buttons', 'jsvehiclemanager_register_my_tc_button');
    }
}

function jsvehiclemanager_add_tinymce_plugin($plugin_array) {
    $plugin_array['jsvehiclemanager_vmpages_button'] = JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/editor_vehiclemanagerpages_button.js'; // CHANGE THE BUTTON SCRIPT HERE
    if(jsvehiclemanager::$_car_manager_theme == 1){
        $plugin_array['jsvehiclemanager_featuredvehicles_button'] = JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/cm_editor_featuredvehicles_button.js'; // CHANGE THE BUTTON SCRIPT HERE
        $plugin_array['jsvehiclemanager_newestvehicles_button'] = JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/cm_editor_newestvehicles_button.js'; // CHANGE THE BUTTON SCRIPT HERE
        $plugin_array['jsvehiclemanager_searchvehicles_button'] = JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/cm_editor_searchvehicles_button.js'; // CHANGE THE BUTTON SCRIPT HERE
    }else{
        $plugin_array['jsvehiclemanager_vmvehicles_button'] = JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/editor_vehicles_button.js'; // CHANGE THE BUTTON SCRIPT HERE
        $plugin_array['jsvehiclemanager_vmvehiclesbycities_button'] = JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/editor_vehiclesbycities_button.js'; // CHANGE THE BUTTON SCRIPT HERE
    }

    return $plugin_array;
}

function jsvehiclemanager_register_my_tc_button($buttons) {
    array_push($buttons, "jsvehiclemanager_vmpages_button");
    array_push($buttons, "jsvehiclemanager_vmvehicles_button");
    array_push($buttons, "jsvehiclemanager_vmvehiclesbycities_button");
    array_push($buttons, "jsvehiclemanager_featuredvehicles_button");
    array_push($buttons, "jsvehiclemanager_newestvehicles_button");
    array_push($buttons, "jsvehiclemanager_searchvehicles_button");
    return $buttons;
}
// END Tiny mce


// --------------------------WP registration from fields --------
// 1. wp register form extra field
add_action('register_form', 'jsvehiclemanager_add_registration_fields');

function jsvehiclemanager_add_registration_fields() {
    //to add profile section fields to the regestration form
}

//2. Add validation. In this case, we make sure jobs_role is required
add_filter('registration_errors', 'jsvehiclemanager_registration_errors', 10, 3);

function jsvehiclemanager_registration_errors($errors, $sanitized_user_login, $user_email) {

    if (isset($_POST['jobs_role']) && $_POST['jobs_role'] == 0) {

        $errors->add('user_role_error','<strong>'.__("Error","js-vehicle-manager").'</strong>:'. __('You must set jobs user role', "js-vehicle-manager").'.');
    }

    return $errors;
}

// 3. wp register form extra field get and set to user meta
add_action('user_register', 'jsvehiclemanager_registration_save', 10, 1);

function jsvehiclemanager_registration_save($user_id) {
}

// ------------------- jsjobs registrationFrom request handler--------
// register a new user
function jsvehiclemanager_add_new_member() {
    if (isset($_POST["jsvehiclemanager_user_login"]) && wp_verify_nonce($_POST['jsvehiclemanager_autoz_register_nonce'], 'jsvehiclemanager-autoz-register-nonce')) {

        if(JSVEHICLEMANAGERincluder::getJSModel('user')->captchaValidate() == false){
            jsvehiclemanager_errors()->add('recaptcha_failed', __("Invalid recaptcha answer", "js-vehicle-manager"));
        }

        $user_login = $_POST["jsvehiclemanager_user_login"];
        $user_email = $_POST["jsvehiclemanager_user_email"];
        $user_first = $_POST["jsvehiclemanager_user_first"];
        $user_last = $_POST["jsvehiclemanager_user_last"];
        $user_pass = $_POST["jsvehiclemanager_user_pass"];
        $pass_confirm = $_POST["jsvehiclemanager_user_pass_confirm"];

        // this is required for username checks
        // require_once(ABSPATH . WPINC . '/registration.php');

        if (username_exists($user_login)) {
            // Username already registered
            jsvehiclemanager_errors()->add('username_unavailable', __("Username already taken", "js-vehicle-manager"));
        }
        if (!validate_username($user_login)) {
            // invalid username
            jsvehiclemanager_errors()->add('username_invalid', __("Invalid username", "js-vehicle-manager"));
        }
        if ($user_login == '') {
            // empty username
            jsvehiclemanager_errors()->add('username_empty', __("Please enter a username", "js-vehicle-manager"));
        }
        if (!is_email($user_email)) {
            //invalid email
            jsvehiclemanager_errors()->add('email_invalid', __("Invalid email", "js-vehicle-manager"));
        }
        if (email_exists($user_email)) {
            //Email address already registered
            jsvehiclemanager_errors()->add('email_used', __("Email already registered", "js-vehicle-manager"));
        }
        if ($user_pass == '') {
            // passwords do not match
            jsvehiclemanager_errors()->add('password_empty', __("Please enter a password", "js-vehicle-manager"));
        }
        if ($user_pass != $pass_confirm) {
            // passwords do not match
            jsvehiclemanager_errors()->add('password_mismatch', __("Passwords do not match", "js-vehicle-manager"));
        }

        $errors = jsvehiclemanager_errors()->get_error_messages();

        // only create the user in if there are no errors
        if (empty($errors)) {

            $wperrors = register_new_user(  $user_login,  $user_email );
            $new_user_id = "";
            if (!is_wp_error($wperrors)) {
                $new_user_id = $wperrors;
                if ( $user_first && $user_last ) {
                    $display_name = sprintf( _x( '%1$s %2$s', 'Display name based on first name and last name' ), $user_first, $user_last );
                } elseif ( $user_first ) {
                    $display_name = $user_first;
                } elseif ( $user_last ) {
                    $display_name = $user_last;
                } else {
                    $display_name = $user_login;
                }
                //update_user_option( $new_user_id, 'default_password_nag', false, true );
                wp_set_password( $user_pass, $new_user_id );
                update_user_option( $new_user_id, 'first_name', $user_first, true );
                update_user_option( $new_user_id, 'last_name', $user_last, true );
                wp_update_user( array ('ID' => $new_user_id,  'display_name' => $display_name) ) ;
            } else {
                jsvehiclemanager_errors()->add('email_invalid', __($wperrors->get_error_message(), 'js-vehicle-manager'));
            }


            if ($new_user_id) {
                // send an email to the admin alerting them of the registration
                wp_new_user_notification($new_user_id);
                // log the new user in
                wp_set_current_user($new_user_id, $user_login);
                wp_set_auth_cookie($new_user_id);
                do_action('wp_login', $user_login);
                // insert entry into out db also
                $data = JSVEHICLEMANAGERrequest::get('post');
                $data['uid'] = $new_user_id;
                $data['name'] = $user_first.' '.$user_last;
                $data['email'] = $user_email;
                $data['created'] = date_i18n('Y-m-d H:i:s');
                $data['status'] = 1;
                $data['id'] = '';
                JSVEHICLEMANAGERincluder::getJSModel('user')->storeProfile($data);
                $pageid = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('register_user_redirect_page');
                $url = home_url();
                if(is_page($pageid)){
                    if(get_post_status($pageid) == 'publish'){
                        $url = get_the_permalink($pageid);
                    }
                }
                wp_redirect($url);
                exit;
            }
        }
    }
}

add_action('init', 'jsvehiclemanager_add_new_member');

// used for tracking error messages
function jsvehiclemanager_errors() {
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

// displays error messages from form submissions
function jsvehiclemanager_show_error_messages() {
    if ($codes = jsvehiclemanager_errors()->get_error_codes()) {
        echo '<div class="jsvehiclemanager_errors">';
        // Loop error codes and display errors
        foreach ($codes as $code) {
            $message = jsvehiclemanager_errors()->get_error_message($code);
            echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
        }
        echo '</div>';
    }
}

// ---------------Remove wp user ---------------

function jsvehiclemanager_remove_vehicles_user($user_id) {
    $js_model = JSVEHICLEMANAGERincluder::getJSModel('user');
    $userid = $js_model->getUserIDByWPUid($user_id);

    if (isset($_POST['delete_option']) AND $_POST['delete_option'] == 'delete') {
        $result = $js_model->deleteUserRecords($userid , true );
        if ($result) {

        } else {

        }
    }
}
add_action('delete_user', 'jsvehiclemanager_remove_vehicles_user');

// visual composer hooks for shortcodes
add_action( 'vc_before_init', 'js_vehicle_manager_vcSetAsTheme' );
function js_vehicle_manager_vcSetAsTheme() {
    if(jsvehiclemanager::$_car_manager_theme == 0){
        vc_set_as_theme();

        vc_map( array(
              "name" => __( "Vehicle List", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_list_vehicles",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/list_vehicles.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Vehicle Search", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_vehicle_search",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/vehicle_search.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Add Vehicle", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_add_vehicle",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/add_vehicle.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "My Vehicles", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_my_vehicles",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/my_vehicles.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Dashboard", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_control_panel",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/control_panel.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Compare Vehicles", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_compare_vehicles",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/compare_vehicles.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Shortlisted Vehicles", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_shortlisted_vehicles",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/shortlisted_vehicles.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Vehicles By Cities", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_vehicles_by_city",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/vehicles_by_city.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Vehicle By Types", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_vehicles_by_type",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/vehicles_by_type.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Vehicles By Make", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_vehicles_by_make",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/vehicles_by_make.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Seller List", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_sellers_list",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/sellers_list.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Sellers By Cities", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_sellers_by_city",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/sellers_by_city.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Credits Pack", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_credits_pack",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/credits_pack.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Rate List", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_credits_rate_list",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/credits_rate_list.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Purchase History", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_purchase_history",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/purchase_history.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Credits Log", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_credits_log",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/credits_log.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Vehicle Alert", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_vehicle_alerts",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/vehicle_alerts.png',
              "show_settings_on_create" => false,
            )
        );

        vc_map( array(
              "name" => __( "Login", "js-vehicle-manager" ),
              "base" => "jsvehiclemanager_login",
              "class" => "",
              "category" => __( "WP Vehicle Manager Pages", "js-vehicle-manager"),
              "icon" => JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/vc-icons/login.png',
              "show_settings_on_create" => false,
            )
        );


    }
}
?>
