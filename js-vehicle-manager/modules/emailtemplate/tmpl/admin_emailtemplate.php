<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php echo __('Email Templates', 'js-vehicle-manager'); ?>
        </span>
        <form method="post" class="jsvm_emailtemplateform" action="<?php echo esc_url(admin_url("?page=jsvm_emailtemplate&task=saveemailtemplate")); ?>">
            <div class="jsvm_js-email-menu">
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'nw-ve-a') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=nw-ve-a')); ?>"><?php echo __('New Vehicle Admin', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'nw-ve') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=nw-ve')); ?>"><?php echo __('New Vehicle', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'nw-ve-v') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=nw-ve-v')); ?>"><?php echo __('Visitor Vehicle', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 've-st') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=ve-st')); ?>"><?php echo __('Vehicle Status', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'de-ve') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=de-ve')); ?>"><?php echo __('Delete Vehicle', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'cr-pr-a') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=cr-pr-a')); ?>"><?php echo __('Credits Purchase Admin', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'cr-pr') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=cr-pr')); ?>"><?php echo __('Credits Purchase', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'cr-ex') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=cr-ex')); ?>"><?php echo __('Credits Expire', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'nw-sl') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=nw-sl')); ?>"><?php echo __('Register New Seller', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 've-al') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=ve-al')); ?>"><?php echo __('Vehicle Alert', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 't-a-fr') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=t-a-fr')); ?>"><?php echo __('Tell A Friend', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'mk-a-of') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=mk-a-of')); ?>"><?php echo __('Make An Offer', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'sc-t-dr') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=sc-t-dr')); ?>"><?php echo __('Schedule Test Drive', 'js-vehicle-manager'); ?></a></span>
                <span class="jsvm_js-email-menu-link <?php if (jsvehiclemanager::$_data[1] == 'mg-t-sr') echo 'jsvm_selected'; ?>"><a class="jsvm_js-email-link" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_emailtemplate&for=mg-t-sr')); ?>"><?php echo __('Message To Seller', 'js-vehicle-manager'); ?></a></span>
            </div>
            <div class="jsvm_js-email-body">
                <div class="jsvm_js-form-wrapper">
                    <div class="jsvm_a-js-form-title"><?php echo __('Subject', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_a-js-form-field"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('subject', jsvehiclemanager::$_data[0]->subject, array('class' => 'jsvm_inputbox', 'style' => 'width:100%;')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                </div>
                <div class="jsvm_js-form-wrapper">
                    <div class="jsvm_a-js-form-title"><?php echo __('Body', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_a-js-form-field"><?php echo wp_kses_post(wp_editor(jsvehiclemanager::$_data[0]->body, 'body', array('media_buttons' => false)), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                </div>
                <div class="jsvm_js-email-parameters">
                    <span class="jsvm_js-email-parameter-heading"><?php echo __('Parameters', 'js-vehicle-manager') ?></span>

                    <?php if (jsvehiclemanager::$_data[1] == 'nw-ve-a'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{LOCATION}:  <?php echo __('Vehicle location', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_STATUS}:  <?php echo __('Vehicle status', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_CREDITS}:  <?php echo __('Vehicle credits', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_LINK}:  <?php echo __('Vehicle link', 'js-vehicle-manager'); ?></span>
                    <?php
                        foreach (jsvehiclemanager::$_data[2] as $field ) {
                            if($field->userfieldtype != 'file'){ ?>
                                <span class="jsvm_js-email-paramater">{<?php echo esc_html($field->field.'_'.$field->fieldfor);?>} : <?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></span>
                    <?php   }
                        }
                    }elseif (jsvehiclemanager::$_data[1] == 'nw-ve'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{LOCATION}:  <?php echo __('Vehicle location', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_STATUS}:  <?php echo __('Vehicle status', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_CREDITS}:  <?php echo __('Vehicle credits', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_LINK}:  <?php echo __('Vehicle link', 'js-vehicle-manager'); ?></span>
                    <?php
                            foreach (jsvehiclemanager::$_data[2] as $field ) {
                                if($field->userfieldtype != 'file'){ ?>
                                    <span class="jsvm_js-email-paramater">{<?php esc_html($field->field.'_'.$field->fieldfor);?>} : <?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></span>
                        <?php   }
                            }
                        }elseif (jsvehiclemanager::$_data[1] == 'nw-ve-v'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{LOCATION}:  <?php echo __('Vehicle location', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_STATUS}:  <?php echo __('Vehicle status', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_LINK}:  <?php echo __('Vehicle link', 'js-vehicle-manager'); ?></span>
                    <?php
                            foreach (jsvehiclemanager::$_data[2] as $field ) {
                                if($field->userfieldtype != 'file'){ ?>
                                    <span class="jsvm_js-email-paramater">{<?php echo esc_html($field->field.'_'.$field->fieldfor);?>} : <?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></span>
                        <?php   }
                            }
                        }elseif (jsvehiclemanager::$_data[1] == 've-st'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{LOCATION}:  <?php echo __('Vehicle location', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_CREDITS}:  <?php echo __('Vehicle credits', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_LINK}:  <?php echo __('Vehicle link', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_STATUS}:  <?php echo __('Vehicle approve or reject', 'js-vehicle-manager').'('.__('Featured','js-vehicle-manager') . ')'; ?></span>
                    <?php
                            foreach (jsvehiclemanager::$_data[2] as $field ) {
                                if($field->userfieldtype != 'file'){ ?>
                                    <span class="jsvm_js-email-paramater">{<?php echo esc_html($field->field.'_'.$field->fieldfor);?>} : <?php echo esc_html(__($field->fieldtitle, 'js-vehicle-manager')); ?></span>
                        <?php   }
                            }
                        }elseif (jsvehiclemanager::$_data[1] == 'de-ve'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 'cr-pr-a'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_NAME}:  <?php echo __('Package name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_PRICE}:  <?php echo __('Package price', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_PURCHASE_DATE}:  <?php echo __('Package purchase date', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 'cr-pr'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_NAME}:  <?php echo __('Package name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_PRICE}:  <?php echo __('Package price', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_LINK}:  <?php echo __('Package link', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_PURCHASE_DATE}:  <?php echo __('Package purchase date', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 'cr-ex'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_NAME}:  <?php echo __('Package name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_LINK}:  <?php echo __('Package link', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{PACKAGE_PURCHASE_DATE}:  <?php echo __('Package purchase date', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 'nw-sl'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{MY_DASHBOARD_LINK}:  <?php echo __('My dashboard link', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 've-al'){ ?>
                        <span class="jsvm_js-email-paramater">{VEHICLES_DATA}:  <?php echo __('Vehicles list that match your alert criteria', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 't-a-fr'){ ?>
                        <span class="jsvm_js-email-paramater">{SENDER_NAME}:  <?php echo __('Sender name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{SITE_NAME}:  <?php echo __('Your website name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_LINK}:  <?php echo __('Vehicle link', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{SENDER_MESSAGE}:  <?php echo __('Sender message', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 'mk-a-of'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_NAME}:  <?php echo __('Customer name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_EMAIL_ADDRESS}:  <?php echo __('Customer Email Address', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_CELL_PHONE}:  <?php echo __('Customer mobile no', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_OFFERED_PRICE}:  <?php echo __('Customer offered price', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_MESSAGE}:  <?php echo __('Customer message', 'js-vehicle-manager'); ?></span>
                    <?php }elseif (jsvehiclemanager::$_data[1] == 'sc-t-dr'){ ?>
                        <span class="jsvm_js-email-paramater">{SELLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{VEHICLE_TITLE}:  <?php echo __('Vehicle title', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_NAME}:  <?php echo __('Customer name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_EMAIL_ADDRESS}:  <?php echo __('Customer Email Address', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{CUSTOMER_CELL_PHONE}:  <?php echo __('Customer mobile no', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{DAY}:  <?php echo __('Test Drive Date', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{TIME}:  <?php echo __('Test Drive Time', 'js-vehicle-manager'); ?></span>

                    <?php }elseif (jsvehiclemanager::$_data[1] == 'mg-t-sr'){ ?>
                        <span class="jsvm_js-email-paramater">{SLLER_NAME}:  <?php echo __('Seller name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{SENDER_NAME}:  <?php echo __('Sender name', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{SENDER_EMAIL_ADDRESS}:  <?php echo __('Sender email address', 'js-vehicle-manager'); ?></span>
                        <span class="jsvm_js-email-paramater">{MESSAGE}:  <?php echo __('Message from sender', 'js-vehicle-manager'); ?></span>
                    <?php } ?>

                </div>
                <div class="jsvm_js-form-button">
                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('Email Template', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                </div>
            </div>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', jsvehiclemanager::$_data[0]->id), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('created', jsvehiclemanager::$_data[0]->created), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('templatefor', jsvehiclemanager::$_data[0]->templatefor), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('for', jsvehiclemanager::$_data[1]), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'emailtemplate_saveemailtemplate'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-emailtemplate')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
        </form>
    </div>
</div>
