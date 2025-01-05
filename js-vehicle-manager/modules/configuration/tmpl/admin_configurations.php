<?php
if (!defined('ABSPATH'))
    die('Restricted Access');

wp_enqueue_script('jquery-ui-tabs');

// Lists objecs
$date_format = array((object) array('id' => 'd-m-Y', 'text' => __('dd-mm-yyyy', 'js-vehicle-manager')), (object) array('id' => 'm/d/Y', 'text' => __('mm/dd/yyyy', 'js-vehicle-manager')), (object) array('id' => 'Y-m-d', 'text' => __('yyyy-mm-dd', 'js-vehicle-manager')));
$yesno = array((object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager')), (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));
$valertpopupbtn = array((object) array('id' => 1, 'text' => __('Only Show Button','js-vehicle-manager')),(object) array('id' => 2, 'text' => __('Show Auto Popup','js-vehicle-manager')), (object) array('id' => 3, 'text' => __('Both','js-vehicle-manager')));
$showhide = array((object) array('id' => 1, 'text' => __('Show', 'js-vehicle-manager')), (object) array('id' => 0, 'text' => __('Hide', 'js-vehicle-manager')));
$number_after_decimal = array((object) array('id' => 0, 'text' => 0), (object) array('id' => 1, 'text' => 1), (object) array('id' => 2, 'text' => 2), (object) array('id' => 3, 'text' => 3), (object) array('id' => 4, 'text' => 4), (object) array('id' => 5, 'text' => 5), (object) array('id' => 6, 'text' => 6), (object) array('id' => 7, 'text' => 7), (object) array('id' => 8, 'text' => 8), (object) array('id' => 9, 'text' => 9), );
$defaultradius = array((object) array('id' => 1, 'text' => __('Meters', 'js-vehicle-manager')), (object) array('id' => 2, 'text' => __('Kilometers', 'js-vehicle-manager')), (object) array('id' => 3, 'text' => __('Miles', 'js-vehicle-manager')), (object) array('id' => 4, 'text' => __('Nautical Miles', 'js-vehicle-manager')));
$defaultaddressdisplaytype = array((object) array('id' => 'csc', 'text' => __('City','js-vehicle-manager').', ' .__('State','js-vehicle-manager').', ' .__('Country', 'js-vehicle-manager')), (object) array('id' => 'cs', 'text' => __('City','js-vehicle-manager').', ' .__('State', 'js-vehicle-manager')), (object) array('id' => 'cc', 'text' => __('City','js-vehicle-manager').', ' .__('Country', 'js-vehicle-manager')), (object) array('id' => 'c', 'text' => __('City', 'js-vehicle-manager')));
$social = array(1 => '');
$leftright = array((object) array('id' => 1, 'text' => __('Left align', 'js-vehicle-manager')),(object) array('id' => 2, 'text' => __('Right align', 'js-vehicle-manager')));
$refinesearchpositions = array(
        (object) array('id' => 1 , 'text' => __('Top Left','js-vehicle-manager') ),
        (object) array('id' => 2 , 'text' => __('Top Right','js-vehicle-manager') ),
        (object) array('id' => 3 , 'text' => __('Middle Left','js-vehicle-manager') ),
        (object) array('id' => 4 , 'text' => __('Middle Right','js-vehicle-manager') ),
        (object) array('id' => 5 , 'text' => __('Bottom Left','js-vehicle-manager') ),
        (object) array('id' => 6 , 'text' => __('Bottom Right','js-vehicle-manager') )
    );

global $wp_roles;
$roles = $wp_roles->get_names();
$userroles = array();
foreach ($roles as $key => $value) {
    $userroles[] = (object) array('id' => $key, 'text' => $value);
}
$watermark_position = array((object) array('id' => 1, 'text' => __('Left Top', 'js-vehicle-manager')),
                   (object) array('id' => 2, 'text' => __('Left Bottom', 'js-vehicle-manager')),
                   (object) array('id' => 3, 'text' => __('Right Top', 'js-vehicle-manager')),
                   (object) array('id' => 4, 'text' => __('Right Bottom', 'js-vehicle-manager')));

$wpdir = wp_upload_dir();
$data_directory = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('data_directory');
$image_watermark = $wpdir['baseurl'] . '/' . $data_directory . '/data/'.jsvehiclemanager::$_data[0]['water_mark_img_name'];
$uploads = wp_upload_dir();
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
            $msgkey = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getMessagekey();
            JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php echo __('Configuration', 'js-vehicle-manager'); ?>
        </span>
        <form id="jsvehiclemanager-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_configuration&task=saveconfiguration")); ?>" enctype="multipart/form-data">
            <div id="jsvm_tabs" class="jsvm_tabs">
                <ul>
                    <li><a href="#jsvm_site_setting"><?php echo __('Site Settings', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_pricing"><?php echo __('Pricing', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_vehicle_setting"><?php echo __('Vehicle setting', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_vehicle_detail"><?php echo __('Vehicle Detail', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_vehicle_list"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_seller"><?php echo __('Seller', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_recaptcha"><?php echo __('Recaptcha', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_memberlinks"><?php echo __('Member Links', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_visitorlinks"><?php echo __('Visitor Links', 'js-vehicle-manager'); ?></a></li>
                    <li><a href="#jsvm_email"><?php echo __('Email setting', 'js-vehicle-manager'); ?></a></li>
                    <?php if(in_array('vehiclerss', jsvehiclemanager::$_active_addons)){ ?>
                        <li><a href="#jsvm_rss"><?php echo __('RSS setting', 'js-vehicle-manager'); ?></a></li>
                    <?php } ?>
                    <?php if(in_array('adsense', jsvehiclemanager::$_active_addons)){ ?>
                        <li><a href="#jsvm_adsense"><?php echo __('Google Map and Adsense', 'js-vehicle-manager'); ?></a></li>
                    <?php } ?>
                    <?php if(in_array('sociallogin', jsvehiclemanager::$_active_addons)){ ?>
                        <li><a href="#jsvm_sociallogin"><?php echo __('Social Login', 'js-vehicle-manager'); ?></a></li>
                    <?php } ?>
                    <?php if(in_array('socialshare', jsvehiclemanager::$_active_addons)){ ?>
                        <li><a href="#jsvm_socailsharing"><?php echo __('Social Sharing', 'js-vehicle-manager'); ?></a></li>
                    <?php } ?>
                    <?php if(in_array('financeplan', jsvehiclemanager::$_active_addons)){ ?>
                        <li><a href="#jsvm_financing"><?php echo __('Finance Plan', 'js-vehicle-manager'); ?></a></li>
                    <?php } ?>
                </ul>
                <div class="jsvm_tabInner">
                    <div id="jsvm_site_setting">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Site Settings', 'js-vehicle-manager'); ?></h3>
                        <div class="jsvm_js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <?php  if(jsvehiclemanager::$_car_manager_theme == 0 ){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Offline', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('offline', $yesno, jsvehiclemanager::$_data[0]['offline']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses_post(wp_editor(jsvehiclemanager::$_data[0]['offline_message'], 'offline_text', array('media_buttons' => false,'textarea_rows'=>2)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Data directory', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('data_directory', jsvehiclemanager::$_data[0]['data_directory'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('System will upload all user files in this folder', 'js-vehicle-manager'); echo '<br/>'; echo esc_html($uploads['basedir']).esc_html(jsvehiclemanager::$_data[0]['data_directory']);?></small></div>
                                </div>

                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Date format', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('date_format', $date_format, jsvehiclemanager::$_data[0]['date_format']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <?php if(in_array("credits", jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Auto assign package to new user', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('auto_assign_free_package', $yesno, jsvehiclemanager::$_data[0]['auto_assign_free_package']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Auto assign free package to new user', 'js-vehicle-manager'); ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Auto approve free package', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('free_package_auto_approve', $yesno, jsvehiclemanager::$_data[0]['free_package_auto_approve']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Auto approve free package of new new user', 'js-vehicle-manager'); ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Purchase free package only once', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('free_package_purchase_only_once', $yesno, jsvehiclemanager::$_data[0]['free_package_purchase_only_once']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('User can purchase free package only once', 'js-vehicle-manager'); ?></small></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('User can add vehicle', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('allow_user_to_add_vehicle', $yesno, jsvehiclemanager::$_data[0]['allow_user_to_add_vehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle default expiry in days', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('default_vehicle_expiry', jsvehiclemanager::$_data[0]['default_vehicle_expiry'],array('class'=>'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle SEO', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('vehicle_seo', jsvehiclemanager::$_data[0]['vehicle_seo'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Vehicle seo options are make, model, modelyear, vehicletype, condition, location', 'js-vehicle-manager').'. eg- ['.__('make', 'js-vehicle-manager').']'.' ['.__('model', 'js-vehicle-manager').']'.' ['.__('model year', 'js-vehicle-manager').']'; ?></small></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Breadcrumbs', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('breadcrumbs_showhide',$showhide,jsvehiclemanager::$_data[0]['breadcrumbs_showhide']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Default pagination size', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pagination_default_page_size', jsvehiclemanager::$_data[0]['pagination_default_page_size'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Maximum number of records show per Page', 'js-vehicle-manager'); ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Default radius type', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('default_radius_type', $defaultradius, jsvehiclemanager::$_data[0]['default_radius_type']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Default Radius Type', 'js-vehicle-manager'); ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Default address display style', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('defaultaddressdisplaytype', $defaultaddressdisplaytype, jsvehiclemanager::$_data[0]['defaultaddressdisplaytype']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('User can add city', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('newtyped_cities', $yesno, jsvehiclemanager::$_data[0]['newtyped_cities']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Maximum record for city field', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('number_of_cities_for_autocomplete', jsvehiclemanager::$_data[0]['number_of_cities_for_autocomplete'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show maximum records for city field', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Allowed upload file size', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('allowed_file_size', jsvehiclemanager::$_data[0]['allowed_file_size'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('File size in kb', 'js-vehicle-manager'); ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Allowed extensions type', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('image_file_type', jsvehiclemanager::$_data[0]['image_file_type'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Allowed file extensions types for upload files', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Upload file types for brochure', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('file_file_type', jsvehiclemanager::$_data[0]['file_file_type'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('For example', 'js-vehicle-manager').':'.'jpeg,jpg,png'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Default page', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('default_pageid', JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getPageList(), jsvehiclemanager::$_data[0]['default_pageid']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Select WP Vehicle Manager default page, on action system will redirect on selected page. If not select default page, email links and support icon might not work.', 'js-vehicle-manager'); ?></small></div>
                                </div>
                            </div>
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('User Registration', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Enable user registeration custom link', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('user_registration_custom_link_enabled', $yesno, jsvehiclemanager::$_data[0]['user_registration_custom_link_enabled'],'',array('onChange'=>'userregistrationcustomlink();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value user_registration_custom_link"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('user_registration_custom_link', jsvehiclemanager::$_data[0]['user_registration_custom_link'], array('class' => 'jsvm_inputbox','placeholder'=>__('Insert user registration custom link','js-vehicle-manager') )), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('If this configuration is enabled and link is provided then all the register links of WP Vehicle Manager will redirect to this link.', 'js-vehicle-manager'); ?></small></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row user_registration_redirect_link">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('WP Vehicle Manager Registration Redirect page', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('register_user_redirect_page', JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getPageList(), jsvehiclemanager::$_data[0]['register_user_redirect_page']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('User will be redirected to the slected page on successful registration.', 'js-vehicle-manager'); ?></small></div>
                                </div>
                            </div>
                        </div>

                    </div>
					</div>
                    <div id="jsvm_pricing">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Price Notations', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Currency symbol position', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('price_poition_of_currency', $leftright, jsvehiclemanager::$_data[0]['price_poition_of_currency']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('The available currencies in the system can be managed from', 'js-vehicle-manager'); echo '&nbsp;'.'<a target="_blank" href="'. admin_url('admin.php?page=jsvm_currency').'">'. __('here','js-vehicle-manager') . '</a>'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Price number after decimal Point', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('price_numbers_after_decimel_point', $number_after_decimal, jsvehiclemanager::$_data[0]['price_numbers_after_decimel_point']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Price decimal separator', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('price_decimal_separator', jsvehiclemanager::$_data[0]['price_decimal_separator'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Price thousand separator', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('price_thousand_separator', jsvehiclemanager::$_data[0]['price_thousand_separator'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="jsvm_vehicle_setting">
                        <?php if(in_array('visitoraddvehicle', jsvehiclemanager::$_active_addons)){ ?>
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Visitors Settings', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Visitor can add vehicle', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('visitor_can_add_vehicle', $yesno, jsvehiclemanager::$_data[0]['visitor_can_add_vehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">
                                    <?php /*
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show captcha', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo JSVEHICLEMANAGERformfield::select('cap_on_reg_form', $yesno, jsvehiclemanager::$_data[0]['cap_on_reg_form']); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show google captcha on registration form', 'js-vehicle-manager'); ?></small></div>
                                    </div>
                                    */ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Visitor add vehicle redirect page', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('visitor_add_vehicle_redirect_page', JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getPageList(), jsvehiclemanager::$_data[0]['visitor_add_vehicle_redirect_page']), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Where to redirect visitor when visitor adds a new vehicle', 'js-vehicle-manager'); ?></small></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Vehicle Settings', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <?php if(in_array("markassold", jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show sold vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('show_sold_vehicles', $yesno, jsvehiclemanager::$_data[0]['show_sold_vehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show sold vehicles in vehicle listing', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array("featured", jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show featured vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('show_featured_vehicles_in_vehicles_listing', $yesno, jsvehiclemanager::$_data[0]['show_featured_vehicles_in_vehicles_listing']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show featured vehicles in vehicle listings', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('vehiclealert', jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Limit vehicle alerts', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('vechicle_alerts_allowed_per_user', jsvehiclemanager::$_data[0]['vechicle_alerts_allowed_per_user'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Maximum vehicles alerts for user', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                <?php if(jsvehiclemanager::$_car_manager_theme == 1) {?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle alert action button', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_alert_button_or_popup', $valertpopupbtn, jsvehiclemanager::$_data[0]['vehicle_alert_button_or_popup']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show vehicle alert display type after search vehicle', 'js-vehicle-manager'); ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle alert popup delay', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('vehicle_alert_popup_delay', jsvehiclemanager::$_data[0]['vehicle_alert_popup_delay'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Popup delay in seconds', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                <?php }else{

                                    if(jsvehiclemanager::$_data[0]['vehicle_alert_button_or_popup'] > 0){
                                        jsvehiclemanager::$_data[0]['vehicle_alert_button_or_popup'] = 1;
                                    } ?>

                                        <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                            <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle alert button', 'js-vehicle-manager'); ?></div>
                                            <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_alert_button_or_popup', $yesno, jsvehiclemanager::$_data[0]['vehicle_alert_button_or_popup']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                            <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show vehicle alert button on vehicle listing', 'js-vehicle-manager'); ?></small></div>
                                        </div>
                                <?php
                                }?>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Maximum images per vehicle', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('maximum_images_per_vehicle', jsvehiclemanager::$_data[0]['maximum_images_per_vehicle'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Maximum upload images per vehicle', 'js-vehicle-manager'); echo '<br/><b></b>'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle auto approve', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_auto_approve', $yesno, jsvehiclemanager::$_data[0]['vehicle_auto_approve'], '', array('class' => 'jsvm_inputbox', 'data-validation' => '')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Vehicle Auto Approve','js-vehicle-manager'); ?></small></div>
                                </div>
                                <?php if(in_array('featuredvehicle', jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Featured vehicle auto approve', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('featuredvehicle_autoapprove', $yesno, jsvehiclemanager::$_data[0]['featuredvehicle_autoapprove']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Number of featured vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('no_of_featured_vehicles_in_vehicle_listing', jsvehiclemanager::$_data[0]['no_of_featured_vehicles_in_vehicle_listing'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show number of featured vehicles in vehicle listings', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle type per row', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('type_per_row', jsvehiclemanager::$_data[0]['type_per_row'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle condition row', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('condition_per_row', jsvehiclemanager::$_data[0]['condition_per_row'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle city per row', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('city_per_row', jsvehiclemanager::$_data[0]['city_per_row'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <?php /*
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle model year per row', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo JSVEHICLEMANAGERformfield::text('modelyear_per_row', jsvehiclemanager::$_data[0]['modelyear_per_row'], array('class' => 'jsvm_inputbox')); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                */ ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Add Watermark To Vehicle Images', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('show_water_mark', $yesno, jsvehiclemanager::$_data[0]['show_water_mark']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Select Whether To Add Watermark Or Not', 'js-vehicle-manager'); ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Watermark Image', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><img width="50px" height="50px" src="<?php echo $image_watermark; ?>" style="border-radius:4px;border:1px solid #A8A8A8;"/></div>
                                    <input type="file" id="jsvm_watermarkimage" name="watermarkimage" />
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Select The Image You Want To Use As Watermark', 'js-vehicle-manager'); ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Watermark Position', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('water_mark_position', $watermark_position, jsvehiclemanager::$_data[0]['water_mark_position']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Select Position Of Watermark', 'js-vehicle-manager'); ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Position Of Model Year', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_modelyearposition', $leftright,jsvehiclemanager::$_data[0]['vehicle_modelyearposition']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show number in vehicle by make mode', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclebymake_show_number_of_vehicles', $leftright,jsvehiclemanager::$_data[0]['vehiclebymake_show_number_of_vehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('This configuration controls whether or not to show number in vehicle by make model layout or not', 'js-vehicle-manager'); ?></small></div>
                                </div>
                            </div>
                        </div>
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Vehicle By City', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                              <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle Count', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclebycity_vehiclecount', $showhide,jsvehiclemanager::$_data[0]['vehiclebycity_vehiclecount']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Country Name', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclebycity_countryname', $showhide,jsvehiclemanager::$_data[0]['vehiclebycity_countryname']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                        </div>

                    </div>
                     <div id="jsvm_vehicle_detail">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Vehicle Detail', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <?php if(in_array('shortlist',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Shortlist', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_shortlist',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_shortlist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php }
                                if(in_array('tellafriend',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Tell A Friend', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_tellafriend',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_tellafriend']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php }
                                if(in_array('makeanoffer',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Make An Offer', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_makeanoffer',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_makeanoffer']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('testdrive',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Schedule Test Drive', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_scheduletestdrive',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_scheduletestdrive']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <?php if(in_array('pdf',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('PDF', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_pdf',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_pdf']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('print',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Print', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_print',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_print']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller Detail', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_sellerdetail',$showhide, jsvehiclemanager::$_data[0]['vehicledetail_sellerdetail']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="jsvm_vehicle_list">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Refine Search Tag Position', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclelist_refinesearchposition',$refinesearchpositions, jsvehiclemanager::$_data[0]['vehiclelist_refinesearchposition']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller Image', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclelist_sellerimage',$showhide, jsvehiclemanager::$_data[0]['vehiclelist_sellerimage']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <?php if(in_array('shortlist',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Shortlist', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclelist_shortlist',$showhide, jsvehiclemanager::$_data[0]['vehiclelist_shortlist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php }
                                if(in_array('tellafriend',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Tell A Friend', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehiclelist_tellafriend',$showhide, jsvehiclemanager::$_data[0]['vehiclelist_tellafriend']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div id="jsvm_adsense">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Google Map', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Default longitude', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('default_longitude', jsvehiclemanager::$_data[0]['default_longitude'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Default Longitude', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Default latitude', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('default_latitude', jsvehiclemanager::$_data[0]['default_latitude'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Default Latitude', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google map API key', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('google_map_api_key', jsvehiclemanager::$_data[0]['google_map_api_key'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Get API key from', 'js-vehicle-manager'); echo '<a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>'; ?></small></div>
                                </div>
                            </div>
                        </div>
                        <?php if(in_array('adsense',jsvehiclemanager::$_active_addons)){ ?>
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Adsense', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show google adds in list vehicle', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('googleadsenseshowinlistvehicle', $yesno, jsvehiclemanager::$_data[0]['googleadsenseshowinlistvehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google adsense client id', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleadsenseclient', jsvehiclemanager::$_data[0]['googleadsenseclient'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google adsense slot id', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleadsenseslot', jsvehiclemanager::$_data[0]['googleadsenseslot'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google adds show after number of vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleadsenseshowafter', jsvehiclemanager::$_data[0]['googleadsenseshowafter'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">
                                     <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google adds width', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleadsensewidth', jsvehiclemanager::$_data[0]['googleadsensewidth'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google adds height', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('googleadsenseheight', jsvehiclemanager::$_data[0]['googleadsenseheight'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Google adds custom css', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::textarea('googleadsensecustomcss', jsvehiclemanager::$_data[0]['googleadsensecustomcss'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div id="jsvm_email">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Email', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Sender email address', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mailfromaddress', jsvehiclemanager::$_data[0]['mailfromaddress'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Default sender email', 'js-vehicle-manager'); echo '<br/><b></b>'; ?></small></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Email sender name', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mailfromname', jsvehiclemanager::$_data[0]['mailfromname'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Default Email Sender Name', 'js-vehicle-manager'); echo '<br/><b></b>'; ?></small></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                               <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Admin email address', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('adminemailaddress', jsvehiclemanager::$_data[0]['adminemailaddress'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Admin Email', 'js-vehicle-manager'); echo '<br/><b></b>'; ?></small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(in_array('vehiclerss',jsvehiclemanager::$_active_addons)){ ?>
                        <div id="jsvm_rss">
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('RSS', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle RSS', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_rss', $yesno, jsvehiclemanager::$_data[0]['vehicle_rss']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><div><small></small></div></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Webmaster', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Title', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rss_vehicle_title', jsvehiclemanager::$_data[0]['rss_vehicle_title'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Must provide title for feed', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Description', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::textarea('rss_vehicle_description', jsvehiclemanager::$_data[0]['rss_vehicle_description'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Must provide description for feed', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Copyright', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rss_vehicle_copyright', jsvehiclemanager::$_data[0]['rss_vehicle_copyright'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Leave blank to hide', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show vehicle image', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('rss_vehicle_image', $yesno, jsvehiclemanager::$_data[0]['rss_vehicle_image']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><div><small></small></div></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Show vehicle image in feeds', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Editor', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rss_vehicle_editor', jsvehiclemanager::$_data[0]['rss_vehicle_editor'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Leave blank to hide editor used for feed content issue', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Time to live', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rss_vehicle_ttl', jsvehiclemanager::$_data[0]['rss_vehicle_ttl'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Time to live for feed', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Web master', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rss_vehicle_webmaster', jsvehiclemanager::$_data[0]['rss_vehicle_webmaster'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Leave blank to hide webmaster used for technical issue', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show Vehicle Condition', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('rss_vehicle_categories', $yesno, jsvehiclemanager::$_data[0]['rss_vehicle_categories']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><div><small></small></div></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Categorize vehicle by condition in feeds', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if(in_array('sociallogin',jsvehiclemanager::$_active_addons)){ ?>
                        <div id="jsvm_sociallogin">
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Facebook', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Login with facebook', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('loginwithfacebook', $yesno, jsvehiclemanager::$_data[0]['loginwithfacebook']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><div><small></small></div></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Facebook user can login in js vehicle manager', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('API Key', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('apikeyfacebook', jsvehiclemanager::$_data[0]['apikeyfacebook'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('API key is required for facebook app', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Secret', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('clientsecretfacebook', jsvehiclemanager::$_data[0]['clientsecretfacebook'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Linkedin', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Login with linkedin', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('loginwithlinkedin', $yesno, jsvehiclemanager::$_data[0]['loginwithlinkedin']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><div><small></small></div></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('Linkedin user can login in js vehicle manager', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('API Key', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('apikeylinkedin', jsvehiclemanager::$_data[0]['apikeylinkedin'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small><?php echo __('API key is required for linkedin app', 'js-vehicle-manager'); echo '<br/>'; ?></small></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Secret', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('clientsecretlinkedin', jsvehiclemanager::$_data[0]['clientsecretlinkedin'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-description"><small></small></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if(in_array('socialshare',jsvehiclemanager::$_active_addons)){ ?>
                        <div id="jsvm_socailsharing">
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Social Media', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('tumbler_share', $social, (jsvehiclemanager::$_data[0]['tumbler_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Tumbler share', 'js-vehicle-manager'); ?></div>
                                </div>
                                <?php /*
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo JSVEHICLEMANAGERformfield::checkbox('fb_like', $social, (jsvehiclemanager::$_data[0]['fb_like'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')); ?><?php echo __('Facebook like', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo JSVEHICLEMANAGERformfield::checkbox('fb_comments', $social, (jsvehiclemanager::$_data[0]['fb_comments'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')); ?><?php echo __('Facebook comment', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo JSVEHICLEMANAGERformfield::checkbox('google_like', $social, (jsvehiclemanager::$_data[0]['google_like'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')); ?><?php echo __('Google like', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo JSVEHICLEMANAGERformfield::checkbox('yahoo_share', $social, (jsvehiclemanager::$_data[0]['yahoo_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')); ?><?php echo __('Yahoo share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                */ ?>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('fb_share', $social, (jsvehiclemanager::$_data[0]['fb_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?><?php echo __('Facebook share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('google_share', $social, (jsvehiclemanager::$_data[0]['google_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Google share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('blogger_share', $social, (jsvehiclemanager::$_data[0]['blogger_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Blogger share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('instgram_share', $social, (jsvehiclemanager::$_data[0]['instgram_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Instagram share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('linkedin', $social, (jsvehiclemanager::$_data[0]['linkedin'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?><?php echo __('Linkedin share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('digg_share', $social, (jsvehiclemanager::$_data[0]['digg_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Digg share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('twitter_share', $social, (jsvehiclemanager::$_data[0]['twitter_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Twitter share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                                <div class="js-vehicle-managerconfig-threecols">
                                    <div class="js-vehicle-manager-configuration-row"><label><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('pintrest_share', $social, (jsvehiclemanager::$_data[0]['pintrest_share'] == 1) ? 1 : 0, array('class' => 'jsvm_checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?><?php echo __('Pintrest share', 'js-vehicle-manager'); ?></label></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Member links start-->
                   <div id="jsvm_memberlinks">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('User Top Menu Links', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Control Panel', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_controlpanel', $showhide,jsvehiclemanager::$_data[0]['topmenu_controlpanel']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Add Vehicle', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_addVehicle', $showhide,jsvehiclemanager::$_data[0]['topmenu_addVehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('My Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_myvehicles', $showhide,jsvehiclemanager::$_data[0]['topmenu_myvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_vehiclelist', $showhide,jsvehiclemanager::$_data[0]['topmenu_vehiclelist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('shortlist',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Shortlist Vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_shortlistvehicles', $showhide,jsvehiclemanager::$_data[0]['topmenu_shortlistvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Search Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php  echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_searchvehicles', $showhide,jsvehiclemanager::$_data[0]['topmenu_searchvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Cities', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_vehiclebycity', $showhide,jsvehiclemanager::$_data[0]['topmenu_vehiclebycity']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Make', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_vehiclebymake', $showhide,jsvehiclemanager::$_data[0]['topmenu_vehiclebymake']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('topmenu_sellerlist', $showhide,jsvehiclemanager::$_data[0]['topmenu_sellerlist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                        </div>

                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('User Dashboard Links', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Add Vehicle', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_addVehicle', $showhide,jsvehiclemanager::$_data[0]['dashboard_addVehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('My Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_myvehicles', $showhide,jsvehiclemanager::$_data[0]['dashboard_myvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehiclelist', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehiclelist']), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Search Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_searchvehicles', $showhide,jsvehiclemanager::$_data[0]['dashboard_searchvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('shortlist',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Shortlist Vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_shortlistvehicles', $showhide,jsvehiclemanager::$_data[0]['dashboard_shortlistvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('comparevehicle',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Compare', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_compare', $showhide,jsvehiclemanager::$_data[0]['dashboard_compare']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle Types', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehicletypes', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehicletypes']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Cities', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehiclebycity', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehiclebycity']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Condition', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehiclebycondition', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehiclebycondition']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Make', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehiclebymake', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehiclebymake']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('vehiclerss',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle RSS', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehiclerss', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehiclerss']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Logout', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_logout', $showhide,jsvehiclemanager::$_data[0]['dashboard_logout']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Profile', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_profile', $showhide,jsvehiclemanager::$_data[0]['dashboard_profile']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller By City', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_sellerbycity', $showhide,jsvehiclemanager::$_data[0]['dashboard_sellerbycity']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_sellerlist', $showhide,jsvehiclemanager::$_data[0]['dashboard_sellerlist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('credits',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Packages', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_package', $showhide,jsvehiclemanager::$_data[0]['dashboard_package']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Rate List', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_ratelist', $showhide,jsvehiclemanager::$_data[0]['dashboard_ratelist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Credits Log', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_creditslog', $showhide,jsvehiclemanager::$_data[0]['dashboard_creditslog']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Purchase History', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_purchasehistory', $showhide,jsvehiclemanager::$_data[0]['dashboard_purchasehistory']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Stats', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_stats', $showhide,jsvehiclemanager::$_data[0]['dashboard_stats']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('vehiclealert', jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle Alert', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('dashboard_vehiclealert', $showhide,jsvehiclemanager::$_data[0]['dashboard_vehiclealert']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!--Member Links End-->

                    <!-- Visitor links start-->
                   <div id="jsvm_visitorlinks">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Visitor Top Menu Links', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <?php if(in_array("visitoraddvehicle", jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Add Vehicle', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_addVehicle', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_addVehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('My Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_myvehicles', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_myvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_vehiclelist', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_vehiclelist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('shortlist',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Shortlist Vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_shortlistvehicles', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_shortlistvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Search Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_searchvehicles', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_searchvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Cities', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_vehiclebycity', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_vehiclebycity']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Make', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_vehiclebymake', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_vehiclebymake']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_topmenu_sellerlist', $showhide,jsvehiclemanager::$_data[0]['vis_topmenu_sellerlist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                        </div>

                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Visitor Dashboard Links', 'js-vehicle-manager'); ?></h3>
                        <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <?php if(in_array('visitoraddvehicle',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Add Vehicle', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_addVehicle', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_addVehicle']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('My Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_myvehicles', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_myvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehiclelist', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehiclelist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Search Vehicles', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_searchvehicles', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_searchvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('shortlist',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Shortlist Vehicles', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_shortlistvehicles', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_shortlistvehicles']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('comparevehicle',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Compare', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_compare', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_compare']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle Types', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehicletypes', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehicletypes']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Cities', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehiclebycity', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehiclebycity']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Condition', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehiclebycondition', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehiclebycondition']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle By Make', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehiclebymake', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehiclebymake']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('vehiclerss', jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle RSS', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehiclerss', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehiclerss']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Login', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_login', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_login']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Register', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_register', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_register']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller By City', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_sellerbycity', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_sellerbycity']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller List', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_sellerlist', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_sellerlist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('vehiclerss', jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Packages', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_package', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_package']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Rate List', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_ratelist', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_ratelist']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Credits Log', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_creditslog', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_creditslog']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Purchase History', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_purchasehistory', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_purchasehistory']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    </div>
                                <?php } ?>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Stats', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_stats', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_stats']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <?php if(in_array('vehiclealert', jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle Alert', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vis_dashboard_vehiclealert', $showhide,jsvehiclemanager::$_data[0]['vis_dashboard_vehiclealert']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!--Visitor Links End-->
                        <div id="jsvm_seller">
                        <?php if(in_array('buyercontacttoseller', jsvehiclemanager::$_active_addons)){ ?>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                  <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Buyer Can Contact Seller', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicle_buyercontactseller', $yesno,jsvehiclemanager::$_data[0]['vehicle_buyercontactseller']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">

                                </div>
                            </div>
                        <?php } ?>
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Seller By City', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                              <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Seller Count', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('sellerbycity_sellercount', $showhide,jsvehiclemanager::$_data[0]['sellerbycity_sellercount']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Country Name', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('sellerbycity_countryname', $showhide,jsvehiclemanager::$_data[0]['sellerbycity_countryname']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="jsvm_recaptcha">
                        <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Recaptcha', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                              <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Public Key', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('recaptcha_publickey',jsvehiclemanager::$_data[0]['recaptcha_publickey'],array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Private Key', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('recaptcha_privatekey',jsvehiclemanager::$_data[0]['recaptcha_privatekey'],array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>
                        </div>

                         <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Visitor Enable', 'js-vehicle-manager').'/'.__('Disable Recaptcha', 'js-vehicle-manager'); ?></h3>
                         <div class="js-vehicle-manager-configuration-table">
                            <div class="jsvm_left">
                                <?php if(in_array("testdrive", jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Schedule Test Drive', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('recaptcha_scheduletestdrive',$yesno,jsvehiclemanager::$_data[0]['recaptcha_scheduletestdrive']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array("makeanoffer", jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Make An Offer', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('recaptcha_makeanoffer',$yesno,jsvehiclemanager::$_data[0]['recaptcha_makeanoffer']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                <?php } ?>
                                <?php if(in_array('tellafriend',jsvehiclemanager::$_active_addons)){ ?>
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Tell A Friend', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('recaptcha_tellafriend',$yesno,jsvehiclemanager::$_data[0]['recaptcha_tellafriend']), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="jsvm_right">
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Contact To Seller', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('recaptcha_contacttoseller',$yesno,jsvehiclemanager::$_data[0]['recaptcha_contacttoseller']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Vehicle Form', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('recaptcha_vehicleform',$yesno,jsvehiclemanager::$_data[0]['recaptcha_vehicleform']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Registration Form', 'js-vehicle-manager'); ?></div>
                                    <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('recaptcha_registrationform',$yesno,jsvehiclemanager::$_data[0]['recaptcha_registrationform']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                            </div>




                        </div>
                    </div>
                    <!-- Finance links start-->
                    <?php if(in_array("financeplan", jsvehiclemanager::$_active_addons)){ ?>
                        <div id="jsvm_financing">
                            <h3 class="js-vehicle-manager-configuration-heading-main"><?php echo __('Finance Plan', 'js-vehicle-manager'); ?></h3>
                            <div class="js-vehicle-manager-configuration-table">
                                <div class="jsvm_left">
                                  <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Show/Hide Finance Icon', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicledetail_finance_calculator',$showhide,jsvehiclemanager::$_data[0]['vehicledetail_finance_calculator']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                </div>
                                <div class="jsvm_right">
                                    <div class="js-col-xs-12 js-col-md-12 js-vehicle-manager-configuration-row">
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-title"><?php echo __('Interest Rate', 'js-vehicle-manager'); ?></div>
                                        <div class="js-col-xs-12  js-vehicle-manager-configuration-value"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('interestrate',jsvehiclemanager::$_data[0]['interestrate'],array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- Finance links end-->

                </div>
            </div>

            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('isgeneralbuttonsubmit', 1), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('jsvmlt', 'configurations'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'configuration_saveconfiguration'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-configuration')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_js-form-button">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('Configuration', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>
    </div>
</div>

    <?php /*
    <style type="text/css">
        div#map_container{
            z-index:1000;
            position:relative;
            background:#000;
            width:100%;
            height:<?php echo jsvehiclemanager::$_config['mapheight'] . 'px'; ?>;}
    </style>

    <?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
    <?php wp_enqueue_script('jsvm-repaptcha-scripti','https://maps.googleapis.com/maps/api/js?key='.jsvehiclemanager::$_config['google_map_api_key']); ?>
    <script type="text/javascript">
        function hideshowtables(table_id) {
            var obj = document.getElementById(table_id);
            var bool = obj.style.display;
            if (bool == '')
                obj.style.display = "none";
            else
                obj.style.display = "";
        }
        function loadMap() {
            var default_latitude = document.getElementById('default_latitude').value;
            var default_longitude = document.getElementById('default_longitude').value;
            var latlng = new google.maps.LatLng(default_latitude, default_longitude);
            zoom = 10;
            var myOptions = {
                zoom: zoom,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map_container"), myOptions);
            var lastmarker = new google.maps.Marker({
                postiion: latlng,
                map: map,
            });
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
            });
            marker.setMap(map);
            lastmarker = marker;

            google.maps.event.addListener(map, "click", function (e) {
                var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
                geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latLng}, function (results, status) {

                    if (status == google.maps.GeocoderStatus.OK) {
                        if (lastmarker != '')
                            lastmarker.setMap(null);
                        var marker = new google.maps.Marker({
                            position: results[0].geometry.location,
                            map: map,
                        });
                        marker.setMap(map);
                        lastmarker = marker;
                        document.getElementById('default_latitude').value = marker.position.lat();
                        document.getElementById('default_longitude').value = marker.position.lng();

                    } else {
                        alert("<?php echo __('Geocode was not successful for the following reason', 'js-vehicle-manager'); ?>: " + status);
                    }
                });
            });
        }
        function showdiv() {
            document.getElementById('map').style.visibility = 'visible';
            jQuery("div#full_background").css("display", "block");
            jQuery("div#popup_main").slideDown('slow');
        }
        function hidediv() {
            document.getElementById('map').style.visibility = 'hidden';
            jQuery("div#popup_main").slideUp('slow');
            jQuery("div#full_background").hide();
        }
*/ ?>

<script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery("div#jsvm_tabs").tabs();
        $.validate();
        userregistrationcustomlink()
    });

    function userregistrationcustomlink(){
        if(jQuery("#user_registration_custom_link_enabled").val() == 1){
            jQuery('div.user_registration_custom_link').slideDown();
            jQuery('div.user_registration_redirect_link').slideUp();
            jQuery('div.user_registration_custom_link').find('input#user_registration_custom_link').attr("data-validation","required");
        }else{
            jQuery('div.user_registration_custom_link').slideUp();
            jQuery('div.user_registration_redirect_link').slideDown();
            jQuery('div.user_registration_custom_link').find('input#user_registration_custom_link').attr("data-validation","");
        }

    }
</script>
