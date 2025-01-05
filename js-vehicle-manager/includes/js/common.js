jQuery(document).ready(function () {
    window.setTimeout(function() {
            jQuery("#jsvm_autohidealert").fadeTo(500, 0).slideUp(500, function(){
                jQuery(this).remove();
           });
    }, 5000);   
     // Call block for all the #
    jQuery("body").delegate('a[href="#"]', "click", function (event) {
        event.preventDefault();
    });
    // Check boxess multi-selection
    jQuery('#jsvm_selectall').click(function (event) {
        if (this.checked) {
            jQuery('.jsvehiclemanager-cb').each(function () {
                this.checked = true;
            });
        } else {
            jQuery('.jsvehiclemanager-cb').each(function () {
                this.checked = false;
            });
        }
    });
    //submit form with anchor
    jQuery("a.jsvm_multioperation").click(function (e) {
        e.preventDefault();
        var total = jQuery('.jsvehiclemanager-cb:checked').size();
        if (total > 0) {
            var task = jQuery(this).attr('data-for');
            if (task.toLowerCase().indexOf("remove") >= 0) {
                if (confirmdelete(jQuery(this).attr('confirmmessage')) == true) {
                    jQuery("input#task").val(task);
                    jQuery("form#jsvehiclemanager-list-form").submit();
                }
            } else {
                jQuery("input#task").val(task);
                var wpnoncecheck = jQuery(this).attr('data-for-wpnonce');
                jQuery("input#_wpnonce").val(wpnoncecheck);
                jQuery("form#jsvehiclemanager-list-form").submit();
            }
        } else {
            var message = jQuery(this).attr('message');
            alert(message);
        }
    });
    
    //submit form with anchor
    jQuery("a.jsvm_multioperation-frontend").click(function (e) {
        e.preventDefault();
        var total = jQuery('.jsvehiclemanager-cb:checked').size();
        if (total > 0) {
            var task = jQuery(this).attr('data-for');
            var formid = jQuery(this).attr('data-formid');
            if (task.toLowerCase().indexOf("removemulti") >= 0) {
                if (confirmdelete(jQuery(this).attr('confirmmessage')) == true) {
                    jQuery("input#task").val(task);
                    jQuery("form#"+formid).submit();
                }
            }
        } else {
            var message = jQuery(this).attr('message');
            alert(message);
        }
    });

    jsvehiclemanagerPopupLink();
    jQuery("img#jsvm_popup_cross").click(function () {
        jsvehiclemanagerClosePopup();
    });
    jQuery("div#jsvm_jsauto-popup-background").click(function () {
        jsvehiclemanagerClosePopup();
    });
});

function jsvehiclemanagerPopupLink() {
    jQuery('a.jsvehiclemanager-popup').click(function (e) {
        e.preventDefault();
    });
}

function confirmdelete(message) {
    if (confirm(message) == true) {
        return true;
    } else {
        return false;
    }
}

function jsvehiclemanagerPopup(actionname, id, srcid, anchorid) {
    var isPluginCall = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
    if( isPluginCall == true ){
        jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup', task: actionname, id: id, srcid: srcid, anchorid: anchorid,isPluginCall:isPluginCall, wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                jQuery("body").append(data);
                jQuery("div#jsvehiclemanager-popup-background").show().click(function () {
                    jsvehiclemanagerClosePopup();
                });
                jQuery("img#jsvm_popup_cross").click(function () {
                    jsvehiclemanagerClosePopup();
                });
                //this line is added to resolve remaining credits issue in popup
                jQuery("input[type='radio'].jsvm_checkboxes").prop("checked", true);
                jQuery("input[type='radio'].jsvm_checkboxes").change(function (e) {
                    setRemaingCredits();
                });
                jQuery("div#jsvehiclemanager-popup").slideDown();
                jsvehiclemanagerPopupLink();
            }
        });
    }
    else{
        jsvm_showloading();
        jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup', task: actionname, id: id, srcid: srcid, anchorid: anchorid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                jQuery("body").append(data);
                jQuery("div#jsvehiclemanager-popup-background").show().click(function () {
                    jsvehiclemanagerClosePopup();
                });
                jQuery("img#jsvm_popup_cross").click(function () {
                    jsvehiclemanagerClosePopup();
                });
                //this line is added to resolve remaining credits issue in popup
                jQuery("input[type='radio'].jsvm_checkboxes").prop("checked", true);
                jQuery("input[type='radio'].jsvm_checkboxes").change(function (e) {
                    setRemaingCredits();
                });
                jQuery("div#jsvehiclemanager-popup").slideDown();
                jsvehiclemanagerPopupLink();
            }
            jsvm_hideloading();
        });    
    }
    
}

