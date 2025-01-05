<?php
if (!defined('ABSPATH')) die('Restricted Access');?>
<div id="jsvehiclemanager-main-up-wrapper">
<?php
    $msgkey = JSVEHICLEMANAGERincluder::getJSModel('vehicle')->getMessagekey();
    JSVEHICLEMANAGERmessages::getLayoutMessage($msgkey);
    JSVEHICLEMANAGERbreadcrumbs::getBreadcrumbs();
    include_once(JSVEHICLEMANAGER_PLUGIN_PATH . 'includes/header.php');
if (jsvehiclemanager::$_error_flag == null) {
?>
<div id="jsvehiclemanager-wrapper">
        <div class="control-pannel-header">
            <span class="heading">
                <?php echo __('Search Vehicle', 'js-vehicle-manager'); ?>
            </span>            
        </div>
        <div id="jsvehiclemanager-add-form-vehicle-wrapper">
        <div id="jsvehiclemanager-add-vehicle-wrap">
<form class="jsvehiclemanager_autoz_form" id="jsvm_autoz_form" method="post" action="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles'))); ?>">
<div class="jsvehiclemanager-form-field-wrapper">
    <?php
    wp_enqueue_script('jquery-ui-datepicker');
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    wp_enqueue_style('jquery-ui-css', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');
    $radiustype = array(
        (object) array('id' => '1', 'text' => esc_html__('Meters', 'js-vehicle-manager')),
        (object) array('id' => '2', 'text' => esc_html__('Kilometers', 'js-vehicle-manager')),
        (object) array('id' => '3', 'text' => esc_html__('Miles', 'js-vehicle-manager')),
        (object) array('id' => '4', 'text' => esc_html__('Nautical Miles', 'js-vehicle-manager')),
    );

    foreach (jsvehiclemanager::$_data[3] AS $field) {
        switch ($field->field) {
            case 'modelyear': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                    
                        <label for="modelyearfrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                        <div class="jsvehiclemanager-value">
                            <div class="jsvehiclemanager-js-form-wrapper">            
                                <div class="halfsearchfilter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('modelyearfrom', JSVEHICLEMANAGERincluder::getJSModel('modelyears')->getModelyearsTitleForCombo(), '' , esc_html__('Select model year from', 'js-vehicle-manager') , array('class' => 'form-control fullsearchformfield jsvm_cm_select2', 'title'=> esc_html__('Select Model Year From','js-vehicle-manager'), 'data-placeholder'=> esc_html__('From', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                                </div>
                                <div class="jsvehiclemanager-js-form-wrapper">
                        <div class="halfsearchfilter2"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('modelyearto', JSVEHICLEMANAGERincluder::getJSModel('modelyears')->getModelyearsTitleForCombo(), '' , esc_html__('Select model year to', 'js-vehicle-manager') , array('class' => 'form-control fullsearchformfield jsvm_cm_select2', 'title'=> esc_html__('Select Model Year to','js-vehicle-manager'), 'data-placeholder'=> esc_html__('To', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?></div>
                            </div>
                        </div>
                        
                </div>
            <?php
            break;
            case 'make': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="make[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('make[]', JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeForCombo(), '' , esc_html__('Select make', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2','onchange' => 'getmodels();',"multiple"=>"multiple" ,'title'=> esc_html__('Select Make','js-vehicle-manager'), "data-makeid" => "1" , 'data-placeholder'=> esc_html__('Select make', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'model': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="model[]" class="jsvehiclemanager-label">
                            <?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?>
                            <img id="makemodelloading-gif" style="display:none;" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL;?>/includes/images/makemodelloading.gif" alt="<?php echo esc_attr(__('loading','js-vehicle-manager')); ?>" title="<?php echo esc_attr(__('loading','js-vehicle-manager')); ?>" />
                        </label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('model[]', JSVEHICLEMANAGERincluder::getJSModel('model')->getModelForCombo(), '' ,esc_html__('Select model', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2 jsvm_cm_model_class',"multiple"=>"multiple" ,'title'=> esc_html__('Select Model','js-vehicle-manager') , "data-modelid" => "1", 'data-placeholder'=> esc_html__('Select model', 'js-vehicle-manager') )), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'vehicletype': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="vehicletype[]" class="jsvehiclemanager-label"><?php echo __($field->fieldtitle,'js-vehicle-manager');?></label>
                        <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicletype[]', JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getVehicletypeForCombo(), '' ,esc_html__('Select type', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Vehicle Type','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select type', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                </div>
            <?php
            break;
            case 'condition': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="condition[]" class="jsvehiclemanager-label"><?php echo __($field->fieldtitle,'js-vehicle-manager');?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('condition[]', JSVEHICLEMANAGERincluder::getJSModel('conditions')->getConditionForCombo(), '' ,esc_html__('Select condition', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Condition','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select condition', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'fueltype': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="fueltype[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('fueltype[]', JSVEHICLEMANAGERincluder::getJSModel('fueltypes')->getFueltypeForCombo(), '' ,esc_html__('Select fuel type', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Fuel Type','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select fuel type', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'cylinder': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="cylinder[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('cylinder[]', JSVEHICLEMANAGERincluder::getJSModel('cylinders')->getCylinderForCombo(), '' ,esc_html__('Select cylinder', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Cylinder','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select cylinder', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'registrationnumber': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="registrationnumber" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('registrationnumber', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'registrationcity': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="registrationcity" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('registrationcity', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'locationcity': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="locationcity" class="jsvehiclemanager-label"><?php echo __($field->fieldtitle,'js-vehicle-manager');?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('locationcity', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'loczip': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="loczip" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('loczip ', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'map': ?>
                <div class="form-group">
                    <div class="jsvehiclemanager-js-form-wrapper jsvehiclemanager-full-width">
                        <label for="map" class="control-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                        <div class="jsvehiclemanager-value">
                        <div id="map_container">
                        </div>
                        </div>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper">
                        <label class="control-label"  id="jsvm_longitudemsg" for="longitude"><?php echo esc_html__('Longitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                        <div class="jsvehiclemanager-value">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('longitude', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper">
                        <label class="control-label"  id="jsvm_latitudemsg" for="latitude"><?php echo esc_html__('Latitude','js-vehicle-manager')." :"; ?> <?php if ($field->required == 1) { echo ' <font color="red">*</font>'; } ?></label>
                        <div class="jsvehiclemanager-value">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('latitude',  '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper">
                            <label for="radiustype" class="jsvehiclemanager-label"><?php echo esc_html__('Radius Type','js-vehicle-manager');?></label>
                        <div class="jsvehiclemanager-value">
                            <?php echo  wp_kses(JSVEHICLEMANAGERformfield::select('radiustype', $radiustype ,jsvehiclemanager::$_config['default_radius_type'], esc_html__('Select radius type','js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2', 'data-placeholder'=> esc_html__('Select radius type', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper">
                            <label for="radius" class="jsvehiclemanager-label"><?php echo esc_html__('Radius','js-vehicle-manager');?></label>
                        <div class="jsvehiclemanager-value">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('radius', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                </div>
            <?php
            break;
            case 'price': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="currency" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                    <div class="jsvehiclemanager-js-form-wrapper-one-third">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pricefrom', '', array('class' => 'form-control jsvm_three-width-field price-field', 'placeholder'=> esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper-one-third">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('priceto', '', array('class' => 'form-control jsvm_three-width-field price-field', 'placeholder'=> esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper-one-third">
                       <?php echo  wp_kses(JSVEHICLEMANAGERformfield::select('currency', JSVEHICLEMANAGERincluder::getJSModel('currency')->getCurrencyForCombo(), '' , esc_html__('Select currency','js-vehicle-manager'), array('class' => 'form-control jsvm_three-width-field jsvm_cm_select2', 'data-placeholder'=> esc_html__('Select currency', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    </div>
                </div>
            <?php
            break;
            case 'exteriorcolor': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="exteriorcolor" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                       <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('exteriorcolor', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'interiorcolor': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="interiorcolor" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                       <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('interiorcolor', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'cityfuelconsumption': ?>
                <div class="jsvehiclemanager-js-form-wrapper jsvm_speedometer">
                        <label for="cityfuelconsumptionfrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityfuelconsumptionfrom', '', array('class' => 'form-control jsvm_half-width-field jsvm_cityfuelconsumption-field', 'placeholder'=>esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityfuelconsumptionto', '', array('class' => 'form-control jsvm_half-width-field jsvm_cityfuelconsumption-field jsvm_cityfuelconsumptionto jsvm_to', 'placeholder'=>esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                            <span class="jsvm_speedometer"></span>
                        </div>
                    </div>
                </div>
            <?php
            break;
            case 'highwayfuelconsumption': ?>
                <div class="jsvehiclemanager-js-form-wrapper jsvm_speedometer">
                        <label for="highwayfuelconsumptionfrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <div class="jsvehiclemanager-js-form-wrapper">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('highwayfuelconsumptionfrom', '', array('class' => 'form-control jsvm_half-width-field jsvm_highwayfuelconsumption-field', 'placeholder'=>esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('highwayfuelconsumptionto', '', array('class' => 'form-control jsvm_half-width-field jsvm_highwayfuelconsumption-field jsvm_highwayfuelconsumptionto jsvm_to', 'placeholder'=>esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        <span class="jsvm_speedometer"></span>
                        </div>                        
                    </div>
                </div>
            <?php
            break;
            case 'enginecapacity': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="enginecapacityfrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginecapacityfrom', '', array('class' => 'form-control jsvm_half-width-field jsvm_enginecapacity-field', 'placeholder'=> esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginecapacityto', '', array('class' => 'form-control jsvm_half-width-field jsvm_enginecapacity-field', 'placeholder'=> esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                </div>
            <?php
            break;
            case 'stocknumber': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="stocknumber" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('stocknumber', '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'mileages': ?>
                <div class="jsvehiclemanager-js-form-wrapper jsvm_speedometer">
                        <label for="mileagefrom" class="jsvehiclemanager-label"><?php echo __($field->fieldtitle,'js-vehicle-manager');?></label>
                    <div class="jsvehiclemanager-value">
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mileagefrom', '', array('class' => 'form-control jsvm_half-width-field mileage-field', 'placeholder'=> esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mileageto', '', array('class' => 'form-control jsvm_half-width-field jsvm_mileagesto jsvm_to', 'placeholder'=> esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        <span class="jsvm_speedometer"></span>
                        </div>
                    </div>
                </div>
            <?php
            break;
            case 'speedmetertype': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="mileagetype" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('mileagetype', JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMileagesForCombo(), '', esc_html__('Select mileage','js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2','title'=> esc_html__('Select Speedometer Type','js-vehicle-manager'),'onchange' => "speedmeterchange(this,true)",'data-symbols' => jsvehiclemanager::$_data['mileage_symbols'], 'data-placeholder'=> esc_html__('Select mileage', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'transmission': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="transmission[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('transmission[]', JSVEHICLEMANAGERincluder::getJSModel('transmissions')->gettransmissionsForCombo(), '', esc_html__('Select transmission', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Transmission','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select transmission', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            default:
                $i = 0;
                $u_field = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldsForSearch($field, $i,1);
                if($u_field){ ?>
                    <div class="jsvehiclemanager-js-form-wrapper">
                            <label for="transmission[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                        <div class="jsvehiclemanager-value">
                            <?php echo wp_kses($u_field, JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                    <?php
                }
            break;
        }
    }
    echo '</div>'; // in each case div of wrapper col-md-12 has to close;
    ?>
    
    <input type="hidden" id="jsvm_issearch" name="issearch" value="1"/>
    <input type="hidden" id="jsvehiclemanagerpageid" name="jsvehiclemanagerpageid" value="<?php echo esc_attr(get_the_ID()); ?>"/>
    
    
    <div class="jsvehiclemanager-js-buttons-area">
        <div class="jsvehiclemanager-js-buttons-area-btn">
            <input class="jsvehiclemanager-js-btn-save" type="submit" value="<?php echo esc_attr(__('Search Vehicle','js-vehicle-manager')); ?>" onClick="return checkmapcooridnate();" />
        </div>
    </div>


    </div>
</form>

<input type="hidden" id="default_longitude" name="default_longitude" value="<?php echo esc_attr( jsvehiclemanager::$_config['default_longitude']); ?>"/>
<input type="hidden" id="default_latitude" name="default_latitude" value="<?php echo esc_attr( jsvehiclemanager::$_config['default_latitude']); ?>"/>
 
</div>
</div>
</div>
<?php }
?>
</div>
