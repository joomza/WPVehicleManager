<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('ABSPATH'))
    die('Restricted Access');

$color1 = "#4d89dc";
$color2 = "#4d4d4d";
$color3 = "#ffffff";
$color4 = "#fafafa";
$color5 = "#d4d4d5";
$color6 = "#4b4b4d";
$color7 = "#f5f5f5";
$color8 = "#373435";

$color10 = jsvm_adjustBrightness($color1, -30);

function jsvm_adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));
    // Normalize into a six character long hex string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(substr($hex, 2, 1), 2);
    }
    // Split into three parts: R, G and B
    $color_parts = str_split($hex, 2);
    $return = '#';
    foreach ($color_parts as $color) {
        $color = hexdec($color); // Convert to decimal
        $color = max(0, min(255, $color + $steps)); // Adjust color
        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
    }
    return $return;
}
?>
<style type="text/css">

    div#jsvehiclemanager-header-main-wrapper{background:<?php echo esc_attr($color1); ?>;border-bottom: 5px solid <?php echo esc_attr($color2); ?>;box-shadow: 0px 4px 1px #d4d4d5;}
    div#jsvehiclemanager-header-main-wrapper a.headerlinks{color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-header-main-wrapper a.headerlinks:hover{background-color: <?php echo esc_attr($color2); ?>}
    div#jsvehiclemanager-wrapper div.control-pannel-header{border-bottom:2px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-wrapper div.control-pannel-header span.heading{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div.control-pannel-header a.jsvehiclemanager-cmp-goto-compare{color:<?php echo esc_attr($color1); ?>;border:1px solid <?php echo esc_attr($color1); ?>;background:<?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div.control-pannel-header a.jsvehiclemanager-vehicle-alert-show-popup{color:<?php echo esc_attr($color6); ?>;border:1px solid <?php echo esc_attr($color5); ?>;background:<?php echo esc_attr($color7); ?>;}

    /* Vehicle Form */
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap {border:1px solid <?php echo esc_attr($color5); ?>;background-color:<?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div#jsvm_save{border-top:2px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div#jsvm_save input{background-color: <?php echo esc_attr($color1); ?>; border: 1px solid <?php echo esc_attr($color2); ?>;color:#fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-field-wrapper div.jsvehiclemanager-js-form-wrapper label{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-field-wrapper div.jsvehiclemanager-js-form-wrapper div.jsvehiclemanager-value input[type="text"]{border:1px solid <?php echo esc_attr($color5); ?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-section-checkbox-wrap div.jsvehiclemanager-checkbox-sections div.jsvehiclemanager-vehicle-details-checkbox{background:#fff;border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div.jsvehiclemanager-termsconditions-wrapper{background-color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-field-wrapper div.jsvehiclemanager-js-form-wrapper div.jsvehiclemanager-value select{background-color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-field-wrapper div.jsvehiclemanager-js-form-wrapper div.jsvehiclemanager-value div.jsvehiclemanager-vehicle-details-checkbox{background-color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-js-buttons-area div.jsvehiclemanager-js-buttons-area-btn input{background-color: <?php echo esc_attr($color1); ?>; border: 1px solid <?php echo esc_attr($color2); ?>;color:#fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-js-buttons-area div.jsvehiclemanager-js-buttons-area-btn{border-top:2px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-upload-img-wrap div.jsvehiclemanager-vehicle-upload-img-wrp div.jsvehiclemanager-vehicle-upload-img-top div.jsvehiclemanager-vehicle-upload-img-right input{background:<?php echo esc_attr($color1); ?>;border:1px solid <?php echo esc_attr($color2); ?>;color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-add-form-vehicle-wrapper div#jsvehiclemanager-add-vehicle-wrap div.jsvehiclemanager-form-upload-img-wrap div.jsvehiclemanager-vehicle-upload-img-wrp div.jsvehiclemanager-vehicle-upload-img-bottom div.jsvehiclemanager-vehicle-upload-img div.jsvehiclemanager-vehicle-upload-make-defualt input{background:#fff;color:<?php echo esc_attr($color8); ?>;border:1px solid <?php echo esc_attr($color5); ?>;}


    /*Buyer Cp Front-End*/
    div#jsvehiclemanager-wrapper div.jsvm_control-pannel-header {border-color:<?php echo esc_attr($color2);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-graph .jsvehiclemanager-graph-wrp .jsvehiclemanager-graph-title{ border-color: #d1d1d1 #d1d1d1 #d1d1d1 #9260e9;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-graph .jsvehiclemanager-graph-wrp .jsvm_stack-chart-horizontal {border-color: #d1d1d1;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-cpheading-vehicles {border-color: #d1d1d1 #d1d1d1 #d1d1d1 #ef348a;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link a:hover {background: #f6f6f6 ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link a {background: #ffffff ; border-color:#e3e3e3; color: #727376;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link a .jsvm_cptext{color: #7d8082;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_new-vehicles a {border-bottom-color: #f4a400; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_used-vehicles a {border-bottom-color: #003887; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_veh-by-city a {border-bottom-color: #ed4a3e; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_veh-by-type a {border-bottom-color: #805ea8; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_veh-by-model-year a {border-bottom-color: #60c614; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles {background: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_most-view-vehicles-header {background: #4a8bc2 ; border-color:#d4d4d5; color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion {border-color: #d4d4d5 #d4d4d5; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper {border-color:#d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-bottom .jsvehiclemanager-bottom-portion a {background: #fff ; border-color:#d4d4d5; color: #64676a;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_left-img {border-color: #d4d4d5 #d4d4d5 #d4d4d5 #00a9e0;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-top {background: #fff ; border-bottom-color:#d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-top a {color: #606060;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-top .jsvm_veh-price {background: #00a9e0;color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-location {color: #64676a;} 
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-bottom {background: #fafafa; border-top-color: #d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-bottom .jsvm_left-part .jsvm_detail .jsvm_js_autoz_tag {color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles .jsvm_vehicles-portion .jsvm_vechile-wrapper .jsvm_right-bottom .jsvm_left-part .jsvm_detail{border-right-color:#d4d4d5;color: #64676a;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvm_most-view-vehicles a.show-more {background: #4a8bc2; color: #fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager_cpheading {background-color: #f6f6f6;border-color: #d4d4d5 #d4d4d5 #d4d4d5 <?php echo esc_attr($color1); ?>;border-style: solid; border-width: 1px 1px 1px 5px;color: #1D2127;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-bottom .jsvehiclemanager-bottom-portion a .jsvehiclemanager-cptext {color: #7d8082;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-bottom .jsvehiclemanager-bottom-portion a:hover{ background: #f6f6f6;}
    /*Seller Cp Front-End*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_add-new-vehicles a {border-bottom-color:#117a2b;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_add-used-vehicles a {border-bottom-color:#f4a605;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_my-vehicles a {border-bottom-color:#9463e9;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.jsvehiclemanager-top-portion-link.jsvm_messages a {border-bottom-color:#9149af;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-bottom .jsvehiclemanager-bottom-portion.jsvm_stats a {border-bottom-color:#6629b6;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-bottom .jsvehiclemanager-bottom-portion.jsvm_purchase-history a {border-bottom-color:#e82e1a;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-bottom .jsvehiclemanager-bottom-portion.jsvm_package a {border-bottom-color:#923dbb;}
    /* Search Vehicles */    
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-data-wraper {border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color4); ?>}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-data-wraper div.jsvehiclemanager-form-wrap label.jsvehiclemanager-form-title {color: <?php echo esc_attr($color8); ?>}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-data-wraper form div.jsvehiclemanager-form-wrap div.jsvehiclemanager-form-fields div.jsvehiclemanager-form-value select.jsvehiclemanager-cb {/*border:1px solid <?php echo esc_attr($color5); ?>;*/}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-data-wraper form div.jsvehiclemanager-search-btn-wrap div.jsvehiclemanager-search-btn {border-top: 2px solid <?php echo esc_attr($color2); ?>}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-data-wraper form div.jsvehiclemanager-search-btn-wrap div.jsvehiclemanager-search-btn input.jsvm_search-btn {background: <?php echo esc_attr($color1); ?>;border: 1px solid <?php echo esc_attr($color2); ?>;color: <?php echo esc_attr($color3); ?>;}

    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion.box div.jsvehiclemanager-top-portion-link.box {background-color: #fefefe;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.add-vehicle{border-right: 3px solid #347ab8;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.my-vehicles{border-right: 3px solid #5db85b;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.shortlist-vehicles{border-bottom: 3px solid #efad4d;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.search-vehicles{border-right: 3px solid #d9524c;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.vehicle-types{border-bottom: 3px solid #f6601f;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.vehicle-by-cities{border-bottom: 3px solid #0098da;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.vehicle-by-condition{border-bottom: 3px solid #a45e4d;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.login{border-bottom: 3px solid #4D4D4D;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.profile{border-bottom: 3px solid #c13663;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.seller-by-city{border-bottom: 3px solid #000000;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.seller-list{border-bottom: 3px solid #00A859;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.vehicle-list{border-right: 3px solid #efad4d;;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.vehicle-by-make{border-bottom: 3px solid #51a8b1;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.compare{border-bottom: 3px solid #ed3237;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.save-search{border-bottom: 3px solid #3e4095;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.credits{border-bottom: 3px solid #F42211;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.rate-list{border-bottom: 3px solid #0098da;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.credits-log{border-bottom: 3px solid #A45E4D;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.rss{border-bottom: 3px solid #ac52c1;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.purchase-history{border-bottom: 3px solid #00A859;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.stats{border-bottom: 3px solid #A53692;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.vehicle-alert{border-bottom: 3px solid #ed3237;}

    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper{}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper div.jsvehiclemanager-credits-log-detail-title{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color3); ?>;border:1px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper table.jsvehiclemanager-credits-log-detail-table{border:1px solid #d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper table.jsvehiclemanager-credits-log-detail-table tr{border:none;border-top:1px solid #d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper table.jsvehiclemanager-credits-log-detail-table thead tr th{background:#F4F5F6;color:#373435;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper table.jsvehiclemanager-credits-log-detail-table tbody tr td{background:#fff;color:#606062;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper table.jsvehiclemanager-credits-log-detail-table tbody tr td span.jsvehiclemanager-credits-log-vehicle-text{color:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper div.jsvehiclemanager-credits-log-detail-view-all{border:1px solid #d4d4d5;background:#fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-credits-log-detail-wrapper div.jsvehiclemanager-credits-log-detail-view-all a{border:1px solid #d4d4d5;background:#f6f6f6;color:#757575;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-stats-wrapper div.jsvehiclemanager_cpcontent{background:#fff;border:1px solid #d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-stats-wrapper div.jsvehiclemanager_cpcontent div.jsvehiclemanager-stats-detail-wrapper{background:#f6f6f6;border:1px solid #d4d4d5;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-stats-wrapper div.jsvehiclemanager_cpcontent div.jsvehiclemanager-stats-detail-wrapper div.jsvehiclemanager-stats-detail-bottom div.jsvehiclemanager-stats-detail-count{color:#1D2127;}
div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp div.jsvehiclemanager-stats-wrapper div.jsvehiclemanager_cpcontent div.jsvehiclemanager-stats-detail-wrapper div.jsvehiclemanager-stats-detail-bottom div.jsvehiclemanager-stats-detail-text{color:#757575;}



    /* Vehicles listing */
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper{border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_cmp_sel_wrapper{border:1px solid <?php echo esc_attr($color1); ?>;}
    /*div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper:hover{border:1px solid <?php //echo esc_attr($color1); ?>;*/}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_slide_wrap div.jsvehiclemanager_vehicle_slide_image {border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_content_top_row {border-bottom: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_content_top_row span.jsvehiclemanager_vehicle_title a span.title {color: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_content_top_row span.jsvehiclemanager_vehicle_price {background:<?php echo esc_attr($color4); ?>;border-left: 1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_detail_row span.jsvehiclemanager_vehicle_create_date{color: <?php echo esc_attr($color6); ?>}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_detail_row span.jsvehiclemanager_vehicle_fuel_title {color: <?php echo esc_attr($color8); ?>}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_detail_row span.jsvehiclemanager_vehicle_value {color: <?php echo esc_attr($color6); ?>}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_detail_row span.jsvehiclemanager_vehicle_loction_title {color: <?php echo esc_attr($color8); ?>}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_detail_row span.jsvehiclemanager_vehicle_location_value {color: <?php echo esc_attr($color6); ?>}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_status a {border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap {border-top: 1px solid <?php echo esc_attr($color5); ?>;background:<?php echo esc_attr($color4); ?>;color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap div.jsvehiclemanager_vehicle_left div.jsvehiclemanager_vehicle_option{border-right: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap div.jsvehiclemanager_vehicle_left div.jsvehiclemanager_vehicle_option span.jsvehiclemanager_vehicle_condions_new {color:#ffffff ;background: #ff7b04;/*border:1px solid .d25500;*/}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap div.jsvehiclemanager_vehicle_right_button div.jsvehiclemanager_vehicle_button_area a.jsvehiclemanager_vehicle_btn {background:<?php echo esc_attr($color7); ?>;border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap div.jsvehiclemanager_vehicle_right_button div.jsvehiclemanager_vehicle_button_area a.jsvehiclemanager_vehicle_btn:hover {border: 1px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap div.jsvehiclemanager_vehicle_right_button div.jsvehiclemanager_vehicle_button_area a.jsvehiclemanager_cmp_selected {border: 1px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_tags{border-bottom:1px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_tags div.jsvehiclemanager_featured_tag{color:<?php echo esc_attr($color3); ?>;background:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper a.jsvehiclemanager-plg-showmoreautoz {background-color:<?php echo esc_attr($color2); ?>;color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-wrapper a.jsvehiclemanager-plg-showmoreautoz span {color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_my_comments {border-top: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_my_comments span.jsvehiclemanager_my_comments_label{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_my_comments span.jsvehiclemanager_my_comments_text{color:<?php echo esc_attr($color6); ?>;}
    /*Detail Vehicles*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-date-section {border: 1px solid <?php echo esc_attr($color5); ?>; background: <?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-date-section div#jsvehiclemanager-date-area span#jsvehiclemanager-date-text {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-date-section  div#jsvehiclemanager-social-icons a {border: 1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color7); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-date-section  div#jsvehiclemanager-social-icons a:hover {border: 1px solid <?php echo esc_attr($color2); ?>;background:#fff}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-model-price div#jsvehiclemanager-model { border-left:3px solid <?php echo esc_attr($color1); ?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-model-price div#jsvehiclemanager-model span#jsvehiclemanager-model-text {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-model-price div#jsvehiclemanager-price span#jsvehiclemanager-price-text {background: <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-detail-images-wrapper{border-top:1px solid #ccc;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-detail-images-wrapper div#jsvehiclemanager-left-side {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-detail-images-wrapper div#jsvehiclemanager-right-side  div#jsvehiclemanager-thumbs div#jsvehiclemanager-thumbnails div#jsvehiclemanager-thumbsetting {}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-detail-images-wrapper div#jsvehiclemanager-right-side div#jsvehiclemanager-thumbs div#jsvehiclemanager-thumbnails div#jsvehiclemanager-thumbsetting a img{border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail {border: 1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail img {background: <?php echo esc_attr($color4); ?>;border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail span.jsvehiclemanager-middle-sec-value {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail span.jsvehiclemanager-bottom-sec-value {background: <?php echo esc_attr($color4); ?> ;border-top: 1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail:hover {border-color: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail a:hover img {border-color:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail a:hover {border-color: 1px solid <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail a:hover span.jsvehiclemanager-middle-sec-value{color: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-data div.jsvehiclemanager-condition-featured-detail a:hover span.jsvehiclemanager-bottom-sec-value{background-color: <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-flex-autoz-image img {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-middle-sec div#jsvehiclemanager-flex-header {border-bottom: 1px solid <?php echo esc_attr($color5); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-middle-sec div#jsvehiclemanager-flex-header a {color: <?php echo esc_attr($color1); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-middle-sec div#jsvehiclemanager-flex-det-row {color: <?php echo esc_attr($color6); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper div#jsvehiclemanager-flex-autoz-dealer-information {border-left: 1px solid <?php echo esc_attr($color5); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper span#jsvehiclemanager-flex-autoz-dealer-information-text {background: <?php echo esc_attr($color7); ?> ;border: 1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper span#jsvehiclemanager-flex-autoz-dealer-information-text:hover {border:1px solid <?php echo esc_attr($color2); ?> ;background:#fff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-vehicle-detail-tabs ul li a{border: 1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>;background: <?php echo esc_attr($color7); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-vehicle-detail-tabs ul li a:hover {background: <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-overview div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text{border-left: 4px solid <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper{border-left: 3px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper div.jsvehiclemanager-vehicle-detail span.jsvehiclemanager-detail-title{color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper div.jsvehiclemanager-vehicle-detail span.jsvehiclemanager-details-value{color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-presnet-text{color:<?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text{border-left: 4px solid <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div#jsvehiclemanager-feature-tab-sub-heading {border-left: 3px solid <?php echo esc_attr($color1); ?>;background: <?php echo esc_attr($color4); ?> ;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div#jsvehiclemanager-feat-tab-wrap div#jsvehiclemanager-feature-tab-data div#jsvehiclemanager-feat-tab-row {border:1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-gallery div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text{border-left: 4px solid <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-gallery div#jsvehiclemanager-vehicle-detail-galary {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-gallery div#jsvehiclemanager-vehicle-detail-galary div#jsvehiclemanager-auto-gallerythumbssetting {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text{border-left: 4px solid <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-dealer-information-wrapper{border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-dealer-information-wrapper div.jsvehiclemanager-dealer-info-name-wrapper div.jsvehiclemanager-dealer-info-img{border:1px solid <?php echo esc_attr($color5); ?>;}

    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-dealer-information-wrapper div.jsvehiclemanager-dealer-info-name-wrapper div.jsvehiclemanager-dealer-info-name-right div.jsvehiclemanager-dealer-info-prop-label{border-left: 3px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-dealer-information-wrapper div.jsvehiclemanager-dealer-info-name-wrapper div.jsvehiclemanager-dealer-info-name-right div.jsvehiclemanager-dealer-info-prop-label span.jsvehiclemanager-dealer-info-prop-label-text{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-dealer-information-wrapper div.jsvehiclemanager-dealer-info-name-wrapper div.jsvehiclemanager-dealer-info-name-right div.jsvehiclemanager-dealer-info-prop-value{border-left: 3px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-dealer-information-wrapper div.jsvehiclemanager-dealer-info-name-wrapper div.jsvehiclemanager-dealer-info-name-right div.jsvehiclemanager-dealer-info-prop-value span.jsvehiclemanager-dealer-info-prop-value-text{color:<?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-social-links-wrapper span.jsvehiclemanager-social-link-icon{border-left:1px solid <?php echo esc_attr($color5); ?>;border-right:1px solid <?php echo esc_attr($color5); ?>;}


    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-feature-detail-list div#jsvehiclemanager-veh-view-dealer-wrapper div#jsvehiclemanager-dealer-left-side div#jsvehiclemanager-dealer-left-big-image {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-feature-detail-list  div#jsvehiclemanager-veh-view-dealer-wrapper div#jsvehiclemanager-right-part-detail div#jsvehiclemanager-right-detail-info div#jsvehiclemanager-title {border-left: 2px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-feature-detail-list  div#jsvehiclemanager-veh-view-dealer-wrapper div#jsvehiclemanager-right-part-detail div#jsvehiclemanager-right-detail-info div#jsvehiclemanager-value {border-left: 2px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper{border-left: 3px solid <?php echo esc_attr($color5) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper div.jsvehiclemanager-detail-title{color: <?php echo esc_attr($color6) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper div.jsvehiclemanager-details-value{color: <?php echo esc_attr($color8) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div#jsvehiclemanager-description-wrapper {border: 1px solid <?php echo esc_attr($color5) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-sellerinformation div.jsvehiclemanager-feature-detail-list div#jsvehiclemanager-veh-view-dealer-wrapper div#jsvehiclemanager-description-wrapper {border: 1px solid <?php echo esc_attr($color5) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-form-section-checkbox-wrap div.jsvehiclemanager-checkbox-headings{border-left: 4px solid<?php echo esc_attr($color1);?>;color: <?php $color8;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-form-section-checkbox-wrap div.jsvehiclemanager-checkbox-sections div.jsvehiclemanager-checkboxes{color: <?php echo esc_attr($color6);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-social-links-wrapper {background-color:<?php echo esc_attr($color4);?>;border:1px solid <?php echo esc_attr($color5); ?>;}
    /* Vehicles By Conditions,Types,Model Years,City */
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper div.jsvehiclemanager-record-number span{color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper{border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color4); ?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper:hover{border:1px solid <?php echo esc_attr($color1); ?>;background: #ffffff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper div.jsvehiclemanager-record-title span.jsvehiclemanager-record-number {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper div.jsvehiclemanager-record-types-title {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper div.jsvehiclemanager-record-types-title span.jsvehiclemanager-record-number {color: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-vehicles-details a div.jsvehiclemanager-record-wraper div.jsvehiclemanager-record-number span.jsvehiclemanager-record-number-text {color: <?php echo esc_attr($color1); ?>;}
    /* Vehicles By Make & Model */
    div#jsvehiclemanager-wrapper div.jsvm_mkmd-make{background:<?php echo esc_attr($color4); ?>;color: <?php echo esc_attr($color8);?>;border-left:4px solid<?php echo esc_attr($color1);?>; }
    div#jsvehiclemanager-wrapper div.jsvm_mkmd-make a.jsvm_parent{color:<?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div.jsvm_mkmd-model a.jsvm_mkmd-child{background: <?php echo esc_attr($color4);?>;border: 1px solid <?php echo esc_attr($color5);?>;color:<?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div.jsvm_mkmd-model a.jsvm_mkmd-child:hover{border: 1px solid <?php echo esc_attr($color1);?>;background:#FFFFFF; }
    div#jsvehiclemanager-wrapper div.jsvm_mkmd-model a div.jsvm_mkmd-model-mumber div.jsvm_color {color: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div.jsvm_mkmd-make div.jsvm_mkmd-make-number{background:<?php echo esc_attr($color1);?>;color:<?php echo esc_attr($color3);?>;}
    div#jsvehiclemanager-wrapper div.jsvm_mk-make a{border: 1px solid <?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div.jsvm_mk-make a div.jsvm_make-title{background: <?php echo esc_attr($color4);?>; border-right: 1px solid <?php echo esc_attr($color5);?>;color:<?php echo esc_attr($color6);?>;}
     /* Vehicles By Make & Model - new */
     div#jsvehiclemanager-wrapper div.jsvehiclemanager-vehicle-by-make div.jsvehiclemanager-vehicle-by-make-wrapper div.jsvehiclemanager-title h3{color:<?php echo esc_attr($color2); ?>;}
     div#jsvehiclemanager-wrapper div.jsvehiclemanager-vehicle-by-make div.jsvehiclemanager-vehicle-by-make-wrapper div.jsvehiclemanager-title{border-bottom:1px solid <?php echo esc_attr($color2);?>;}
     div#jsvehiclemanager-wrapper div.jsvehiclemanager-vehicle-by-make div.jsvehiclemanager-vehicle-by-make-wrapper div.jsvehiclemanager-values div.jsvehiclemanager-make-number{color:<?php echo esc_attr($color2); ?>;}
     div#jsvehiclemanager-wrapper div.jsvehiclemanager-vehicle-by-make div.jsvehiclemanager-vehicle-by-make-wrapper div.jsvehiclemanager-values{border-bottom:1px solid <?php echo esc_attr($color5);?>;}
     div#jsvehiclemanager-wrapper div.jsvehiclemanager-vehicle-by-make div.jsvehiclemanager-vehicle-by-make-wrapper div.jsvehiclemanager-values:hover{background:<?php echo esc_attr($color1); ?>;border-bottom:1px solid <?php echo esc_attr($color4);?>;}
     div#jsvehiclemanager-wrapper div.jsvehiclemanager-vehicle-by-make div.jsvehiclemanager-vehicle-by-make-wrapper div.jsvehiclemanager-values:hover a{color:#fff;}

    /*Vehicle Messages*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap {border:1px solid <?php echo esc_attr($color5) ;?>;background: <?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-image a img {border:1px solid <?php echo esc_attr($color5) ;?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-left div#jsvehiclemanager-msg-top-row {border-bottom:1px solid <?php echo esc_attr($color5) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-left div#jsvehiclemanager-msg-top-row span#jsvehiclemanager-msg-title a {color: <?php echo esc_attr($color8) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-left div#jsvehiclemanager-msg-top-row span#jsvehiclemanager-msg-date {color: <?php echo esc_attr($color6) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-left div#jsvehiclemanager-msg-bottom-row span#jsvehiclemanager-msg-more-info span#jsvehiclemanager-msg-more-info-title {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-left div#jsvehiclemanager-msg-bottom-row span#jsvehiclemanager-msg-more-info span#jsvehiclemanager-msg-more-info-value {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-left {border-right: 1px solid <?php echo esc_attr($color5) ;?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-messages-wrap div#jsvehiclemanager-msg-content-wrap div#jsvehiclemanager-msg-det-wrap div#jsvehiclemanager-msg-det-right a {color: <?php echo esc_attr($color8) ;?>;background: <?php echo esc_attr($color7) ;?>;border:1px solid <?php echo esc_attr($color5) ;?>;}
    /*Vehicle Send Messages*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-buyer-seller-wrap div#jsvehiclemanager-buyer {border: 1px solid <?php echo esc_attr($color5); ?> ;background: <?php echo esc_attr($color4); ?> ; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-buyer-seller-wrap div#jsvehiclemanager-seller {border: 1px solid <?php echo esc_attr($color5); ?> ; border-left: none;background: <?php echo esc_attr($color4); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-buyer-seller-wrap div#jsvehiclemanager-buyer span#jsvehiclemanager-buyer-title {color: <?php echo esc_attr($color8); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-buyer-seller-wrap div#jsvehiclemanager-buyer span#jsvehiclemanager-buyer-value {color: <?php echo esc_attr($color6); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-buyer-seller-wrap div#jsvehiclemanager-seller span#jsvehiclemanager-seller-title {color: <?php echo esc_attr($color8); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-buyer-seller-wrap div#jsvehiclemanager-seller span#jsvehiclemanager-seller-value {color: <?php echo esc_attr($color6); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-det {border: 1px solid <?php echo esc_attr($color5); ?> ;background: <?php echo esc_attr($color4); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-det div#jsvehiclemanager-msg-det-row {border-bottom: 1px solid <?php echo esc_attr($color5); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-det div#jsvehiclemanager-msg-det-row span#jsvehiclemanager-msg-det-title {color: <?php echo esc_attr($color8); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-det div#jsvehiclemanager-msg-det-row span#jsvehiclemanager-msg-det-value {color: <?php echo esc_attr($color6); ?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-textarea-title {border-left: 4px solid <?php echo esc_attr($color1); ?>; background: <?php echo esc_attr($color4); ?>;color: <?php echo esc_attr($color8); ?> ; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-send-btn {border-top: 2px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-send-btn a {border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color7); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap {border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-left {border: 1px solid <?php echo esc_attr($color5); ?>;border-left: 4px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-right div#jsvehiclemanager-msg-history-top span#jsvehiclemanager-msg-sender-title {color:<?php echo esc_attr($color3); ?>;background: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-right div#jsvehiclemanager-msg-history-top span#jsvehiclemanager-msg-sender-det {color:<?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-right div#jsvehiclemanager-msg-history-bottom span#jsvehiclemanager-msg-sender-value {color:<?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap.jsvehiclemanager-buyer {background: #ffffff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-right div#jsvehiclemanager-msg-history-top span#jsvehiclemanager-msg-buyer-title {border:1px solid <?php echo esc_attr($color8); ?>;color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-right div#jsvehiclemanager-msg-history-top span#jsvehiclemanager-msg-buyer-det {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-send-message-wrap div#jsvehiclemanager-msg-history-det-wrap div#jsvehiclemanager-msg-history-right div#jsvehiclemanager-msg-history-bottom {color: <?php echo esc_attr($color6); ?>;}
    /*Compare Vehicle*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-tit{border:1px solid<?php echo esc_attr($color5);?>;background:<?php echo esc_attr($color4);?>;color:<?php echo esc_attr($color8);?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-img img{border:1px solid<?php  echo esc_attr($color5);  ?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-price{border:1px solid<?php echo esc_attr($color1);?>;background:<?php echo esc_attr($color1);?>;color:<?php echo esc_attr($color7);?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-tit{border:1px solid<?php echo esc_attr($color5);?>;background:<?php echo esc_attr($color4);?>;color:<?php echo esc_attr($color8);?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-img img{border:1px solid<?php  echo esc_attr($color5);  ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-price{border:1px solid<?php echo esc_attr($color1);?>;background:<?php echo esc_attr($color1);?>;color:<?php echo esc_attr($color7);?>; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div.jsvehiclemanager-compare-vehicle-optn{border:1px solid<?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div.jsvehiclemanager-compare-vehicle-optn:hover{border:1px solid<?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div.jsvehiclemanager-compare-vehicle-optn img{border:1px solid<?php echo esc_attr($color5);?>;background:<?php echo esc_attr($color4);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div:hover img{border:1px solid<?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div.jsvehiclemanager-compare-vehicle-optn span.jsvehiclemanager-compare-vehicle-optn-name{color: <?php echo esc_attr($color6);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div:hover span.jsvehiclemanager-compare-vehicle-optn-name{color: <?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div.jsvehiclemanager-compare-vehicle-optn span.jsvehiclemanager-compare-vehicle-optn-tit{border-top: 1px solid<?php echo esc_attr($color5);?>;background: <?php  echo esc_attr($color4);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-left div.jsvehiclemanager-compare-vehicle-detail div.jsvehiclemanager-compare-vehicle-detail-optn div:hover span.jsvehiclemanager-compare-vehicle-optn-tit{border-top: 1px solid<?php echo esc_attr($color1);?>;background: <?php  echo esc_attr($color1);?>;color: <?php echo esc_attr($color7);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div.jsvehiclemanager-compare-vehicle-optn-right{border:1px solid<?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div.jsvehiclemanager-compare-vehicle-optn-right:hover{border:1px solid<?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div.jsvehiclemanager-compare-vehicle-optn-right img{border:1px solid<?php echo esc_attr($color5);?>;background:<?php echo esc_attr($color4);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div:hover img{border:1px solid<?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div.jsvehiclemanager-compare-vehicle-optn-right span.jsvehiclemanager-compare-vehicle-right-optn-name{color: <?php echo esc_attr($color6);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div:hover span.jsvehiclemanager-compare-vehicle-right-optn-name{color: <?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div.jsvehiclemanager-compare-vehicle-optn-right span.jsvehiclemanager-compare-vehicle-right-optn-tit{border-top: 1px solid<?php echo esc_attr($color5);?>;background: <?php  echo esc_attr($color4);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-detail-right div.jsvehiclemanager-compare-vehicle-right-detail div.jsvehiclemanager-compare-vehicle-right-optn div:hover span.jsvehiclemanager-compare-vehicle-right-optn-tit{border-top: 1px solid<?php echo esc_attr($color1);?>;background: <?php  echo esc_attr($color1);?>;color: <?php echo esc_attr($color7);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-fields-wrap div.jsvehiclemanager-compare-vehicle-fields-tit{border-left: 3px solid<?php echo esc_attr($color1);?>;background: <?php  echo esc_attr($color4);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-fields-wrap div.jsvehiclemanager-compare-vehicle-fields-section div.jsvehiclemanager-compare-vehicle-fields{border: 1px solid<?php echo esc_attr($color5);?>;border-left: 5px solid<?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-fields-wrap div.jsvehiclemanager-compare-vehicle-fields-section div.jsvehiclemanager-compare-vehicle-fields span.jsvehiclemanager-compare-vehicle-field-tit{border-right: 1px solid<?php echo esc_attr($color5);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager-compare-vehicle-fields-wrap div.jsvehiclemanager-compare-vehicle-fields-section div.jsvehiclemanager-compare-vehicle-fields span.jsvehiclemanager-compare-vehicle-field-cancel{border-right: 1px solid<?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-form-section-checkbox-wrap div.jsvm_checkboxs-headings{border-left: 3px solid <?php echo esc_attr($color1);?>;background: <?php  echo esc_attr($color4);?>;color: <?php echo esc_attr($color8);?>;}
    /*Credits Pack*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper {border-bottom: 1px solid <?php echo esc_attr($color1);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data {border: 1px solid <?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-top {background: <?php echo esc_attr($color4);?>;border-bottom: 1px solid <?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-top span.jsvehiclemanager-credit-pack-top-left span.jsvehiclemanager-credits {color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-top span.jsvehiclemanager-credit-pack-top-right {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-middle {color: <?php echo esc_attr($color8);?>;border-bottom:1px solid <?php echo esc_attr($color5);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-middle span.jsvehiclemanager-middle-right a  {border: 1px solid <?php echo esc_attr($color5);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-bottom {background: <?php echo esc_attr($color4);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-bottom span.jsvehiclemanager-credit-pack-message {border-bottom: 1px solid <?php echo esc_attr($color5);?>;color: <?php echo esc_attr($color6);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-bottom span.jsvehiclemanager-credit-pack-expiry {color: #da6556;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-top span.jsvehiclemanager-credit-pack-top-right span.jsvehiclemanager-net-amount{background-color: <?php echo esc_attr($color1);?>;}
    
    /* Credits Rate List*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.jsvehiclemanager-rate-list-item {border: 1px solid <?php echo esc_attr($color5);?> ;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.jsvehiclemanager-rate-list-item div.jsvehiclemanager-rate-list-bottom {border-top: 1px solid <?php echo esc_attr($color5);?> ;background: <?php echo esc_attr($color4);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.jsvehiclemanager-rate-list-item div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left {color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.jsvehiclemanager-rate-list-item div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-bold {color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.jsvehiclemanager-rate-list-item div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-bottom-right {border: 1px solid <?php echo esc_attr($color5);?> ;background: <?php echo esc_attr($color7);?>;color: <?php echo esc_attr($color8);?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-1{border-top: 5px solid #00AFEF;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-1 div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left span.jsvehiclemanager-bold{color:#00AFEF;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-2{border-top: 5px solid #F58634;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-2 div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left span.jsvehiclemanager-bold{color:#F58634;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-3{border-top: 5px solid #00A859;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-3 div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left span.jsvehiclemanager-bold{color:#00A859;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-4{border-top: 5px solid #A8518A;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-4 div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left span.jsvehiclemanager-bold{color:#A8518A;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-5{border-top: 5px solid #3E4095;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-5 div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left span.jsvehiclemanager-bold{color:#3E4095;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-6{border-top: 5px solid #57A695;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-rate-list-wrap div.color-class-6 div.jsvehiclemanager-rate-list-bottom span.jsvehiclemanager-rate-list-left span.jsvehiclemanager-bold{color:#57A695;}

    /* Credits Purchase History*/
    div#jsvehiclemanager-wrapper div.jsvm_control-pannel-header span.jsvehiclemanager-expire {border:1px solid <?php echo esc_attr($color1); ?>;background: <?php echo esc_attr($color4); ?>; color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-credits-header div.jsvehiclemanager-credits-box {border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-credits-header div.jsvehiclemanager-credits-box.jsvm_total img {background: #70ba63;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-credits-header div.jsvehiclemanager-credits-box.jsvm_spent img {background: #ff666f;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-credits-header div.jsvehiclemanager-credits-box.jsvm_remaining img {background: #feb252;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-credits-header div.jsvehiclemanager-credits-box span.jsvehiclemanager-credits-number {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-credits-header div.jsvehiclemanager-credits-box span.jsvehiclemanager-credits-text {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper {border-top: 1px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper:last-child {border-bottom: 1px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts {background: <?php echo esc_attr($color4); ?>;border-bottom: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts span.jsvehiclemanager-data-title {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts span.jsvehiclemanager-data-price {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts span.jsvehiclemanager-data-price span.jsvehiclemanager-amount {background: <?php echo esc_attr($color1); ?>;color: <?php echo esc_attr($color7); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-credit {color: <?php echo esc_attr($color8); ?>;border-bottom: 1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts span.jsvehiclemanager-data-created {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts span.jsvehiclemanager-data-status.jsvm_approved {background: #d9efe0;color: #009933; }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-purchase-history-wrap div.jsvehiclemanager-purchase-history-wrapper div.jsvehiclemanager-purchase-history-data span.jsvehiclemanager-data-parts span.jsvehiclemanager-data-status.jsvm_expired {background: #fff2f2;color: #c21700; }
    /* Credits Purchase History*/
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header {border-bottom: 1px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header div.jsvehiclemanager-credits-log-box {border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color4); ?>;;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header div.jsvehiclemanager-credits-log-box.jsvm_total img {background: #70ba63;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header div.jsvehiclemanager-credits-log-box.jsvm_spent img {background: #ff666f;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header div.jsvehiclemanager-credits-log-box.jsvm_remaining img {background: #feb252;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header div.jsvehiclemanager-credits-log-box span.jsvehiclemanager-credits-log-number {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-header div.jsvehiclemanager-credits-log-box span.jsvehiclemanager-credits-log-text {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap{border:1px solid <?php echo esc_attr($color5); ?>;background: <?php echo esc_attr($color4); ?>}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-date-time {border-right:1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-action {color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-action span.jsvehiclemanager-credits-log-action-text.company {background: #70ba63;color: #ffffff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-action span.jsvehiclemanager-credits-log-action-text.jsvm_gold {background: #cc9900;color: #ffffff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-action span.jsvehiclemanager-credits-log-action-text.jsvm_featured {background: #2993cf;color: #ffffff;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-desc {border-left:1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-cost {color: <?php echo esc_attr($color3); ?>;background: <?php echo esc_attr($color1); ?>}
    /* popup */
    div#jsvm_jsauto-search-popup span.jsvm_popup-title, div#jsvehiclemanager-listpopup span.jsvm_popup-title{background: <?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color7); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_commentrow textarea {border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_commentrow label {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_quickviewlower div.jsvm_quickviewbutton a.jsvm_quickviewbutton{background:<?php echo esc_attr($color4); ?>;color:<?php echo esc_attr($color6); ?>;border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_quickviewlower div.jsvm_quickviewbutton a#jsvm_apply-now-btn{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_quickviewrow div.jsvm_quickviewhalfwidth input[type="text"] {border:1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>;background-color:<?php echo esc_attr($color3); ?> ;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_quickviewrow div.jsvm_quickviewhalfwidth label {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_quickviewrow div.jsvm_quickviewfullwidth label {color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea div.jsvm_quickviewrow div.jsvm_quickviewfullwidth textarea {border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper div.jsvehiclemanager-pop-body div.jsvehiclemanager-pop-heading{color:<?php echo esc_attr($color3); ?>;background-color:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper{background: #fff;border-bottom: 10px solid <?php echo esc_attr($color1); ?>;box-shadow: 0px 0px 10px #7e6363;}
    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper div.jsvehiclemanager-pop-body div.jsvehiclemanager-pop-content button#jsvehiclemanager-pop-close{background:<?php echo esc_attr($color7); ?>;border: 1px solid <?php echo esc_attr($color5); ?>;color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper div.jsvehiclemanager-pop-body div.jsvehiclemanager-pop-content button#jsvehiclemanager-pop-save{color:<?php echo esc_attr($color3); ?>;background:<?php echo esc_attr($color1); ?>;border: 1px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper div.jsvehiclemanager-pop-body div.jsvehiclemanager-pop-content div.jsvehiclemanager-pop-finance-detail div.jsvm_finance_wrp{border:1px solid <?php echo esc_attr($color1); ?>;background-color: <?php echo esc_attr($color7); ?>;}
    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper div.jsvehiclemanager-pop-body div.jsvehiclemanager-pop-content div.jsvehiclemanager-pop-finance-detail div.jsvm_finance_wrp div.jsvm_finance_payment{color: <?php echo esc_attr($color1); ?>;}
    /* paginatnion */
    div#jsvehiclemanager-pagination span.jsvm_page-numbers.jsvm_current{color:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-pagination a.page-numbers.next{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color7); ?>;}
    div#jsvehiclemanager-pagination a.page-numbers.prev{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color7); ?>;}
    /* Vehicle List */
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvm_jsvm-vm-header-main-wrapper{background-color: <?php echo esc_attr($color1);?>; border-bottom-color:<?php echo esc_attr($color1);?>;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div.jsvm_js_effect_preview div.jsvm_vehicle_list {color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanagers-wrapper{border-top: 3px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanagers-wrapper div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_top_wrap div#jsvehiclemanager_vehicle_right_content div#jsvehiclemanager_vehicle_content_top_row span#jsvehiclemanager_vehicle_price{background-color:<?php echo esc_attr($color4); ?>;border-left-color:<?php echo esc_attr($color5); ?>  ;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanagers-wrapper div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_top_wrap div#jsvehiclemanager_vehicle_right_content div#jsvehiclemanager_vehicle_content_top_row span#jsvehiclemanager_vehicle_title span#title{color:<?php echo esc_attr($color1); ?> ;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanagers-wrapper div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_bottom_wrap div#jsvehiclemanager_vehicle_left div#jsvehiclemanager_vehicle_option{color:<?php echo esc_attr($color6); ?>;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanagers-wrapper div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_top_wrap div#jsvehiclemanager_vehicle_right_content div#jsvehiclemanager_vehicle_content_top_row span#jsvehiclemanager_vehicle_price span#price{color:<?php echo esc_attr($color8); ?> ;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanager_vehicle_wrapper{border-color:<?php echo esc_attr($color5); ?> ;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_bottom_wrap{background-color:<?php echo esc_attr($color4);?>;border-top-color:<?php echo esc_attr($color5);?>;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_bottom_wrap div#jsvehiclemanager_vehicle_left div#jsvehiclemanager_vehicle_option span#jsvehiclemanager_vehicle_condions_new {background-color:#ff7b04;border:1px solid #d25500;color:white;}
    
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_bottom_wrap div#jsvehiclemanager_vehicle_right_button div#jsvehiclemanager_vehicle_button_area a#jsvehiclemanager_vehicle_btn{background-color: <?php echo esc_attr($color7);?>;border 1px solid <php $color5;?>;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_top_wrap div#jsvehiclemanager_vehicle_right_content div#jsvehiclemanager_vehicle_detail_row span#jsvehiclemanager_vehicle_create_date{color:<?php echo esc_attr($color6); ?> ;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_top_wrap div#jsvehiclemanager_vehicle_right_content div#jsvehiclemanager_vehicle_detail_row span#jsvehiclemanager_vehicle_value{color:<?php echo esc_attr($color6); ?> ;}
    div#jsvehiclemanageradmin-wrapper div#jsvehiclemanageradmin-data div#jsvehiclemanagers-wrapper div#jsvehiclemanager_vehicle_wrapper div#jsvehiclemanager_vehicle_top_wrap div#jsvehiclemanager_vehicle_right_content div#jsvehiclemanager_vehicle_detail_row{color:<?php echo esc_attr($color8); ?> ;}
    /* view seller info */
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det{border: 1px solid <?php echo esc_attr($color5); ?>}

    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-left {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-bottom {background: <?php echo esc_attr($color1); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-sellers-info-bottom {background: <?php echo esc_attr($color4); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-sellers-info-bottom div.jsvehiclemanager_seller-info-wrp span.jsvehiclemanager_cm-seller-info-bottom-bold-text {color: <?php echo esc_attr($color8); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-sellers-info-bottom div.jsvehiclemanager_seller-info-wrp span.jsvehiclemanager_cm-seller-info-bottom-text {color: <?php echo esc_attr($color6); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-top {border-bottom: 1px solid #D4D4D4;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-top span.jsvehiclemanager_cm-seller-info-left a.jsvehiclemanager_cm-seller-info-left-text {color: <?php echo esc_attr($color1); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-top span.jsvehiclemanager_cm-seller-info-right a.jsvehiclemanager_cm-seller-info-btn {border: 1px solid <?php echo esc_attr($color5); ?>;background-color:<?php echo esc_attr($color7); ?>;color: <?php echo esc_attr($color8); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-top span.jsvehiclemanager_cm-seller-info-right a.jsvehiclemanager_cm-seller-info-btn:hover {border: 1px solid <?php echo esc_attr($color1); ?>;background-color:#fff;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det {border: 1px solid #D4D4D4;box-shadow: 0 3px 2px 0 <?php echo esc_attr($color4); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-top {border-bottom: 1px solid #D4D4D4;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-bottom {background: <?php echo esc_attr($color1); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-message-map-wrap div.jsvehiclemanager_cm-message {border: 1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color1); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-message-map-wrap div.jsvehiclemanager_cm-message div.send-to-seller-wrapper label{color:<?php echo esc_attr($color8); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-message-map-wrap div.jsvehiclemanager_cm-message button.jsvehiclemanager_cm-send-btn {background: <?php echo esc_attr($color1); ?>;border: 1px solid #D4D4D4;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-message-map-wrap div.jsvehiclemanager_cm-map {border: 1px solid <?php echo esc_attr($color5); ?>;}
    div.send-to-seller-wrapper div.jsvehiclemanager_cm-multi-popup-overlay {display: none;width: 100%;height: 100%;position: absolute;background: #fafafa;opacity: 0.6;top: 0px;bottom: 0px;left: 0px;right: 0px;z-index: 1053;text-align: center;}
    div.send-to-seller-wrapper img.jsvehiclemanager_multipop-loading-gif {display: none;position: absolute;top: 0px;bottom: 0px;left: 0px;right: 0px;z-index: 1054;margin: auto;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-desc-wrap div.jsvehiclemanager_cm-desc-title {border-color:<?php echo esc_attr($color5)?>;background: <?php echo esc_attr($color4); ?>;border-left:3px solid <?php echo esc_attr($color1);?>;color:<?php echo esc_attr($color8); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-desc-wrap div.jsvehiclemanager_cm-desc-det {border: 1px solid <?php echo esc_attr($color5); ?>;color:<?php echo esc_attr($color6);?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-vid-wrap div.jsvehiclemanager_cm-vid-title {border-color:<?php echo esc_attr($color5)?>;background: <?php echo esc_attr($color4); ?>;border-left:3px solid <?php echo esc_attr($color1);?>;color:<?php echo esc_attr($color8); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-vid-wrap div.jsvehiclemanager_cm-vid-det {border: 1px solid <?php echo esc_attr($color5); ?>;color:<?php echo esc_attr($color6);?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-show-seller-btn-wrap{border-top:2px solid <?php echo esc_attr($color1); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-show-seller-btn-wrap a.jsvehiclemanager_cm-show-seller-btn {background: <?php echo esc_attr($color1); ?>;border: 1px solid <?php echo esc_attr($color2); ?>;color:<?php echo esc_attr($color3); ?>;}
    div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-seller-det div.jsvehiclemanager_cm-seller-det-right div.jsvehiclemanager_cm-seller-info-top .jsvehiclemanager_cm-seller-info-left a.jsvehiclemanager_cm-seller-info-left-text{color:<?php echo esc_attr($color1); ?>;}

    /* Seller List */

    div#jsvehiclemanager-wrapper div#jsvehiclemanager-content form.jsvehiclemanager_autoz_form div.jsvehiclemanager_seller-list-btn-wrapper input.jsvehiclemanager-seller-list-btn-reset{background-color:<?php echo esc_attr($color7);?>;color:<?php echo esc_attr($color8); ?>;border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-content form.jsvehiclemanager_autoz_form div.jsvehiclemanager_seller-list-btn-wrapper input.jsvehiclemanager-seller-list-btn-search{background-color:<?php echo esc_attr($color1);?>;color:<?php echo esc_attr($color3); ?>;border:1px solid <?php echo esc_attr($color2); ?>;}

    /* Compare Vehicle */
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper h5.jsvehiclemanager_cm-veh-comp-title{border:1px solid <?php echo esc_attr($color5); ?>;background:<?php echo esc_attr($color4); ?>;color:<?php echo esc_attr($color6); ?>;border-left:3px solid <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-data div.jsvehiclemanager-compare-vehicle-fields div.jsvehiclemanager-compare-vehicle-fields-section span.jsvehiclemanager_cm-com-veh-name{color:<?php echo esc_attr($color6); ?>;border-bottom:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-data div.jsvehiclemanager-compare-vehicle-fields div.jsvehiclemanager-compare-vehicle-fields-section span.jsvehiclemanager_cm-com-veh-txt{color:<?php echo esc_attr($color6); ?>;border-bottom:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-list div.jsvehiclemanager_cm-veh-comp-list-section div.jsvehiclemanager_cm-veh-comp-list-img-wrp img.jsvehiclemanager_cm-veh-comp-list-img{border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-list div.jsvehiclemanager_cm-veh-comp-list-section div.jsvehiclemanager_cm-veh-comp-list-price h3.jsvehiclemanager_cm-veh-comp-list-price-txt{color: <?php echo esc_attr($color3); ?>;background: <?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-data{border-width: 0px 1px 1px 1px;border-style: solid;border-color: <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-list div.jsvehiclemanager_cm-veh-comp-list-section div.jsvehiclemanager_cm-veh-comp-list-veh-name h3.jsvehiclemanager_cm-veh-comp-list-veh-name-txt{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper div.jsvehiclemanager_cm-veh-comp-list div.jsvehiclemanager_cm-veh-comp-list-section{background:#fff;border:1px solid <?php echo esc_attr($color5); ?>;}

    /* Refine Search popup */
     
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-heading-refine{color:<?php echo esc_attr($color3); ?>;background-color:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine{background: #fff;border-bottom: 10px solid <?php echo esc_attr($color1); ?>;box-shadow: 0px 0px 10px #7e6363;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine button#jsvehiclemanager-pop-close-refine{background:<?php echo esc_attr($color7); ?>;border: 1px solid <?php echo esc_attr($color5); ?>;color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine button#jsvehiclemanager-pop-save-refine{color:<?php echo esc_attr($color3); ?>;background:<?php echo esc_attr($color1); ?>;border: 1px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine {background-color:<?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-form-wrapper label{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-form-wrapper div.jsvehiclemanager-value input[type="text"]{border:1px solid <?php echo esc_attr($color5); ?>; }
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-form-section-checkbox-wrap div.jsvehiclemanager-checkbox-sections div.jsvehiclemanager-vehicle-details-checkbox{background:#fff;border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-form-wrapper div.jsvehiclemanager-value select{background-color: #fff;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-form-wrapper div.jsvehiclemanager-value div.jsvehiclemanager-vehicle-details-checkbox{background-color: #fff;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-buttons-area div.jsvehiclemanager-js-buttons-area-btn input{background-color: <?php echo esc_attr($color1); ?>; border: 1px solid <?php echo esc_attr($color2); ?>;color:#fff;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-buttons-area div.jsvehiclemanager-js-buttons-area-btn input.jsvehiclemanager-reset{background-color: #fff; border: 1px solid <?php echo esc_attr($color2); ?>;color:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-pop-transparent-refine div.jsvehiclemanager-pop-wrapper-refine div.jsvehiclemanager-pop-body-refine div.jsvehiclemanager-pop-content-refine div.jsvehiclemanager-js-buttons-area div.jsvehiclemanager-js-buttons-area-btn{border-top:2px solid <?php echo esc_attr($color2); ?>;}

    /* login form */

    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content{border:1px solid <?php echo esc_attr($color5); ?>;background:<?php echo esc_attr($color4); ?>}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper div.jsvehiclemanager-login-heading{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-username label{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-username input{border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-username input:focus{border:1px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-password label{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-password input{border:1px solid <?php echo esc_attr($color5); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-password input:focus{border:1px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-remember label{color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-submit input{color:<?php echo esc_attr($color3); ?>;border:1px solid <?php echo esc_attr($color2); ?>;background:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-login-content div.jsvehiclemanager-login-form-wrapper p.login-submit input:hover{background:<?php echo esc_attr($color2); ?>;}

    /* credits popup */
    div#jsvehiclemanager-popup{background:#fff;border-bottom:10px solid <?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager-popup span.jsvm_popup-title{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-popup div.jsvm_icon{background:<?php echo esc_attr($color1); ?>;}
    div#jsvehiclemanager-popup div.jsvm_popup-row.jsvm_button-wrap a{border:1px solid <?php echo esc_attr($color5); ?>;background:<?php echo esc_attr($color7); ?>;color:<?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-popup div.jsvm_popup-row.jsvm_button-wrap a.jsvm_proceed{border:1px solid <?php echo esc_attr($color2); ?>;background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color3); ?>;}
    div#jsvehiclemanager-popup div.jsvm_popup-row{color:<?php echo esc_attr($color6); ?>;border-bottom:1px solid <?php echo esc_attr($color5); ?>;}

    div.js_vehiclemanager_error_messages_wrapper{border:1px solid <?php echo esc_attr($color1); ?>; color: <?php echo esc_attr($color7); ?>;background:#ffffff;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message2{box-shadow: 0px 3px 3px 2px <?php $color5; ?>; background:<?php echo esc_attr($color1); ?>; color: <?php $color7; ?>;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message3{box-shadow: 0px 3px 3px 2px <?php $color5; ?>; background:#B81D20; color: <?php $color7; ?>;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_footer{background: <?php echo esc_attr($color3); ?>; border-top: 1px solid <?php echo esc_attr($color5); ?>;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message1 span{ font-size: 30px; font-weight: bold;color:<?php echo esc_attr($color8) ?>}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message2 span.jsvehiclemanager_img{border:1px solid <?php echo esc_attr($color1); ?>;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message2 span.jsvehiclemanager_message-text{font-size: 24px; font-weight: bold; }
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message3 span.jsvehiclemanager_img{border:1px solid <?php echo esc_attr($color1); ?>;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_message3 span.jsvehiclemanager_message-text{font-size: 24px; font-weight: bold; }
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_footer a{background: <?php echo esc_attr($color3); ?>; color:<?php echo esc_attr($color8); ?> !important;border: 1px solid <?php echo esc_attr($color5); ?>; font-size: 16px;}
    div.js_vehiclemanager_error_messages_wrapper div.jsvehiclemanager_footer a:hover{background: <?php echo esc_attr($color1); ?>; color:<?php echo esc_attr($color7); ?> !important;}
    div#jsvehiclemanager_breadcrumbs_parent div.jsvehiclemanager_home{background-color:<?php echo esc_attr($color2); ?>;}
    div#jsvehiclemanager_breadcrumbs_parent div.jsvehiclemanager_links a.jsvehiclemanager_links{color:<?php echo esc_attr($color2); ?>;}
    table#jsvehiclemanager-table thead.stats tr{background: <?php echo esc_attr($color3); ?>;border:1px solid <?php echo esc_attr($color5); ?>;}
    table#jsvehiclemanager-table thead.stats tr th{border-right:1px solid <?php echo esc_attr($color5); ?>;color: <?php echo esc_attr($color8); ?>;}
    table#jsvehiclemanager-table thead.stats tr th:last-child{border-right:none;}
    table#jsvehiclemanager-table tbody.stats tr td{border:1px solid <?php echo esc_attr($color5); ?>; color: <?php echo esc_attr($color6); ?>; background: #ffffff;}
    table#jsvehiclemanager-table tbody.stats tr td{border-right: none;}
    table#jsvehiclemanager-table tbody.stats tr td:last-child{border-right: 1px solid <?php echo esc_attr($color5); ?>;}
    table#jsvehiclemanager-table tbody.stats tr td.publish{color: <?php echo esc_attr($color8); ?>;}
    table#jsvehiclemanager-table tbody.stats tr td.expired{color: <?php echo esc_attr($color8); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-mystats-content div.jsvehiclemanager-topstats {border-bottom: 1px solid <?php echo esc_attr($color1); ?> }
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-mystats-content div.jsvehiclemanager-topstats div.jsvehiclemanager-mainwrp{border: 1px solid <?php echo esc_attr($color5); ?> ;background:<?php echo esc_attr($color4); ?>;}
    div#jsvehiclemanager-wrapper div#jsvehiclemanager-mystats-content div.jsvehiclemanager-topstats div.jsvehiclemanager-mainwrp div.jsvehiclemanager-headtext{color: <?php echo esc_attr($color8);?>}
    div.jsvehiclemanager-pagination span.page-numbers.current{color:<?php echo esc_attr($color1); ?>;}
    div.jsvehiclemanager-pagination a.page-numbers.next{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color7); ?>;}
    div.jsvehiclemanager-pagination a.page-numbers.prev{background:<?php echo esc_attr($color1); ?>;color:<?php echo esc_attr($color7); ?>;}

    table.jsvehiclemanager-cm-veh-alert-tabl {border: 1px solid <?php echo esc_attr($color5);?>;}
    table.jsvehiclemanager-cm-veh-alert-tabl thead.jsvehiclemanager-cm-veh-alert-tab-head {background: <?php echo esc_attr($color4);?>;}
    table.jsvehiclemanager-cm-veh-alert-tabl thead.jsvehiclemanager-cm-veh-alert-tab-head tr th {padding-top: 10px;color: <?php echo esc_attr($color6);?>;}
    table.jsvehiclemanager-cm-veh-alert-tabl tbody tr td span.jsvehiclemanager-cm-veh-alert-tab-email {color: <?php echo esc_attr($color1);?>;}
    table.jsvehiclemanager-cm-veh-alert-tabl tbody tr td span.jsvehiclemanager-cm-veh-alert-tab-type {color: <?php echo esc_attr($color6);?>;}
    table.jsvehiclemanager-cm-veh-alert-tabl tbody tr td span.jsvehiclemanager-cm-veh-alert-tab-cri {color: <?php echo esc_attr($color8);?>;}
    table.jsvehiclemanager-cm-veh-alert-tabl tbody tr td.jsvehiclemanager-cm-veh-alert-act a.jsvehiclemanager-cm-actn-btn {border: 1px solid <?php echo esc_attr($color5);?>;}

    div.jsvm_pictures_eyes div.jsvm_pictures_eyes_in div.jsvm_cm_vehicle_detail span.jsvm_cm_vlb_price{background: <?php echo  $color1;?>}

    .jsvehiclemanager-vehicle-listing-total-vehicles{border:1px solid <?php echo esc_attr($color5)?>;background: <?php echo esc_attr($color3);?>;color:<?php echo esc_attr($color6);?>;}
    .jsvehiclemanager-vehicle-listing-total-vehicles span{color:<?php echo esc_attr($color8)?>;}
    
    /* vehicle widget */
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_top div.jsvehiclemanager_vehicles_widget_title{border-bottom: 1px solid <?php echo esc_attr($color5);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record{border: 1px solid <?php echo esc_attr($color5);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record:hover{border: 1px solid <?php echo esc_attr($color1);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record div.jsvehiclemanager_vehicles_widget_data_record_image_wrap div.jsvehiclemanager_vehicles_widget_data_record_price{background: <?php echo esc_attr($color1);?>;color: #fff;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record div.jsvehiclemanager_vehicles_widget_data_record_data a.jsvehiclemanager_vehicles_widget_data_record_link{color: <?php echo esc_attr($color1);?>;border-bottom: 1px solid <?php echo esc_attr($color5);?>; }
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record div.jsvehiclemanager_vehicles_widget_data_record_data a.jsvehiclemanager_vehicles_widget_data_record_link:hover{color: <?php echo esc_attr($color2);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record div.jsvehiclemanager_vehicles_widget_data_record_data div.jsvehiclemanager_vehicles_widget_data_record_bottom{background: <?php echo esc_attr($color4);?>;color: <?php echo esc_attr($color6); ?>;border-top: 1px solid <?php echo esc_attr($color5);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_data_wrapper div.jsvehiclemanager_vehicles_widget_data_record div.jsvehiclemanager_vehicles_widget_data_record_data div.jsvehiclemanager_vehicles_widget_data_record_middle span{color:<?php echo esc_attr($color6);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper a.jsvehiclemanager_vehicles_widget_data_record{color: <?php echo esc_attr($color6);?>;background:<?php echo esc_attr($color3);?>; }
    div.jsvehiclemanager_vehicles_widget_wrapper a.jsvehiclemanager_vehicles_widget_data_record:hover{color: <?php echo esc_attr($color1);?>;background:#fff; }

    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_top div.jsvehiclemanager_vehicles_widget_title{color: <?php echo esc_attr($color8);?>;}
    div.jsvehiclemanager_vehicles_widget_wrapper div.jsvehiclemanager_vehicles_widget_top div.jsvehiclemanager_vehicles_widget_desc{color: <?php echo esc_attr($color6)?>;}

    div#jsvehiclemanager-pop-transparent div.jsvehiclemanager-pop-wrapper div.jsvehiclemanager-pop-body div.jsvehiclemanager-pop-content div.jsvehiclemanager-pop-elm-row .jsvehiclemanager-symbol-sign{
        color: <?php echo esc_attr($color6);?>;
    }

    @media(max-width:480px){
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-credit-pack-wrap div#jsvehiclemanager-credit-pack-wrapper div.jsvehiclemanager-credit-pack-data div.jsvehiclemanager-credit-pack-data-top span.jsvehiclemanager-credit-pack-top-right{border-top:1px solid <?php echo esc_attr($color5); ?>;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-desc {border-top: 1px solid <?php echo esc_attr($color5); ?>;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper div#jsvehiclemanager-flex-autoz-dealer-information {border-top: 1px solid <?php echo esc_attr($color5); ?>;}
    }
    @media(max-width:650px){
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-desc {border-top: 1px solid <?php echo esc_attr($color5); ?>;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper div#jsvehiclemanager-flex-autoz-dealer-information {border-top: 1px solid <?php echo esc_attr($color5); ?>;}
    }

    <?php  if (is_rtl()) {?>
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.add-vehicle {border-right: none;border-left: 3px solid #347ab8;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.my-vehicles {border-right: none;border-left: 3px solid #5db85b;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.shortlist-vehicles {border-right: none;border-left: 3px solid #efad4d;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager-buyer-cp-top-portion div.search-vehicles {border-right: none;border-left: 3px solid #d9524c;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-buyer-cp .jsvehiclemanager_cpheading {border-right: 5px solid <?php echo esc_attr($color1); ?>;border-left:  1px solid #d4d4d5;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-model-price div#jsvehiclemanager-model { border-right:3px solid <?php echo esc_attr($color1); ?>;border-left:  none; }
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper div#jsvehiclemanager-flex-autoz-dealer-information {border-right: 1px solid <?php echo esc_attr($color5); ?> ;border-left: none;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-overview div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text{border-right: 4px solid <?php echo esc_attr($color1); ?>;border-left: none;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper{border-right: 3px solid <?php echo esc_attr($color5); ?>;border-left: none;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-vehicle-details-wrapper{border-rght: 3px solid <?php echo esc_attr($color5) ;?>;border-left: none;}
        div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_bottom_wrap div.jsvehiclemanager_vehicle_left div.jsvehiclemanager_vehicle_option{border-left: 1px solid <?php echo esc_attr($color5); ?>;border-right: none;}
        div.jsvehiclemanager_cm-seller-wrap div.jsvehiclemanager_cm-desc-wrap div.jsvehiclemanager_cm-desc-title {border-left:1px solid <?php echo esc_attr($color5)?>;border-right:3px solid <?php echo esc_attr($color1);?>;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-compare-vehicle-wrapper div.jsvehiclemanager_cm-compare-wrapper h5.jsvehiclemanager_cm-veh-comp-title{border-left:1px solid <?php echo esc_attr($color5); ?>;border-right:3px solid <?php echo esc_attr($color1); ?>;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-desc {border-right:1px solid <?php echo esc_attr($color5); ?>;border-left: none;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-date-time {border-left:1px solid <?php echo esc_attr($color5); ?>;border-right: none;}
        table#jsvehiclemanager-table tbody.stats tr td.total-vehicles{border-right: 4px solid #65a324;border-left: none;} 
        table#jsvehiclemanager-table tbody.stats tr td.total-feature{border-right: 4px solid #00afef;border-left: none;} 
        div#jsvehiclemanager_breadcrumbs_parent div{border-right:1px solid #ababab;border-left: none;} 
        div#jsvehiclemanager-wrapper div.jsvehiclemanager_vehicle_wrapper div.jsvehiclemanager_vehicle_top_wrap div.jsvehiclemanager_vehicle_right_content div.jsvehiclemanager_vehicle_content_top_row span.jsvehiclemanager_vehicle_price {border-right: 1px solid <?php echo esc_attr($color5); ?>;border-left: none;}
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-features div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text ,
        div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-gallery div.jsvehiclemanager-feature-detail-list div.jsvehiclemanager-feature-detail-sub-heading span.jsvehiclemanager-sub-heading-text  {border-right: 4px solid <?php echo esc_attr($color1); ?>;border-left: none;}


        @media(max-width:780px){
            div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-desc {border-left: 1px solid <?php echo esc_attr($color5); ?> !important;border-right: none;}
        }
        @media(max-width:650px){
            div#jsvehiclemanager-wrapper div#jsvehiclemanager-veh-detail-wrapper div#jsvehiclemanager-flex-autoz-wrapper div#jsvehiclemanager-detail-flex-autoz div#jsvehiclemanager-middle-sec-wrap div#jsvehiclemanager-flex-autoz-dealer-information-wrapper div#jsvehiclemanager-flex-autoz-dealer-information {border-right: none;}
            div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-date-time {border-left:none;}
            div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-desc {border-left:none !important;}
            div#jsvehiclemanager-wrapper div#jsvehiclemanager-credits-log-wrap div.jsvehiclemanager-credits-log-wrapper div.jsvehiclemanager-credits-log-row-wrap span.jsvehiclemanager-credits-log-cost {float: right !important;}
        }


    <?php } ?>
</style>
