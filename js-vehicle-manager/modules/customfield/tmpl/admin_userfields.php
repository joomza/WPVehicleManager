<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsvm-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERIncluder::getJSModel('customfield')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php echo __('User Fields', 'js-vehicle-manager') ?>
            <a class="jsvm_js-button-link button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_fieldordering&jsvmlt=formuserfield')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add User Field', 'js-vehicle-manager') ?></a>
        </span>
        <div class="jsvm_page-actions js-row no-margin">
            <a class="jsvm_js-bulk-link jsvm_button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="remove" confirmmessage="<?php echo __('Are you sure to delete', 'js-vehicle-manager') .' ?'; ?>"  href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete-icon.png" /><?php echo __('Delete', 'js-vehicle-manager') ?></a>
        </div>
        <script	type="text/javascript">
            function resetFrom() {
                jQuery("input#title").val('');
                jQuery("select#type").val('');
                jQuery("select#required").val('');
                jQuery("form#jsvehiclemanagerform").submit();
            }
        </script>
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_customfield&ff=" . jsvehiclemanager::$_data['fieldfor'])); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('title', jsvehiclemanager::$_data['filter']['title'], array('class' => 'jsvm_inputbox', 'placeholder' => __('Title', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('type', JSVEHICLEMANAGERincluder::getJSModel('common')->getFeilds(), is_numeric(jsvehiclemanager::$_data['filter']['type']) ? jsvehiclemanager::$_data['filter']['type'] : __('Select type', 'js-vehicle-manager'), __('Select','js-vehicle-manager') .' '. __('Field Type', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('required', JSVEHICLEMANAGERincluder::getJSModel('common')->getYesNo(), is_numeric(jsvehiclemanager::$_data['filter']['required']) ? jsvehiclemanager::$_data['filter']['required'] : '', __('Select required', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('jsvm_form_search', 'jsvm_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_filter-bottom-button">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'jsvm_button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'jsvm_button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>
        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_customfield")); ?>">
                <table id="jsvm_js-table">
                    <thead>
                        <tr>
                            <th class="jsvm_grid"><input type="checkbox" name="selectall" id="jsvm_selectall" value=""></th>
                            <th class="jsvm_left-row"><?php echo __('Field Name', 'js-vehicle-manager'); ?></th>
                            <th><?php echo __('Field Title', 'js-vehicle-manager'); ?></th>
                            <th><?php echo __('Field Type', 'js-vehicle-manager'); ?></th>
                            <th><?php echo __('Required', 'js-vehicle-manager'); ?></th>
                            <th><?php echo __('Read Only', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_action"><?php echo __('Action', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 0;
                        for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                            $row = jsvehiclemanager::$_data[0][$i];
                            $required = ($row->required == 1) ? 'yes' : 'no';
                            $requiredalt = ($row->required == 1) ? __('Required', 'js-vehicle-manager') : __('Not Required', 'js-vehicle-manager');
                            $readonly = ($row->readonly == 1) ? 'yes' : 'no';
                            $readonlyalt = ($row->readonly == 1) ? __('Required', 'js-vehicle-manager') : __('Not Required', 'js-vehicle-manager');
                            ?>
                            <tr valign="top">
                                <td class="jsvm_grid-rows">
                                    <input type="checkbox" class="jsvm_jsvm-vm-cb" id="jsvehiclemanager-cb" name="jsvm-vm-cb[]" value="<?php echo $row->id; ?>" />
                                </td>
                                <td class="jsvm_left-row"><a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_customfield&jsvmlt=formuserfield&jsvehiclemanagerid='.$row->id)); ?>"><?php echo esc_attr($row->name); ?></a></td>
                                <td><?php echo esc_html($row->title); ?></td>
                                <td><?php echo esc_html($row->type); ?></td>
                                <td><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo esc_attr($required); ?>.png" alt="<?php echo esc_attr($requiredalt); ?>" /></td>
                                <td><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo esc_attr($readonly); ?>.png" alt="<?php echo esc_attr($readonlyalt); ?>" /></td>
                                <td class="jsvm_action">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_customfield&jsvmlt=formuserfield&jsvehiclemanagerid='.$row->id)); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit.png" title="<?php echo __('Edit', 'js-vehicle-manager'); ?>"></a>
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_customfield&task=remove&action=jsvmtask&jsvm-vm-cb[]='.$row->id),'delete-customfield')); ?>" onclick="return confirmdelete('<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>');"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" title="<?php echo __('Delete', 'js-vehicle-manager'); ?>"></a>
                                </td>
                            </tr>
                            <?php
                            $k = 1 - $k;
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'customfield_remove'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('delete-customfield')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' .  wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
            }
        } else {
            echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound(), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
