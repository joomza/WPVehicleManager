<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
wp_enqueue_script('jquery-ui-sortable');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
wp_enqueue_style('jquery-ui-css', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');
$searchable_combo = array(
        (object) array('id' => 1, 'text' => __('Enabled', 'js-vehicle-manager')),
        (object) array('id' => 0, 'text' => __('Disabled', 'js-vehicle-manager')));
?>


<script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery("div#jsvm_full_background").click(function () {
                    searchclosePopup();
                });

                jQuery('table#jsvm_js-table tbody').sortable({
                    handle : ".grid-rows , .jsvm_left-row",
                    update  : function () {
                        var abc =  jQuery('table#jsvm_js-table tbody').sortable('serialize');
                        jQuery('input#fields_ordering_new').val(abc);
                    }
                });
            });

            function searchShowPopupAndSetValues(id,title_string, search_user, search_visitor) {
                jQuery("select#search_user").val(search_user);
                jQuery("select#search_visitor").val(search_visitor);
                jQuery("input#id").val(id);
                jQuery("span#jsvm_popup_title").html(title_string);
                jQuery("div#jsvm_full_background").css("display", "block");
                jQuery("div#jsvm_popup_main").slideDown('slow');
            }

            function searchclosePopup() {
                jQuery("div#jsvm_popup_main").slideUp('slow');
                setTimeout(function () {
                    jQuery("div#jsvm_full_background").hide();
                    //jQuery("div#jsvm_popup_main").html('');
                }, 700);
            }
        </script>

<div style="display:none;" id="jsvm_ajaxloaded_wait_overlay"></div>
<img style="display:none;" id="jsvm_ajaxloaded_wait_image" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL . 'includes/images/loading.gif'; ?>">

<div id="jsvehiclemanageradmin-wrapper">

    <div id="jsvm_full_background" style="display:none;"></div>
    <div id="jsvm_popup_main" style="display:none;">
        <span class="jsvm_popup-top">
            <span id="jsvm_popup_title" >
            </span> 
            <img id="jsvm_popup_cross" alt="popup cross" onClick="searchclosePopup()" src="<?php echo  JSVEHICLEMANAGER_PLUGIN_URL;?>includes/images/popup-close.png">
        </span>
        <form id="jsvehiclemanager-form" class="jsvm_popup-field-from" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering&task=savesearchfieldordering&action=jsvmtask"));?>">
            <div class="jsvm_popup-field-wrapper">
                <div class="jsvm_popup-field-title"><?php echo  __('User Search', 'js-vehicle-manager');?></div>
                <div class="jsvm_popup-field-obj"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('search_user', $searchable_combo, 0, '', array('class' => 'inputbox one')), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
            </div>
            <div class="jsvm_popup-field-wrapper">
                <div class="jsvm_popup-field-title"><?php echo  __('Visitor Search', 'js-vehicle-manager');?></div>
                <div class="jsvm_popup-field-obj"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('search_visitor', $searchable_combo, 0, '', array('class' => 'inputbox one')), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
            </div>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id',''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldfor',jsvehiclemanager::$_data['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('savesearch-field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="js-submit-container js-col-lg-10 js-col-md-10 js-col-md-offset-1 js-col-md-offset-1">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>
    </div>
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <?php 
        $msgkey = JSVEHICLEMANAGERincluder::getJSModel('fieldordering')->getMessagekey();
        JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey); 
        $search_combo = array(
        (object) array('id' => 0, 'text' => __('Search Fields', 'js-vehicle-manager')),
        (object) array('id' => 1, 'text' => __('All Fields', 'js-vehicle-manager')));
        ?>
        <span class="jsvm_js-admin-title">
            <a href="?page=jsvehiclemanager"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php 
                echo __('Search Field Ordering', 'js-vehicle-manager');
            ?>
            <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
            
        </span>
        
        <form class="jsvm_js-filter-form" name="jsvehiclemanagerform" id="jsvehiclemanagerform" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering&jsvmlt=searchfieldsordering&ff=" . jsvehiclemanager::$_data['fieldfor'])); ?>">
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('search', $search_combo, is_numeric(jsvehiclemanager::$_data['filter']['search']) ? jsvehiclemanager::$_data['filter']['search'] : '', __('Select user status', 'js-vehicle-manager'), array('class' => 'inputbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('JSVEHICLEMANAGER_form_search', 'JSVEHICLEMANAGER_SEARCH'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_filter-bottom-button">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('btnsubmit', __('Search', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>

        <?php
        if (!empty(jsvehiclemanager::$_data[0])) {
            ?>          
            <form id="jsvehiclemanager-list-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering&action=jsvmtask&task=savesearchfieldorderingFromForm")); ?>">
                <table id="jsvm_js-table">
                    <thead>
                        <tr>
                            <th class="jsvm_left-row"><?php echo __('Field Title', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('User Published', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Visitor Published', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_action"><?php echo __('Action', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0, $n = count(jsvehiclemanager::$_data[0]); $i < $n; $i++) {
                            $row = jsvehiclemanager::$_data[0][$i];
                            ?>
                            <tr valign="top" id="id_<?php echo $row->id; ?>">
                                <td class="jsvm_left-row" style="cursor:grab;">
                                    <?php echo esc_html(__($row->fieldtitle,'js-vehicle-manager')); ?>
                                </td>
                                <td >
                                     <?php if($row->search_user == 1){ ?>
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                     <?php }else{ ?>
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                     <?php } ?>
                                </td>
                                <td >
                                    <?php if($row->search_visitor == 1){ ?>
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/yes.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                    <?php }else{ ?>
                                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/no.png" title="<?php echo __('Cannot unpublished', 'js-vehicle-manager'); ?>" />
                                    <?php } ?>
                                </td>
                                <td class="action" >
                                    <a href="#" onclick="searchShowPopupAndSetValues(<?php echo esc_attr($row->id); ?>,'<?php echo esc_attr($row->fieldtitle);?>', <?php echo esc_attr($row->search_user);?>, <?php echo esc_attr($row->search_visitor);?>)" ><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/edit.png" title="<?php echo __('Edit', 'js-vehicle-manager'); ?>"></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fields_ordering_new', ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('savesearch-field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldfor',jsvehiclemanager::$_data['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('ff',jsvehiclemanager::$_data['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <div class="js-submit-container js-col-lg-8 js-col-md-8 js-col-md-offset-2 js-col-md-offset-2">
                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-jobs') .' '. __('Ordering', 'js-jobs'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                </div>
            </form>
        <?php
    }
    ?>
    </div>
</div>
</div>