function jsvehiclemanagerPopupAdmin(actionname, id, srcid, anchorid, payment) {
    if(payment === undefined){
        payment = 0;
    }
    var userid = jQuery('a[data-anchorid="'+anchorid+'"]').attr('data-credit-userid');
    jsvm_showloading();
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup', task: actionname, id: id, srcid: srcid, anchorid: anchorid, isadmin:1, payment:payment,userid:userid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            jQuery("body").append(data);
            jQuery("div#jsvehiclemanager-popup-background").show().click(function () {
                jsvehiclemanagerClosePopup();
            });
            jQuery("img#jsvm_popup_cross").click(function () {
                jsvehiclemanagerClosePopup();
            });
            //this line is added to resolve remaining credits issue in popup
            jQuery("input[type='radio'].jsvm_checkboxes").prop("checked", true);
            jQuery("input[type='radio'].jsvm_checkboxes").change(function (e) {
                setRemaingCredits();
            });
            jQuery("div#jsvehiclemanager-popup").slideDown();
            jsvehiclemanagerPopupLink();
        }
        jsvm_hideloading();
    });
}

function setRemaingCredits() {
    var requiredcredits = 0;
    var totalcredits = 0;
    jQuery('input[type=radio].jsvm_checkboxes').each(function () {
        if (this.checked) {
            requiredcredits = parseInt(jQuery(this).attr('data-credits'));
            totalcredits = parseInt(jQuery(this).attr('data-totalcredits'));
        }
    });
    jQuery("span#jsvm_remaing-credits").html(totalcredits - requiredcredits);
}

function jsvehiclemanagerClosePopup() {
    jQuery("div#jsvehiclemanager-popup").slideUp();
    jQuery("div#jsvehiclemanager-listpopup").slideUp();
    setTimeout(function () {
    jQuery("div#jsvehiclemanager-popup-background").hide();
        jQuery("div#jsvehiclemanager-popup").html(' ');
    }, 350);
}

function jsvehiclemanagerPopupProceeds(actionname, objectid, srcid, anchorid, actionid) {
    if (actionid == -1) {
        jQuery('input[type=radio].jsvm_checkboxes').each(function () {
            if (this.checked) {
                creditid = parseInt(jQuery(this).val());
            }
        });
    } else {
        creditid = actionid;
    }
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0){
        alert(common.insufficient_credits);
        return;
    }
    jQuery('div#jsvehiclemanager-popup').prepend('<div class="jsvm_loading"></div>');
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup_action', task: actionname, id: objectid, actiona: creditid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            var obj = jQuery.parseJSON(data);
            if(typeof obj =='object'){
                jsvehiclemanagerClosePopup();               
                location.reload();
            }
        }
    });
}

function jsvehiclemanagerPopupProceedsAdmin(actionname, objectid, srcid, anchorid, actionid, payment) {
    if(payment === undefined){
        payment = 0;
    }
    if (actionid == -1) {
        jQuery('input[type=radio].jsvm_checkboxes').each(function () {
            if (this.checked) {
                creditid = parseInt(jQuery(this).val());
            }
        });
    } else {
        creditid = actionid;
    }
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0 && payment == 1){
        alert(common.insufficient_credits);
        return;
    }
    jQuery('div#jsvehiclemanager-popup').prepend('<div class="jsvm_loading"></div>');
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup_action', task: actionname, id: objectid, actiona: creditid, isadmin:1, payment:payment, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            var obj = jQuery.parseJSON(data);
            if(typeof obj =='object'){
                jsvehiclemanagerClosePopup();
                location.reload();
            }
        }
    });
}

