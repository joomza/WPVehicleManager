
<!-- popup start -->

<div id="jsvehiclemanager-pop-transparent-refine">
    <div class="jsvehiclemanager-pop-wrapper-refine">
        <span id="jsvehiclemanager-pop-wrapper-close-refine" onclick="closeRefineSearchPopup();">
            <img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."includes/images/popup-close.png" ?>">
        </span>
        <div class="jsvehiclemanager-pop-body-refine">

        <!-- refine search content start -->
            <div class="" id="jsvehiclemanager-ctn-short-refine">
                <div class="jsvehiclemanager-pop-heading-refine">
                    <?php echo __('Refine Search','js-vehicle-manager'); ?>
                </div>
                <div class="jsvehiclemanager-pop-content-refine" id="jsvehiclemanager-shortlist-content-refine">
            <?php
            $urlArr = array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles');
            if(JSVEHICLEMANAGERrequest::getVar('sellerid',null,0) > 0)
                $urlArr['sellerid'] = JSVEHICLEMANAGERrequest::getVar('sellerid');
            ?>
            <form class="jsvehiclemanager_autoz_form" id="jsvm_autoz_form" method="post" action="<?php echo esc_url(jsvehiclemanager::makeUrl($urlArr)); ?>">   
        <?php
        foreach (jsvehiclemanager::$_data[3] AS $field) {
        switch ($field->field) {
            case 'modelyear': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="modelyearfrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                        <div class="jsvehiclemanager-value">
                            <div class="jsvehiclemanager-js-form-wrapper">            
                                <div class="halfsearchfilter"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('modelyearfrom', JSVEHICLEMANAGERincluder::getJSModel('modelyears')->getModelyearsTitleForCombo(), isset(jsvehiclemanager::$_data['filter']['modelyearfrom']) ? jsvehiclemanager::$_data['filter']['modelyearfrom'] : '' , esc_html__('Select model year from', 'js-vehicle-manager') , array('class' => 'form-control fullsearchformfield jsvm_cm_select2', 'title'=> esc_html__('Select Model Year From','js-vehicle-manager'), 'data-placeholder'=> esc_html__('From', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                                </div>
                                <div class="jsvehiclemanager-js-form-wrapper">
                        <div class="halfsearchfilter2"><?php echo wp_kses(JSVEHICLEMANAGERformfield::select('modelyearto', JSVEHICLEMANAGERincluder::getJSModel('modelyears')->getModelyearsTitleForCombo(), isset(jsvehiclemanager::$_data['filter']['modelyearto']) ? jsvehiclemanager::$_data['filter']['modelyearto'] : '' , esc_html__('Select model year to', 'js-vehicle-manager') , array('class' => 'form-control fullsearchformfield jsvm_cm_select2', 'title'=> esc_html__('Select Model Year to','js-vehicle-manager'), 'data-placeholder'=> esc_html__('To', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS);?></div>
                            </div>
                        </div>
                        
                </div>
            <?php
            break;
            case 'make': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="make[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('make[]', JSVEHICLEMANAGERincluder::getJSModel('make')->getMakeForCombo(),isset(jsvehiclemanager::$_data['filter']['make']) ? jsvehiclemanager::$_data['filter']['make'] : '', esc_html__('Select make', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2','onchange' => 'getmodels();',"multiple"=>"multiple" ,'title'=> esc_html__('Select Make','js-vehicle-manager'), "data-makeid" => "1" , 'data-placeholder'=> esc_html__('Select make', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'model': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="model[]" class="jsvehiclemanager-label">
                            <?php echo __($field->fieldtitle,'js-vehicle-manager');?>
                            <img id="makemodelloading-gif" style="display:none;" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL;?>/includes/images/makemodelloading.gif" alt="<?php echo esc_attr(__('loading','js-vehicle-manager')); ?>" title="<?php echo esc_attr(__('loading','js-vehicle-manager')); ?>" />
                        </label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('model[]', JSVEHICLEMANAGERincluder::getJSModel('model')->getModelForCombo(), isset(jsvehiclemanager::$_data['filter']['model']) ? jsvehiclemanager::$_data['filter']['model'] : '' ,esc_html__('Select model', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Model','js-vehicle-manager') , "data-modelid" => "1", 'data-placeholder'=> esc_html__('Select model', 'js-vehicle-manager') )), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'vehicletype': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="vehicletype[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                        <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('vehicletype[]', JSVEHICLEMANAGERincluder::getJSModel('vehicletype')->getVehicletypeForCombo(),isset(jsvehiclemanager::$_data['filter']['vehicletype']) ? jsvehiclemanager::$_data['filter']['vehicletype'] : '',esc_html__('Select type', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Vehicle Type','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select type', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                </div>
            <?php
            break;
            case 'condition': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="condition[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('condition[]', JSVEHICLEMANAGERincluder::getJSModel('conditions')->getConditionForCombo(),isset(jsvehiclemanager::$_data['filter']['condition']) ? jsvehiclemanager::$_data['filter']['condition'] : '' ,esc_html__('Select condition', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Condition','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select condition', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'fueltype': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="fueltype[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('fueltype[]', JSVEHICLEMANAGERincluder::getJSModel('fueltypes')->getFueltypeForCombo(),isset(jsvehiclemanager::$_data['filter']['fueltype']) ? jsvehiclemanager::$_data['filter']['fueltype'] : '',esc_html__('Select fuel type', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Fuel Type','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select fuel type', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'cylinder': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="cylinder[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('cylinder[]', JSVEHICLEMANAGERincluder::getJSModel('cylinders')->getCylinderForCombo(),isset(jsvehiclemanager::$_data['filter']['cylinder']) ? jsvehiclemanager::$_data['filter']['cylinder'] : '',esc_html__('Select cylinder', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Cylinder','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select cylinder', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'registrationnumber': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="registrationnumber" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('registrationnumber', isset(jsvehiclemanager::$_data['filter']['registrationnumber']) ? jsvehiclemanager::$_data['filter']['registrationnumber'] : '', array('class' => 'form-control')) , JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'registrationcity': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="registrationcity" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('registrationcity',isset(jsvehiclemanager::$_data['filter']['registrationcity']) ? jsvehiclemanager::$_data['filter']['registrationcity'] : '', array('class' => 'form-control')) , JSVEHICLEMANAGER_ALLOWED_TAGS);?>
                    </div>
                </div>
            <?php
            break;
            case 'locationcity': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="locationcity" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('locationcity',isset(jsvehiclemanager::$_data['filter']['locationcity']) ? jsvehiclemanager::$_data['filter']['locationcity'] : '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'loczip': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="loczip" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('loczip ',isset(jsvehiclemanager::$_data['filter']['loczip']) ? jsvehiclemanager::$_data['filter']['loczip'] : '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
             
            case 'price': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="currency" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                    <div class="jsvehiclemanager-js-form-wrapper-one-third">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('pricefrom',isset(jsvehiclemanager::$_data['filter']['pricefrom']) ? jsvehiclemanager::$_data['filter']['pricefrom'] : '', array('class' => 'form-control jsvm_three-width-field price-field', 'placeholder'=> esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper-one-third">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('priceto',isset(jsvehiclemanager::$_data['filter']['priceto']) ? jsvehiclemanager::$_data['filter']['priceto'] : '', array('class' => 'form-control jsvm_three-width-field price-field', 'placeholder'=> esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    <div class="jsvehiclemanager-js-form-wrapper-one-third">
                       <?php echo  wp_kses(JSVEHICLEMANAGERformfield::select('currency', JSVEHICLEMANAGERincluder::getJSModel('currency')->getCurrencyForCombo(),isset(jsvehiclemanager::$_data['filter']['currency']) ? jsvehiclemanager::$_data['filter']['currency'] : '', esc_html__('Select currency','js-vehicle-manager'), array('class' => 'form-control jsvm_three-width-field jsvm_cm_select2', 'data-placeholder'=> esc_html__('Select currency', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                    </div>
                </div>
            <?php
            break;
            case 'exteriorcolor': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="exteriorcolor" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                       <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('exteriorcolor',isset(jsvehiclemanager::$_data['filter']['exteriorcolor']) ? jsvehiclemanager::$_data['filter']['exteriorcolor'] : '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'interiorcolor': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="interiorcolor" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                       <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('interiorcolor',isset(jsvehiclemanager::$_data['filter']['interiorcolor']) ? jsvehiclemanager::$_data['filter']['interiorcolor'] : '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'cityfuelconsumption': ?>
                <div class="jsvehiclemanager-js-form-wrapper jsvm_speedometer">
                        <label for="cityfuelconsumptionfrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityfuelconsumptionfrom',isset(jsvehiclemanager::$_data['filter']['cityfuelconsumptionfrom']) ? jsvehiclemanager::$_data['filter']['cityfuelconsumptionfrom'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_cityfuelconsumption-field', 'placeholder'=>esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('cityfuelconsumptionto',isset(jsvehiclemanager::$_data['filter']['cityfuelconsumptionto']) ? jsvehiclemanager::$_data['filter']['cityfuelconsumptionto'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_cityfuelconsumption-field jsvm_cityfuelconsumptionto jsvm_to', 'placeholder'=>esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
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
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('highwayfuelconsumptionfrom',isset(jsvehiclemanager::$_data['filter']['highwayfuelconsumptionfrom']) ? jsvehiclemanager::$_data['filter']['highwayfuelconsumptionfrom'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_highwayfuelconsumption-field', 'placeholder'=>esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('highwayfuelconsumptionto', isset(jsvehiclemanager::$_data['filter']['highwayfuelconsumptionto']) ? jsvehiclemanager::$_data['filter']['highwayfuelconsumptionto'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_highwayfuelconsumption-field jsvm_highwayfuelconsumptionto jsvm_to', 'placeholder'=>esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
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
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginecapacityfrom', isset(jsvehiclemanager::$_data['filter']['enginecapacityfrom']) ? jsvehiclemanager::$_data['filter']['enginecapacityfrom'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_enginecapacity-field', 'placeholder'=> esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('enginecapacityto', isset(jsvehiclemanager::$_data['filter']['enginecapacityto']) ? jsvehiclemanager::$_data['filter']['enginecapacityto'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_enginecapacity-field', 'placeholder'=> esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                    </div>
                </div>
            <?php
            break;
            case 'stocknumber': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="stocknumber" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('stocknumber', isset(jsvehiclemanager::$_data['filter']['stocknumber']) ? jsvehiclemanager::$_data['filter']['stocknumber'] : '', array('class' => 'form-control')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'mileages': ?>
                <div class="jsvehiclemanager-js-form-wrapper jsvm_speedometer">
                        <label for="mileagefrom" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <div class="jsvehiclemanager-js-form-wrapper">
                            <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mileagefrom', isset(jsvehiclemanager::$_data['filter']['mileagefrom']) ? jsvehiclemanager::$_data['filter']['mileagefrom'] : '', array('class' => 'form-control jsvm_half-width-field mileage-field', 'placeholder'=> esc_html__('From','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                        </div>
                        <div class="jsvehiclemanager-js-form-wrapper">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::text('mileageto', isset(jsvehiclemanager::$_data['filter']['mileageto']) ? jsvehiclemanager::$_data['filter']['mileageto'] : '', array('class' => 'form-control jsvm_half-width-field jsvm_mileagesto jsvm_to', 'placeholder'=> esc_html__('To','js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
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
                        <?php echo  wp_kses(JSVEHICLEMANAGERformfield::select('mileagetype', JSVEHICLEMANAGERincluder::getJSModel('mileages')->getMileagesForCombo(),isset(jsvehiclemanager::$_data['filter']['mileagetype']) ? jsvehiclemanager::$_data['filter']['mileagetype'] : '', esc_html__('Select mileage','js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2','title'=> esc_html__('Select Speedometer Type','js-vehicle-manager'),'onchange' => "speedmeterchange(this,true)",'data-symbols' => jsvehiclemanager::$_data['mileage_symbols'], 'data-placeholder'=> esc_html__('Select mileage', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            case 'transmission': ?>
                <div class="jsvehiclemanager-js-form-wrapper">
                        <label for="transmission[]" class="jsvehiclemanager-label"><?php echo esc_html(__($field->fieldtitle,'js-vehicle-manager'));?></label>
                    <div class="jsvehiclemanager-value">
                        <?php echo wp_kses(JSVEHICLEMANAGERformfield::select('transmission[]', JSVEHICLEMANAGERincluder::getJSModel('transmissions')->gettransmissionsForCombo(),isset(jsvehiclemanager::$_data['filter']['transmission']) ? jsvehiclemanager::$_data['filter']['transmission'] : '', esc_html__('Select transmission', 'js-vehicle-manager'), array('class' => 'form-control jsvm_cm_select2',"multiple"=>"multiple" ,'title'=> esc_html__('Select Transmission','js-vehicle-manager'), 'data-placeholder'=> esc_html__('Select transmission', 'js-vehicle-manager'))), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
                    </div>
                </div>
            <?php
            break;
            default:
                $i = 0;
                $u_field = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->formCustomFieldsForSearch($field, $i,1);
                if($u_field){
                    ?>
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
    ?>
        <div class="jsvehiclemanager-js-buttons-area">
            <div class="jsvehiclemanager-js-buttons-area-btn">
                <input class="jsvehiclemanager-js-btn-save" type="submit" value="<?php echo esc_attr(__('Search Vehicle','js-vehicle-manager')); ?>" onClick="document.forms[0].submit();" />
                <input class=" jsvehiclemanager-reset" type="button" value="<?php echo esc_attr(__('Reset','js-vehicle-manager')); ?>" onclick="restFrom();" />
            </div>
        </div>

         <input type="hidden" id="jsvm_issearch" name="issearch" value="1"/>
        <input type="hidden" id="jsvehiclemanagerpageid" name="jsvehiclemanagerpageid" value="<?php echo esc_attr(get_the_ID()); ?>"/>

        </form>

                </div>
            </div>
        <!-- refine search content end -->
            
        </div>
    </div>
</div>

<!-- popup end -->