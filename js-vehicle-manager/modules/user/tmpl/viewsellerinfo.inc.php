<script type="text/javascript">

var isPluginCall = <?php echo jsvehiclemanager::$_car_manager_theme == 1 ? 'false' : 'true'; ?>;
var map;

<?php $seller = jsvehiclemanager::$_data[0]; ?>

function initMap(  ){
    var isPluginCall = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;

    <?php if(isset($seller->latitude) && $seller->latitude !='' && isset($seller->longitude) && $seller->longitude !=''){ ?>

    if( isPluginCall == true ){
        var myOptions = {zoom:10,scrollwheel: false,center:new google.maps.LatLng(<?php echo esc_js($seller->latitude); ?>,<?php echo esc_js($seller->longitude); ?>),mapTypeId: google.maps.MapTypeId.ROADMAP};
        map = new google.maps.Map(document.getElementById("jsvehiclemanager_map"), myOptions);
        var latlang = new google.maps.LatLng(<?php echo esc_js($seller->latitude); ?>,<?php echo esc_js($seller->longitude); ?>);
        var marker = new google.maps.Marker({
            position: latlang,
            map: map,
            scrollwheel: false,
            draggable: false,
        });
        marker.setMap(map)
    }
    else{
        var myOptions = {zoom:10,scrollwheel: false,center:new google.maps.LatLng(<?php echo esc_js($seller->latitude); ?>,<?php echo esc_js($seller->longitude); ?>),mapTypeId: google.maps.MapTypeId.ROADMAP};
        document.map = new google.maps.Map(document.getElementById("jsvm_map"), myOptions);
        var latlang = new google.maps.LatLng(<?php echo esc_js($seller->latitude); ?>,<?php echo esc_js($seller->longitude); ?>);
        var marker = new google.maps.Marker({
            position: latlang,
            map: document.map,
            scrollwheel: false,
            draggable: false,
        });
        marker.setMap(document.map);
    }
    <?php }   ?>
}


function sendToSeller(){
    var isPluginCall = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;

    if(isPluginCall = 0){
        var captcharesponce = jQuery('#g-recaptcha-response').val(); //hidden field by google recaptcha api
    }else{
        var captcharesponce = jQuery('#sellercaptcha').val(); //hidden field by google recaptcha api
    }

    var sname = jQuery("input#sname").val();
    if (sname == "") {
        jQuery("input#sname").css({"border": "1px solid red"}).focus();
        return false;
    }
    else{
        jQuery("input#sname").css("border","");
    }
    var semail = jQuery("input#semail").val();
    if (semail == "" || emailverify(semail) == false) {
        jQuery("input#semail").css({"border": "1px solid red"}).focus();
        return false;
    }
    else{
        jQuery("input#semail").css("border","");
    }
    var message = jQuery("textarea#smessage").val();
    if (message == "") {
        jQuery("textarea#smessage").css({"border": "1px solid red"}).focus();
        return false;
    }
    else{
        jQuery("textarea#smessage").css("border","");
    }

    var sellerid = jQuery("input#sellerid").val();
    if(isPluginCall == 0){
        jQuery("div.send-to-seller-wrapper").find("div.jsvm_cm-multi-popup-overlay").show();
        jQuery("div.send-to-seller-wrapper").find("img.jsvm_multipop-loading-gif").show();
    }else{
        jQuery("div.jsvehiclemanager_cm-message").find("div.jsvehiclemanager_cm-multi-popup-overlay").show();
        jQuery("div.jsvehiclemanager_cm-message").find("img.jsvehiclemanager_multipop-loading-gif").show();

    }
    jQuery.post(common.ajaxurl, { action: "jsvehiclemanager_ajax" , jsvmme: "buyercontacttoseller" ,task: "sendToSeller" ,name: sname ,email: semail ,message: message ,sellerid: sellerid ,captcha_responce: captcharesponce,wpnoncecheck:common.wp_vm_nonce} , function (data) {
        if (data) {
            var html =  jQuery.parseJSON(data);
            if(isPluginCall == 0){
                jQuery("div.send-to-seller-wrapper").append(html);
                jQuery("div.send-to-seller-wrapper").find("div.jsvm_cm-multi-popup-overlay").hide();
                jQuery("div.send-to-seller-wrapper").find("img.jsvm_multipop-loading-gif").hide();
            }else{
                jQuery("div.jsvehiclemanager_cm-message").append(html);
                jQuery("div.jsvehiclemanager_cm-message").find("div.jsvehiclemanager_cm-multi-popup-overlay").hide();
                jQuery("div.jsvehiclemanager_cm-message").find("img.jsvehiclemanager_multipop-loading-gif").hide();
            }
        }
    });
}

jQuery(document).ready(function(){

    initMap(isPluginCall);

});

</script>