function jsvehiclemanagerformpopupAdmin(actionname, formid) {
    var formvalid = jQuery('form#'+formid).isValid();
    if(formvalid == false){
        return;
    }

    var userid = jQuery('form#'+formid).find('input.jsvm_credit-userid').attr('data-credit-userid');
    jsvm_showloading();
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup', task: actionname, formid: formid,isadmin:1,userid:userid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            jQuery("body").append(data);
            jQuery("div#jsvehiclemanager-popup-background").show().click(function () {
                jsvehiclemanagerClosePopup();
            });
            jQuery("img#jsvm_popup_cross").click(function () {
                jsvehiclemanagerClosePopup();
            });
            jQuery("div#jsvehiclemanager-popup").slideDown();
            jsvehiclemanagerPopupLink();
            //this line is added to resolve remaining credits issue in popup
            jQuery("input[type='radio'].jsvm_checkboxes").prop("checked", true);
            jQuery("input[type='radio'].jsvm_checkboxes").change(function (e) {
                setRemaingCredits();
            });
        }
        jsvm_hideloading();
    });
}

function jsvm_showloading(){
    jQuery('div#jsvm_ajaxloaded_wait_overlay').show();
    jQuery('img#jsvm_ajaxloaded_wait_image').show();
}
function jsvm_hideloading(){
    jQuery('div#jsvm_ajaxloaded_wait_overlay').hide();
    jQuery('img#jsvm_ajaxloaded_wait_image').hide();
}

function jsvehiclemanagerformpopup(actionname, formid , jsvehiclemanagerpageid) {
    var isPluginCall = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : false;
    var formvalid = jQuery('form#'+formid).isValid();
    if(formvalid == false){
        return;
    }
    if(isPluginCall == true){
        try{
            var termsandcondtions = document.getElementById("termsconditions1").checked;
            if( !termsandcondtions ){
                alert(common.terms_conditions);
                return false;
            }
        }
        catch(e){
        }
    }
    else{
        var termsandcondtions = jQuery('div.jsvm_data-terms-and-condidtions-flag-div').attr("data-terms-and-condidtions-flag");
        if(termsandcondtions == 1){
            if(!jQuery("input[name='termsconditions']").is(":checked")){
                alert(common.terms_conditions);
                return false;
            }
        }   
    }
    jsvm_showloading();
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax_popup', task: actionname, formid: formid ,jsvehiclemanagerpageid : jsvehiclemanagerpageid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            jQuery("body").append(data);
            jQuery("div#jsvehiclemanager-popup-background").show().click(function () {
                jsvehiclemanagerClosePopup();
            });
            jQuery("img#jsvm_popup_cross").click(function () {
                jsvehiclemanagerClosePopup();
            });
            jQuery("div#jsvehiclemanager-popup").slideDown();
            jsvehiclemanagerPopupLink();
            //this line is added to resolve remaining credits issue in popup
            jQuery("input[type='radio'].jsvm_checkboxes").prop("checked", true);
            jQuery("input[type='radio'].jsvm_checkboxes").change(function (e) {
                setRemaingCredits();
            });
        }
        jsvm_hideloading();
    });
}

function jsvehiclemanagerPopupResumeFormProceeds(actionid) {
    if (actionid == -1) {
        jQuery('input[type=radio].jsvm_checkboxes').each(function () {
            if (this.checked) {
                creditid = parseInt(jQuery(this).val());
            }
        });
    } else {
        creditid = actionid;
    }
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0){
        alert(common.insufficient_credits);
        return;
    }
    jQuery("input#creditid").val(creditid);
    jQuery("div#jsvehiclemanager-popup").slideUp();
    jQuery("div#jsvehiclemanager-popup-background").hide();
}

function jsvehiclemanagerPopupResumeFormProceedsAdmin(actionid, payment) {
    if(payment === undefined){
        payment = 0;
    }
    if (actionid == -1) {
        jQuery('input[type=radio].jsvm_checkboxes').each(function () {
            if (this.checked) {
                creditid = parseInt(jQuery(this).val());
            }
        });
    } else {
        creditid = actionid;
    }
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0 && payment == 1){
        alert(common.insufficient_credits);
        return;
    }
    jQuery("input#jsvm_payment").val(payment);
    jQuery("input#creditid").val(creditid);
    jQuery("div#jsvehiclemanager-popup").slideUp();
    jQuery("div#jsvehiclemanager-popup-background").hide();
}

function jsvehiclemanagerPopupFormProceeds(formid, actionid) {
    if (actionid == -1) {
        jQuery('input[type=radio].jsvm_checkboxes').each(function () {
            if (this.checked) {
                creditid = parseInt(jQuery(this).val());
            }
        });
    } else {
        creditid = actionid;
    }
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0){
        alert(common.insufficient_credits);
        return;
    }
    jQuery("input#creditid").val(creditid);
    jQuery("div#jsvehiclemanager-popup").slideUp();
    jQuery("div#jsvehiclemanager-popup-background").hide();
    jQuery("form#" + formid).submit();
}

