<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php  JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title"><a class="jsanchor-backlink" href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager'));?>"><img alt="image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premium Add ons', 'js-vehicle-manager'); ?></span></span>

        <div id="jsvmadmin-data">
            <h1 class="jsvm-missing-addon-message" >
                <?php
                $addon_name = JSVEHICLEMANAGERrequest::getVar('page');
                $addon_name = explode('_', $addon_name);
                echo esc_html(ucfirst($addon_name[1])).'&nbsp;';
                echo __('addon is no longer active','js-vehicle-manager').'!';
                ?>

            </h1>
        </div>
    </div>
</div>
