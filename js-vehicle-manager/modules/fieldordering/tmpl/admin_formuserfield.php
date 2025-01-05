<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<div id="jsvehiclemanageradmin-wrapper">
    <div id="jsvehiclemanageradmin-leftmenu">
        <?php JSVEHICLEMANAGERincluder::getClassesInclude('jsvehiclemanageradminsidemenu'); ?>
    </div>
    <div id="jsvehiclemanageradmin-data">
        <span class="jsvm_js-admin-title">
            <a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_fieldordering&ff='.jsvehiclemanager::$_data['fieldfor'])); ?>"><img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/back-icon.png" /></a>
            <?php
            $heading = isset(jsvehiclemanager::$_data[0]['fieldvalues']) ? __('Edit', 'js-vehicle-manager') : __('Add New', 'js-vehicle-manager');
            echo esc_html($heading) . '&nbsp' . __('User Field', 'js-vehicle-manager');
            ?>
        </span>
        <?php
        $yesno = array(
            (object) array('id' => 1, 'text' => __('Yes', 'js-vehicle-manager')),
            (object) array('id' => 0, 'text' => __('No', 'js-vehicle-manager')));

        // Customfields sections array
        
        $sectionarray = array(
                            (object) array('id' => 10, 'text' => __('Vehicle', 'js-vehicle-manager'))
                        );
        foreach(jsvehiclemanager::$_data[0]['vehiclesections'] AS $rs){
            $sectionarray[] = (object) array('id' => $rs->section, 'text' => __($rs->fieldtitle, 'js-vehicle-manager'));
        }

        $fieldtypes = array(
            (object) array('id' => 'text', 'text' => __('Text Field', 'js-vehicle-manager')),
            (object) array('id' => 'checkbox', 'text' => __('Check Box', 'js-vehicle-manager')),
            (object) array('id' => 'date', 'text' => __('Date', 'js-vehicle-manager')),
            (object) array('id' => 'combo', 'text' => __('Drop Down', 'js-vehicle-manager')),
            (object) array('id' => 'email', 'text' => __('Email Address', 'js-vehicle-manager')),
            (object) array('id' => 'textarea', 'text' => __('Text Area', 'js-vehicle-manager')),
            (object) array('id' => 'radio', 'text' => __('Radio Button', 'js-vehicle-manager')),
            (object) array('id' => 'depandant_field', 'text' => __('Dependent Field', 'js-vehicle-manager')),
            (object) array('id' => 'file', 'text' => __('Upload File', 'js-vehicle-manager')),
            (object) array('id' => 'multiple', 'text' => __('Multi Select', 'js-vehicle-manager')));

        ?>
        <div class="jsvehiclemanager-form-wrap">
            <form id="jsvehiclemanager-form" method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_fieldordering&task=saveuserfield")); ?>">
                <?php if (jsvehiclemanager::$_data[0]['fieldfor'] == 1) { ?>
                    <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                        <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Section', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                        <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding">
                            <?php
                                if(isset(jsvehiclemanager::$_data[0]['userfield']->section)){
                                    $farray = array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'disabled' => 'true');
                                }else{
                                    $farray = array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'onChange' => 'setFieldsType();');
                                }
                                echo wp_kses(JSVEHICLEMANAGERformfield::select('section', $sectionarray, isset(jsvehiclemanager::$_data[0]['userfield']->section) ? jsvehiclemanager::$_data[0]['userfield']->section : '', __('Select section', 'js-vehicle-manager'), $farray), JSVEHICLEMANAGER_ALLOWED_TAGS);  echo '<span class="jsvehiclemanager-fieldordering-warning">[ '.__('Section cannot be changeable in edit case','js-vehicle-manager').' ]</span>';
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Field Type', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('userfieldtype', $fieldtypes, isset(jsvehiclemanager::$_data[0]['userfield']->userfieldtype) ? jsvehiclemanager::$_data[0]['userfield']->userfieldtype : 'text', __('Select type', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required', 'onchange' => 'toggleType(this.options[this.selectedIndex].value);')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin" id="jsvm_for-combo-wrapper" style="display:none;">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Select','js-vehicle-manager') .' '. __('Parent Field', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding" id="jsvm_for-combo"></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Field Title', 'js-vehicle-manager'); ?><font class="jsvm_required-notifier">*</font></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('fieldtitle', isset(jsvehiclemanager::$_data[0]['userfield']->fieldtitle) ? jsvehiclemanager::$_data[0]['userfield']->fieldtitle : '', array('class' => 'jsvm_inputbox jsvm_one', 'data-validation' => 'required')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin jsvm_show-on-listing">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Show on listing', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('showonlisting', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->showonlisting) ? jsvehiclemanager::$_data[0]['userfield']->showonlisting : 0, __('Select show on listing', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('User Published', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('published', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->published) ? jsvehiclemanager::$_data[0]['userfield']->published : 1, __('Select published', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Visitor Published', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('isvisitorpublished', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->isvisitorpublished) ? jsvehiclemanager::$_data[0]['userfield']->isvisitorpublished : 1, __('Select visitor published', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row no-margin jsvm_searchfield">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding "><?php echo __('User Search', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('search_user', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->search_user) ? jsvehiclemanager::$_data[0]['userfield']->search_user : 1, __('Select user search', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin jsvm_searchfield">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding "><?php echo __('Visitor Search', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('search_visitor', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->search_visitor) ? jsvehiclemanager::$_data[0]['userfield']->search_visitor : 1, __('Select visitor search', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin jsvm_required">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding "><?php echo __('Required', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('required', $yesno, isset(jsvehiclemanager::$_data[0]['userfield']->required) ? jsvehiclemanager::$_data[0]['userfield']->required : 0, __('Select required', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin jsvm_fieldsize">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding "><?php echo __('Field Size', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('size', isset(jsvehiclemanager::$_data[0]['userfield']->size) ? jsvehiclemanager::$_data[0]['userfield']->size : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div id="jsvm_for-combo-options-head" >
                    <span class="js-admin-title"><?php echo __('Use The Table Below To Add New Values', 'js-vehicle-manager'); ?></span>
                </div>
                <div id="jsvm_for-combo-options" >
                    <?php
                    $arraynames = '';
                    $comma = '';
                    if (isset(jsvehiclemanager::$_data[0]['userfieldparams']) && jsvehiclemanager::$_data[0]['userfield']->userfieldtype == 'depandant_field') {
                        foreach (jsvehiclemanager::$_data[0]['userfieldparams'] as $key => $val) {
                            $textvar = $key;
                            $textvar .='[]';
                            $arraynames .= $comma . "$key";
                            $comma = ',';
                            ?>
                            <div class="jsvm_js-field-wrapper js-row no-margin">
                                <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding">
                                    <?php echo esc_html($key); ?>
                                </div>
                                <div class="js-col-lg-9 js-col-md-9 jsvm_no-padding jsvm_combo-options-fields" id="<?php echo esc_attr($key); ?>">
                                <?php
                                    if (!empty($val)) {
                                        foreach ($val as $each) {
                                            ?>
                                            <span class="jsvm_input-field-wrapper">
                                                <input name="<?php echo esc_attr($textvar); ?>" id="<?php echo esc_attr($textvar); ?>" value="<?php echo esc_attr($each); ?>" class="jsvm_inputbox jsvm_one jsvm_user-field" type="text">
                                                <img class="jsvm_input-field-remove-img" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL ?>includes/images/remove.png">
                                            </span><?php
                                        }
                                    }
                                    ?>
                                    <input id="jsvm_depandant-field-button" onclick="getNextField( &quot;<?php echo esc_attr($key); ?>&quot;,this );" value="Add More" type="button">
                                </div>
                            </div><?php
                        }
                    }
                    ?>
                </div>

                <div id="jsvm_divText" class="jsvm_js-field-wrapper jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Max Length', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('maxlength', isset(jsvehiclemanager::$_data[0]['userfield']->maxlength) ? jsvehiclemanager::$_data[0]['userfield']->maxlength : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_divColsRows jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Columns', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cols', isset(jsvehiclemanager::$_data[0]['userfield']->cols) ? jsvehiclemanager::$_data[0]['userfield']->cols : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div class="jsvm_js-field-wrapper jsvm_divColsRows jsvm_js-row jsvm_no-margin">
                    <div class="jsvm_js-field-title js-col-lg-3 js-col-md-3 jsvm_no-padding"><?php echo __('Rows', 'js-vehicle-manager'); ?></div>
                    <div class="jsvm_js-field-obj js-col-lg-9 js-col-md-9 jsvm_no-padding"><?php echo wp_kses(JSVEHICLEMANAGERformfield::text('rows', isset(jsvehiclemanager::$_data[0]['userfield']->rows) ? jsvehiclemanager::$_data[0]['userfield']->rows : '', array('class' => 'jsvm_inputbox jsvm_one')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?></div>
                </div>
                <div id="jsvm_divValues" class="jsvm_js-field-wrapper jsvm_divColsRows jsvm_js-row jsvm_no-margin">
                    <span class="jsvm_js-admin-title"><?php echo __('Use The Table Below To Add New Values', 'js-vehicle-manager'); ?></span>
                    <div class="jsvm_page-actions jsvm_js-row jsvm_no-margin">
                        <div id="jsvm_user-field-values" class="jsvm_no-padding">
                            <?php
                            if (isset(jsvehiclemanager::$_data[0]['userfield']) && jsvehiclemanager::$_data[0]['userfield']->userfieldtype != 'depandant_field') {
                                if (isset(jsvehiclemanager::$_data[0]['userfieldparams'])) {
                                    foreach (jsvehiclemanager::$_data[0]['userfieldparams'] as $key => $val) {
                                        ?>
                                        <span class="jsvm_input-field-wrapper">
                                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('values[]', isset($val) ? $val : '', array('class' => 'jsvm_inputbox jsvm_one jsvm_user-field')), JSVEHICLEMANAGER_ALLOWED_TAGS);  ?>
                                            <img class="jsvm_input-field-remove-img" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" />
                                        </span>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <span class="jsvm_input-field-wrapper">
                                    <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('values[]', isset($val) ? $val : '', array('class' => 'jsvm_inputbox jsvm_one jsvm_user-field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                                        <img class="jsvm_input-field-remove-img" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" />
                                    </span>
                                <?php
                                }
                            }
                            ?>
                            <a class="jsvm_js-button-link jsvm_button jsvm_user-field-val-button" id="jsvm_user-field-val-button" onclick="insertNewRow();"><?php echo __('Add Value', 'js-vehicle-manager') ?></a>
                        </div>
                    </div>
                </div>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('id', isset(jsvehiclemanager::$_data[0]['userfield']->id) ? jsvehiclemanager::$_data[0]['userfield']->id : ''), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('isuserfield', 1), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldfor', jsvehiclemanager::$_data[0]['fieldfor']), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('ordering', isset(jsvehiclemanager::$_data[0]['userfield']->ordering) ? jsvehiclemanager::$_data[0]['userfield']->ordering : '' ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('action', 'fieldordering_saveuserfield'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('field', isset(jsvehiclemanager::$_data[0]['userfield']->field) ? jsvehiclemanager::$_data[0]['userfield']->field : '' ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('fieldname', isset(jsvehiclemanager::$_data[0]['userfield']->field) ? jsvehiclemanager::$_data[0]['userfield']->field : '' ), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('arraynames2', $arraynames), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('form_request', 'jsvehiclemanager'), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <?php echo wp_kses(JSVEHICLEMANAGERformfield::hidden('_wpnonce', wp_create_nonce('save-field')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                <div class="jsvm_js-submit-container">
                    <div class="jsvm_js-button-container">
                        <a id="jsvm_form-cancel-button" href="<?php echo esc_url(admin_url('admin.php?page=jsvm_fieldordering&ff='.$_GET['ff'])); ?>" ><?php echo __('Cancel', 'js-vehicle-manager'); ?></a>
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::submitbutton('save', __('Save','js-vehicle-manager') .' '. __('User Field', 'js-vehicle-manager'), array('class' => 'button')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            var fieldstype = {
                                text : '<?php echo __('Text Field','js-vehicle-manager'); ?>',
                                checkbox : '<?php echo __('Check Box','js-vehicle-manager'); ?>',
                                date : '<?php echo __('Date','js-vehicle-manager'); ?>',
                                combo : '<?php echo __('Drop Down','js-vehicle-manager'); ?>',
                                email : '<?php echo __('Email Address','js-vehicle-manager'); ?>',
                                textarea : '<?php echo __('Text Area','js-vehicle-manager'); ?>',
                                radio : '<?php echo __('Radio Button','js-vehicle-manager'); ?>',
                                depandant_field : '<?php echo __('Dependent Field','js-vehicle-manager'); ?>',
                                file: '<?php echo __('Upload File','js-vehicle-manager'); ?>',
                                multiple : '<?php echo __('Multi Select','js-vehicle-manager'); ?>'
                            };
            jQuery(document).ready(function () {
                toggleType(jQuery('#userfieldtype').val());
            });
            function disableAll() {
                jQuery("#jsvm_divValues").slideUp();
                jQuery(".jsvm_divColsRows").slideUp();
                jQuery("#jsvm_divText").slideUp();
            }
            function toggleType(type) {
                disableAll();
                selType(type);
            }
            function setFieldsType(){
                var section = jQuery('select#section').val();
                var fieldfor = jQuery('input#fieldfor').val();
                jQuery('select#userfieldtype option').remove();
                if(section == 10 || fieldfor == 2){
                    jQuery.each(fieldstype, function(val, text) {
                        jQuery('select#userfieldtype').append(new Option(text,val));
                    });
                    jQuery('div.jsvm_show-on-listing, div.jsvm_required, div.jsvm_searchfield, div.jsvm_fieldsize div.jsvm_maxlength').show();
                }else{
                    jQuery("select#userfieldtype").append(new Option('<?php echo __('Vehicle Option','js-vehicle-manager'); ?>', 'vehicleoption'));
                    jQuery('div.jsvm_show-on-listing, div.jsvm_required, div.jsvm_searchfield, div.jsvm_fieldsize div.jsvm_maxlength').hide();
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
                        jQuery("#jsvm_divText").slideUp();
                        jQuery("#jsvm_divValues").slideUp();
                        jQuery(".jsvm_divColsRows").slideUp();
                        jQuery("div.jsvm_show-on-listing").slideUp();
                        jQuery("div#jsvm_for-combo-wrapper").hide();
                        jQuery("div#jsvm_for-combo-options").hide();
                        jQuery("div#jsvm_for-combo-options-head").hide();
                        break;
                    case 'editor':
                        jQuery("#jsvm_divText").slideUp();
                        jQuery("#jsvm_divValues").slideUp();
                        jQuery(".jsvm_divColsRows").slideUp();
                        jQuery("div.jsvm_show-on-listing").slideUp();
                        jQuery("div#jsvm_for-combo-wrapper").hide();
                        jQuery("div#jsvm_for-combo-options").hide();
                        jQuery("div#jsvm_for-combo-options-head").hide();
                        break;
                    case 'textarea':
                        jQuery("#jsvm_divText").slideUp();
                        jQuery(".jsvm_divColsRows").slideDown();
                        jQuery("#jsvm_divValues").slideUp();
                        jQuery("div.jsvm_show-on-listing").slideUp();
                        jQuery("div#jsvm_for-combo-wrapper").hide();
                        jQuery("div#jsvm_for-combo-options").hide();
                        jQuery("div#jsvm_for-combo-options-head").hide();
                        break;
                    case 'email':
                    case 'password':
                    case 'text':
                        jQuery("#jsvm_divText").slideDown();
                        jQuery("div#jsvm_for-combo-wrapper").hide();
                        jQuery("div#jsvm_for-combo-options").hide();
                        jQuery("div#jsvm_for-combo-options-head").hide();
                        break;
                    case 'combo':
                    case 'multiple':
                        jQuery("#jsvm_divValues").slideDown();
                        jQuery("div#jsvm_for-combo-wrapper").hide();
                        jQuery("div#jsvm_for-combo-options").hide();
                        jQuery("div#jsvm_for-combo-options-head").hide();
                        break;
                    case 'depandant_field':
                        comboOfFields();
                        break;
                    case 'radio':
                    case 'checkbox':
                        jQuery("#jsvm_divValues").slideDown();
                        jQuery("div#jsvm_for-combo-wrapper").hide();
                        jQuery("div#jsvm_for-combo-options").hide();
                        jQuery("div#jsvm_for-combo-options-head").hide();
                        break;
                    case 'delimiter':
                    default:
                }
            }

            function comboOfFields() {
                var ff = jQuery("input#fieldfor").val();
                var pf = jQuery("input#fieldname").val();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'fieldordering', task: 'getFieldsForComboByFieldFor', fieldfor: ff, parentfield: pf,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        var d = jQuery.parseJSON(data);
                        jQuery("div#jsvm_for-combo").html(d);
                        jQuery("div#jsvm_for-combo-wrapper").show();
                    }
                });
            }

            function getDataOfSelectedField() {
                var field = jQuery("select#parentfield").val();
                jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'fieldordering', task: 'getSectionToFillValues', pfield: field,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                    if (data) {
                        console.log(data);
                        var d = jQuery.parseJSON(data);
                        jQuery("div#jsvm_for-combo-options-head").show();
                        jQuery("div#jsvm_for-combo-options").html(d);
                        jQuery("div#jsvm_for-combo-options").show();
                    }
                });
            }

            function getNextField(divid,object) {
                var textvar = divid + '[]';
                var fieldhtml = "<span class='jsvm_input-field-wrapper' ><input type='text' name='" + textvar + "' class='jsvm_inputbox jsvm_one jsvm_user-field'  /><img class='jsvm_input-field-remove-img' src='<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png' /></span>";
                jQuery(object).before(fieldhtml);
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

            function insertNewRow() {
                var fieldhtml = '<span class="jsvm_input-field-wrapper" ><input name="values[]" id="values[]" value="" class="jsvm_inputbox jsvm_one jsvm_user-field" type="text" /><img class="jsvm_input-field-remove-img" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/remove.png" /></span>';
                jQuery("#jsvm_user-field-val-button").before(fieldhtml);
            }
            jQuery(document).ready(function () {
                jQuery("body").delegate("img.jsvm_input-field-remove-img", "click", function () {
                    jQuery(this).parent().remove();
                });
            });

        </script>
    </div>
</div>
