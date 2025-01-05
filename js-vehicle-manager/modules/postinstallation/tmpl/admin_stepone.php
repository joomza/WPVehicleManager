<?php 
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('awesomemin-css', $protocol.'cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');

$date_format = array((object) array('id' => 'd-m-Y', 'text' => __('DD MM YYYY', 'js-vehicle-manager')),
                            (object) array('id' => 'm/d/Y', 'text' => __('MM DD YYYY', 'js-vehicle-manager')),
                            (object) array('id' => 'Y-m-d', 'text' => __('YYYY MM DD', 'js-vehicle-manager')));
$yesno = array((object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager'))
                    , (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));
$leftright = array((object) array('id' => 1, 'text' => __('Left align', 'js-vehicle-manager')),(object) array('id' => 2, 'text' => __('Right align', 'js-vehicle-manager')));
$showhide = array((object) array('id' => 1, 'text' => __('Show', 'js-vehicle-manager')), (object) array('id' => 0, 'text' => __('Hide', 'js-vehicle-manager')));
$defaultaddressdisplaytype = array((object) array('id' => 'csc', 'text' => __('City','js-vehicle-manager').', ' .__('State','js-vehicle-manager').', ' .__('Country', 'js-vehicle-manager')), (object) array('id' => 'cs', 'text' => __('City','js-vehicle-manager').', ' .__('State', 'js-vehicle-manager')), (object) array('id' => 'cc', 'text' => __('City','js-vehicle-manager').', ' .__('Country', 'js-vehicle-manager')), (object) array('id' => 'c', 'text' => __('City', 'js-vehicle-manager')));
if (!defined('ABSPATH')) die('Restricted Access'); ?>
<div id="jsvehiclemanageradmin-wrapper" class="post-installation">
    <div class="js-admin-title-installtion">
        <img class="left-image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/setting-icon.png" />
        <span class="title-text"><?php echo __('Vehicle Manager Settings','js-vehicle-manager'); ?></span>
        <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>" class="close-button">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/close-icon.png" />
        </a>
    </div>
    <div class="post-installation-content-wrp">
        <div class="post-installtion-content-header">
            <div class="update-header-img step-1">
                <div class="header-parts first-part active">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    <span class="text active"><?php echo __('General Settings', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts second-part">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <span class="text"><?php echo __('User Settings', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts third-part">
                    <i class="fa fa-car" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Vehicle Settings', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts fourth-part">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Sample Data', 'js-vehicle-manager'); ?></span>
                </div>
                <div class="header-parts fourth-part">
                    <i class="fa  fa-check-square-o" aria-hidden="true"></i>
                    <span class="text"><?php echo __('Settings Complete', 'js-vehicle-manager'); ?></span>
                </div>
            </div>
        </div>
       <div class="post-installtion-content">
            <div class="heading-post">
                <span class="heading-post-ins"><?php echo __('General Settings','js-vehicle-manager');?></span>
                <span class="heading-post-ins-step-count"><?php echo __('Step 1 Of 5','js-vehicle-manager');?></span>
            </div>
            <form id="jsvehiclemanager-form-ins" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&task=save&action=jsvmtask")); ?>">
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Currency symbol position','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <span class="wrp">
                           <input id="price_poition_of_currency-on" class="toggle toggle-left" name="price_poition_of_currency" value="2" type="radio" >
                           <label for="price_poition_of_currency-on" class="btn"><?php echo __('Left','js-vehicle-manager'); ?></label>
                           <input id="price_poition_of_currency-off" class="toggle toggle-right" name="price_poition_of_currency" value="1" type="radio" checked>
                           <label for="price_poition_of_currency-off" class="btn"><?php echo __('Right','js-vehicle-manager'); ?></label>
                       </span>
                    </div>
                    <div class="desc"><?php echo __('The available currencies in the system can be managed from', 'js-vehicle-manager'); echo '&nbsp;'.'<a target="_blank" href="'. esc_url(admin_url('admin.php?page=jsvm_currency')).'">'. __('here','js-vehicle-manager') . '</a>'; ?></div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Position Of Model Year','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <span class="wrp">
                           <input id="vehicle_modelyearposition-on" class="toggle toggle-left" name="vehicle_modelyearposition" value="2" type="radio" >
                           <label for="vehicle_modelyearposition-on" class="btn"><?php echo __('Left','js-vehicle-manager'); ?></label>
                           <input id="vehicle_modelyearposition-off" class="toggle toggle-right" name="vehicle_modelyearposition" value="1" type="radio"checked>
                           <label for="vehicle_modelyearposition-off" class="btn"><?php echo __('Right','js-vehicle-manager'); ?></label>
                       </span>
                    </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Default page');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('default_pageid', JSVEHICLEMANAGERincluder::getJSModel('postinstallation')->getPageList(),jsvehiclemanager::$_data[0]['default_pageid'],__('Select default page', 'js-vehicle-manager'),array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Select WP Jobs default page, on action system will redirect on selected page','js-vehicle-manager');?>.</div>
                    <div class="desc"><?php echo __('If not select default page, email links and support icon might not work','js-vehicle-manager');?>. </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Admin email address','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('adminemailaddress',jsvehiclemanager::$_data[0]['adminemailaddress'], array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Admin will receive email notifications on this address','js-vehicle-manager');?> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Data directory','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('data_directory',jsvehiclemanager::$_data[0]['data_directory'], array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('System will upload all user files in this folder','js-vehicle-manager');?> </div>
                    <div class="desc"><?php echo JSVEHICLEMANAGER_PLUGIN_PATH.jsvehiclemanager::$_data[0]['data_directory'];?> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Default date format','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('date_format', $date_format,jsvehiclemanager::$_data[0]['date_format'],__('Select date format', 'js-vehicle-manager'),array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Date format for plugin','js-vehicle-manager');?> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Show breadcrumbs', 'js-vehicle-manager'); ?>:
                    </div>
                    <div class="field">
                       <span class="wrp">
                           <input id="breadcrumbs_showhide-on" class="toggle toggle-left" name="breadcrumbs_showhide" value="0" type="radio" >
                           <label for="breadcrumbs_showhide-on" class="btn"><?php echo __('Yes','js-vehicle-manager'); ?></label>
                           <input id="breadcrumbs_showhide-off" class="toggle toggle-right" name="breadcrumbs_showhide" value="1" type="radio" checked>
                           <label for="breadcrumbs_showhide-off" class="btn"><?php echo __('No','js-vehicle-manager'); ?></label>
                       </span>
                    </div>
                    <div class="desc"><?php echo __('Show navigation in breadcrumbs','js-vehicle-manager');?> </div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Sender email address','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mailfromaddress', jsvehiclemanager::$_data[0]['mailfromaddress'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Default sender email', 'js-vehicle-manager'); echo '<br/><b></b>'; ?></div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Email sender name','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mailfromname', jsvehiclemanager::$_data[0]['mailfromname'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Default Email Sender Name', 'js-vehicle-manager'); echo '<br/><b></b>'; ?></div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Default pagination size','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pagination_default_page_size', jsvehiclemanager::$_data[0]['pagination_default_page_size'], array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"><?php echo __('Maximum number of records show per Page', 'js-vehicle-manager'); ?></div>
                </div>
                <div class="pic-config">
                    <div class="title">
                        <?php echo __('Default address display style','js-vehicle-manager');?>:
                    </div>
                    <div class="field">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('defaultaddressdisplaytype', $defaultaddressdisplaytype, jsvehiclemanager::$_data[0]['defaultaddressdisplaytype']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="desc"> </div>
                </div>
                <div class="pic-button-part">
                    <a class="next-step full-width" href="#" onclick="document.getElementById('jsvehiclemanager-form-ins').submit();" >
                        <?php echo __('Next','js-vehicle-manager'); ?>
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/back-arrow.png" />
                    </a>
                </div>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'postinstallation_save'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('step', 1), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
        </div>
    </div>
</div>
