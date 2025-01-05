<?php
if (!defined('ABSPATH'))
    die('Restricted Access');
wp_enqueue_script('jsauto-res-tables', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/js/responsivetable.js');
$categoryarray = array(
    (object) array('id' => 1, 'text' => __('ID', 'js-vehicle-manager')),
    (object) array('id' => 2, 'text' => __('User Name', 'js-vehicle-manager')),
    (object) array('id' => 3, 'text' => __('Reference For', 'js-vehicle-manager')),
    (object) array('id' => 4, 'text' => __('Created', 'js-vehicle-manager'))
);
?>
<script>
    jQuery(document).ready(function () {
        jQuery("div#jsvm_full_background,img#jsvm_popup_cross").click(function () {
            HidePopup();
        });
    });

    function ShowPopup() {
        jQuery("div#jsvm_full_background").show();
        jQuery("div#jsvm_popup_main").fadeIn(300);
    }

    function HidePopup() {
        jQuery("div#jsvm_full_background").hide();
        jQuery("div#jsvm_popup_main").fadeOut(300);
    }
    function submitfrom() {
        jQuery("form#jsvm_filter_form").submit();

    }

    function changeSortBy() {
        var value = jQuery('a.jsvm_sort-icon').attr('data-sortby');
        var img = '';
        if (value == 1) {
            value = 2;
            img = jQuery('a.jsvm_sort-icon').attr('data-image2');
        } else {
            img = jQuery('a.jsvm_sort-icon').attr('data-image1');
            value = 1;
        }
        jQuery("img#jsvm_sortingimage").attr('src', img);
        jQuery('input#sortby').val(value);
        jQuery('form#jsvm_filter_form').submit();
    }

    function buttonClick() {
        changeSortBy();
    }
    function changeCombo() {
        jQuery("input#sorton").val(jQuery('select#jsvm_sorting').val());
        changeSortBy();
    }
</script>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <span class="jsvm_heading">
                <a href="<?php echo esc_url(admin_url('admin.php?page=jsvehiclemanager')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
                <span class="jsvm_heading-text"><?php echo __('Activity Log', 'js-vehicle-manager') ?></span>
            </span>
        </span>
            <div id="jsvm_full_background" style="display:none;"></div>
            <div id="jsvm_popup_main" style="display:none;">
                <span class="jsvm_popup-top">
                    <span id="jsvm_popup_title" >
                        <?php echo __('Settings', 'js-vehicle-manager'); ?>
                    </span>
                    <img id="jsvm_popup_cross" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/popup-close.png">
                </span>
                <div id="jsvm_checkbox-popup-wrapper">
                    <form id="jsvm_filter_form" method="post" action="?page=jsvm_activitylog&jsvmlt=activitylogs">
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[vehicles]', array('1' => __('Vehicles', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['vehicles']) ? jsvehiclemanager::$_data['filter']['vehicles'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[vehicletypes]', array('1' => __('Vehicle Types', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['vehicletypes']) ? jsvehiclemanager::$_data['filter']['vehicletypes'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[fueltypes]', array('1' => __('Fuel Types', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['fueltypes']) ? jsvehiclemanager::$_data['filter']['fueltypes'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[mileages]', array('1' => __('Mileage', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['mileages']) ? jsvehiclemanager::$_data['filter']['mileages'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[modelyears]', array('1' => __('Model years', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['modelyears']) ? jsvehiclemanager::$_data['filter']['modelyears'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[transmissions]', array('1' => __('Transmissions', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['transmissions']) ? jsvehiclemanager::$_data['filter']['transmissions'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[adexpiries]', array('1' => __('Ad Expiry', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['adexpiries']) ? jsvehiclemanager::$_data['filter']['adexpiries'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[cylinders]', array('1' => __('Cylinders', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['cylinders']) ? jsvehiclemanager::$_data['filter']['cylinders'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[conditions]', array('1' => __('Conditions', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['conditions']) ? jsvehiclemanager::$_data['filter']['conditions'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[currencies]', array('1' => __('Currencies', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['currencies']) ? jsvehiclemanager::$_data['filter']['currencies'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[makes]', array('1' => __('Makes', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['makes']) ? jsvehiclemanager::$_data['filter']['makes'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[config]', array('1' => __('Config', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['config']) ? jsvehiclemanager::$_data['filter']['config'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[countries]', array('1' => __('Countries', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['countries']) ? jsvehiclemanager::$_data['filter']['countries'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[states]', array('1' => __('States', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['states']) ? jsvehiclemanager::$_data['filter']['states'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                        <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[cities]', array('1' => __('Cities', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['cities']) ? jsvehiclemanager::$_data['filter']['cities'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                        <?php if(!in_array('credits',jsvehiclemanager::$_active_addons)){ ?>
                            <div class="jsvm_checkbox-filter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::checkbox('filter[credits_pack]', array('1' => __('Credit Packs', 'js-vehicle-manager')), isset(jsvehiclemanager::$_data['filter']['credits_pack']) ? jsvehiclemanager::$_data['filter']['credits_pack'] : 0, array('class' => 'checkbox')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                        <?php } ?>
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('searchsubmit', 1 ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sortby', jsvehiclemanager::$_data['sortby']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('sorton', jsvehiclemanager::$_data['sorton']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        <div class="jsvm_activitylog_btn">
                            <span class="jsvm_submit-button-popup" onclick="submitfrom()"><?php echo __('Submit', 'js-vehicle-manager'); ?></span>
                        </div>
                    </form>
                </div>
            </div>

                <div class="jsvm_page-actions js-row jsvm_no-margin">
                    <?php
                    $image1 = JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/up.png";
                    $image2 = JSVEHICLEMANAGER_PLUGIN_URL . "includes/images/down.png";
                    if (jsvehiclemanager::$_data['sortby'] == 1) {
                        $image = $image1;
                    } else {
                        $image = $image2;
                    }
                    ?>
                    <span class="jsvm_sort">
                        <span class="jsvm_sort-text"><?php echo __('Sort by', 'js-vehicle-manager'); ?>:</span>
                        <span class="jsvm_sort-field"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('jsvm_sorting', $categoryarray, jsvehiclemanager::$_data['combosort'], '', array('class' => 'inputbox', 'onchange' => 'changeCombo();')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></span>
                        <a class="jsvm_sort-icon" href="#" data-image1="<?php echo $image1; ?>" data-image2="<?php echo $image2; ?>" data-sortby="<?php echo jsvehiclemanager::$_data['sortby']; ?>" onclick="buttonClick();"><img id="jsvm_sortingimage" src="<?php echo $image; ?>" /></a>
                    </span>
                    <span Onclick="ShowPopup()" id="jsvm_filter-activity-log">
                        <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/settings.png">
                        <?php echo __('Settings', 'js-vehicle-manager'); ?>
                    </span>
                </div>
        <?php if (!empty(jsvehiclemanager::$_data[0])) { ?>
                <table id="jsvm_js-table">
                    <thead>
                        <tr>
                            <th ><?php echo __('ID', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_left-row"><?php echo __('User Name', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_left-row"><?php echo __('Description', 'js-vehicle-manager'); ?></th>
                            <th ><?php echo __('Reference For', 'js-vehicle-manager'); ?></th>
                            <th ><?php echo __('Created', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (jsvehiclemanager::$_data[0] AS $data) { ?>
                            <tr >
                                <td><?php echo esc_html($data->id); ?></td>
                                <td class="jsvm_left-row"><?php echo esc_html(__($data->display_name, 'js-vehicle-manager')); ?></td>
                                <td class="jsvm_left-row"><?php echo esc_html(__($data->description, 'js-vehicle-manager')); ?></td>
                                <td><?php echo esc_html(ucwords(__($data->referencefor , 'js-vehicle-manager'))); ?></td>
                                <td><?php echo esc_html($data->created); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>

            </table>
            <?php
            if (jsvehiclemanager::$_data[1]) {
                echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsvehiclemanager::$_data[1]) . '</div></div>';
            }
        } else {
            $msg = __('No record found','js-vehicle-manager');
            echo wp_kses(JSVEHICLEMANAGERlayout::getNoRecordFound($msg), JSVEHICLEMANAGER_ALLOWED_TAGS);
        }
        ?>
    </div>
</div>
