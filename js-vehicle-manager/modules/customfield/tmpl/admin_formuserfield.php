<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<div id="jsjobsadmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_fieldordering')); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php
            $heading = isset(jsvehiclemanager::$_data[0]['fieldvalues']) ? __('Edit', 'js-vehicle-manager') : __('Add', 'js-vehicle-manager');
            echo esc_html($heading ). '&nbsp' . __('User Field', 'js-vehicle-manager');
            ?>
        </span>
        <?php
        $yesno = array(
            (object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager')),
            (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));

        if (jsvehiclemanager::$_data[0]['fieldfor'] == 3) {
            $fieldtypes = array(
                (object) array('id' => 'text', 'text' => __('Text Field', 'js-vehicle-manager')),
                (object) array('id' => 'checkbox', 'text' => __('Check Box', 'js-vehicle-manager')),
                (object) array('id' => 'date', 'text' => __('Date', 'js-vehicle-manager')),
                (object) array('id' => 'combo', 'text' => __('Drop Down', 'js-vehicle-manager')),
                (object) array('id' => 'email', 'text' => __('Email Address', 'js-vehicle-manager')),
                (object) array('id' => 'textarea', 'text' => __('Text Area', 'js-vehicle-manager')),
                (object) array('id' => 'radio', 'text' => __('Radio Button', 'js-vehicle-manager')),
                (object) array('id' => 'depandant_field', 'text' => __('Dependent Field', 'js-vehicle-manager')),
                (object) array('id' => 'file', 'text' => __('upload file', 'js-vehicle-manager')),
                (object) array('id' => 'multiple', 'text' => __('Multi Select', 'js-vehicle-manager')));
        } else {
            $fieldtypes = array(
                (object) array('id' => 'text', 'text' => __('Text Field', 'js-vehicle-manager')),
                (object) array('id' => 'checkbox', 'text' => __('Check Box', 'js-vehicle-manager')),
                (object) array('id' => 'date', 'text' => __('Date', 'js-vehicle-manager')),
                (object) array('id' => 'combo', 'text' => __('Drop Down', 'js-vehicle-manager')),
                (object) array('id' => 'email', 'text' => __('Email Address', 'js-vehicle-manager')),
                (object) array('id' => 'textarea', 'text' => __('Text Area', 'js-vehicle-manager')),
                (object) array('id' => 'radio', 'text' => __('Radio Button', 'js-vehicle-manager')),
                (object) array('id' => 'editor', 'text' => __('Text Editor', 'js-vehicle-manager')),
                (object) array('id' => 'file', 'text' => __('upload file', 'js-vehicle-manager')),
                (object) array('id' => 'depandant_field', 'text' => __('Dependent Field', 'js-vehicle-manager')),
                (object) array('id' => 'multiple', 'text' => __('Multi Select', 'js-vehicle-manager')));
        }
        ?>
        <form id="jsvm-vm-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering&task=saveuserfield")); ?>">
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Field Type', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('userfieldtype', $fieldtypes, isset(jsvehiclemanager::$_data[0]['userfield']->userfieldtype) ? jsvehiclemanager::$_data[0]['userfield']->userfieldtype : 'text', __('Select field type', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'onchange' => 'toggleType(this.options[this.selectedIndex].value);')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin" id="for-combo-wrapper" style="display:none;">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Select','js-vehicle-manager') .' '. __('Parent Field', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding" id="for-combo"></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Field Name', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('field', isset(jsvehiclemanager::$_data[0]['userfield']->field) ? jsvehiclemanager::$_data[0]['userfield']->field : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'onchange' => 'prep4SQL(this);')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Field Title', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('fieldtitle', isset(jsvehiclemanager::$_data[0]['userfield']->fieldtitle) ? jsvehiclemanager::$_data[0]['userfield']->fieldtitle : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin jsvm_show-on-listing">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Show on listing', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('showonlisting', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->showonlisting) ? jsvehiclemanager::$_data[0]['userfield']->showonlisting : 0, __('Select show on listing', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Section', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('section', $sectionarray, isset(jsvehiclemanager::$_data[0]['userfield']->section) ? jsvehiclemanager::$_data[0]['userfield']->section : '', __('Select section', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Read Only', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('readonly', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->readonly) ? jsvehiclemanager::$_data[0]['userfield']->readonly : 0, __('Select read only', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('User Published', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('published', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->published) ? jsvehiclemanager::$_data[0]['userfield']->published : 1, __('Select published', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Visitor Published', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('isvisitorpublished', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->isvisitorpublished) ? jsvehiclemanager::$_data[0]['userfield']->isvisitorpublished : 1, __('Select visitor published', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('User Search', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('Search_user', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->search_user) ? jsvehiclemanager::$_data[0]['userfield']->search_user : 1, __('Select user search', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Visitor Search', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('search_visitor', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->search_visitor) ? jsvehiclemanager::$_data[0]['userfield']->search_visitor : 1, __('Select visitor search', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Required', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('required', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->required) ? jsvehiclemanager::$_data[0]['userfield']->required : 0, __('Select required', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Field Size', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('size', isset(jsvehiclemanager::$_data[0]['userfield']->size) ? jsvehiclemanager::$_data[0]['userfield']->size : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>

            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Java Script', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::textarea('j_script', isset(jsvehiclemanager::$_data[0]['userfield']->j_script) ? jsvehiclemanager::$_data[0]['userfield']->j_script : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>


            <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin" id="for-combo-options" style="display:none;"></div>

            <div id="divText" class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Max Length', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('maxlength', isset(jsvehiclemanager::$_data[0]['userfield']->maxlength) ? jsvehiclemanager::$_data[0]['userfield']->maxlength : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_divColsRows jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Columns', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cols', isset(jsvehiclemanager::$_data[0]['userfield']->cols) ? jsvehiclemanager::$_data[0]['userfield']->cols : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div class="jsvm_js-field-wrapper jsvm_divColsRows jsvm_js-row jsvm_no-margin">
                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Rows', 'js-vehicle-manager'); ?></div>
                <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rows', isset(jsvehiclemanager::$_data[0]['userfield']->rows) ? jsvehiclemanager::$_data[0]['userfield']->rows : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
            </div>
            <div id="divValues" class="jsvm_js-field-wrapper jsvm_divColsRows jsvm_js-row jsvm_no-margin">
                <span class="jsvm_js-admin-title"><?php echo __('Use The Table Below To Add New Values', 'js-vehicle-manager'); ?></span>
                <div class="jsvm_page-actions jsvm_js-row jsvm_no-margin">
                    <div class="js-col-lg-8 js-col-md-8 jsvm_no-padding">
                        <span class="jsvm_sample-text"><?php echo __('Sample Text', 'js-vehicle-manager'); ?></span>
                    </div>
                    <div class="jsvm_add-action js-col-lg-4 js-col-md-4 jsvm_no-padding">
                        <a class="jsvm_js-button-link button" href="javascript:void(0);" onclick="insertRow();"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/add_icon.png" /><?php echo __('Add Value', 'js-vehicle-manager') ?></a>
                    </div>
                </div>
                <table id="js-table">
                    <thead>
                        <tr>
                            <th class="jsvm_centered"><?php echo __('Title', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_centered"><?php echo __('Value', 'js-vehicle-manager'); ?></th>
                            <th class="jsvm_action"><?php echo __('Action', 'js-vehicle-manager'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="fieldValuesBody">
                        <?php
                        $i = 0;
                        if (isset(jsvehiclemanager::$_data[0]['userfield']->type) && jsvehiclemanager::$_data[0]['userfield']->type == 'select') {
                            foreach (jsvehiclemanager::$_data[0]['fieldvalues'] as $value) {
                                ?>
                                <tr id="jsvm_trcust<?php echo esc_attr($i); ?>">
                            <input type="hidden" value="<?php echo esc_attr($value->id); ?>" name="jsIds[<?php echo esc_attr($i); ?>]" />
                            <td><input type="text" value="<?php echo esc_attr($value->fieldtitle); ?>" name="jsNames[<?php echo esc_attr($i); ?>]" /></td>
                            <td><input type="text" value="<?php echo esc_attr($value->fieldvalue); ?>" name="jsValues[<?php echo esc_attr($i); ?>]" /></td>
                            <td width="10%"><a href="javascript:void(0);" data-rowid="jsvm_trcust<?php echo esc_attr($i); ?>" data-optionid="<?php echo esc_attr($value->id); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png"></a></td>
                            </tr>
                            <?php
                            $i++;
                        }
                        $i--; //for value to store correctly
                    } else {
                        ?>
                        <tr id="jsvm_trcust0">
                            <td><input type="text" value="" name="jsNames[0]" /></td>
                            <td><input type="text" value="" name="jsValues[0]" /></td>
                            <td width="10%"><a data-rowid="jsvm_trcust0" href="javascript:void(0);"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png"></a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', isset(jsvehiclemanager::$_data[0]['userfield']->id) ? jsvehiclemanager::$_data[0]['userfield']->id : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('valueCount', $i), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldfor', jsvehiclemanager::$_data[0]['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('ordering', isset(jsvehiclemanager::$_data[0]['userfield']->ordering) ? jsvehiclemanager::$_data[0]['userfield']->ordering : '' ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'customfield_saveuserfield'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('isuserfield', 1), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-customfield')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            <div class="jsvm_js-submit-container js-col-lg-8 js-col-md-8 js-col-md-offset-2 js-col-md-offset-2">
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('User Field', 'js-vehicle-manager'), array('class' => 'jsvm_button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
            </div>
        </form>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                toggleType(jQuery('#userfieldtype').val());
            });
            function disableAll() {
                jQuery("#divValues").slideUp();
                jQuery(".divColsRows").slideUp();
                jQuery("#divText").slideUp();
            }
            function toggleType(type) {
                disableAll();
                prep4SQL(document.forms['jsvm-vm-form'].elements['field']);
                selType(type);
            }
            function prep4SQL(field) {
                if (field.value != '') {
                    field.value = field.value.replace('js_', '');
                    field.value = 'js_' + field.value.replace(/[^a-zA-Z]+/g, '');
                }
            }
            function selType(sType) {
                var elem;
                /*
                 text
                 checkbox
                 date
                 combo
                 email
                 textarea
                 radio
                 editor
                 depandant_field
                 multiple*/

                switch (sType) {
                    case 'file':
                        jQuery("#divText").hide();
                        jQuery("#divValues").hide();
                        jQuery(".divColsRows").hide();
                        jQuery("div.show-on-listing").slideUp();
                        jQuery("div#for-combo-wrapper").hide();
                        jQuery("div#for-combo-options").hide();
                        break;
                    case 'editor':
                        jQuery("#divText").slideUp();
                        jQuery("#divValues").slideUp();
                        jQuery(".divColsRows").slideUp();
                        jQuery("div#for-combo-wrapper").hide();
                        jQuery("div#for-combo-options").hide();
                        break;
                    case 'textarea':
                        jQuery("#divText").slideUp();
                        jQuery(".divColsRows").slideDown();
                        jQuery("#divValues").slideUp();
                        jQuery("div#for-combo-wrapper").hide();
                        jQuery("div#for-combo-options").hide();
                        break;
                    case 'email':
                    case 'password':
                    case 'text':
                        jQuery("div.show-on-listing").show();
                        jQuery("div.show-on-listing").show();
                        jQuery("#divText").slideDown();
                        jQuery("div#for-combo-wrapper").hide();
                        jQuery("div#for-combo-options").hide();
                        break;
                    case 'combo':
                    case 'multiple':
                        jQuery("div.show-on-listing").show();
                        jQuery("#divValues").slideDown();
                        jQuery("div#for-combo-wrapper").hide();
                        jQuery("div#for-combo-options").hide();
                        break;
                    case 'depandant_field':
                        jQuery("div.show-on-listing").show();
                        comboOfFields();
                        break;
                    case 'radio':
                    case 'checkbox':
                        //jQuery(".divColsRows").slideDown();
                        jQuery("div.show-on-listing").show();
                        jQuery("#divValues").slideDown();
                        jQuery("div#for-combo-wrapper").hide();
                        jQuery("div#for-combo-options").hide();
                        break;

                    case 'delimiter':
                    default:
                }
            }

            function comboOfFields() {
                var ff = jQuery("input#fieldfor").val();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'fieldordering', task: 'getFieldsForComboByFieldFor', fieldfor: ff ,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        var d = jQuery.parseJSON(data);
                        jQuery("div#for-combo").html(d);
                        jQuery("div#for-combo-wrapper").show();
                    }
                });
            }

            function getDataOfSelectedField() {
                var field = jQuery("select#parentfield").val();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'fieldordering', task: 'getSectionToFillValues', pfield: field ,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        var d = jQuery.parseJSON(data);
                        jQuery("div#for-combo-options").html(d);
                        jQuery("div#for-combo-options").show();
                    }
                });
            }

            function getNextField(divid) {
                var textvar = divid + '[]';
                var fieldhtml = "<input type='text' name='" + textvar + "' />";
                jQuery("div#" + divid).append(fieldhtml);
            }

            function getObject(obj) {
                var strObj;
                if (document.all) {
                    strObj = document.all.item(obj);
                } else if (document.getElementById) {
                    strObj = document.getElementById(obj);
                }
                return strObj;
            }
            function insertRow() {
                var oTable = getObject("fieldValuesBody");
                var oRow, oCell, oCellCont, oInput, oSpan;
                var i, j;
                i = document.forms['jsvm-vm-form'].elements['valueCount'].value;
                i++;
                // Create and insert rows and cells into the first body.
                oRow = document.createElement("TR");
                jQuery(oRow).attr('id', "jsjob_trcust" + i);
                oTable.appendChild(oRow);

                oCell = document.createElement("TD");
                oInput = document.createElement("INPUT");
                oInput.name = "jsNames[" + i + "]";
                oInput.setAttribute('id', "jsNames_" + i);
                oCell.appendChild(oInput);
                oRow.appendChild(oCell);

                oCell = document.createElement("TD");
                oInput = document.createElement("INPUT");
                oInput.name = "jsValues[" + i + "]";
                oInput.setAttribute('id', "jsValues_" + i);
                oCell.appendChild(oInput);
                oRow.appendChild(oCell);

                oCell = document.createElement("TD");
                oCell.setAttribute('width', "10%");
                oAction = document.createElement("A");
                oAction.setAttribute('href', "javascript:void(0);");
                oImg = document.createElement("IMG");
                oImg.setAttribute('src', "<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png");
                oAction.appendChild(oImg);
                oCell.appendChild(oAction);
                jQuery(oAction).click(function () {
                    jQuery('#jsjob_trcust' + i).remove();
                    document.forms['jsvm-vm-form'].elements['valueCount'].value = document.forms['jsvm-vm-form'].elements['valueCount'].value - 1;
                });
                oRow.appendChild(oCell);

                document.forms['jsvm-vm-form'].elements['valueCount'].value = i;
            }
        </script>
    </div>
</div>
