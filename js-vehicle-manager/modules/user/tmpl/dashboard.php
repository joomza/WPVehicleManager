<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
$msgkey = JSVEHICLEMANAGERincluder::getJSModel('user')->getMessagekey();
JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag == null) {
?>
    <div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Control Panel', 'js-vehicle-manager'); ?>
            </span>
        </div>
        <div id="jsvehiclemanager-buyer-cp">
            <div class="jsvehiclemanager-buyer-cp-top-portion">
            <?php if(jsvehiclemanagercheckLink('dashboard_addVehicle') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link add-vehicle">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'formvehicle'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/add-vehicle.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Add Vehicle', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_myvehicles') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link my-vehicles">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'myvehicles'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/my-vehicle.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('My Vehicles', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
             <?php if(jsvehiclemanagercheckLink('dashboard_vehiclelist') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link vehicle-list">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/vehicle-list.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Vehicle List', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_searchvehicles') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link search-vehicles">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehiclesearch'))) ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/search.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Search Vehicles', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            </div>
            <div class="jsvehiclemanager_cpheading"><?php echo __('Misc', 'js-vehicle-manager'); ?></div>
            <div class="jsvehiclemanager-buyer-cp-top-portion box">
            <?php if(jsvehiclemanagercheckLink('dashboard_vehicletypes') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link vehicle-types">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicletype', 'jsvmlt'=>'vehiclesbytype'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/types.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Vehicle Types', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_vehiclebycity') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link vehicle-by-cities">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'city', 'jsvmlt'=>'vehiclesbycity'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/cities.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Vehicle By Cities', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_vehiclebycondition') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link vehicle-by-condition">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'conditions', 'jsvmlt'=>'vehiclesbycondition'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/vehicle-condtion.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Vehicle By Condition', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_sellerbycity') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link seller-by-city">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellersbycity'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/seller-city.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Seller By City', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_sellerlist') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link seller-list">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'sellerlist'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/seller-list.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Sellers List', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_vehiclebymake') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link vehicle-by-make">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'make', 'jsvmlt'=>'vehiclesbymake'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/vehicle-make.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Vehicles By Make', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_compare') == true){
                do_action("jsvm_addons_user_cp_links_for_compare");
            } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_profile') == true){ ?>
            <div class="jsvehiclemanager-top-portion-link profile">
                <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'profile'))); ?>">
                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/profile.png'; ?>">
                    <div class="jsvehiclemanager-cptext"><?php echo __('Profile', 'js-vehicle-manager'); ?></div>
                </a>
            </div>
            <?php } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_vehiclerss') == true){
                do_action("jsvm_addons_user_cp_links_for_vehiclerss");
            }

            if(jsvehiclemanagercheckLink('dashboard_shortlistvehicles') == true){
                do_action("jsvm_addons_user_cp_links_for_shortlist");
            }

            if(jsvehiclemanagercheckLink('dashboard_vehiclealert') == true){
                do_action("jsvm_addons_user_cp_links_for_vehiclealert");
            } ?>
            <?php if(jsvehiclemanagercheckLink('dashboard_stats') == true){ ?>
                <div class="jsvehiclemanager-top-portion-link stats">
                    <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user', 'jsvmlt'=>'stats'))); ?>">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/stats.png'; ?>">
                        <div class="jsvehiclemanager-cptext"><?php echo __('Stats', 'js-vehicle-manager'); ?></div>
                    </a>
                </div>
            <?php } ?>
            <?php if(JSVEHICLEMANAGERIncluder::getObjectClass('user')->isguest()){ ?>
                    <?php if(jsvehiclemanagercheckLink('dashboard_login') == true){ ?>
                    <div class="jsvehiclemanager-top-portion-link login">
                        <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'jsvehiclemanager', 'jsvmlt'=>'login'))); ?>">
                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/login.png'; ?>">
                            <div class="jsvehiclemanager-cptext"><?php echo __('Login', 'js-vehicle-manager'); ?></div>
                        </a>
                    </div>
                    <?php } ?>
                    <?php if(jsvehiclemanagercheckLink('dashboard_register') == true){ ?>
                    <div class="jsvehiclemanager-top-portion-link profile">
                        <?php
                            if(jsvehiclemanager::$_config['user_registration_custom_link_enabled'] == 1 && jsvehiclemanager::$_config['user_registration_custom_link'] != '' ){
                                $rlink = jsvehiclemanager::$_config['user_registration_custom_link'];
                            }else{
                                $rlink = jsvehiclemanager::makeUrl(array("jsvmme"=>"user","jsvmlt"=>"userregister", "jsvehiclemanagerpageid"=>jsvehiclemanager::getPageid()));
                            }
                        ?>
                        <a href="<?php echo esc_url($rlink); ?>">
                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/profile.png'; ?>">
                            <div class="jsvehiclemanager-cptext"><?php echo __('Register', 'js-vehicle-manager'); ?></div>
                        </a>
                    </div>
                    <?php } ?>
                <?php }else{
                    $logout_link = '';
                    if (isset($_COOKIE['jsvehiclemanager-socialmedia']) && !empty($_COOKIE['jsvehiclemanager-socialmedia'])) {
                        if(in_array('sociallogin', jsvehiclemanager::$_active_addons)){
                            $logout_link = jsvehiclemanager::makeUrl(array('jsvmme'=>'sociallogin', 'task'=>'logout', 'action'=>'jsvmtask', 'media'=>$_COOKIE['jsvehiclemanager-socialmedia'] , 'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()));
                        }
                    } else {
                            $logout_link = wp_logout_url(get_permalink());
                    }
                    ?>
                    <?php if(jsvehiclemanagercheckLink('dashboard_logout') == true){ ?>
                    <div class="jsvehiclemanager-top-portion-link login">
                        <a href="<?php echo esc_url($logout_link); ?>">
                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/buyer-cp/login.png'; ?>">
                            <div class="jsvehiclemanager-cptext"><?php echo __('Logout', 'js-vehicle-manager'); ?></div>
                        </a>
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <?php do_action("jsvm_addons_user_cp_links_for_credits"); ?>
        </div>

    </div>
<?php
}
?>
</div>