function jsvehiclemanagerPopupFormProceedsAdmin(formid, actionid, payment) {
    if(payment === undefined){
        payment = 0;
    }
    if (actionid == -1) {
        jQuery('input[type=radio].jsvm_checkboxes').each(function () {
            if (this.checked) {
                creditid = parseInt(jQuery(this).val());
            }
        });
    } else {
        creditid = actionid;
    }
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0 && payment == 1){
        alert(common.insufficient_credits);
        return;
    }
    jQuery("input#jsvm_payment").val(payment);
    jQuery("input#creditid").val(creditid);
    jQuery("div#jsvehiclemanager-popup").slideUp();
    jQuery("div#jsvehiclemanager-popup-background").hide();
    jQuery("form#" + formid).submit();
}

function getShortlistViewByVehicleId(vehicleid) {
    var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    if(isPluginCall == false){
        jQuery("div#jsvm_jsauto-popup-background").show();
        jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'shortlist', task: 'getShortlistViewByVehicleId', vehicleid: vehicleid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                var d = jQuery.parseJSON(data);
                jQuery("div#jsvehiclemanager-listpopup span.jsvm_popup-title span.jsvm_title").html(d.title);
                jQuery("div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea").html(d.content);
                jQuery("div#jsvehiclemanager-listpopup").slideDown();
            }
        });    
    }else{
        jQuery("div#jsvm_plg-shortlist-pop-transparent").slideDown();
        jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'shortlist', task: 'getShortlistViewByVehicleId', vehicleid: vehicleid,isPluginCall:isPluginCall, wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                var d = jQuery.parseJSON(data);
                jQuery("div#jsvehiclemanager-shortlist-content").html(d.content);
            }
        });    
    }
    
}

function setrating(src, newrating) {
    jQuery("#" + src).width(parseInt(newrating * 20) + '%');
}

function saveVehicleShortlist() {
    var vehicleid = jQuery("input#jsvm_vehicleid").val();
    var slid = jQuery("input#jsvehiclemanagerid").val();
    var comments = jQuery("textarea#jsvehiclemanagercomment").val();
    rating = jQuery('#jsvm_rating_' + vehicleid).width();
    rateintvalue = parseInt(rating);
    rate = rateintvalue / 20;
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'shortlist', task: 'saveVehicleShortlist', vehicleid: vehicleid, comments: comments, rate: rate, slid: slid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            console.log(data);
            jQuery("div.jsvm_quickviewbutton").html(data); //retuen value
        }
    });
}

function getTellaFriend(vehicleid) {
    var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    if(isPluginCall == true){
        jQuery("div#jsvm_plg-tellfriend-pop-transparent").slideDown();
        jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'tellafriend', task: 'getTellaFriend', vehicleid: vehicleid,isPluginCall:isPluginCall, wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                var d = jQuery.parseJSON(data);
                jQuery("#vehicletitle").val(d.content);
                jQuery("#yourname").val('');
                jQuery("#youremail").val('');
                jQuery("#femail1").val('');
                jQuery("#femail2").val('');
                jQuery("#femail3").val('');
                jQuery("#message").val('');
            }
        });
    }else{
        jQuery("div#jsvm_jsauto-popup-background").show();
        jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'tellafriend', task: 'getTellaFriend', vehicleid: vehicleid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
            if (data) {
                var d = jQuery.parseJSON(data);
                jQuery("div#jsvehiclemanager-listpopup span.jsvm_popup-title span.jsvm_title").html(d.title);
                jQuery("div#jsvehiclemanager-listpopup div.jsvm_jsauto-contentarea").html(d.content);
                jQuery("div#jsvehiclemanager-listpopup").slideDown();
            }
        });
    }
    
}

function emailverify(email) {
    var emailParts = email.toLowerCase().split('@');
    if (emailParts.length == 2) {
        regex = /^[a-zA-Z0-9.!#$%&‚Äô*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        return regex.test(email)
    }
    return false;
}

function getDataForDepandantField(parentf, childf, type) {
    if (type == 1) {
        var val = jQuery("select#" + parentf).val();
    } else if (type == 2) {
        var val = jQuery("input[name=" + parentf + "]:checked").val();
    }
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'fieldordering', task: 'DataForDepandantField', fvalue: val, child: childf, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            var d = jQuery.parseJSON(data);
           // jQuery("select#" + childf).replaceWith(d);//dependent field issue showing two combos
           jQuery("select#" + childf).html(d);
        }
    });
}

