<?php
delete_option( 'jsvm_addon_install_data' );
delete_option( 'jsvm_addon_install_data_actual_transaction_key' );
?>
    <div id="jsvehiclemanageradmin-wrapper">
        <div id="jsvehiclemanageradmin-leftmenu">
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
        </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title"><a class="jsanchor-backlink" href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager'));?>"><img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Add ons', 'js-vehicle-manager'); ?></span></span>

        <div id="jsvehiclemanager-content">
            <div id="jsvm_black_wrapper_translation"></div>
            <div id="jsvm_jstran_loading">
                <img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="jsvm-lower-wrapper">
                <div class="jsvm-addon-installer-wrapper" >
                    <form id="jsvehiclefrom" action="<?php echo esc_url(admin_url('admin.php?page=jsvm_premiumplugin&task=verifytransactionkey&action=jsvmtask')); ?>" method="post">
                        <div class="jsvm-addon-installer-left-section-wrap" >
                            <div class="jsvm-addon-installer-left-image-wrap" >
                                <img class="jsvm-addon-installer-left-image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/addon-images/addon-installer-logo.png" />
                            </div>
                            <div class="jsvm-addon-installer-left-heading" >
                                <?php echo __("Vehicle Manager","js-vehicle-manager"); ?>
                            </div>
                            <div class="jsvm-addon-installer-left-title" >
                                <?php echo __("Wordpress Plugin","js-vehicle-manager"); ?>
                            </div>
                            <div class="jsvm-addon-installer-left-description" >
                                <?php echo __("Vehicle Manager is a car dealership plugin that is easy to use. Vehicle Manager provides all the functionalities whether you want to build a small car dealer or a large car dealership. Vehicle Manager is highly customizable it has a powerful interface for admin using which he can fully control all the functionalities and features of Vehicle Manager.","js-vehicle-manager"); ?>
                            </div>
                        </div>
                        <div class="jsvm-addon-installer-right-section-wrap" >
                            <div class="jsvm-addon-installer-right-heading" >
                                <?php echo __("Vehicle Manager Addon Installer","js-vehicle-manager"); ?>
                            </div>
                            <div class="jsvm-addon-installer-right-description" >
                                <a href="?page=jsvm_premiumplugin&jsvmlt=addonfeatures" class="jsvm-addon-installer-addon-list-link" >
                                    <?php echo __("Add-on list","js-vehicle-manager"); ?>
                                </a>
                            </div>
                            <div class="jsvm-addon-installer-right-key-section" >
                                <div class="jsvm-addon-installer-right-key-label" >
                                    <?php echo __("Please Insert Your Transaction key","js-vehicle-manager"); ?>.
                                </div>

                                <?php
                                $error_message = '';
                                $transactionkey = '';
                                if(get_option( 'jsvm_addon_return_data', '' ) != ''){
                                    if(get_option( 'jsvm_addon_return_data_status' , 0) == 0){
                                        $error_message = get_option( 'jsvm_addon_return_data_message');
                                        $transactionkey = get_option( 'jsvm_addon_return_data_transactionkey');
                                    }
                                    delete_option( 'jsvm_addon_return_data' );
                                    delete_option( 'jsvm_addon_return_data_status' );
                                    delete_option( 'jsvm_addon_return_data_message' );
                                    delete_option( 'jsvm_addon_return_data_transactionkey' );
                                }

                                ?>
                                <div class="jsvm-addon-installer-right-key-field" >
                                    <input type="text" name="transactionkey" id="transactionkey" class="jsvm_key_field" value="<?php echo esc_html($transactionkey);?>" placeholder="<?php echo __('Transaction key','js-vehicle-manager'); ?>"/>
                                    <?php if($error_message != '' ){ ?>
                                        <div class="jsvm-addon-installer-right-key-field-message" > <img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/icon.png" /> <?php echo esc_html($error_message);?></div>
                                    <?php } ?>
                                </div>
                                <div class="jsvm-addon-installer-right-key-button" >
                                    <button type="submit" class="jsvm_btn" role="submit" onclick="jsShowLoading();"><?php echo __("Proceed","js-vehicle-manager"); ?></button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('#jsvehiclefrom').on('submit', function() {
            jsShowLoading();
        });
    });

    function jsShowLoading(){
        jQuery('div#jsvm_black_wrapper_translation').show();
        jQuery('div#jsvm_jstran_loading').show();
    }
</script>
