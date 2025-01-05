<!-- <script type="text/javascript" src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."/includes/js/select2.min.js" ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."/includes/css/select2.min.css" ?>"> -->
<?php
    wp_enqueue_style('select2-css', JSVEHICLEMANAGER_PLUGIN_URL . '/includes/css/select2.min.css');
    wp_enqueue_script('select2-css-js', JSVEHICLEMANAGER_PLUGIN_URL.'/includes/js/select2.min.js');
?>
<script type="text/javascript">

	/*
	jsvehiclemanager_pop_vehicleid
	global variable defined with popup functions in common.js
	*/

    var ajaxurl = '<?php echo esc_url(admin_url("admin-ajax.php")); ?>';
    var isPluginCall  = true;
    var multicities = <?php echo isset(jsvehiclemanager::$_data['filter']['registrationcitypopup']) ? jsvehiclemanager::$_data['filter']['registrationcitypopup'] : '""'; ?>;
    var multicities1 = <?php echo isset(jsvehiclemanager::$_data['filter']['locationcitypopup']) ? jsvehiclemanager::$_data['filter']['locationcitypopup'] : '""'; ?>;

	function showPopupFromVehicleList(contentWrapper){
        var vehicleid = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 0;

		jsvehiclemanager_pop_vehicleid = vehicleid;
		showPopup( contentWrapper );
	}

	jQuery(window).scroll(function () {
        if (jQuery(window).scrollTop() > ( Math.abs(jQuery(window).height() - jQuery("div#jsvehiclemanager-wrapper").height()-200))) {
	        var scrolltask = jQuery("div#jsvehiclemanager-wrapper").find("a.jsvehiclemanager-scrolltask").attr("data-scrolltask");
	        var offset = jQuery("div#jsvehiclemanager-wrapper").find("a.jsvehiclemanager-scrolltask").attr("data-offset");
	        var showmore = jQuery("div#jsvehiclemanager-wrapper").find("a.jsvehiclemanager-scrolltask").attr("data-showmore");
	        if(showmore == 1){
	            return;
	        }
            if (scrolltask != null && scrolltask != "" && scrolltask != "undefined") {
	            jQuery("div#jsvehiclemanager-wrapper").find("a.jsvehiclemanager-scrolltask").remove();
	            var s_ajaxurl = ajaxurl + "?pagenum=" + offset;
	            <?php
	            if(isset(jsvehiclemanager::$_data["filter"]))  {
                    echo 'var searchcriteria = "'.esc_html(jsvehiclemanager::bjencode(jsvehiclemanager::$_data["filter"])).'";';
                }
	            ?>
	            jQuery('div.jsvehiclemanager_light-box-loading').show();
	            jQuery.get(s_ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "vehicle", task: scrolltask,ajaxsearch:'',isPluginCall:true,wpnoncecheck:common.wp_vm_nonce
		        <?php
	            if(isset(jsvehiclemanager::$_data["filter"]))  {
                    echo ',ajaxsearch:searchcriteria';
                }
                if(isset(jsvehiclemanager::$_data["sellerid"]) && is_numeric(jsvehiclemanager::$_data["sellerid"])) {
                    echo ',sellerid:"'.esc_html(jsvehiclemanager::$_data["sellerid"]).'"';
                }
	            ?>
	        	}, function (data) {
                    jQuery("div#jsvehiclemanager-wrapper").find("#jsvehiclemanager-content").append(data);
	                jQuery('div.jsvehiclemanager_light-box-loading').hide();
	            });
	        }
	    }
    });

    function showmoreautoz(){
        var isPluginCall = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    	if( isPluginCall == true ){
    		jQuery("div#jsvehiclemanager-wrapper").find("a.jsvehiclemanager-scrolltask").attr("data-showmore","0");
	        jQuery(window).scroll();
	        jQuery("a.jsvehiclemanager-plg-showmoreautoz").remove();
    	}
    	else{
    		jQuery("div#jsvm_cm-autoscroll-vehicles").find("a.jsvm_scrolltask").attr("data-showmore","0");
            jQuery(window).scroll();
            jQuery("a#jsvm_showmoreautoz").remove();
    	}

    }

    var allVehicleImagePaths=Array();
    /* Array(
    	vehicle-id-x = Array( index-of-currnet-displaying-image  , Array( Images... ) )
    	.
    	.
    	.
    )*/

    function showImageSlide(vehicleid){
        var backward = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

    	if( typeof allVehicleImagePaths[vehicleid] === 'undefined' ){
    		var currentImageIndex=0;
    		jQuery.get(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "vehicle", task:"getVehicleImagesByVehicleIdAJAX",vehicleid:vehicleid,wpnoncecheck:common.wp_vm_nonce},function(data){
    			var images = jQuery.parseJSON( data ).image;
    			allVehicleImagePaths[vehicleid] = Array(currentImageIndex,images);
    			showImageSlide(vehicleid,backward);
    		});
    	}
    	else{
    		if(backward == true){
	        	var prvIndex = allVehicleImagePaths[vehicleid][0] - 1;
	        	if(typeof allVehicleImagePaths[vehicleid][1][prvIndex] === 'undefined' )
	        		allVehicleImagePaths[vehicleid][0] = allVehicleImagePaths[vehicleid][1].length - 1;
	        	else
	        		allVehicleImagePaths[vehicleid][0] = prvIndex;
	        }
	        else{
	        	var nextIndex = allVehicleImagePaths[vehicleid][0] + 1;
	        	if(typeof allVehicleImagePaths[vehicleid][1][nextIndex] === 'undefined' )
	        		allVehicleImagePaths[vehicleid][0] = 0;
	        	else
	        		allVehicleImagePaths[vehicleid][0] = nextIndex;
	        }

    		var index = allVehicleImagePaths[vehicleid][0];
    		var imagePath = allVehicleImagePaths[vehicleid][1][index].main;
	        jQuery("#jsvehiclemanager-big-image-"+vehicleid).attr('src',imagePath);
    	}

    }

    function speedmeterchange(obj){
        var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
        if(isPluginCall == true){
            var selectedValue = jQuery(obj).val();
            var mileagesSymbols = jQuery(obj).attr("data-symbols");
            if(mileagesSymbols){
                var array = mileagesSymbols.split(",");
                for (var i = 0; i < array.length; i++) {
                    var arr = array[i].split(":");
                    if(arr[0] == selectedValue){
                        // Update fields label
                        jQuery("div.jsvm_speedometer").find("input.jsvm_to").addClass("jsvehiclemanager-lenghtless");
                        jQuery("div.jsvm_speedometer").find("span.jsvm_speedometer").css("display","inline-block");
                        jQuery("div.jsvm_speedometer").find("span.jsvm_speedometer").html(arr[1]);
                        break;
                    }
                }
            }
        }
        else{
            var selectedValue = jQuery(obj).val();
            var mileagesSymbols = jQuery(obj).attr("data-symbols");
            if(mileagesSymbols){
                var array = mileagesSymbols.split(",");
                for (var i = 0; i < array.length; i++) {
                    var arr = array[i].split(":");
                    if(arr[0] == selectedValue){
                        // Update fields label
                        jQuery("div.jsvm_speedometer").find("input.jsvm_to").addClass("jsvm_lesslenght");
                        jQuery("div.jsvm_speedometer").find("span.jsvm_speedometer").css("display","inline-block");
                        jQuery("div.jsvm_speedometer").find("span.jsvm_speedometer").html(arr[1]);
                        break;
                    }
                }
            }
        }
    }

    function getTokenInput(){
        var vehicleArray = "<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname"); ?>";
        jQuery("#registrationcity").tokenInput(vehicleArray, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo esc_js(__("Type In A Search Term", "js-vehicle-manager")); ?>",
            noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager")); ?>",
            searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager")); ?>",
            prePopulate: multicities,
            onResult: function(item) {
                if (jQuery.isEmptyObject(item)){
                    return [{id:0, name: jQuery("tester").text()}];
                } else {
                    //add the item at the top of the dropdown
                    item.unshift({id:0, name: jQuery("tester").text()});
                    return item;
                }
            },
        });
        jQuery("#locationcity").tokenInput(vehicleArray, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo esc_js(__("Type In A Search Term", "js-vehicle-manager")); ?>",
            noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager")); ?>",
            searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager")); ?>",
            prePopulate: multicities1,
            onResult: function(item) {
                if (jQuery.isEmptyObject(item)){
                    return [{id:0, name: jQuery("tester").text()}];
                } else {
                    //add the item at the top of the dropdown
                    item.unshift({id:0, name: jQuery("tester").text()});
                    return item;
                }
            },
        });
    }

    function getmodels(){
        jQuery("img#makemodelloading-gif").show();
        var val = jQuery("select[data-makeid=1]").val();
        jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "model", task: "getVehiclesModelsbyMakeMulti", makeid: val,wpnoncecheck:common.wp_vm_nonce}, function(data){
                if (data){
                    jQuery("select[data-modelid=1]").select2('destroy');
                    jQuery("select[data-modelid=1]").html(data); //retuen value
                    jQuery("select[data-modelid=1]").select2();
                }
                jQuery("img#makemodelloading-gif").hide();
            });
    }

    /* compare functions */

    jQuery(document).delegate("a.jsvehiclemanager_cmp-btn","click",function(){

        var vehid = parseInt(jQuery(this).attr("data-vehid"));
        if( jQuery(this).hasClass('jsvehiclemanager_cmp_selected') ){ //remove
            removeVehicleFromSession(vehid);
            removeCompareCss(jQuery(this));
        }
        else{ //add
            var nSelectedVehicles = jQuery('a.jsvehiclemanager_cmp_selected').length;
            if( nSelectedVehicles < 3 ){
                addVehicleToSession(vehid);
                addCompareCss(jQuery(this));
            }else{
                alert("<?php echo __("Can not select more vehicles","js-vehicle-manager"); ?>");
            }
        }
        showHideGotoCompareLink();
    });

    function addVehicleToSession(vehid){
         jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "comparevehicle", task: "getVehicleDataForComparePopup", vehicleid: vehid,wpnoncecheck:common.wp_vm_nonce});
    }
    function removeVehicleFromSession(vehid){
        jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "comparevehicle", task: "removeCompareVehicleFromSession", vehicleid: vehid,wpnoncecheck:common.wp_vm_nonce});
    }

    function addCompareCss(anchor){
        var vehid = parseInt(jQuery(anchor).attr("data-vehid"));

            jQuery(anchor).find("img").attr("title","<?php echo esc_js(__("Remove From Compare","js-vehicle-manager")); ?>");
            jQuery(anchor).addClass('jsvehiclemanager_cmp_selected');
            jQuery('div.jsvehiclemanager_vehicle_wrapper:has(.jsvehiclemanager_cmp_selected[data-vehid='+vehid+'])').addClass('jsvehiclemanager_cmp_sel_wrapper');

    }
    function removeCompareCss(anchor){
        var vehid = parseInt(jQuery(anchor).attr("data-vehid"));
        jQuery(anchor).find("img").attr("title","<?php echo esc_js(__("Add to Compare","js-vehicle-manager")); ?>");
            jQuery('div.jsvehiclemanager_vehicle_wrapper:has(.jsvehiclemanager_cmp_selected[data-vehid='+vehid+'])').removeClass('jsvehiclemanager_cmp_sel_wrapper');
            jQuery(anchor).removeClass('jsvehiclemanager_cmp_selected');
    }

    function showHideGotoCompareLink(){
        var nSelectedVehicles = jQuery('a.jsvehiclemanager_cmp_selected').length;
        if(nSelectedVehicles > 0){
            jQuery('a.jsvehiclemanager-cmp-goto-compare').show();
        }
        else{
            jQuery('a.jsvehiclemanager-cmp-goto-compare').hide();
        }
    }


    /* end compare functions */

    var isComboStyleChanged=false;

    function showRefineSearchPopup(){
    	//jQuery("div#jsjob-popup-background").show();
        jQuery("div#jsvehiclemanager-pop-transparent-refine").slideDown('slow');
            if(isComboStyleChanged == false){

                jQuery(".jsvm_cm_select2").select2({
                    width: 'resolve'
                });
                isComboStyleChanged = true;
            }
    }

    function closeRefineSearchPopup(){
    	jQuery("div#jsvehiclemanager-pop-transparent-refine").slideUp('slow');
    }

    jQuery(document).ready(function(){
        jQuery("div#refineSearch").click(function () {
            showRefineSearchPopup();
        });
        getTokenInput();
        jQuery(".jsvm_cm_select2").select2({});
    });

    function restFrom(){
        var form = jQuery("form#autoz_form, form#jsvm_autoz_form, form#jsvehiclemanager_autoz_form");
        form.find("input[type=text], input[type=email], input[type=password], input[type=hidden], textarea").val("");
        form.find("input:checkbox").removeAttr("checked");
        form.find("select").val("");
        form.find("input[type=\"radio\"]").prop("checked", false);
        form.submit();
    }

    function storeVehicleAlert(){
        var theme_call = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
        var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")) ;?>";
        var email = jQuery("input#jsvm_alertemail").val();
        var type = jQuery("select#jsvm_alerttype").val();
        if(email == "" || type == ""){
            alert("<?php echo esc_js(__("Please fill fields" , "js-vehicle-manager"));?>");
            return false;
        }else{
            if( ! emailverify(email)){
                alert("<?php echo esc_js(__("Invalid email address" , "js-vehicle-manager"));?>");
                return false;
            }
        }
        var searchcriteria = jQuery("input#searchcriteria").val();
        if(theme_call == 0){
            jQuery("div#jsvm_vehiclealert").find("div.jsvm_cm-multi-popup-overlay").show();
            jQuery("div#jsvm_vehiclealert").find("div.jsvm_cm-modal-wrp").append('<img class="jsvm_multipop-loading-gif" src="<?php echo esc_attr(CAR_MANAGER_IMAGE).'/load.gif';?>"/>');
        }else{
            jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").show();
        }
        jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "vehiclealert", task: "storeVehicleAlert", email: email, alerttype:type ,criteria: searchcriteria,themecall:theme_call,wpnoncecheck:common.wp_vm_nonce}, function(data){
            if (data){
                if(theme_call == 0){
                        var html =  jQuery.parseJSON(data);
                        jQuery("div#jsvm_vehiclealert").find("img.jsvm_multipop-loading-gif").replaceWith(html);
                }else{
                    var html =  jQuery.parseJSON(data);
                    jQuery('#jsvehiclemanager-ctn-alert').append(html);
                    jQuery("div#jsvehiclemanager-pop-transparent").find("div.jsvehiclemanager-pop-loading").hide();
                }
            }
        });
    }


</script>