function sendEmailToFriend() {
    var yourname = jQuery("input#jsvm_yourname").val();
    if (yourname == '') {
        jQuery("input#jsvm_yourname").css({"border": "1px solid red"}).focus();
        return false;
    }
    var youremail = jQuery("input#jsvm_youremail").val();
    if (youremail == '' || emailverify(youremail) == false) {
        jQuery("input#jsvm_youremail").css({"border": "1px solid red"}).focus();
        return false;
    }
    var femail1 = jQuery("input#jsvm_femail1").val();
    if (femail1 == '' || emailverify(femail1) == false) {
        jQuery("input#jsvm_femail1").css({"border": "1px solid red"}).focus();
        return false;
    }
    var femail2 = jQuery("input#jsvm_femail2").val();
    if (femail2 != '' && emailverify(femail2) == false) {
        jQuery("input#jsvm_femail2").css({"border": "1px solid red"}).focus();
        return false;
    }
    var femail3 = jQuery("input#jsvm_femail3").val();
    if (femail3 != '' && emailverify(femail3) == false) {
        jQuery("input#jsvm_femail3").css({"border": "1px solid red"}).focus();
        return false;
    }
    var femail4 = jQuery("input#jsvm_femail4").val();
    if (femail4 != '' && emailverify(femail4) == false) {
        jQuery("input#jsvm_femail4").css({"border": "1px solid red"}).focus();
        return false;
    }
    var femail5 = jQuery("input#jsvm_femail5").val();
    if (femail5 != '' && emailverify(femail5) == false) {
        jQuery("input#jsvm_femail5").css({"border": "1px solid red"}).focus();
        return false;
    }
    var message = jQuery("textarea#jsvm_message").val();
    if (message == '') {
        jQuery("textarea#jsvm_message").css({"border": "1px solid red"}).focus();
        return false;
    }
    var vehicletitle = jQuery("input#jsvm_vehicletitle").val();
    var vehicleid = jQuery("input#jsvm_vehicleid").val();
    jQuery.post(common.ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'tellafriend', task: 'sendmailtofriend', yourname: yourname, youremail: youremail, message: message, femail1: femail1, femail2: femail2, femail3: femail3, femail4: femail4, femail5: femail5, vehicletitle: vehicletitle, vehicleid: vehicleid, wpnoncecheck:common.wp_vm_nonce}, function (data) {
        if (data) {
            jQuery("div.jsvm_quickviewbutton").html(data); //retuen value
        }
    });
}

function validateRemaingCredits(){
    var remaingcredits = jQuery('span#jsvm_remaing-credits').html();
    remaingcredits = parseInt(remaingcredits);
    if(remaingcredits < 0){
        alert(common.insufficient_credits);
        return false;
    }
    return true;
}

function deleteCutomUploadedFile (field1) {
    jQuery("input#"+field1).val(1);
    jQuery("span."+field1).hide();
    
}

function fillSpaces(string) {
    string = string.replace(" ", "%20");
    return string;
}

function cm_clear_tellfriend_popup_data(){
    jQuery("#jsvm_yourname").val('');
    jQuery("#jsvm_youremail").val('');
    jQuery("#jsvm_femail1").val('');
    jQuery("#jsvm_femail2").val('');
    jQuery("#jsvm_message").val('');
    try{
        grecaptcha.reset(tafcaptcha);
    }
    catch(e){}
}

function cm_clear_testdrive_popup_data(){
    jQuery("#jsvm_stdname").val('');
    jQuery("#jsvm_stdemail").val('');
    jQuery("#jsvm_stdphonenumber").val('');
    jQuery("#jsvm_stdday").val('');
    jQuery("#jsvm_stdtime").val('');
    try{
        grecaptcha.reset(stdcaptcha);
    }
    catch(e){}
}

function cm_clear_offer_popup_data(){
    jQuery("#jsvm_oapname").val('');
    jQuery("#jsvm_oapemail").val('');
    jQuery("#jsvm_oapphonenumber").val('');
    jQuery("#jsvm_offeredprice").val('');
    jQuery("#jsvm_commentscondition").val('');
    try{
        grecaptcha.reset(oapcaptcha);
    }
    catch(e){}
}


/*common popup funcitons*/

var jsvehiclemanager_pop_vehicleid;

