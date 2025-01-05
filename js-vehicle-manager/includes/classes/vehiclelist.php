<?php
if (!defined('ABSPATH')) die('Restricted Access');

	class JSVEHICLEMANAGERvehiclelist {

        function checkrowcount(&$rowcount,&$html, &$noofvehicles , $showgoogleadds, $after_vehicles, $googleclient, $googleslot, $googleaddhieght, $googleaddwidth, $googleaddcss,$function_flag){
            if ($rowcount == 0) {
            	if($function_flag == 1){
                	$html .='<div class="col-sm-12 col-md-12 jsvm_cm-veh-list-vert-wrap">';
                }else{
                	$html .='<div class="col-sm-12 col-md-12 jsvm_cm-veh-list-side-wrap">';
                }
            }elseif ($rowcount % 3 == 0) {
                $html .='</div>';
                $noofvehicles++;
                if ($showgoogleadds == 1) {
                    if (($noofvehicles != 0) && ($noofvehicles % $after_vehicles) == 0) {
                        $html .= '<div class="jsvm-ad-wrap">
                                    <ins class="adsbygoogle adslot_1" style="'.$googleaddcss.' height: '.$googleaddhieght.'px; width: '.$googleaddwidth.'px;" data-ad-client="'.$googleclient.'" data-ad-slot="'.$googleslot.'"></ins>
                                    <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>';
                    }
                }
                if($function_flag == 1){
                	$html .='<div class="col-sm-12 col-md-12 jsvm_cm-veh-list-vert-wrap">';
                }else{
                	$html .='<div class="col-sm-12 col-md-12 jsvm_cm-veh-list-side-wrap">';
                }
            }
            $rowcount++;
        }

        function printpluginvehicle(&$vehicles){
        	global $car_manager_options;
            function checkLinks($name) {
                $print = false;
                $configname = $name;

                $config_array = jsvehiclemanager::$_data['config'];
                if ($config_array["$configname"] == 1) {
                    $print = true;
                }
                return $print;
            }
			if(empty($vehicles)){
				$html  = '<div class="jsvehiclemanager-no-more-vehicles-message"><h1>';
				$html .= 	 __('No More Vehicles','js-vehicle-manager');
				$html .= '</h1></div>';
				return $html;
			}
			ob_start();
            $compareVehicleList=array();
            if(in_array('comparevehicle',jsvehiclemanager::$_active_addons)){
                if(isset(jsvehiclemanager::$_data['json_data'])){
                    foreach(json_decode(jsvehiclemanager::$_data['json_data']) as $k=>$compVeh){
                        $compareVehicleList[] = $k;
                    }
                echo '<script>showHideGotoCompareLink();</script>';
                }
            }
			$curdate = date_i18n('Y-m-d');
            $noofvehicles = 0;
            foreach ($vehicles as $vehicle) {
                $arrow_flag = 1;
                if( empty($vehicle->imagename) ){
                    $imagepath = JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/vehicle-image.png';
                    $arrow_flag = 0;
                }else{
                    $imagepath = $vehicle->filepath.$vehicle->imagename;
                }
                do_action('jsvm_featuredvehicle_vehiclelist_feature_icon',$vehicle); // Feature icon
                ?>
                <div class="jsvehiclemanager_vehicle_wrapper <?php if(in_array($vehicle->id,$compareVehicleList)) echo 'jsvehiclemanager_cmp_sel_wrapper'; ?>">
                            <div class="jsvehiclemanager_vehicle_top_wrap">
                                <div class="jsvehiclemanager_vehicle_slide_wrap">
                                    <div class="jsvehiclemanager_vehicle_slide_image">
                                    <a href="<?php echo jsvehiclemanager::makeUrl(array('jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->vehicleid, 'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid())); ?>">
                                    <img class="big-image" src="<?php echo esc_url($imagepath); ?>" id="jsvehiclemanager-big-image-<?php echo esc_attr($vehicle->id); ?>">
                                    </a>
                                        <?php if ($arrow_flag == 1) { ?>
                                            <span class="jsvehiclemanager_vehicle_slide_left_arrow" onclick="showImageSlide(<?php echo $vehicle->id?>,true);">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>/includes/images/shortlisted-veh/left-arrow.png" /></span>
                                            <span class="jsvehiclemanager_vehicle_slide_right_arrow" onclick="showImageSlide(<?php echo $vehicle->id?>);">
                                            <img class="jsvehiclemanager_vehicle_logo" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>/includes/images/shortlisted-veh/right-arrow.png" /></span>
                                        <?php } ?>
                                        <?php do_action('jsvm_vehiclelist_mark_vehicle_sold',$vehicle); ?>
                                    </div>
                                </div>
                                <div class="jsvehiclemanager_vehicle_right_content">
                                    <div class="jsvehiclemanager_vehicle_content_top_row">
                                        <span class="jsvehiclemanager_vehicle_title">
                                            <a href="<?php echo jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid(),'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$vehicle->vehicleid)); ?>">
                                                <span class="title"><?php
                                                    echo JSVEHICLEMANAGERincluder::getJSModel('common')->returnVehicleTitle($vehicle->maketitle,$vehicle->modeltitle,$vehicle->modelyeartitle);

                                                ?></span>
                                            </a>
                                        </span>
                                        <span class="jsvehiclemanager_vehicle_price">
                                            <span class="price">
                                            <?php $v_price = JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($vehicle->price,$vehicle->currencysymbol, $vehicle->isdiscount, $vehicle->discounttype, $vehicle->discount, $vehicle->discountstart, $vehicle->discountend); ?>
                                             <?php echo esc_html($v_price); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_create_date">
                                            <?php
                                               echo esc_html(date_i18n(jsvehiclemanager::$_config['date_format'],strtotime($vehicle->created)));
                                             ?>
                                        </span>
                                    </div>
                                    <div class="jsvehiclemanager_vehicle_detail_row">
                                        <span class="jsvehiclemanager_vehicle_fuel_title"><?php echo __("Fuel Consumption",'js-vehicle-manager').": ";?></span>
                                        <span class="jsvehiclemanager_vehicle_value">
                                        <?php
                                            if (jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1) {
                                                echo esc_html(__($vehicle->cityfuelconsumption,'js-vehicle-manager'))." ".esc_html($vehicle->mileagesymbol)." ".esc_html__("City",'js-vehicle-manager');
                                            }
                                            if(jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1 && jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                echo    " / ";
                                            }
                                            if( jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                echo esc_html(__($vehicle->highwayfuelconsumption,'js-vehicle-manager'))." ".esc_html($vehicle->mileagesymbol)." ".esc_html__("Highway",'js-vehicle-manager');
                                            }
                                        ?>
                                        </span>
                                    </div>

                                <?php do_action('jsvm_featuredvehicle_vehiclelist_show_stock_color',$vehicle); ?>
                                <div class="jsvehiclemanager_vehicle_detail_row">
                                    <span class="jsvehiclemanager_vehicle_loction_title"><?php echo __(jsvehiclemanager::$_data['fields']['locationcity'],'js-vehicle-manager').': '; ?></span>
                                    <span class="jsvehiclemanager_vehicle_location_value"><?php echo esc_html(__($vehicle->location,'js-vehicle-manager')) ;?></span>
                                </div>
				                <?php
                                    $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                    foreach($customfields AS $field){
                                        $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$vehicle->params); ?>
                                        <div class="jsvehiclemanager_vehicle_detail_row">
                                            <span class="jsvehiclemanager_vehicle_loction_title"><?php echo esc_html(__($array[0],'js-vehicle-manager')).': '; ?></span>
                                            <span class="jsvehiclemanager_vehicle_location_value"><?php echo esc_html(__($array[1],'js-vehicle-manager'));?></span>
                                        </div>
                                        <?php
                                    }
                                ?>
                                    <?php if( JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_sellerimage')==true && !empty($vehicle->sellerphoto) ): ?>
                                    <div class="jsvehiclemanager_vehicle_status">
                                        <a href="<?php echo esc_url(jsvehiclemanager::makeUrl(array('jsvmme'=>'user','jsvmlt'=>'viewsellerinfo','jsvehiclemanagerid'=>$vehicle->sellerid,'jsvehiclemanagerpageid'=>jsvehiclemanager::getPageid()))); ?>">
                                        <img class="jsvehiclemanager_vehicle_logo" src="<?php echo esc_attr($vehicle->sellerphoto); ?>" />
                                        </a>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="jsvehiclemanager_vehicle_bottom_wrap" class="jsvehiclemanager_frontend">
                                <div class="jsvehiclemanager_vehicle_left">
                                    <div class="jsvehiclemanager_vehicle_option">
                                        <span class="jsvehiclemanager_vehicle_condions_new" style="background:#fff;font-weight:bold;color:<?php echo esc_attr($vehicle->conditioncolor);?>;border:1px solid <?php echo esc_attr($vehicle->conditioncolor);?>;">
                                          <?php echo esc_html(__($vehicle->conditiontitle,'js-vehicle-manager'));?>
                                        </span>
                                    </div><!--menu box-->
                                    <?php if(trim($vehicle->transmissiontitle) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="manual_box"><?php echo esc_html(__($vehicle->transmissiontitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->

                                    <?php
                                        }
                                        if(trim($vehicle->fueltypetitle) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="petrol_box"><?php echo esc_html(__($vehicle->fueltypetitle,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->
                                    <?php
                                        }
                                        if(trim($vehicle->mileages) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="milage_box"><?php echo esc_html(__($vehicle->mileages,'js-vehicle-manager'))." ".esc_html(__($vehicle->mileagesymbol,'js-vehicle-manager'));?></span>
                                        </div><!--menu box-->
                                    <?php
                                        }
                                        if(trim($vehicle->enginecapacity) != ''){ ?>
                                        <div class="jsvehiclemanager_vehicle_option">
                                            <span class="model_box"><?php echo esc_html(__($vehicle->enginecapacity,'js-vehicle-manager'))." ".__("CC",'js-vehicle-manager');?></span>
                                        </div><!--menu box-->
                                        <?php } ?>
                                </div><!--left side-->
                                <div class="jsvehiclemanager_vehicle_right_button">
                                    <div class="jsvehiclemanager_vehicle_button_area">
                                        <?php do_action('jsvm_vehiclelist_bottom_btns',$vehicle,$compareVehicleList); ?>
                                    </div>
                                </div>
                            </div><!--bottom row -->
                        </div><!--jsvehiclemanager_admin_wrapper -->
                <?php }
               $html = ob_get_clean();
               if($html != ''){
                    $noofvehicles++;
                    $html .= apply_filters("jsvm_adsense_show_adsense_vehiclelist",'',$noofvehicles);
                    $nextpage = JSVEHICLEMANAGERpagination::$_currentpage;
		            $nextpage += 1;
		            $showmore = 0;
		            if($nextpage % 6 == 0){
		                $showmore = 1;
		            }
                    $html .= '<a class="jsvehiclemanager-scrolltask" data-showmore="'.$showmore.'" data-scrolltask="getNexttemplateVehicles" data-offset="'.$nextpage.'"></a>';
		            if($showmore == 1 && count($vehicles) > 0){
		                $html .= '<a class="jsvehiclemanager-plg-showmoreautoz" href="javascript:void(0);" onclick="showmoreautoz(true);">
				                	<span>' . __('Show More', 'js-vehicle-manager') . '</span>
				  					<img src="' .JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/arrow-icon.png">
				                </a>';
		            }
	        	}
			   return $html;
        }

		function printtemplatevehicle(&$vehicles,$isPluginCall=false) {
            global $car_manager_options;
            if(empty($vehicles)){
                $html  = '<div class="no-more-vehicles-message"><h1>';
                $html .=     __('No More Vehicles','js-vehicle-manager');
                $html .= '</h1></div>';
                return $html;
            }
            $noofvehicles = 0;
            $config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('googleadds');
            $showgoogleadds = $config_array['googleadsenseshowinlistvehicle'];
            $after_vehicles = $config_array['googleadsenseshowafter'];
            $googleclient = $config_array['googleadsenseclient'];
            $googleslot = $config_array['googleadsenseslot'];
            $googleaddhieght = $config_array['googleadsenseheight'];
            $googleaddwidth = $config_array['googleadsensewidth'];
            $googleaddcss = $config_array['googleadsensecustomcss'];

            if(jsvehiclemanager::$_config['date_format'] == 'd-m-Y' ){
                $date_format_string = 'd/F/Y';
            }elseif(jsvehiclemanager::$_config['date_format'] == 'm/d/Y'){
                $date_format_string = 'F/d/Y';
            }elseif(jsvehiclemanager::$_config['date_format'] == 'Y-m-d'){
                $date_format_string = 'Y/F/d';
            }
            $curdate = date_i18n('Y-m-d');
            $html = '';
            if (isset($_COOKIE['jsvm_listing_style']) && $_COOKIE['jsvm_listing_style'] == 1) {
                foreach ($vehicles as $row){
                $featuredexpiry = date_i18n('Y-m-d', strtotime($row->endfeatureddate));
                $lightbox_flag = 0;
                if($row->imagename == ''){
                    $imgpath = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
                }else{
                    $lightbox_flag = 1;
                    $imgpath = $row->filepath.'ms_'.$row->imagename;
                }
                if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate) {
                    $html .='<div class="jsvm_cm-veh-list-featured">';
                    $html .='   <span class="jsvm_cm-veh-list-feature">';
                    $html .='       <i class="glyphicon glyphicon-star"></i>'
                                    . __('Featured','js-vehicle-manager');
                    $html .='   </span>';
                    $html .='</div>';
                }

                $html .='<div class="col-xs-12 col-md-12 jsvm_cm-veh-list-wrap">';
                $html .='   <div class="thumbnail jsvm_cm-veh-list">';

                $html .='       <div class="jsvm_cm-veh-list-img-wrap ';
                                if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate){
                                        $html .= ' jsvm_image-featured';
                                }
                                if($lightbox_flag == 1){
                                    $html .=' jsvm_hover-pointer';
                                }
                $html .='       "';
                                if($lightbox_flag == 1){
                                    $html .='onClick="showLightBox('.$row->vehicleid.');"';
                                }
                $html .='       >';
                $html .='           <img class="img-responsive jsvm_cm-veh-list-img" src="'.$imgpath.'" title="'.esc_attr('Image').'" alt="'.esc_attr('Image').'" />';
                                    if($lightbox_flag == 1){
                $html .='           <span class="jsvm_cm-sl-veh-left-txt" >'. __('See','js-vehicle-manager').' '.$row->totalimages.' '. __('Photos','js-vehicle-manager').'</span>';
                                    }
                                if ($row->issold == 1) {
                $html .='           <div class="jsvm_cm-veh-sold-wrap';
                                        if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate){
                                            $html .=' jsvm_image-featuredes';
                                        }
                $html .='                           ">';
                $html .='               <span class="jsvm_cm-veh-sold">'.
                                            __('Sold','js-vehicle-manager');
                $html .='               </span>';
                $html .='           </div>';
                                }
                $html .='       </div>';
                $html .='       <div class="jsvm_cm-veh-list-data-wrap';
                                if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate){
                                        $html .= ' jsvm_data-featured';
                                }
                $html .='       ">';
                $html .='           <div class="jsvm_cm-veh-list-top-wrap">';
                $html .='               <h4 class="jsvm_cm-veh-list-top-title">';
                $html .='                   <a class="jsvm_list-vehicle-title-link" href="'. jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'], 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$row->vehicleid)).'" title="'.car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle).'">';
                $html .=                        car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) ;
                $html .='                   </a>';
                $html .='               </h4>';
                $html .='               <h4 class="jsvm_cm-veh-list-top-price">'.
                                            JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($row->price,$row->currencysymbol, $row->isdiscount, $row->discounttype, $row->discount, $row->discountstart, $row->discountend);
                $html .='               </h4>';
                $html .='           </div>';
                $html .='           <div class="jsvm_cm-veh-list-middle-wrap">';
                $html .='               <div class="jsvm_cm-veh-list-middle-val">'.
                                            date_i18n($date_format_string,strtotime($row->created));
                $html .='               </div>';
                $html .='               <div class="jsvm_cm-veh-list-middle-val jsvm_biglineheight">';
                $html .='                   <span class="jsvm_cm-veh-list-middle-tit">'.  __('Fuel Consumption','js-vehicle-manager').": ".'</span>';
                $html .='                   <span class="jsvm_cm-veh-list-middle-vale">';
                                                if (jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1) {
                                                    $html .= __($row->cityfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager');
                                                }
                                                if(jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1 && jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                    $html .=' / ';
                                                }
                                                if( jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                    $html .= __($row->highwayfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager')." ".__("Highway",'js-vehicle-manager');
                                                }
                $html .='                   </span>';
                $html .='               </div>';
                                        if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate) {
                                            if (jsvehiclemanager::$_data['listingfields']['exteriorcolor'] == 1) {
                $html .='                       <div class="jsvm_cm-veh-list-middle-val jsvm_biglineheight">';
                $html .='                           <span class="jsvm_cm-veh-list-middle-tit">'.  __('Exterior Color','js-vehicle-manager').": ".'</span>';
                $html .='                           <span class="jsvm_cm-veh-list-middle-vale">'. __($row->exteriorcolor,'js-vehicle-manager').'</span>';
                $html .='                       </div>';
                                            }
                                        }
                                        if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate) {
                                            if (jsvehiclemanager::$_data['listingfields']['stocknumber'] == 1) {
                $html .='                       <div class="jsvm_cm-veh-list-middle-val jsvm_biglineheight">';
                $html .='                           <span class="jsvm_cm-veh-list-middle-tit">'.  __('Stock Number','js-vehicle-manager').": ".'</span>';
                $html .='                           <span class="jsvm_cm-veh-list-middle-vale">'. __($row->stocknumber,'js-vehicle-manager').'</span>';
                $html .='                       </div>';
                                            }
                                        }
                $html .='               <div class="jsvm_cm-veh-list-middle-val jsvm_biglineheight">';
                $html .='                   <span class="jsvm_cm-veh-list-middle-tit">'.  __('Location','js-vehicle-manager').": ".'</span>';
                $html .='                   <span class="jsvm_cm-veh-list-middle-vale">'. __($row->location,'js-vehicle-manager').'</span>';
                $html .='               </div>';
                                            $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                            foreach($customfields AS $field){
                                                $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params);
                $html .='                       <div class="jsvm_cm-veh-list-middle-val jsvm_biglineheight">';
                $html .='                           <span class="jsvm_cm-veh-list-middle-tit">'.__($array[0],'js-vehicle-manager').": ".'</span>';
                $html .='                           <span class="jsvm_cm-veh-list-middle-vale">'. $array[1] .'</span>';
                $html .='                       </div>';
                                            }
                if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_sellerimage') == 1){
                    if($row->sellerphoto != ''){
                                                    $simg = '<a href ="'.jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'], 'jsvmme'=>'user', 'jsvmlt'=>'viewsellerinfo', 'jsvehiclemanagerid'=>$row->sellerid)).'" title="'.esc_attr('Seller').'" >
                                                                <img src="'. $row->sellerphoto  .'" class="img-reponsives jsvm_cm-my-veh-log" title="'.esc_attr(esc_html__('Image' ,'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Image' ,'js-vehicle-manager')).'" />
                                                            </a>';
                        $html .='               <div class="jsvm_cm-veh-list-middle-img">';
                        $html .=                $simg;
                        $html .='               </div>';
                    }
                }
                $html .='           </div>';
                $html .='           <div class="jsvm_cm-veh-list-bottom-wrap jsvm_bigfont">';
                $html .='               <div class="jsvm_cm-veh-list-bottom-optn-wrap">';
                $html .='                   <div class="jsvm_condition-title-listing jsvm_full-width" style="color:'.$row->conditioncolor.';border:1px solid '.$row->conditioncolor.';" >
                                                '. $row->conditiontitle.'
                                            </div>';

                                            if (jsvehiclemanager::$_data['listingfields']['mileages'] == 1) {
                                                if (trim($row->mileages) AND trim($row->mileagesymbol)) {

                $html .='                           <span class="jsvm_cm-veh-list-bottom-optn">';
                $html .='                               <img src="'.CAR_MANAGER_IMAGE.'/milage-icon.png" class="img-reponsives" title="'.esc_attr(esc_html__('Mileage', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Mileage', 'js-vehicle-manager')).'"/>'.
                                                        __($row->mileages,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager');
                $html .='                           </span>';
                                                }
                                            }
                                            if(trim($row->transmissiontitle)){
                $html .='                       <span class="jsvm_cm-veh-list-bottom-optn">';
                $html .='                           <img src="'. CAR_MANAGER_IMAGE.'/transmission-icon.png" class="img-reponsives" title="'.esc_attr(esc_html__('Transmission', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Transmission', 'js-vehicle-manager')).'" />'.
                                                    __($row->transmissiontitle,'js-vehicle-manager');
                $html .='                       </span>';
                                            }
                                            if(trim($row->fueltypetitle)){
                $html .='                       <span class="jsvm_cm-veh-list-bottom-optn">';
                $html .='                           <img src="'. CAR_MANAGER_IMAGE.'/fuel-icon.png" class="img-reponsives" title="'.esc_attr(esc_html__('Fuel', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Fuel', 'js-vehicle-manager')).'"/>'.
                                                    __($row->fueltypetitle,'js-vehicle-manager');
                $html .='                       </span>';
                                            }
                $html .='               </div>';
                $html .='               <div class="jsvm_cm-veh-list-bottom-btn-wrap" > ';
                $html .='                   <div class="jsvm_cm-veh-list-bottom-btns"> ';
                if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_shortlist') == 1){
                    $html .='                       <a class="jsvm_cm-veh-list-bottom-btn"  href="#"  data-toggle="modal" data-target="#jsvm_shortlist" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) .'" data-vehicleimg="'. $imgpath.'" data-vehicleid="'.$row->vehicleid .'" >';
                    $html .='                           <img src="'.CAR_MANAGER_IMAGE.'/shortlist-icon.png" class="img-reponsives" title="'. __('Shortlist','js-vehicle-manager').'" alt="'. __('Shortlist','js-vehicle-manager').'" />';
                    $html .='                       </a>';
                }
                if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_tellafriend') == 1){
                    $html .='                       <a class="jsvm_cm-veh-list-bottom-btn"  href="#"  data-toggle="modal" data-target="#jsvm_tellafriend" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)  .'" data-vehicleimg="'. $imgpath .'" data-vehicleid="'. $row->vehicleid .'" >';
                    $html .='                           <img src="'.CAR_MANAGER_IMAGE.'/tell-friend-icon.png" class="img-reponsives" title="'. __('Tell A Friend','js-vehicle-manager').'" alt="'. __('Tell A Friend','js-vehicle-manager').'" />';
                    $html .='                       </a>';
                }
                $html .='                       <a class="jsvm_cm-veh-list-bottom-btn jsvm_cmp-btn jsvm_btn_'.$row->vehicleid.'" href="#" data-elenum="1" data-vehid="'. $row->vehicleid .'" >';
                $html .='                           <img src="'.CAR_MANAGER_IMAGE.'/compare-icon.png" class="img-reponsives" title="'. __('Add To Compare','js-vehicle-manager').'" alt="'. __('Add To Compare','js-vehicle-manager').'" />';
                $html .='                       </a>';
                $html .='                   </div>';
                $html .='               </div>';
                $html .='           </div>';
                $html .='       </div>';
                $html .='   </div>';
                $html .='</div>';

                    $noofvehicles++;
                    if ($showgoogleadds == 1) {
                        if (($noofvehicles != 0) && ($noofvehicles % $after_vehicles) == 0) {
                            $html .= '<div class="jsvm-ad-wrap">
                                    <ins class="adsbygoogle adslot_1" style="'.$googleaddcss.'" data-ad-client="'.$googleclient.'" data-ad-slot="'.$googleslot.'"></ins>
                                    <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>';
                        }
                    }
                }
            }elseif (isset($_COOKIE['jsvm_listing_style']) && ($_COOKIE['jsvm_listing_style'] == 2 || $_COOKIE['jsvm_listing_style'] == 3)) {
                foreach (jsvehiclemanager::$_data[0] as $row){
                    $featuredexpiry = date_i18n('Y-m-d', strtotime($row->endfeatureddate));
                    $lightbox_flag = 0;
                    if($row->imagename == ''){
                        $imgpath = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
                    }else{
                        $lightbox_flag = 1;
                        $imgpath = $row->filepath.'ms_'.$row->imagename;
                    }

                    if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate) {
                        $html .='       <div class="jsvm_cm-veh-list-side-featured">';
                        $html .='           <span class="jsvm_cm-veh-list-side-feature">';
                        $html .='               <i class="glyphicon glyphicon-star"></i>'.
                                                 __('Featured','js-vehicle-manager');
                        $html .='           </span>';
                        $html .='       </div>';
                    }
                    $html .='   <div class="thumbnail jsvm_cm-veh-list-side">';
                    $html .='       <div class="jsvm_cm-veh-list-side-top-wrap">';

                    $html .='           <div class="jsvm_cm-veh-list-side-img-wrap';
                    if($lightbox_flag == 1){
                        $html .=' jsvm_hover-pointer';
                    }
                    $html .='           "';
                    if($lightbox_flag == 1){
                        $html .='onClick="showLightBox('.$row->vehicleid.');"';
                    }
                    $html .='           >';
                    $html .='               <img src="'.$imgpath.'" class="img-responsive jsvm_cm-veh-list-side-img" title="'.esc_attr(esc_html__('Image', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Image', 'js-vehicle-manager')).'">';
                    if($lightbox_flag == 1){
                        $html .='                   <span class="jsvm_cm-sl-veh-left-txt" >'. __('See','js-vehicle-manager')." ".$row->totalimages.' '. __('Photos','js-vehicle-manager').'</span>';
                    }
                    if ($row->issold == 1) {
                        $html .='                   <div class="jsvm_cm-veh-sold-wrap">';
                        $html .='                       <span class="jsvm_cm-veh-sold">'.
                                                            __('Sold','js-vehicle-manager');
                        $html .='                       </span>';
                        $html .='                   </div>';
                    }
                    $html .='           </div>';
                    $html .='           <div class="jsvm_cm-veh-list-side-data-wrap">';
                    $html .='               <div class="jsvm_cm-veh-list-side-top-wrap">';
                    $html .='                   <h4 class="jsvm_cm-veh-list-side-top-title">';
                    $html .='                       <a class="jsvm_list-vehicle-title-link" href="'. jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'], 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$row->vehicleid)).'" title="'.esc_attr(car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)).'">'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) .'</a>';
                    $html .='                   </h4>';
                    $html .='                   <h4 class="jsvm_cm-veh-list-side-top-price">'.
                                                    JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($row->price,$row->currencysymbol, $row->isdiscount, $row->discounttype, $row->discount, $row->discountstart, $row->discountend);
                    $html .='                   </h4>';
                    $html .='               </div>';
                    $html .='               <div class="jsvm_cm-veh-list-side-middle-wrap">';
                    $html .='                   <div class="jsvm_cm-veh-list-side-middle-val">'.
                                                    date_i18n($date_format_string,strtotime($row->created));
                    $html .='                   </div>';
                    $html .='                   <div class="jsvm_cm-veh-list-side-middle-val jsvm_biglineheight">';
                    $html .='                       <span class="jsvm_cm-veh-list-side-middle-tit">'. __("Fuel Consumption",'js-vehicle-manager').": ".'</span>';
                    $html .='                       <span class="jsvm_cm-veh-list-side-middle-vale">';
                                                        if (jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1) {
                                                            $html .= __($row->cityfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager');
                                                        }
                                                        if(jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1 && jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                            $html .=' / ';
                                                        }
                                                        if( jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                            $html .= __($row->highwayfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager')." ".__("Highway",'js-vehicle-manager');
                                                        }
                    $html .='                       </span>';
                    $html .='                   </div>';
                    $html .='                   <div class="jsvm_cm-veh-list-side-middle-val jsvm_biglineheight">';
                    $html .='                       <span class="jsvm_cm-veh-list-side-middle-tit">'. __("Location",'js-vehicle-manager').": ".'</span>';
                    $html .='                       <span class="jsvm_cm-veh-list-side-middle-vale">'.__($row->location,'js-vehicle-manager').'</span>';
                    $html .='                   </div>';
                                             $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                                foreach($customfields AS $field){
                                                    $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params);
                    $html .='                                   <div class="jsvm_cm-veh-list-side-middle-val jsvm_biglineheight">';
                    $html .='                                       <span class="jsvm_cm-veh-list-side-middle-tit">'. __($array[0],'js-vehicle-manager').": ".'</span>';
                    $html .='                                       <span class="jsvm_cm-veh-list-side-middle-vale">'. $array[1].'</span>';
                    $html .='                                   </div>';
                                                }
                    if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_sellerimage') == 1){
                        if($row->sellerphoto != ''){
                                                        $simg = '<a href ="'.jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'], 'jsvmme'=>'user', 'jsvmlt'=>'viewsellerinfo', 'jsvehiclemanagerid'=>$row->sellerid)).'" title="'.esc_attr('Seller').'">
                                                                    <img src="'. $row->sellerphoto  .'" class="img-reponsives jsvm_cm-my-veh-log" title="'.esc_attr('Image').'" alt="'.esc_attr('Image').'"/>
                                                                </a>';
                            $html .='                       <div class="jsvm_cm-veh-list-side-middle-img">';
                            $html .=                        $simg;
                            $html .='                       </div>';
                        }
                    }
                    $html .='               </div>';
                    $html .='           </div>';
                    $html .='       </div>';
                    $html .='       <div class="jsvm_cm-veh-list-side-bottom-wrap jsvm_bigfont">';
                    $html .='           <div class="jsvm_cm-veh-list-side-bottom-optn-wrap">';
                    $html .='                   <div class="jsvm_condition-title-listing jsvm_full-width" style="color:'.$row->conditioncolor.';border:1px solid '.$row->conditioncolor.';" >
                                                    '.$row->conditiontitle.'
                                                </div>';
                    if (jsvehiclemanager::$_data['listingfields']['mileages'] == 1){
                        $html .='                   <span class="jsvm_cm-veh-list-side-bottom-optn">';
                        $html .='                       <img src="'.CAR_MANAGER_IMAGE.'/milage-icon.png" class="img-reponsives" title="'.esc_attr(esc_html__('Mileage', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Mileage', 'js-vehicle-manager')).'" />'.
                                                        __($row->mileages,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager');
                        $html .='                   </span>';
                    }

                                        if(trim($row->transmissiontitle)){
                    $html .='               <span class="jsvm_cm-veh-list-side-bottom-optn">';
                    $html .='                   <img src="'.CAR_MANAGER_IMAGE.'/transmission-icon.png" class="img-reponsives" title="'.esc_attr(esc_html__('Transmission', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Transmission', 'js-vehicle-manager')).'" />'.
                                                __($row->transmissiontitle,'js-vehicle-manager');
                    $html .='               </span>';
                                        }
                                        if(trim($row->fueltypetitle)){
                    $html .='               <span class="jsvm_cm-veh-list-side-bottom-optn">';
                    $html .='                   <img src="'.CAR_MANAGER_IMAGE.'/fuel-icon.png" class="img-reponsives" title="'.esc_attr(esc_html__('Fuel', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Fuel', 'js-vehicle-manager')).'" />'.
                                                __($row->fueltypetitle,'js-vehicle-manager');
                    $html .='               </span>';
                                        }
                    $html .='           </div>';
                    $html .='           <div class="jsvm_cm-veh-list-side-bottom-btn-wrap">';
                    $html .='               <div class="jsvm_cm-veh-list-side-bottom-btns">';
                    if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_shortlist') == 1){
                        $html .='                   <a class="jsvm_cm-veh-list-side-bottom-btn"  href="#"  data-toggle="modal" data-target="#jsvm_shortlist" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) .'" data-vehicleimg="'. $imgpath.'" data-vehicleid="'.$row->vehicleid .'" >';
                        $html .='                       <img src="'.CAR_MANAGER_IMAGE.'/shortlist-icon.png" class="jsvm_img-reponsives" title="'. __('Shortlist','js-vehicle-manager').'" alt="'.esc_attr(esc_html__('Shortlist', 'js-vehicle-manager')).'" title="'.esc_attr(esc_html__('Shortlist', 'js-vehicle-manager')).'" />';
                        $html .='                   </a>';
                    }
                    if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_tellafriend') == 1){
                        $html .='                   <a class="jsvm_cm-veh-list-side-bottom-btn"  href="#"  data-toggle="modal" data-target="#jsvm_tellafriend" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)  .'" data-vehicleimg="'. $imgpath .'" data-vehicleid="'. $row->vehicleid .'" >';
                        $html .='                       <img src="'.CAR_MANAGER_IMAGE.'/tell-friend-icon.png" class="img-reponsives" title="'. __('Tell A Friend','js-vehicle-manager').'" title="'.esc_attr(esc_html__('Tell a friend', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Tell a friend', 'js-vehicle-manager')).'" />';
                        $html .='                   </a>';
                    }
                    $html .='                   <a class="jsvm_cm-veh-list-side-bottom-btn jsvm_cmp-btn jsvm_btn_'.$row->vehicleid.'" href="#" data-elenum="1" data-vehid="'. $row->vehicleid .'" >';
                    $html .='                       <img src="'.CAR_MANAGER_IMAGE.'/compare-icon.png" class="img-reponsives" title="'. __('Add To Compare','js-vehicle-manager').'" title="'.esc_attr(esc_html__('Add to compare', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Add to compare', 'js-vehicle-manager')).'"/>';
                    $html .='                   </a>';
                    $html .='               </div>';
                    $html .='           </div>';
                    $html .='       </div>';
                    $html .='   </div>';

                    $noofvehicles++;
                    if ($showgoogleadds == 1) {
                        if (($noofvehicles != 0) && ($noofvehicles % $after_vehicles) == 0) {
                            $html .= '<div class="jsvm-ad-wrap">
                                    <ins class="adsbygoogle adslot_1" style="display:inline-block;'.$googleaddcss.'" data-ad-client="'.$googleclient.'" data-ad-slot="'.$googleslot.'"></ins>
                                    <script async src="http://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                    <script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>';
                        }
                    }
                 }
            }elseif (isset($_COOKIE['jsvm_listing_style']) && ($_COOKIE['jsvm_listing_style'] == 5 || $_COOKIE['jsvm_listing_style'] == 6)) {
                $rowcountes= 0;
                foreach (jsvehiclemanager::$_data[0] as $row){
                    $featuredexpiry = date_i18n('Y-m-d', strtotime($row->endfeatureddate));
                    $lightbox_flag = 0;
                    if($row->imagename == ''){
                        $imgpath = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
                    }else{
                        $lightbox_flag = 1;
                        $imgpath = $row->filepath.'ms_'.$row->imagename;
                    }
                    $this->checkrowcount($rowcountes,$html, $noofvehicles , $showgoogleadds, $after_vehicles, $googleclient, $googleslot, $googleaddhieght, $googleaddwidth, $googleaddcss,2);
                    $html .='           <div class="col-sm-12 col-md-4">';
                    if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate) {
                        $html .='                   <div class="jsvm_cm-veh-list-side-vert-featured">';
                        $html .='                       <span class="jsvm_cm-veh-list-side-vert-feature">';
                        $html .='                           <i class="glyphicon glyphicon-star"></i>'. __('Featured','js-vehicle-manager');
                        $html .='                       </span>';
                        $html .='                   </div>';
                    }else{
                        $html .='                   <div class="jsvm_cm-veh-list-side-vert-featured-pading"></div>';
                    }
                    $html .='               <div class="thumbnail jsvm_cm-veh-list-side-vert">';
                    $html .='                   <div class="jsvm_cm-veh-list-side-vert-img ';
                                                if($lightbox_flag == 1){
                                                    $html .=' jsvm_hover-pointer';
                                                }
                    $html .='                       "';
                                                if($lightbox_flag == 1){
                                                    $html .='onClick="showLightBox('.$row->vehicleid.');"';
                                                }
                $html .='                       >';
                $html .='                       <img src="'.$imgpath.'" class="img-responives jsvm_side-vert-img" title="'.esc_attr(esc_html__('Image', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Image', 'js-vehicle-manager')).'">';
                                                if($lightbox_flag == 1){
                $html .='                           <span class="jsvm_cm-sl-veh-left-txt">'. __('See','js-vehicle-manager').' '.$row->totalimages.' '. __('Photos','js-vehicle-manager').'</span>';
                                                }
                                                if ($row->issold == 1) {
                $html .='                           <div class="jsvm_cm-veh-sold-wrap">';
                $html .='                               <span class="jsvm_cm-veh-sold">'.
                                                            __('Sold','js-vehicle-manager');
                $html .='                               </span>';
                $html .='                           </div>';
                                                }
                $html .='                       <h4 class="jsvm_cm-veh-list-side-vert-price">'.
                                                    JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($row->price,$row->currencysymbol, $row->isdiscount, $row->discounttype, $row->discount, $row->discountstart, $row->discountend);
                $html .='                       </h4>';
                $html .='                   </div>';
                $html .='                   <div class="caption jsvm_cm-veh-list-side-vert-caption">';
                $html .='                       <div class="jsvm_cm-veh-list-side-vert-heading">';
                $html .='                           <h5 class="jsvm_cm-veh-list-side-vert-head">';
                $html .='                               <a class="jsvm_list-vehicle-title-link" href="'. jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'], 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$row->vehicleid)).'" title="'.esc_attr(car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)).'">';
                $html .=                                    car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) ;
                $html .='                               </a>';
                $html .='                           </h5>';
                $html .='                       </div>';
                $html .='                   </div>';
                $html .='                   <div class="caption jsvm_cm-veh-list-side-vert-contn-wrap">';
                $html .='                       <div class="jsvm_cm-veh-list-side-vert-contnt">'.
                                                    date_i18n($date_format_string,strtotime($row->created));
                $html .='                       </div>';
                $html .='                       <div class="jsvm_cm-veh-list-side-vert-contnt jsvm_biglineheight">';
                $html .='                           <span class="jsvm_cm-veh-list-side-vert-contnt-tit">'. __("Fuel Consumption",'js-vehicle-manager').": ".'</span>';
                $html .='                           <span class="jsvm_cm-veh-list-side-vert-contnt-val">';
                                                        if (jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1) {
                                                            $html .= __($row->cityfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager');
                                                        }
                                                        if(jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1 && jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                            $html .=' / ';
                                                        }
                                                        if( jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                            $html .= __($row->highwayfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager')." ".__("Highway",'js-vehicle-manager');
                                                        }
                $html .='                           </span>';
                $html .='                       </div>';
                $html .='                       <div class="jsvm_cm-veh-list-side-vert-contnt jsvm_biglineheight">';
                $html .='                           <span class="jsvm_cm-veh-list-side-vert-contnt-tit">'.__("Location",'js-vehicle-manager').": ".'</span>';
                $html .='                           <span class="jsvm_cm-veh-list-side-vert-contnt-val">'.$row->location.'</span>';
                $html .='                       </div>';
                                                $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                                foreach($customfields AS $field){
                                                    $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params);
                $html .='                           <div class="jsvm_cm-veh-list-side-vert-contnt jsvm_biglineheight">';
                $html .='                               <span class="jsvm_cm-veh-list-side-vert-contnt-tit">'. __($array[0],'js-vehicle-manager').": ".'</span>';
                $html .='                               <span class="jsvm_cm-veh-list-side-vert-contnt-val">'. $array[1].'</span>';
                $html .='                           </div>';
                                                }
                $html .='                       <div class="jsvm_cm-veh-list-side-vert-contnt-btn"> ';
                if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_shortlist') == 1){
                    $html .='                           <a class="jsvm_cm-veh-list-side-vert-btn" href="#" data-toggle="modal" data-target="#jsvm_shortlist" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) .'" data-vehicleimg="'. $imgpath.'" data-vehicleid="'.$row->vehicleid .'" >';
                    $html .='                               <img src="'.CAR_MANAGER_IMAGE.'/shortlist-icon.png" title="'.esc_attr(esc_html__('Shortlist', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Shortlist', 'js-vehicle-manager')).'"/>';
                    $html .='                           </a>';
                }
                if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_tellafriend') == 1){
                    $html .='                           <a class="jsvm_cm-veh-list-side-vert-btn" href="#"data-toggle="modal" data-target="#jsvm_tellafriend" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)  .'" data-vehicleimg="'. $imgpath .'" data-vehicleid="'. $row->vehicleid .'" >';
                    $html .='                               <img src="'.CAR_MANAGER_IMAGE.'/tell-friend-icon.png" title="'.esc_attr(esc_html__('Tell a friend', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Tell a friend', 'js-vehicle-manager')).'"/>';
                    $html .='                           </a>';
                }
                $html .='                           <a class="jsvm_cm-veh-list-side-vert-btn jsvm_cmp-btn jsvm_btn_'.$row->vehicleid.'" href="#" data-elenum="1" data-vehid="'. $row->vehicleid .'" >';
                $html .='                               <img src="'.CAR_MANAGER_IMAGE.'/compare-icon.png" title="'. __('Add To Compare','js-vehicle-manager').'" alt="'. __('Add To Compare','js-vehicle-manager').'" />';
                $html .='                           </a>';
                $html .='                       </div>';
                $html .='                   </div>';
                $html .='                   <div class="jsvm_cm-veh-list-side-vert-bottom jsvm_bigfont">';
                $html .='                   <span class="jsvm_cm-veh-list-side-vert-bottom-optn">
                                                <div class="jsvm_condition-title-listing jsvm_full-width" style="color:'.$row->conditioncolor.';border:1px solid '.$row->conditioncolor.';" >
                                                    '. $row->conditiontitle.'
                                                </div>
                                            </span>';
                                            if(trim($row->transmissiontitle)){
                $html .='                       <span class="jsvm_cm-veh-list-side-vert-bottom-optn">'. __($row->transmissiontitle,'js-vehicle-manager').'</span>';

                                            }
                                            if(trim($row->fueltypetitle)){
                $html .='                       <span class="jsvm_cm-veh-list-side-vert-bottom-optn">'. __($row->fueltypetitle,'js-vehicle-manager').'</span>';

                                            }
                                                if (jsvehiclemanager::$_data['listingfields']['mileages'] == 1) {
                                                    if(trim($row->mileages) AND trim($row->mileagesymbol)){
                $html .='                           <span class="jsvm_cm-veh-list-side-vert-bottom-optn">'. __($row->mileages,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager').'</span>';

                                                    }
                                                }
                                                if(trim($row->enginecapacity)){
                $html .='                       <span class="jsvm_cm-veh-list-side-vert-bottom-optn jsvm_bordernon">'. __($row->enginecapacity,'js-vehicle-manager')." ".__("CC",'js-vehicle-manager').'</span>';

                                                }
                $html .='                   </div>';
                $html .='               </div>';
                $html .='           </div>';
                            }
                $html .='</div>';
                $html .='</div>';

            }elseif(isset($_COOKIE['jsvm_listing_style']) && $_COOKIE['jsvm_listing_style'] == 4){
                $html .='<div class="container-fluid jsvm_cm-veh-list-vert-wrap">';
                $rowcount= 0;
                foreach ($vehicles as $row) {
                    $featuredexpiry = date_i18n('Y-m-d', strtotime($row->endfeatureddate));
                    $this->checkrowcount($rowcount,$html, $noofvehicles , $showgoogleadds, $after_vehicles, $googleclient, $googleslot, $googleaddhieght, $googleaddwidth, $googleaddcss,1);
                    $lightbox_flag = 0;
                    if($row->imagename == ''){
                        $imgpath = CAR_MANAGER_IMAGE."/default-images/vehicle-image.png";
                    }else{
                        $lightbox_flag = 1;
                        $imgpath = $row->filepath.'ms_'.$row->imagename;
                    }
                    $html .='<div class="col-sm-12 col-md-4">';
                                if ($row->isfeaturedvehicle == 1 && $featuredexpiry >= $curdate) {
                    $html .='       <div class="jsvm_cm-veh-list-vert-featured">';
                    $html .='           <span class="jsvm_cm-veh-list-vert-feature">';
                    $html .='               <i class="glyphicon glyphicon-star"></i>'.
                                             __('Featured','js-vehicle-manager');
                    $html .='           </span>';
                    $html .='       </div>';
                                }else{
                    $html .='       <div class="jsvm_cm-veh-list-vert-featured-pading"></div>';
                                }
                    $html .='       <div class="thumbnail jsvm_cm-veh-list-vert">';

                    $html .='           <div class="jsvm_cm-veh-list-img';
                                            if($lightbox_flag == 1){
                                                $html .=' jsvm_hover-pointer';
                                            }
                    $html .='           "';
                                        if($lightbox_flag == 1){
                                            $html .='onClick="showLightBox('.$row->vehicleid.');"';
                                        }
                    $html .='           >';
                    $html .='               <img src="'.$imgpath.'" class="img-responives jsvm_cm-img" title="'.esc_attr(esc_html__('Image', 'js-vehicle-manager')).'" alt="'.esc_attr(esc_html__('Image', 'js-vehicle-manager')).'">';
                                                if($lightbox_flag == 1){
                    $html .='                       <span class="jsvm_cm-sl-veh-left-txt">'. __('See','js-vehicle-manager').' '.$row->totalimages.' '. __('Photos','js-vehicle-manager').'</span>';
                                                }
                                                if ($row->issold == 1) {
                    $html .='                       <div class="jsvm_cm-veh-sold-wrap">';
                    $html .='                           <span class="jsvm_cm-veh-sold">'.
                                                            __('Sold','js-vehicle-manager');
                    $html .='                           </span>';
                    $html .='                       </div>';
                                                }
                    $html .='               <h4 class="jsvm_cm-veh-list-vert-price">'.
                                                JSVEHICLEMANAGERincluder::getJSModel('common')->getPrice($row->price,$row->currencysymbol, $row->isdiscount, $row->discounttype, $row->discount, $row->discountstart, $row->discountend);
                    $html .='               </h4>';
                    $html .='           </div>';
                    $html .='           <div class="caption jsvm_cm-veh-list-vert-caption">';
                    $html .='               <div class="jsvm_cm-veh-list-vert-heading">';
                    $html .='                   <h5 class="jsvm_cm-veh-list-vert-head">';
                    $html .='                       <a class="jsvm_list-vehicle-title-link" href="'. jsvehiclemanager::makeUrl(array('jsvehiclemanagerpageid'=>jsvehiclemanager::$_data['filter']['jsvehiclemanagerpageid'], 'jsvmme'=>'vehicle', 'jsvmlt'=>'vehicledetail', 'jsvehiclemanagerid'=>$row->vehicleid)).'" title="'.esc_attr(car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)).'">';
                    $html .=                            car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) ;
                    $html .='                       </a>';
                    $html .='                   </h5>';
                    $html .='               </div>';
                    $html .='           </div>';
                    $html .='           <div class="caption jsvm_cm-veh-list-vert-contn-wrap">';
                    $html .='               <div class="jsvm_cm-veh-list-vert-contnt">'.
                                                date_i18n($date_format_string,strtotime($row->created));
                    $html .='               </div>';
                    $html .='               <div class="jsvm_cm-veh-list-vert-contnt jsvm_biglineheight">';
                    $html .='                   <span class="jsvm_cm-veh-list-vert-contnt-tit">'. __("Fuel Consumption",'js-vehicle-manager').": ".'</span>';
                    $html .='                   <span class="jsvm_cm-veh-list-vert-contnt-val">';
                                                    if (jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1) {
                                                        $html .= __($row->cityfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager');
                                                    }
                                                    if(jsvehiclemanager::$_data['listingfields']['cityfuelconsumption'] == 1 && jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                        $html .=' / ';
                                                    }
                                                    if( jsvehiclemanager::$_data['listingfields']['highwayfuelconsumption'] == 1 ){
                                                        $html .= __($row->highwayfuelconsumption,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager')." ".__("Highway",'js-vehicle-manager');
                                                    }
                    $html .='                   </span>';
                    $html .='               </div>';
                    $html .='               <div class="jsvm_cm-veh-list-vert-contnt jsvm_biglineheight">';
                    $html .='                   <span class="jsvm_cm-veh-list-vert-contnt-tit">'. __("Location",'js-vehicle-manager').": ".'</span>';
                    $html .='                   <span class="jsvm_cm-veh-list-vert-contnt-val">'. __($row->location,'js-vehicle-manager').'</span>';
                    $html .='               </div>';
                                            $customfields = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->userFieldsData(1,10,1);// 10 for main section of vehicle
                                            foreach($customfields AS $field){
                                            $array = JSVEHICLEMANAGERincluder::getObjectClass('customfields')->showCustomFields($field, 2,$row->params);
                    $html .='               <div class="jsvm_cm-veh-list-vert-contnt jsvm_biglineheight">';
                    $html .='                   <span class="jsvm_cm-veh-list-vert-contnt-tit">'.__($array[0],'js-vehicle-manager').": ".'</span>';
                    $html .='                   <span class="jsvm_cm-veh-list-vert-contnt-val">'. $array[1].'</span>';
                    $html .='               </div>';
                                            }
                    $html .='               <div class="jsvm_cm-veh-list-vert-contnt-btn">';
                    if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_shortlist') == 1){
                        $html .='                   <a class="jsvm_cm-veh-list-vert-btn" href="#" data-toggle="modal" data-target="#jsvm_shortlist" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle) .'" data-vehicleimg="'. $imgpath.'" data-vehicleid="'.$row->vehicleid .'" >
                                                    <img src="'.CAR_MANAGER_IMAGE.'/shortlist-icon.png" title="'. __('Shortlist','js-vehicle-manager').'" alt="'. __('Shortlist','js-vehicle-manager').'" />
                                                </a>';
                    }
                    if(JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigurationByConfigName('vehiclelist_tellafriend') == 1){
                        $html .='                   <a class="jsvm_cm-veh-list-vert-btn" href="#" data-toggle="modal" data-target="#jsvm_tellafriend" data-original-title  data-vehicletitle="'. car_manager_ReturnVehcileTitle($row->maketitle, $row->modeltitle, $row->modelyeartitle)  .'" data-vehicleimg="'. $imgpath .'" data-vehicleid="'. $row->vehicleid .'" >
                                                        <img src="'.CAR_MANAGER_IMAGE.'/tell-friend-icon.png" title="'. __('Tell A Friend','js-vehicle-manager').'" alt="'. __('Tell A Friend','js-vehicle-manager').'" />
                                                    </a>';
                    }
                    $html .='                   <a class="jsvm_cm-veh-list-vert-btn jsvm_cmp-btn jsvm_btn_'. $row->vehicleid.'" href="#" data-elenum="1" data-vehid="'. $row->vehicleid .'" >
                                                    <img src="'.CAR_MANAGER_IMAGE.'/compare-icon.png" title="'. __('Add To Compare','js-vehicle-manager').'" alt="'. __('Add To Compare','js-vehicle-manager').'" />
                                                </a>';
                    $html .='               </div>';
                    $html .='           </div>';
                    $html .='           <div class="jsvm_cm-veh-list-vert-bottom jscm_bigfont">';
                    $html .='               <span class="jsvm_cm-veh-list-vert-bottom-optn">
                                                <div class="jsvm_condition-title-listing jsvm_full-width" style="color:'.$row->conditioncolor.';border:1px solid '.$row->conditioncolor.';" >
                                                    '. $row->conditiontitle.'
                                                </div>
                                            </span>';
                                      if(trim($row->transmissiontitle)){
                    $html .='               <span class="jsvm_cm-veh-list-vert-bottom-optn">'. __($row->transmissiontitle,'js-vehicle-manager').'</span>';
                                      }
                        if(trim($row->fueltypetitle)){
                            $html .='               <span class="jsvm_cm-veh-list-vert-bottom-optn">'. __($row->fueltypetitle,'js-vehicle-manager').'</span>';
                        }
                                            if (jsvehiclemanager::$_data['listingfields']['mileages'] == 1) {
                                                if(trim($row->mileages) AND trim($row->mileagesymbol)){

                        $html .='                   <span class="jsvm_cm-veh-list-vert-bottom-optn">'. __($row->mileages,'js-vehicle-manager')." ".__($row->mileagesymbol,'js-vehicle-manager').'</span>';
                                                }
                                            }

                    if(trim($row->enginecapacity)){
                        $html .='               <span class="jsvm_cm-veh-list-vert-bottom-optn jsvm_bordernon">'. __($row->enginecapacity,'js-vehicle-manager')." ".__("CC",'js-vehicle-manager').'</span>';
                    }

                    $html .='           </div>';
                    $html .='       </div>';

                    $html .='</div>';
                }
                $html .='</div>';
                $html .='</div>';
            }

            if($html != ''){
                $nextpage = JSVEHICLEMANAGERpagination::$_currentpage;
                $nextpage += 1;
                $showmore = 0;
                if($nextpage % 6 == 0){
                    $showmore = 1;
                }
                $html .= '<a class="jsvm_scrolltask" data-showmore="'.$showmore.'" data-scrolltask="getNexttemplateVehicles" data-offset="'.$nextpage.'"></a>';
                if($showmore == 1 && count($vehicles) > 0){
                    $html .= '<a id="jsvm_showmoreautoz" href="javascript:void(0);" onclick="showmoreautoz();">
                                <span>' . __('Show More', 'js-vehicle-manager') . '</span>
                                <img src="' . CAR_MANAGER_IMAGE . '/arrow-icon.png">
                            </a>';
                }
            }
            return $html;
        }
	}
?>
