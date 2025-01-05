<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title"><a class="jsanchor-backlink" href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager'));?>"><img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Add ons', 'js-vehicle-manager'); ?></span></span>

        <div id="jsvehiclemanager-content">
            <div id="black_wrapper_translation"></div>
            <div id="jsvm_jstran_loading">
                <img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/spinning-wheel.gif" />
            </div>
            <div id="jsvm-lower-wrapper">
                <div class="jsvm-addon-installer-wrapper step3" >
                    <div class="jsvm-addon-installer-left-image-wrap" >
                        <img class="jsvm-addon-installer-left-image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/addon-images/addon-installer-logo.png" />
                    </div>
                    <div class="jsvm-addon-installer-left-heading" >
                        <?php echo __("Add ons installed and activated successfully","js-vehicle-manager"); ?>
                    </div>
                    <div class="jsvm-addon-installer-left-description" >
                        <?php echo __("Add ons for Car Manager have been installed and activated successfully. ","js-vehicle-manager"); ?>
                    </div>
                    <div class="jsvm-addon-installer-right-button" >
                        <a class="jsvm_btn" href="?page=jsvehiclemanager" ><?php echo __("Control Panel","js-vehicle-manager"); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
