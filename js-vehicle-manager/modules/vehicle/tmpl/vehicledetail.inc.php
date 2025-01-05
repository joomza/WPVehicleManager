<?php
$rand_id = rand();

?>
<script type="text/javascript">

	/*
	jsvehiclemanager_pop_vehicleid
	global variable defined with popup functions in common.js
	*/

    function showPopupFromVehicleDetail(contentWrapper){
        var vehicleid = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;
		jsvehiclemanager_pop_vehicleid = vehicleid;
		showPopup( contentWrapper );
	}

	jQuery(document).ready(function(){
        jQuery("img.jsvehiclemanager-vehcileimage").click(function(){
	        var imgnum = jQuery(this).attr("data-imagenumber");
            if(imgnum >= 0){
                jQuery("li.jsvehiclemanager_slid-img").picEyes({
                    "fuelgage": "<?php echo CAR_MANAGER_IMAGE.'/light-box-milage.png';?>",
                    "transmission": "<?php echo CAR_MANAGER_IMAGE.'/light-box-transmission.png';?>",
                    "fueltype": "<?php echo CAR_MANAGER_IMAGE.'/light-box-fuel.png';?>",
                });
                jQuery('li img[data-imagenumber="'+imgnum+'"]').click();
            }
	    });
	})

	    function offerAPrice(showCaptcha){
            var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
            if( showCaptcha == 1 ){
                var captchaIndex = isPluginCall==true ? recaptcha_offer : oapcaptcha;
                var captcharesponce = grecaptcha.getResponse( captchaIndex );
            }else{
                var captcharesponce = "";
            }
            var oapname = jQuery("input#jsvm_oapname").val();
            if (oapname == "") {
                jQuery("input#jsvm_oapname").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#jsvm_oapname").css("border","");
            }
            var oapemail = jQuery("input#jsvm_oapemail").val();
            if (oapemail == "" || emailverify(oapemail) == false) {
                jQuery("input#jsvm_oapemail").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#jsvm_oapemail").css("border","");
            }
            var phonenumber = jQuery("input#jsvm_oapphonenumber").val();
            var offeredprice = jQuery("input#jsvm_offeredprice").val();
            if (offeredprice == "") {
                jQuery("input#jsvm_offeredprice").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#jsvm_offeredprice").css("border","");
            }

        if( isPluginCall == true ){

            var commentscondition = jQuery("textarea#jsvm_commentscondition").val();
            var vehicleid = jsvehiclemanager_pop_vehicleid;
            jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").show();
            jQuery.post(common.ajaxurl, {action: "jsvehiclemanager_ajax",jsvmme: "makeanoffer",task: "makeAnOffer",name: oapname,email: oapemail,comments: commentscondition,price: offeredprice,phonenumber: phonenumber,vehicleid: vehicleid,captcha_responce: captcharesponce,isPluginCall:isPluginCall,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    var html =  jQuery.parseJSON(data);
                    jQuery('#jsvehiclemanager-ctn-offer').append(html);
                    jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").hide();
                }
            });
        }else{
            var commentscondition = jQuery("textarea#jsvm_commentscondition").val();
            var vehicleid = jQuery("input#jsvm_oapvehicleid").val();
            jQuery("div#jsvm_makeanoffer").find("div.jsvm_cm-multi-popup-overlay").show();
            jQuery("div#jsvm_makeanoffer").find("img.jsvm_multipop-loading-gif").show();
            jQuery.post(common.ajaxurl, {action: "jsvehiclemanager_ajax",jsvmme: "makeanoffer",task: "makeAnOffer",name: oapname,email: oapemail,comments: commentscondition,price: offeredprice,phonenumber: phonenumber,vehicleid: vehicleid,captcha_responce: captcharesponce,wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    var html =  jQuery.parseJSON(data);
                    jQuery("div#jsvm_makeanoffer").find("img.jsvm_multipop-loading-gif").after(html);
                    jQuery("div#jsvm_makeanoffer").find("img.jsvm_multipop-loading-gif").hide();
                }
            });
        }
    }

    function scheduleTestDrive( showCaptcha){
        var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
            if( showCaptcha == 1){
                var captchaIndex = isPluginCall==true ? recaptcha_drive : stdcaptcha;
                var captcharesponce = grecaptcha.getResponse(captchaIndex);
            }else{
                var captcharesponce = "";
            }
            var stdname = jQuery("input#jsvm_stdname").val();
            if (stdname == "") {
                jQuery("input#jsvm_stdname").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#jsvm_stdname").css("border","");
            }
            var stdemail = jQuery("input#jsvm_stdemail").val();
            if (stdemail == "" || emailverify(stdemail) == false) {
                jQuery("input#jsvm_stdemail").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#jsvm_stdemail").css("border","");
            }
            var stdphonenumber = jQuery("input#jsvm_stdphonenumber").val();
            var stdday = jQuery("input#jsvm_stdday").val();
            if (stdday == "") {
                jQuery("input#jsvm_stdday").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#jsvm_stdday").css("border","");
            }
            if( isPluginCall == true ){
                var stdtime = jQuery("input#jsvm_stdtime").val();
                var vehicleid = jsvehiclemanager_pop_vehicleid;
                jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").show();
                jQuery.post(common.ajaxurl , {action:"jsvehiclemanager_ajax",jsvmme:"testdrive",task:"scheduleTestDrive",name:stdname,email:stdemail,time:stdtime,date:stdday,phonenumber:stdphonenumber,vehicleid:vehicleid,captcha_responce:captcharesponce,isPluginCall:isPluginCall,wpnoncecheck:common.wp_vm_nonce} , function (data) {
                    if (data) {
                        var html =  jQuery.parseJSON(data);
                        jQuery('#jsvehiclemanager-ctn-drive').append(html);
                        jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").hide();
                    }
                });
            }else{
                var stdtime = jQuery("input#jsvm_stdtime").val();
                var vehicleid = jQuery("input#jsvm_stdvehicleid").val();
                jQuery("div#jsvm_schecduletestdrive").find("div.jsvm_cm-multi-popup-overlay").show();
                jQuery("div#jsvm_schecduletestdrive").find("img.jsvm_multipop-loading-gif").show();
                jQuery.post(common.ajaxurl , {action:"jsvehiclemanager_ajax",jsvmme:"testdrive",task:"scheduleTestDrive",name:stdname,email:stdemail,time:stdtime,date:stdday,phonenumber:stdphonenumber,vehicleid:vehicleid,captcha_responce:captcharesponce,wpnoncecheck:common.wp_vm_nonce} , function (data) {
                    if (data) {
                        var html =  jQuery.parseJSON(data);
                        jQuery("div#jsvm_schecduletestdrive").find("img.jsvm_multipop-loading-gif").after(html);
                        jQuery("div#jsvm_schecduletestdrive").find("img.jsvm_multipop-loading-gif").hide();
                    }
                });
            }
    }


</script>
