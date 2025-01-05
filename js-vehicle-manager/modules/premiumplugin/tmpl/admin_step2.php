 <?php
$allPlugins = get_plugins(); // associative array of all installed plugins

$addon_array = array();
foreach ($allPlugins as $key => $value) {
    $addon_index = explode('/', $key);
    $addon_array[] = $addon_index[0];
}
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title"><a class="jsanchor-backlink" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_premiumplugin'));?>"><img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Add ons', 'js-vehicle-manager'); ?></span></span>

        <div id="jsvehiclemanager-content">
            <div id="jsvm_black_wrapper_translation"></div>
            <div id="jsvm_jstran_loading">
                <img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="jsvm-lower-wrapper">
                <div class="jsvm-addon-installer-wrapper" >
                    <form id="jsvehiclefrom" action="<?php echo esc_url(admin_url('admin.php?page=jsvm_premiumplugin&task=downloadandinstalladdons&action=jsvmtask')); ?>" method="post">
                        <div class="jsvm-addon-installer-left-section-wrap" >
                            <div class="jsvm-addon-installer-left-image-wrap" >
                                <img class="jsvm-addon-installer-left-image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/addon-images/addon-installer-logo.png" />
                            </div>
                            <div class="jsvm-addon-installer-left-heading" >
                                <?php echo __("Car Manager","js-vehicle-manager"); ?>
                            </div>
                            <div class="jsvm-addon-installer-left-title" >
                                <?php echo __("Wordpress Plugin","js-vehicle-manager"); ?>
                            </div>
                            <div class="jsvm-addon-installer-left-description" >
                                <?php echo __("Car Manager is a car dealership plugin that is easy to use. Car Manager provides all the functionalities whether you want to build a small car dealer or a large car dealership. Car Manager is highly customizable it has a powerful interface for admin using which he can fully control all the functionalities and features of Car Manager.","js-vehicle-manager"); ?>
                            </div>
                        </div>
                        <div class="jsvm-addon-installer-right-section-wrap step2" >
                            <div class="jsvm-addon-installer-right-heading" >
                                <?php echo __("Car Manager Addon Installer","js-vehicle-manager"); ?>
                            </div>
                            <div class="jsvm-addon-installer-right-addon-wrapper" >
                                <?php
                                $error_message = '';
                                $result = array();
                                if(get_option( 'jsvm_addon_install_data' , "-1") != "-1"){
                                    $result = get_option( 'jsvm_addon_install_data');
                                    if(isset($result['status']) && $result['status'] == 1){?>
                                        <div class="jsvm-addon-installer-right-addon-title">
                                            <?php echo __("Select Addons for download","js-vehicle-manager"); ?>
                                        </div>
                                        <div class="jsvm-addon-installer-right-addon-section" >
                                            <?php
                                            if(!empty($result['data'])){
                                                $addon_availble_count = 0;
                                                foreach ($result['data'] as $key => $value) {
                                                    if(!in_array($key, $addon_array)){
                                                        $addon_availble_count++;
                                                        $addon_slug_array = explode('-', $key);
                                                        $addon_image_name = $addon_slug_array[count($addon_slug_array) - 1];
                                                        $addon_slug = str_replace('-', '', $key);

                                                        $addon_img_path = '';
                                                        if($addon_image_name == 'adsense'){
                                                            $addon_image_name = 'jsvm_ad';
                                                        }
                                                        $addon_img_path = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/add-on-list/';
                                                        if($value['status'] == 1){ ?>
                                                            <div class="jsvm-addon-installer-right-addon-single" >
                                                                <img class="jsvm-addon-installer-right-addon-image" data-addon-name="<?php echo $key; ?>" src="<?php echo $addon_img_path.$addon_image_name.'.png';?>" />
                                                                <div class="jsvm-addon-installer-right-addon-name" >
                                                                    <?php echo esc_html($value['title']);?>
                                                                </div>
                                                                <input type="checkbox" class="jsvm-addon-installer-right-addon-single-checkbox" id="addon-<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="1">
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                if($addon_availble_count == 0){ // all allowed addon are already installed
                                                    $error_message = __('All allowed add ons are already installed','js-vehicle-manager').'.';
                                                }
                                            }else{ // no addon returend
                                                $error_message = __('You are not allowed to install any add on','js-vehicle-manager').'.';
                                            }
                                            if($error_message != ''){
                                                $url = esc_url(admin_url("admin.php?page=jsvm_premiumplugin&jsvmlt=step1"));

                                                echo '<div class="jsvm-addon-go-back-messsage-wrap">';
                                                echo '<h1>';
                                                echo esc_html($error_message);
                                                echo '</h1>';

                                                echo '<a class="jsvm-addon-go-back-link" href="'.$url.'">';
                                                echo __('Back','js-vehicle-manager');
                                                echo '</a>';
                                                echo '</div>';
                                            }
                                             ?>
                                        </div>
                                        <?php if($error_message == ''){ ?>
                                            <div class="jsvm-addon-installer-right-addon-bottom" >
                                                <label for="jsvm-addon-installer-right-addon-checkall-checkbox"><input type="checkbox" class="jsvm-addon-installer-right-addon-checkall-checkbox" id="jsvm-addon-installer-right-addon-checkall-checkbox"><?php echo __("Select All Addons","js-vehicle-manager"); ?></label>
                                            </div>
                                        <?php
                                        }
                                    }
                                }else{
                                    $error_message = __('Somthing Went Wrong','js-vehicle-manager').'!';
                                    $url = esc_url(admin_url("admin.php?page=jsvm_premiumplugin&jsvmlt=step1"));

                                    echo '<div class="jsvm-addon-go-back-messsage-wrap">';
                                    echo '<h1>';
                                    echo esc_html($error_message);
                                    echo '</h1>';

                                    echo '<a class="jsvm-addon-go-back-link" href="'.$url.'">';
                                    echo __('Back','js-vehicle-manager');
                                    echo '</a>';
                                    echo '</div>';
                                }

                                 ?>
                            </div>
                            <?php if($error_message == ''){ ?>
                                <div class="jsvm-addon-installer-right-button" >
                                    <button type="submit" class="jsvm_btn" role="submit" onclick="jsShowLoading();"><?php echo __("Proceed","js-vehicle-manager"); ?></button>
                                </div>
                            <?php } ?>
                        </div>
                        <input type="hidden" name="token" value="<?php echo esc_html($result['token']); ?>"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("")
        jQuery('#jsvehiclefrom').on('submit', function() {
            jsShowLoading();
        });

        jQuery('.jsvm-addon-installer-right-addon-image').on('click', function() {
            var addon_name = jQuery(this).attr('data-addon-name')
            var prop_checked = jQuery("#addon-"+addon_name).prop("checked");
            if(prop_checked){
                jQuery("#addon-"+addon_name).prop("checked", false);
            }else{
                jQuery("#addon-"+addon_name).prop("checked", true);
            }
        });
        // to handle select all check box.
        jQuery('#jsvm-addon-installer-right-addon-checkall-checkbox').change(function() {
           jQuery(".jsvm-addon-installer-right-addon-single-checkbox").prop("checked", this.checked);
       });


    });

    function jsShowLoading(){
        jQuery('div#jsvm_black_wrapper_translation').show();
        jQuery('div#jsvm_jstran_loading').show();
    }
</script>
<?php
delete_option( 'jsvm_addon_install_data' );
delete_option( 'jsvm_addon_install_data_actual_transaction_key' );
?>
