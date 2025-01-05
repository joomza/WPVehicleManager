<?php
if(!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a class="jsvm_js-admin-title-left" href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" />
             <?php echo __('Mileages', 'js-vehicle-manager'); ?>
            </a>

            <a class="jsvm_js-button-link button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_mileages&jsvmlt=formmileage')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add New','js-vehicle-manager') .' '. __('Mileages','js-vehicle-manager'); ?></a>
        </span>
        <div class="jsvm_page-actions">
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="publish" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("publish-milage")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/publish-icon.png" /><?php echo __('Publish', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="unpublish" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("unpublish-milage")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/unbuplish.png" /><?php echo __('Unpublished', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" confirmmessage="<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>" data-for="remove" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete-icon.png" /><?php echo __('Delete', 'js-vehicle-manager') ?></a>
        </div>
        <script type="text/javascript">
            function resetFrom() {
                jQuery("input#title").val('');
                jQuery("select#status").val('');
                jQuery("form#jsvehiclemanagerform").submit();
            }
        </script>
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_mileages")); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('title', jsvehiclemanager::$_data['filter']['title'], array('class' => 'inputbox', 'placeholder' => __('Title', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('status', JSVEHICLEMANAGERincluder::getJSModel('common')->getstatus(), jsvehiclemanager::$_data['filter']['status'], __('Select status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
        </form>
        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_mileages")); ?>">
                <table id="jsvm_js-table">
                    <thead>
                        <tr>
                            <th class="jsvm_grid"><input type="checkbox" name="selectall" id="jsvm_selectall" value=""></th>
                            <th class="jsvm_left-row"><?php echo __('Title', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Default', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Published', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Ordering', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_action"><?php echo __('Action', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', 1);
                        $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                        $islastordershow = JSVEHICLEMANAGERpagination::isLastOrdering(jsvehiclemanager::$_data['total'], $pagenum);
                        for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                            $row = jsvehiclemanager::$_data[0][$i];
                            $upimg = 'uparrow.png';
                            $downimg = 'downarrow.png';
                            ?>
                            <tr valign="top">
                                <td class="jsvm_grid-rows">
                                    <input type="checkbox" class="jsvehiclemanager-cb" id="jsvehiclemanager-cb" name="jsvehiclemanager-cb[]" value="<?php echo esc_attr($row->id); ?>" />
                                </td>
                                <td class="jsvm_left-row">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_mileages&jsvmlt=formmileage&jsvehiclemanagerid='.$row->id)); ?>">
                                        <?php echo esc_html(__($row->title,'js-vehicle-manager')); ?></a>
                                </td>
                                <td>
                                    <?php if ($row->isdefault == 1) { ?>
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/default.png" alt="Default" border="0" />
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_common&task=makedefault&action=jsvmtask&for=mileages&id='.$row->id.$pageid.'&jsvmlt=mileages'),'make-default')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/notdefault.png" border="0" alt="Not Default" />
                                        </a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($row->status == 1) { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_mileages&task=unpublish&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid),'unpublish-milage')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" border="0" alt="<?php echo __('Published', 'js-vehicle-manager'); ?>" />
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_mileages&task=publish&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid),'publish-milage')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" border="0" alt="<?php echo __('Not Published', 'js-vehicle-manager'); ?>" />
                                        </a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($i != 0 || $pagenum > 1) { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_common&task=defaultorderingup&action=jsvmtask&for=mileages&id='.$row->id.$pageid.'&jsvmlt=mileages'),'field-up')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo esc_attr($upimg); ?>" border="0" alt="Order Up" />
                                        </a>
                                    <?php } else echo '     '; ?>
                                    <?php echo esc_html($row->ordering); ?>
                                    <?php if ($i < $n - 1 || $islastordershow) { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_common&task=defaultorderingdown&action=jsvmtask&for=mileages&id='.$row->id.$pageid.'&jsvmlt=mileages'),'field-down')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo esc_attr($downimg); ?>" border="0" alt="Order Down" />
                                        </a>
                                    <?php } ?>
                                </td>
                                <td class="jsvm_action">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_mileages&jsvmlt=formmileage&jsvehiclemanagerid='.$row->id)); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit.png" title="<?php echo __('Edit', 'js-vehicle-manager'); ?>"></a>
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_mileages&task=remove&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id),'delete-milage')); ?>" onclick="return confirmdelete('<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>');"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" title="<?php echo __('Delete', 'js-vehicle-manager'); ?>"></a>
                                </td>
                            </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                </table>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'adexpiry_remove'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('delete-milage')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
            }
        } else {
            $msg = __('No record found','js-vehicle-manager');
            $link[] = array(
                        'link' => 'admin.php?page=jsvm_mileages&jsvmlt=formmileage',
                        'text' => __('Add New','js-vehicle-manager') .' '. __('Mileages','js-vehicle-manager')
                    );
             echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg,$link), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
