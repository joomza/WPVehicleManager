<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSVehicleManagerwidgetModel {

    function __construct() {
    }

    function getVehiclesWidgetHTMl($vehicles,$pageid,$heading,$description,$number_of_columns,$layout_name){
        $html = '';
        $html .= '
                    <div class="jsvehiclemanager_vehicles_widget_wrapper" >

                        <div class="jsvehiclemanager_vehicles_widget_top" >
                            <div class="jsvehiclemanager_vehicles_widget_title" >
                                '. __($heading,'js-vehicle-manager') .'
                            </div>';
        if(trim($description) != '' ){
            $html .='
                            <div class="jsvehiclemanager_vehicles_widget_desc" >
                                '. __($description,'js-vehicle-manager') .'
                            </div>';
        }
        $html .='
                        </div>
                        <div class="jsvehiclemanager_vehicles_widget_data_wrapper" > ';
        $number_of_columns_css = '';
        if($number_of_columns != 1){
            $percentage = 100 / $number_of_columns;
            $number_of_columns_css = 'style="width:calc('.$percentage.'% - 20px);"';
        }
        foreach ($vehicles as $vehicle) {
                $imagesrc = JSVEHICLEMANAGERIncluder::getJSModel('vehicle')->getVehicleImageByPath($vehicle->file,$vehicle->filename,'s');
                $link = jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->id, 'jsvehiclemanagerpageid'=>$pageid));
                $title = JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($vehicle->maketitle , $vehicle->modeltitle , $vehicle->modelyeartitle);
                $location = JSVEHICLEMANAGERincluder::getJSModel('common')->getLocationForView($vehicle->cityname,$vehicle->statename, $vehicle->countryname);
                $price = JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($vehicle->price,$vehicle->currencysymbol, $vehicle->isdiscount, $vehicle->discounttype, $vehicle->discount, $vehicle->discountstart, $vehicle->discountend);
                $html .='    <div class="jsvehiclemanager_vehicles_widget_data_record" '.$number_of_columns_css.' >';
                $html .='       <div class="jsvehiclemanager_vehicles_widget_data_record_image_wrap" >';
                $html .='          <img src="'.$imagesrc.'" class="jsvehiclemanager_vehicles_widget_data_record_image" />';
                $html .='          <div class="jsvehiclemanager_vehicles_widget_data_record_price" >
                                    '.$price;
                $html .='          </div>';
                $html .='       </div>';
                $html .='       <div class="jsvehiclemanager_vehicles_widget_data_record_data">';
                $html .='           <a class="jsvehiclemanager_vehicles_widget_data_record_link" href="'.$link.'" >';
                $html .=                $title;
                $html .='           </a>';
                $html .='           <div class="jsvehiclemanager_vehicles_widget_data_record_middle" >';
                $html .='               <span class="jsvehiclemanager_vehicles_widget_data_record_middle_data" style="background:#fff;color:'.$vehicle->conditioncolor.';border:1px solid '.$vehicle->conditioncolor.';" >';
                $html .=                    $vehicle->conditiontitle;
                $html .='               </span>';
                $html .='               <span class="jsvehiclemanager_vehicles_widget_data_record_middle_data" >';
                $html .=                    $vehicle->transmissiontitle;
                $html .='               </span>';
                $html .='               <span class="jsvehiclemanager_vehicles_widget_data_record_middle_data" >';
                $html .=                    $vehicle->fueltypetitle;
                $html .='               </span>';
                $html .='           </div>';
                if($location != ''){
                    $html .='           <div class="jsvehiclemanager_vehicles_widget_data_record_bottom" >';
                    $html .=                $location;
                    $html .='           </div>';
                }
                $html .='       </div>';
                $html .='    </div>';
        }
        $html .='       </div>

                    </div>
        ';
        return $html;
    }

    function getVehiclesByCitiesWidgetHTMl($cities,$pageid,$heading,$description,$number_of_columns,$layout_name){
    	$html = '';
    	$html .= '
    				<div class="jsvehiclemanager_vehicles_widget_wrapper" >
                        <div class="jsvehiclemanager_vehicles_widget_top" >
                            <div class="jsvehiclemanager_vehicles_widget_title" >
                                '. __($heading,'js-vehicle-manager') .'
                            </div>';
        if(trim($description) != '' ){
            $html .='
                            <div class="jsvehiclemanager_vehicles_widget_desc" >
                                '. __($description,'js-vehicle-manager') .'
                            </div>';
        }
        $html .='
                        </div>
                        <div class="jsvehiclemanager_vehicles_widget_data_wrapper" > ';
        $number_of_columns_css = '';
        if($number_of_columns != 1){
        	$percentage = 100 / $number_of_columns;
        	$number_of_columns_css = 'style="width:calc('.$percentage.'% - 20px);"';
		}
        foreach ($cities as $city) {
                $link = jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicles', 'cityid'=>$city->cityid, 'jsvehiclemanagerpageid'=>$pageid));
                if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclebycity_countryname') != 1){
                    $city->countryname = '';
                }
                $location = JSVEHICLEMANAGERincluder::getJSModel('common')->getLocationForView($city->cityname,$city->statename, $city->countryname);
                $html .='    <div class="jsvehiclemanager_vehicles_widget_data_record" '.$number_of_columns_css.' >';
                $html .='       <a class="jsvehiclemanager_vehicles_widget_data_record" href="'.$link.'" >';
                $html .=            '<div class="jsvehiclemanager_vehicles_widget_data_record_location" >'.$location.'</div>';
                $html .=            '<div class="jsvehiclemanager_vehicles_widget_data_record_number" >('.$city->totalvehiclelbycity.')</div>';
                $html .='       </a>';
				$html .='    </div>';
        }
		$html .='		</div>

    				</div>
    	';
    	return $html;
    }
}

?>
