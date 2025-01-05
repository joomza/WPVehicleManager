<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

add_filter('product_type_selector', 'jsvehiclemanager_credits_add_product_type');

function jsvehiclemanager_credits_add_product_type($types) {
    $types['jsvehiclemanager_credits'] = __('Vehicle Manager Credits');
    return $types;
}

add_action('plugins_loaded', 'jsvehiclemanager_credits_create_custom_product_type');

function jsvehiclemanager_credits_create_custom_product_type() {
    if (!class_exists('WC_Product')) {
        return;
    }

    // declare the product class
    class WC_Product_JSVehicleManager extends WC_Product {

        public function __construct($product) {
            $this->product_type = 'jsvehiclemanager_credits';
            parent::__construct($product);
            // add additional functions here
        }

    }

}

// add the settings under ‘General’ sub-menu
add_action('woocommerce_product_options_general_product_data', 'jsvehiclemanager_credits_add_custom_settings');

function jsvehiclemanager_credits_add_custom_settings() {
    global $woocommerce, $post;
    echo '<div id="jsvehiclemanager_credits_custom_product_option" class="options_group">';

    // get all credits packs
    $db = new jsvehiclemanagerdb();
    $query = "SELECT id,title,credits,price,discount,discounttype,discountstartdate,discountenddate,expireindays FROM `#__js_vehiclemanager_credits_pack` WHERE status = 1";
    $db->setQuery($query);
    $result = $db->loadObjectList();

    //parse the credits packs
    if ($result && is_array($result)) {
        $options = array('' => __('Select Package', 'js-vehicle-manager'));
        $fielddata = '';
        $i = 0;
        foreach ($result AS $pack) {
            $options[$pack->id] = $pack->title . ' [' . $pack->credits . '] ' . $pack->expireindays . ' ' . __('Days', 'js-vehicle-manager');
            if ($i != 0) {
                $fielddata .= '|';
            }
            $curdate = date_i18n('Y-m-d');
            $startdate = date_i18n('Y-m-d', strtotime($pack->discountstartdate));
            $enddate = date_i18n('Y-m-d', strtotime($pack->discountenddate));
            $price = 0; // if discount is not available then it should be same as complete price
            if ($pack->discounttype == 2) { // discount in percentage
                if ($curdate >= $startdate && $enddate >= $curdate) {
                    $price = ($pack->price - (($pack->price / 100) * $pack->discount));
                }
            } elseif ($pack->discounttype == 1) { // discount in amount
                if ($curdate >= $startdate && $enddate >= $curdate) {
                    $price = ($pack->price - $pack->discount);
                }
            }
            $fielddata .= $pack->id . ':' . $pack->price . ',' . $price;
            $i++;
        }
    }

    // Create a number field, for example for UPC
    woocommerce_wp_select(
            array(
                'id' => 'jsvehiclemanager_creditpack_field',
                'label' => __('Package combo', 'woocommerce'),
                'placeholder' => '',
                'desc_tip' => 'true',
                'description' => __('Select credits pack so that user can purchase them.', 'woocommerce'),
                'type' => 'number',
                'options' => $options,
                'custom_attributes' => array('fielddata' => $fielddata)
    ));

    echo '</div>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery( ".options_group.pricing" ).addClass( "show_if_jsvehiclemanager_credits" ).show();

                jQuery("#product-type").change(function(){
                    var value = jQuery(this).val();
                    if(value == "jsvehiclemanager_credits"){
                        jQuery("div#jsvehiclemanager_credits_custom_product_option").show();
                        var selectedvalue = jQuery("select#jsvehiclemanager_creditpack_field").val();
                        var value = jQuery("select#jautoz_creditpack_field").attr("fielddata");
                        var array = value.split("|");
                        for(i=0; i < array.length; i++){
                            var valarray = array[i].split(":");
                            var index = valarray[0];
                            var ans = valarray[1].split(",");
                            if(selectedvalue == index){
                                jQuery("input#_regular_price").val(ans[0]).attr("readonly","true");
                                if(ans[1] != 0){
                                    jQuery("input#_sale_price").val(ans[1]).attr("readonly","true");                                    
                                }else{
                                    jQuery("input#_sale_price").attr("readonly","true");
                                }
                            }
                        }
                    }else{
                        jQuery("div#jsvehiclemanager_credits_custom_product_option").hide();
                        jQuery("input#_regular_price").removeAttr("readonly");
                        jQuery("input#_sale_price").removeAttr("readonly");
                    }                   
                });             
                jQuery("#product-type").change();
                jQuery("select#jsvehiclemanager_creditpack_field").change(function(){
                    var selectedvalue = jQuery(this).val();
                    var value = jQuery(this).attr("fielddata");
                    var array = value.split("|");
                    for(i=0; i < array.length; i++){
                        var valarray = array[i].split(":");
                        var index = valarray[0];
                        var ans = valarray[1].split(",");
                        if(selectedvalue == index){
                            jQuery("input#_regular_price").val(ans[0]).attr("readonly","true");
                            if(ans[1] != 0){
                                jQuery("input#_sale_price").val(ans[1]).attr("readonly","true");         
                            }else{
                                jQuery("input#_sale_price").val("").attr("readonly","true");
                            }
                        }
                    }
                });
            });
        </script>
    ';
}