function showPopup(contentWrapper){
        var isPluginCall = true;
        jQuery('div#jsvehiclemanager-ctn-'+contentWrapper).show();

        if( contentWrapper == 'short' ){
            getShortlistViewByVehicleId( jsvehiclemanager_pop_vehicleid, isPluginCall );
        }else if( contentWrapper == 'friend' ){
            getTellaFriend( jsvehiclemanager_pop_vehicleid, isPluginCall );
            //if previously input field were highlighted due to validation erro, reset them to normal
            jQuery("input#yourname").css('border','');
            jQuery("input#youremail").css('border','');
            jQuery("input#femail1").css('border','');
            jQuery("input#femail2").css('border','');
            jQuery("input#femail3").css('border','');
            jQuery("textarea#message").css('border','');
            //clear recaptcha previously filled, if enabled
            if( typeof recaptcha_friend!='undefined' && recaptcha_friend!=null ){
                grecaptcha.reset( recaptcha_friend );
            }
        }else if( contentWrapper == 'offer' ){
            //if previously input field were highlighted due to validation erro, reset them to normal
            jQuery("input#jsvm_oapname").css('border','');
            jQuery("input#jsvm_oapemail").css('border','');
            jQuery("input#jsvm_offeredprice").css('border','');
            //clear recaptcha previously filled, if enabled
            if( typeof recaptcha_offer!='undefined' && recaptcha_offer!=null ){
                grecaptcha.reset( recaptcha_offer );
            }
        }else if( contentWrapper == 'drive' ){
            //if previously input field were highlighted due to validation erro, reset them to normal
            jQuery("input#jsvm_stdname").css('border','');
            jQuery("input#jsvm_stdemail").css('border','');
            jQuery("input#jsvm_stdday").css('border','');
            //clear recaptcha previously filled, if enabled
            if( typeof recaptcha_drive!='undefined' && recaptcha_drive!=null ){
                grecaptcha.reset( recaptcha_drive );
            }
        }else if( contentWrapper == 'drive' ){
            jQuery("input#jsvm_stdname").css('border','');
            jQuery("input#jsvm_stdemail").css('border','');
            jQuery("input#jsvm_stdday").css('border','');
        }else if(contentWrapper == 'finance'){

        }

        jQuery('div#jsvehiclemanager-pop-transparent').slideDown();
        jQuery('div#jsvehiclemanager-pop-transparent div.popup').remove();
    }

    function closePopup(){        
        jQuery('div#jsvehiclemanager-pop-transparent').slideUp(function(){
            jQuery('div.jsvehiclemanager-pop-body-content-hid').hide();
        }); 
    }
    function closePopupFromOverlay(event){
        if( event.target.id == "jsvehiclemanager-pop-transparent" ){
            closePopup();
        }
    }

     
    function storeVehicleShortlist(){
        var isPluginCall = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
        if(isPluginCall == true){
            var srtcomments = jQuery("textarea#jsvm_srtcomments").val();
            var vehicleid = jsvehiclemanager_pop_vehicleid;
            var slid = jQuery("input#jsvehiclemanagerid").val();
            var rating = document.getElementById("rating_"+vehicleid).style.width;
          if(srtcomments!='' || rating!='0%' )//dont submitwithout entering data 
          {
            rating = parseInt(rating);
            rating = rating / 20;
            jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").show();
            jQuery.post(common.ajaxurl ,{action: "jsvehiclemanager_ajax",jsvmme: "shortlist",task: "saveVehicleShortlist",vehicleid: vehicleid,comments: srtcomments,rate: rating,slid: slid,isPluginCall:isPluginCall, wpnoncecheck:common.wp_vm_nonce} , function (data) {
               if (data) {
                    var html =  jQuery.parseJSON(data);
                    jQuery("div#jsvm_shortlist").find("img.jsvm_multipop-loading-gif").after(html);
                    jQuery("div#jsvm_shortlist").find("img.jsvm_multipop-loading-gif").hide();
                    jQuery("textarea#jsvm_srtcomments").val("");
                    jQuery("li.current-rating").css("width", "0%");
                    jQuery("input#jsvm_srtid").val("");
                    jQuery('#jsvehiclemanager-ctn-short').append(html);
                    jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").hide();
               }
            });
           }
           else
           {
            alert('Please first fill the data ');
           }

        }else{
            var srtcomments = jQuery("textarea#jsvm_srtcomments").val();
            var vehicleid = jQuery("input#jsvm_srtvehicleid").val();

            var slid = jQuery("input#jsvm_srtid").val();
            var shortliststars = jQuery("input#jsvm_shortliststars").val();
             if(srtcomments!='' || shortliststars!='0')
             {
                jQuery("div#jsvm_shortlist").find("div.jsvm_cm-multi-popup-overlay").show();
                jQuery("div#jsvm_shortlist").find("img.jsvm_multipop-loading-gif").show();
                jQuery.post(common.ajaxurl ,{action: "jsvehiclemanager_ajax",jsvmme: "shortlist",task: "saveVehicleShortlist",vehicleid: vehicleid,comments: srtcomments,rate: shortliststars,slid: slid, wpnoncecheck:common.wp_vm_nonce} , function (data) {
                    if (data) {
                        var html =  jQuery.parseJSON(data);

                        jQuery("div#jsvm_shortlist").find("img.jsvm_multipop-loading-gif").after(html);
                        jQuery("div#jsvm_shortlist").find("img.jsvm_multipop-loading-gif").hide();
                        jQuery("textarea#jsvm_srtcomments").val("");
                        jQuery("li.current-rating").css("width", "0%");
                        jQuery("input#jsvm_srtid").val("");
                    }
                }); 
             }
             else
             {
               alert('Please first fill the data ');
             }
           
        }
    }



    function sendEmailToFriends(showCaptcha){
        var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
        if( isPluginCall == true ){
            if( showCaptcha == 1){
                var captcharesponce = grecaptcha.getResponse(recaptcha_friend);
            }else{
                var captcharesponce = "";
            }
            var yourname = jQuery("input#yourname").val();
            if (yourname == "") {
                jQuery("input#yourname").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#yourname").css({"border": ''});
            }
            var youremail = jQuery("input#youremail").val();
            if (youremail == "" || emailverify(youremail) == false) {
                jQuery("input#youremail").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#youremail").css({"border": ''});
            }
            var femail1 = jQuery("input#femail1").val();
            if (femail1 == "" || emailverify(femail1) == false) {
                jQuery("input#femail1").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#femail1").css({"border": ''});
            }
            var femail2 = jQuery("input#femail2").val();
            if (femail2 != "" && emailverify(femail2) == false) {
                jQuery("input#femail2").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#femail2").css({"border": ''});
            }
            var femail3 = jQuery("input#femail3").val();
            if (femail3 != "" && emailverify(femail3) == false) {
                jQuery("input#femail3").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("input#femail3").css({"border": ''});
            }
            var message = jQuery("textarea#message").val();
            if (message == "") {
                jQuery("textarea#message").css({"border": "1px solid red"}).focus();
                return false;
            }
            else{
                jQuery("textarea#message").css({"border": ''});
            }
            var vehicletitle = jQuery("input#vehicletitle").val();
            var vehicleid = jsvehiclemanager_pop_vehicleid;
            jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").show();
            jQuery.post(common.ajaxurl, {action: "jsvehiclemanager_ajax",jsvmme: "tellafriend",task: "sendmailtofriend",yourname: yourname,youremail: youremail,message: message,femail1: femail1,femail2: femail2,femail3: femail3,vehicletitle: vehicletitle,vehicleid: vehicleid,captcha_responce: captcharesponce,isPluginCall:isPluginCall, wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    var html =  jQuery.parseJSON(data);
                    jQuery('#jsvehiclemanager-ctn-friend').append(html);
                    jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").hide();
                }
            });
        }else{
            if( showCaptcha == 1){
                var captcharesponce = grecaptcha.getResponse(tafcaptcha);
            }else{
                var captcharesponce = "";                
            }
            var yourname = jQuery("input#jsvm_yourname").val();
            if (yourname == "") {
                jQuery("input#jsvm_yourname").css({"border": "1px solid red"}).focus();
                return false;
            }
            var youremail = jQuery("input#jsvm_youremail").val();
            if (youremail == "" || emailverify(youremail) == false) {
                jQuery("input#jsvm_youremail").css({"border": "1px solid red"}).focus();
                return false;
            }
            var femail1 = jQuery("input#jsvm_femail1").val();
            if (femail1 == "" || emailverify(femail1) == false) {
                jQuery("input#jsvm_femail1").css({"border": "1px solid red"}).focus();
                return false;
            }
            var femail2 = jQuery("input#jsvm_femail2").val();
            if (femail2 != "" && emailverify(femail2) == false) {
                jQuery("input#jsvm_femail2").css({"border": "1px solid red"}).focus();
                return false;
            }
            var message = jQuery("textarea#jsvm_message").val();
            if (message == "") {
                jQuery("textarea#jsvm_message").css({"border": "1px solid red"}).focus();
                return false;
            }
            var vehicletitle = jQuery("input#jsvm_vehicletitle").val();
            var vehicleid = jQuery("input#jsvm_fevehicleid").val();
            jQuery("div#jsvm_tellafriend").find("div.jsvm_cm-multi-popup-overlay").show();
            jQuery("div#jsvm_tellafriend").find("img.jsvm_multipop-loading-gif").show();
            jQuery.post(common.ajaxurl, {action: "jsvehiclemanager_ajax",jsvmme: "tellafriend",task: "sendmailtofriend",yourname: yourname,youremail: youremail,message: message,femail1: femail1,femail2: femail2,vehicletitle: vehicletitle,vehicleid: vehicleid,captcha_responce: captcharesponce, wpnoncecheck:common.wp_vm_nonce}, function (data) {
                if (data) {
                    var html =  jQuery.parseJSON(data);
                    jQuery("div#jsvm_tellafriend").find("img.jsvm_multipop-loading-gif").after(html);
                    jQuery("div#jsvm_tellafriend").find("img.jsvm_multipop-loading-gif").hide();
                }
            });
        }
    }

    function calculateVehicleFinance(){
        var isPluginCall = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
        jQuery("div#jsvm_finance_monthlypayment").html("");
        jQuery("div#jsvm_finance_interestpayment").html("");
        jQuery("div#jsvm_finance_totalpayment").html("");
        if(isPluginCall == true){
            var vehicleid = jsvehiclemanager_pop_vehicleid;
        }else{
            var vehicleid = jQuery("input#jsvm_fcvehicleid").val();
        }
        var financeperiod = jQuery("input#financeperiod").val();
        var vehicleprice = jQuery("input#vehicleprice").val();
        var interestrate = jQuery("input#interestrate").val();
        
        var downpayment = jQuery("input#downpayment").val();
        if(downpayment == ""){
            downpayment = 0;
        }
        
        if (interestrate == "") {
            jQuery("input#interestrate").css({"border": "1px solid red"}).focus();
            return false;
        }else{
            jQuery("input#interestrate").css({"border": ''});
        }

        if (vehicleprice == "") {
            jQuery("input#vehicleprice").css({"border": "1px solid red"}).focus();
            return false;
        }else{
            jQuery("input#vehicleprice").css({"border": ''});
        }
        

        if (financeperiod == "") {
            jQuery("input#financeperiod").css({"border": "1px solid red"}).focus();
            return false;
        }else{
            jQuery("input#financeperiod").css({"border": ''});
        }

        
        if(isPluginCall == true){
            jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").show();
        }else{
            jQuery("div#jsvm_financialcalculator").find("div.jsvm_cm-multi-popup-overlay").show();
            jQuery("div#jsvm_financialcalculator").find("img.jsvm_multipop-loading-gif").show();
        }
        jQuery.post(common.ajaxurl ,{action: "jsvehiclemanager_ajax",jsvmme: "financeplan",task: "calculateVehicleFinance",vehicleid: vehicleid,downpayment: downpayment,financeperiod: financeperiod ,vehicleprice: vehicleprice ,interestrate: interestrate ,isPluginCall:isPluginCall, wpnoncecheck:common.wp_vm_nonce} , function (data) {
           if (data) {
                var html =  jQuery.parseJSON(data);
                jQuery("div#jsvehiclemanager-pop-finance-detail").css("display","inline-block");
                jQuery("div#jsvm_finance_monthlypayment").append(html['monthly']);
                jQuery("div#jsvm_finance_interestpayment").append(html['interestpayment']);
                jQuery("div#jsvm_finance_totalpayment").append(html['total']);
                if(isPluginCall == true){
                    jQuery("div.jsvehiclemanager-pop-loading").css("display","none");    
                }else{
                    jQuery("div#jsvm_financialcalculator").find("div.jsvm_cm-multi-popup-overlay").hide();
                    jQuery("div#jsvm_financialcalculator").find("img.jsvm_multipop-loading-gif").hide();
                }
            }
        });

    }


/*common popup funcitons end*/


