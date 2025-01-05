<script	type="text/javascript">
    function resetFrom() {
        jQuery("input#countryname").val('');
        jQuery("select#status").val('');
        jQuery("#states1").prop('checked', false);
        jQuery("#city1").prop('checked', false);
        jQuery("form#jsvehiclemanagerform").submit();
    }
</script>
<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('country')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a class="jsvm_js-admin-title-left" href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" />
            <?php echo __('Country', 'js-vehicle-manager') ?>
            </a>
            <a class="jsvm_js-button-link button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_country&jsvmlt=formcountry')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add New','js-vehicle-manager') .' '. __('Country', 'js-vehicle-manager') ?></a>
        </span>
        <div class="jsvm_page-actions js-row no-margin">
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="publish" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("publish-country")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/publish-icon.png" /><?php echo __('Publish', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="unpublish" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("unpublish-country")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/unbuplish.png" /><?php echo __('Unpublished', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="remove" confirmmessage="<?php echo __('Are you sure to delete', 'js-vehicle-manager') .' ?'; ?>"  href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/delete-icon.png" /><?php echo __('Delete', 'js-vehicle-manager') ?></a>
        </div>
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_country")); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('countryname', jsvehiclemanager::$_data['filter']['countryname'], array('class' => 'inputbox', 'placeholder' => __('Name', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('status', JSVEHICLEMANAGERincluder::getJSModel('common')->getstatus(), is_numeric(jsvehiclemanager::$_data['filter']['status']) ? jsvehiclemanager::$_data['filter']['status'] : '', __('Select status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_checkbox">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('states', array('1' => __('Has states', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['states']) ? jsvehiclemanager::$_data['filter']['states'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
            <div class="jsvm_checkbox">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('city', array('1' => __('Has cities', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['city']) ? jsvehiclemanager::$_data['filter']['city'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
            <div class="jsvm_filter-bottom-button">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>
        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_country")); ?>">
                <table id="jsvm_js-table">
                    <thead>
                        <tr>
                            <th class="jsvm_grid"><input type="checkbox" name="selectall" id="jsvm_selectall" value=""></th>
                            <th class="jsvm_left-row"><?php echo __('Name', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Published', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('States', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Cities', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_action"><?php echo __('Action', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', 1);
                        $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                        foreach (jsvehiclemanager::$_data[0] AS $row) {
                            $published = ($row->enabled == 1) ? 'yes.png' : 'no.png';
                            ?>
                            <tr>
                                <td class="jsvm_grid-rows">
                                    <input type="checkbox" class="jsvehiclemanager-cb" id="jsvehiclemanager-cb" name="jsvehiclemanager-cb[]" value="<?php echo $row->id; ?>" />
                                </td>
                                <td class="jsvm_left-row"><a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_country&jsvmlt=formcountry&jsvehiclemanagerid='.$row->id)); ?>"><?php echo __($row->name,'js-vehicle-manager'); ?></a></td>
                                <td>
                                    <?php if ($row->enabled == 1) { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_country&task=unpublish&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid),'unpublish-country')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" alt="<?php echo __('Published', 'js-vehicle-manager'); ?>" />
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_country&task=publish&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid),'publish-country')); ?>">
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" alt="<?php echo __('Not Published', 'js-vehicle-manager'); ?>" />
                                        </a>
                                    <?php } ?>
                                </td>
                                <td><a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_state&countryid='.$row->id)); ?>"> <?php echo __('States', 'js-vehicle-manager'); ?></a></td>
                                <td><a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_city&countryid='.$row->id)); ?>"> <?php echo __('Cities', 'js-vehicle-manager'); ?></a></td>
                                <td class="jsvm_action">
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_country&jsvmlt=formcountry&jsvehiclemanagerid='.$row->id)); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit.png" title="<?php echo __('Edit', 'js-vehicle-manager'); ?>"></a>
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_country&task=remove&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id),'delete-country')); ?>" onclick="return confirmdelete('<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>');"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" title="<?php echo __('Delete', 'js-vehicle-manager'); ?>"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'country_removecountry'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('delete-country')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </form>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
            }
        } else {
            $msg = __('No record found','js-vehicle-manager');
            $link[] = array(
                        'link' => 'admin.php?page=jsvm_country&jsvmlt=formcountry',
                        'text' => __('Add New','js-vehicle-manager') .' '. __('Country','js-vehicle-manager')
                    );
            echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg,$link), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