add_action('woocommerce_process_product_meta', 'jsvehiclemanager_credits_save_custom_settings');

function jsvehiclemanager_credits_save_custom_settings($post_id) {
    // save jsvehiclemanager_creditpack_field
    $jsvehiclemanager_creditpack_field = $_POST['jsvehiclemanager_creditpack_field'];
    if (!empty($jsvehiclemanager_creditpack_field))
        update_post_meta($post_id, 'jsvehiclemanager_creditpack_field', esc_attr($jsvehiclemanager_creditpack_field));
}

function jsvehiclemanager_payment_complete_by_wc($order_id){
    $order = new WC_Order($order_id);
    $user_id = $order->user_id;
    // getting the product detail
    $items = $order->get_items();
    $creditpackids = array();
    foreach ($items as $item) {
        $product_name = $item['name'];
        $product_id = $item['product_id'];
        $product_variation_id = $item['variation_id'];
        $packageid = get_post_meta($product_id, 'jsvehiclemanager_creditpack_field', true);
        // Check if the custom field has a value.
        if (!empty($packageid)) {
            $creditpackids[] = $packageid;
        }
    }
    foreach ($creditpackids AS $packid) {
        // Add record in purchase history
        $pdata['uid'] = JSVEHICLEMANAGERincluder::getObjectClass('user')->getjsvehiclemanageruidbyuserid($user_id);
        $package = JSVEHICLEMANAGERincluder::getJSModel('creditspack')->getPackDetailForPurchase($packid);
        $pdata['creditsid'] = $packid;
        $pdata['purchasetitle'] = $package->title;
        $pdata['credits'] = $package->credits;
        $pdata['expireindays'] = $package->expireindays;
        $pdata['status'] = 1;
        $pdata['created'] = date('Y-m-d H:i:s');
        $pdata['payer_firstname'] = $order->billing_first_name;
        $pdata['payer_lastname'] = $order->billing_last_name;
        $pdata['payer_email'] = $order->billing_email;
        $pdata['payer_contactnumber'] = $order->billing_phone;
        $pdata['payer_address'] = $order->billing_city . ', ' . $order->billing_state . ', ' . $order->billing_country;
        $pdata['payer_transactionumber'] = $order->id;
        $pdata['payer_amount'] = $order->get_total();
        $pdata['payment_gateway'] = 'Woocommerce - ' . $order->payment_method_title;
        $pdata['transactionverified'] = 1;
        $row = JSVEHICLEMANAGERincluder::getJSTable('paymenthistory');        
        if (!$row->bind($pdata)) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        if (!$row->store()) {
            return JSVEHICLEMANAGER_SAVE_ERROR;
        }
        JSVEHICLEMANAGERincluder::getJSModel('emailtemplate')->sendMail(4,$row->id);
    }
}

function jsvehiclemanager_woocommerce_payment_complete($order_id) {
    jsvehiclemanager_payment_complete_by_wc($order_id);
}

function jsvehiclemanager_woocommerce_payment_pending($order_id) {
}

function jsvehiclemanager_woocommerce_payment_failed($order_id) {
}

function jsvehiclemanager_woocommerce_payment_hold($order_id) {
}

function jsvehiclemanager_woocommerce_payment_processing($order_id) {
}

function jsvehiclemanager_woocommerce_payment_completed($order_id) {
    jsvehiclemanager_payment_complete_by_wc($order_id);
}

function jsvehiclemanager_woocommerce_payment_refunded($order_id) {
}

function jsvehiclemanager_woocommerce_payment_cancelled($order_id) {
}

add_action('woocommerce_payment_complete', 'jsvehiclemanager_woocommerce_payment_complete');
add_action('woocommerce_order_status_pending', 'jsvehiclemanager_woocommerce_payment_pending');
add_action('woocommerce_order_status_failed', 'jsvehiclemanager_woocommerce_payment_failed');
add_action('woocommerce_order_status_on-hold', 'jsvehiclemanager_woocommerce_payment_hold');
// Note that it's woocommerce_order_status_on-hold, not on_hold.
add_action('woocommerce_order_status_processing', 'jsvehiclemanager_woocommerce_payment_processing');
add_action('woocommerce_order_status_completed', 'jsvehiclemanager_woocommerce_payment_completed');
add_action('woocommerce_order_status_refunded', 'jsvehiclemanager_woocommerce_payment_refunded');
add_action('woocommerce_order_status_cancelled', 'jsvehiclemanager_woocommerce_payment_cancelled');
?>
