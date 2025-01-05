<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
?>
<div style="display:none;" id="jsvm_ajaxloaded_wait_overlay"></div>
<img style="display:none;" id="jsvm_ajaxloaded_wait_image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/loading.gif'; ?>">

<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvm_full_background" style="display:none;"></div>
    <div id="jsvm_popup_main" style="display:none;">
    </div>
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
        ?>
        <span class="jsvm_js-admin-title">
            <a href="?page=jsvehiclemanager"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php
                if(jsvehiclemanager::$_data['fieldfor'] == 1){
                    echo __('Vehicles','js-vehicle-manager');
                }elseif(jsvehiclemanager::$_data['fieldfor'] == 2){
                    echo __('Seller','js-vehicle-manager');
                }
                echo ' '.__('Field Ordering', 'js-vehicle-manager');
            ?>
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
            <a class="jsvm_js-button-link button" href="?page=jsvm_fieldordering&jsvmlt=formuserfield&ff=<?php echo esc_attr(jsvehiclemanager::$_data['fieldfor']); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add New','js-vehicle-manager') .' '. __('User Field', 'js-vehicle-manager') ?></a>
        </span>
        <div class="jsvm_page-actions js-row no-margin ">
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="fieldpublished" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("publish-field")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/user-publish.png" /><?php echo __('User Publish', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="fieldunpublished" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("unpublish-field")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/user-unpublish.png" /><?php echo __('User Unpublished', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="visitorfieldpublished" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("vpublish-field")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/publish-icon.png" /><?php echo __('Visitor Publish', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="visitorfieldunpublished" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("vunpublish-field")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/unbuplish.png" /><?php echo __('Visitor Unpublished', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="fieldrequired" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("required-field")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" /><?php echo __('Required', 'js-vehicle-manager') ?></a>
            <a class="jsvm_js-bulk-link button jsvm_multioperation" message="<?php echo esc_attr(JSVEHICLEMANAGERmessages::getMSelectionEMessage()); ?>" data-for="fieldnotrequired" data-for-wpnonce="<?php echo esc_attr(wp_create_nonce("notrequired-field")); ?>" href="#"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" /><?php echo __('Not Required', 'js-vehicle-manager') ?></a>
        </div>

        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("div#jsvm_full_background").click(function () {
                    closePopup();
                });
            });

            function resetFrom() {
                jQuery("input#title").val('');
                jQuery("select#ustatus").val('');
                jQuery("select#vstatus").val('');
                jQuery("select#required").val('');
                jQuery("form#jsvehiclemanagerform").submit();
            }

            function showPopupAndSetValues(id) {
                jQuery('div#jsvm_ajaxloaded_wait_overlay').show();
                jQuery('img#jsvm_ajaxloaded_wait_image').show();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'fieldordering', task: 'getOptionsForFieldEdit', field: id, wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        var d = jQuery.parseJSON(data);
                        jQuery("div#jsvm_full_background").css("display", "block");
                        jQuery("div#jsvm_popup_main").html(d);
                        jQuery('div#jsvm_ajaxloaded_wait_overlay').hide();
                        jQuery('img#jsvm_ajaxloaded_wait_image').hide();
                        jQuery("div#jsvm_popup_main").slideDown('slow');
                    }
                });
            }

            function closePopup() {
                jQuery("div#jsvm_popup_main").slideUp('slow');
                setTimeout(function () {
                    jQuery("div#jsvm_full_background").hide();
                    jQuery("div#jsvm_popup_main").html('');
                }, 700);
            }
        </script>
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering&ff=" . jsvehiclemanager::$_data['fieldfor'])); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('title', jsvehiclemanager::$_data['filter']['title'], array('class' => 'inputbox', 'placeholder' => __('Title', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('ustatus', JSVEHICLEMANAGERincluder::getJSModel('common')->getStatus(), is_numeric(jsvehiclemanager::$_data['filter']['ustatus']) ? jsvehiclemanager::$_data['filter']['ustatus'] : '', __('Select user status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vstatus', JSVEHICLEMANAGERincluder::getJSModel('common')->getStatus(), is_numeric(jsvehiclemanager::$_data['filter']['vstatus']) ? jsvehiclemanager::$_data['filter']['vstatus'] : '', __('Select visitor status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('required', JSVEHICLEMANAGERincluder::getJSModel('common')->getYesNo(), is_numeric(jsvehiclemanager::$_data['filter']['required']) ? jsvehiclemanager::$_data['filter']['required'] : '', __('Required', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_filter-bottom-button">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::button('reset', __('Reset', 'js-vehicle-manager'), array('class' => 'button', 'onclick' => 'resetFrom();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>

        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering")); ?>">
                <table id="jsvm_js-table">
                    <thead>
                        <tr>
                            <th class="jsvm_grid"><input type="checkbox" name="selectall" id="jsvm_selectall" value=""></th>
                            <th class="jsvm_left-row"><?php echo __('Field Title', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('User Published', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Visitor Published', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Required', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Ordering', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_action"><?php echo __('Action', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pagenum = JSVEHICLEMANAGERrequest::getVar('pagenum', 'get', 1);
                        $pageid = ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                        for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                            $row = jsvehiclemanager::$_data[0][$i];
                            if (isset(jsvehiclemanager::$_data[0][$i + 1]))
                                $row1 = jsvehiclemanager::$_data[0][$i + 1];
                            else
                                $row1 = jsvehiclemanager::$_data[0][$i];

                            $uptask = 'fieldorderingup';
                            $downtask = 'fieldorderingdown';
                            $upimg = 'uparrow.png';
                            $downimg = 'downarrow.png';

                            $pubtask = $row->published ? 'fieldunpublished' : 'fieldpublished';
                            $pubimg = $row->published ? 'tick.png' : 'publish_x.png';
                            $alt = $row->published ? __('Published', 'js-vehicle-manager') : __('Unpublished', 'js-vehicle-manager');
                            $visitorpubtask = $row->isvisitorpublished ? 'visitorfieldunpublished' : 'visitorfieldpublished';
                            $visitorpubimg = $row->isvisitorpublished ? 'tick.png' : 'publish_x.png';
                            $visitoralt = $row->isvisitorpublished ? __('Published', 'js-vehicle-manager') : __('Unpublished', 'js-vehicle-manager');

                            $requiredtask = $row->required ? 'fieldnotrequired' : 'fieldrequired';
                            $requiredpubimg = $row->required ? 'tick.png' : 'publish_x.png';
                            $requiredalt = $row->required ? __('Required', 'js-vehicle-manager') : __('Not Required', 'js-vehicle-manager');
                            ?>
                            <tr valign="top">
                                <td class="jsvm_grid-rows">
                                    <input type="checkbox" class="jsvehiclemanager-cb" id="jsvehiclemanager-cb" name="jsvehiclemanager-cb[]" value="<?php echo esc_attr($row->id); ?>" />
                                </td>
                                <?php
                                $sec = substr($row->field, 0, 8); //get section_
                                $newsection = 0;
                                if ($sec == 'section_') {
                                    $newsection = 1;
                                    $subsec = substr($row->field, 0, 12);
                                    if ($subsec == 'section_sub_') {
                                        ?>
                                        <td class="jsvm_left-row" ><strong><?php echo esc_attr(__($row->fieldtitle,'js-vehicle-manager')); ?></strong></td>
                                    <?php } else { ?>
                                        <td class="jsvm_left-row" ><strong><font size="2"><?php echo esc_attr(__($row->fieldtitle,'js-vehicle-manager')); ?></font></strong></td>
                                    <?php } ?>
                                    <td>
                                        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                        <?php
                                        } else {
                                            $icon_name = "no.png";
                                            $task = "fieldpublished";
                                            $nonce = "publish-field";
                                            if ($row->published == 1) {
                                                $task = "fieldunpublished";
                                                $nonce = "unpublish-field";
                                                $icon_name = "yes.png";
                                            }
                                            ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task='.$task.'&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),$nonce)); ?>">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo esc_attr($icon_name); ?>" alt="<?php echo esc_attr($alt); ?>" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                        <?php
                                        } else {
                                            $icon_name = "no.png";
                                            $task = "visitorfieldpublished";
                                            $nonce = 'vpublish-field';
                                            if ($row->isvisitorpublished == 1) {
                                                $task = "visitorfieldunpublished";
                                                $nonce = 'vunpublish-field';
                                                $icon_name = "yes.png";
                                            }
                                            ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task='.$task.'&action=jsvmtask&jsvehiclemanager-cb[]'.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),$nonce)); ?>">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo esc_attr($icon_name); ?>" alt="<?php echo esc_attr($visitoralt); ?>" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>--</td>
                                    <td>--</td>
                                    <td><a href="#" onclick="showPopupAndSetValues(<?php echo esc_attr($row->id); ?>)" ><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit.png" title="<?php echo __('Edit', 'js-vehicle-manager'); ?>"></a></td>
                        <?php } else { ?>
                                    <td class="jsvm_left-row">
                                        <?php echo esc_html(__($row->fieldtitle,'js-vehicle-manager')); ?>
                                    </td>
                                    <td>
                                        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                        <?php
                                        } else {
                                            $icon_name = "no.png";
                                            $task = "fieldpublished";
                                            $nonce = 'publish-field';
                                            if ($row->published == 1) {
                                                $task = "fieldunpublished";
                                                $icon_name = "yes.png";
                                                $nonce = 'unpublish-field';
                                            }
                                            ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task='.$task.'&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),$nonce)); ?>">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo $icon_name; ?>" alt="<?php echo $alt; ?>" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($row->cannotunpublish == 1) { ?>
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                        <?php
                                        } else {
                                            $icon_name = "no.png";
                                            $task = "visitorfieldpublished";
                                            $nonce = 'vpublish-field';
                                            if ($row->isvisitorpublished == 1) {
                                                $task = "visitorfieldunpublished";
                                                $icon_name = "yes.png";
                                                $nonce = 'vunpublish-field';
                                            }
                                            ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task='.$task.'&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),$nonce)); ?>">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo $icon_name; ?>" alt="<?php echo $visitoralt; ?>" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($row->sys == 1) { ?>
                                            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot required', 'js-vehicle-manager'); ?>" />
                                        <?php
                                        } else {
                                            $icon_name = "no.png";
                                            $task = "fieldrequired";
                                            $nonce = 'required-field';
                                            if ($row->required == 1) {
                                                $task = "fieldnotrequired";
                                                $icon_name = "yes.png";
                                                $nonce = 'notrequired-field';
                                            }
                                            ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task='.$task.'&action=jsvmtask&jsvehiclemanager-cb[]='.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),$nonce)); ?>">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/<?php echo $icon_name; ?>" alt="<?php echo $requiredalt; ?>" />
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td>
                                           <?php
                                           if ($row->ordering != 1) {
                                               if ($newsection != 1) {
                                                   ?>
                                                <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task=fieldorderingup&action=jsvmtask&fieldid='.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),'fieldup-field')); ?>">
                                                    <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/uparrow.png" alt="Order Up" />
                                                </a>
                                            <?php
                                            } else
                                                echo '    ';
                                        } else
                                            echo '    ';
                                        ?>
                                          <?php echo esc_html($row->ordering); ?>
                                        <?php
                                        //if ($i < $n-1) {
                                        if ($row->section == $row1->section) {
                                            ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task=fieldorderingdown&action=jsvmtask&fieldid='.$row->id.$pageid.'&ff='.jsvehiclemanager::$_data['fieldfor']),'fielddown-field')); ?>">
                                                <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/downarrow.png" alt="Order Down" />
                                            </a>
                                    <?php }
                                    ?>
                                    </td>
                                    <td class="jsvm_action">
                                        <a href="#" onclick="showPopupAndSetValues(<?php echo esc_attr($row->id); ?>)" ><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit.png" title="<?php echo __('Edit', 'js-vehicle-manager'); ?>"></a>
                                        <?php if ($row->isuserfield == 1) { ?>
                                            <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin.php?page=jsvm_fieldordering&task=remove&action=jsvmtask&fieldid='.$row->id.'&ff='.jsvehiclemanager::$_data['fieldfor']),'delete-field')); ?>" onclick="return confirmdelete('<?php echo __('Are you sure to delete', 'js-vehicle-manager').' ?'; ?>');"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" title="<?php echo __('Delete', 'js-vehicle-manager'); ?>"></a>
                                        <?php } ?>
                                    </td>
                        <?php
                        $newsection = 0;
                    }
                    ?>

                            </tr>
                <?php
            }
            ?>
                    </tbody>
                </table>
            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::hidden('task', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::hidden('pagenum', ($pagenum > 1) ? $pagenum : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldfor',jsvehiclemanager::$_data['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::hidden('ff',jsvehiclemanager::$_data['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS);?>
            <?php  echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce',wp_create_nonce('delete-field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>

            </form>
        <?php
        if (jsvehiclemanager::$_data[1]) {
            echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
        }
    } else {
        $msg = __('No record found','js-vehicle-manager');
        $link[] = array(
                    'link' => 'admin.php?page=jsvm_fieldordering&jsvmlt=formuserfield&ff='.jsvehiclemanager::$_data['fieldfor'],
                    'text' => __('Add New','js-vehicle-manager') .' '. __('User Field','js-vehicle-manager')
                );
        echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg,$link), JSVEHICLEMANAGER_ALLOWED_TAGS);
    }
    ?>
    </div>
</div>
