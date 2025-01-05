<?php
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>
<input type="hidden" id="jsvm_default_longitude" name="default_longitude" value="<?php echo esc_attr((isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='' ) ? jsvehiclemanager::$_data[0]->longitude : jsvehiclemanager::$_config['default_longitude']); ?>"/>
<input type="hidden" id="jsvm_default_latitude" name="default_latitude" value="<?php echo esc_attr((isset(jsvehiclemanager::$_data[0]->latitude) && jsvehiclemanager::$_data[0]->latitude !='' ) ? jsvehiclemanager::$_data[0]->latitude : jsvehiclemanager::$_config['default_latitude']); ?>"/>
<input type="hidden" id="jsvm_default_longitude1" name="default_longitude1" value="<?php echo esc_attr((isset(jsvehiclemanager::$_data[6]->longitude) && jsvehiclemanager::$_data[6]->longitude !='' ) ? jsvehiclemanager::$_data[0]->longitude : jsvehiclemanager::$_config['default_longitude']); ?>"/>
<input type="hidden" id="jsvm_default_latitude1" name="default_latitude1" value="<?php echo esc_attr((isset(jsvehiclemanager::$_data[6]->latitude) && jsvehiclemanager::$_data[6]->latitude !='' ) ? jsvehiclemanager::$_data[0]->latitude : jsvehiclemanager::$_config['default_latitude']); ?>"/>
<?php 
if((isset(jsvehiclemanager::$_data[0]->latitude) && jsvehiclemanager::$_data[0]->latitude != '') && (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude != '')) {?>
    <input type="hidden" id="jsvm_addmarker" name="addmarker" value="1"/>
<?php }else{ ?>
<input type="hidden" id="jsvm_addmarker" name="addmarker" value="0"/>
<?php } ?>
<?php 
wp_enqueue_script( 'mapAPI',$protocol.'maps.googleapis.com/maps/api/js?key='.$google_api_key);


wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', JSVEHICLEMANAGER_PLUGIN_URL . 'includes/css/jquery-ui-smoothness.css');

$dateformat = jsvehiclemanager::$_config['date_format'];
if ($dateformat == 'm/d/Y' || $dateformat == 'd/m/y' || $dateformat == 'm/d/y' || $dateformat == 'd/m/Y') {
    $dash = '/';
} else {
    $dash = '-';
}
$firstdash = strpos($dateformat, $dash, 0);
$firstvalue = substr($dateformat, 0, $firstdash);
$firstdash = $firstdash + 1;
$seconddash = strpos($dateformat, $dash, $firstdash);
$secondvalue = substr($dateformat, $firstdash, $seconddash - $firstdash);
$seconddash = $seconddash + 1;
$thirdvalue = substr($dateformat, $seconddash, strlen($dateformat) - $seconddash);
$js_dateformat = '%' . $firstvalue . $dash . '%' . $secondvalue . $dash . '%' . $thirdvalue;
$js_scriptdateformat = $firstvalue . $dash . $secondvalue . $dash . $thirdvalue;
$js_scriptdateformat = str_replace('Y', 'yy', $js_scriptdateformat);
 
?>

<?php
wp_enqueue_style('select2-css', JSVEHICLEMANAGER_PLUGIN_URL . '/includes/css/select2.min.css');
wp_enqueue_script('select2-css-js', JSVEHICLEMANAGER_PLUGIN_URL.'/includes/js/select2.min.js');
 ?>
<script type="text/javascript">
    

    function getTokenInput(){
        var urlToAjaxCall = "<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname"); ?>";
        getTokenInputLocationCity(urlToAjaxCall);
        getTokenInputRegistrationCity(urlToAjaxCall);
        getTokenInputSellerCity(urlToAjaxCall);
    }


    var map;
    var map1;
    var marker;
    var marker1;


    var multicities = "";
    var multicities1 = "";
    <?php if(isset(jsvehiclemanager::$_data[0]->regcity)): ?>
        var multicities = <?php echo jsvehiclemanager::$_data[0]->regcity; ?>;
    <?php endif; ?>

    <?php if(isset(jsvehiclemanager::$_data[0]->loccity)): ?>
        var multicities1 = <?php echo jsvehiclemanager::$_data[0]->loccity; ?>;
    <?php endif; ?>

    function getTokenInputSellerCity(urlToAjaxCall){

        jQuery("#sellercityid").tokenInput(urlToAjaxCall, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo  esc_js(__("Type In A Search Term", "js-vehicle-manager")); ?>",
            noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager")); ?>",
            searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager")); ?>",
            tokenLimit: 1,
            onResult: function(item) {
                if (jQuery.isEmptyObject(item)){
                    return [{id:0, name: jQuery("tester").text()}];
                } else {
                    //add the item at the top of the dropdown
                    item.unshift({id:0, name: jQuery("tester").text()});
                    return item;
                }
            },
            onAdd: function(item) {
                if (item.id > 0){
                    addMarkerOnMap1(item.name);
                    return;
                }

            if (item.name.search(",") == - 1) {
            var input = jQuery("tester").text();
                    alert ("<?php echo esc_js(__("Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name", "js-vehicle-manager")); ?>");
                    jQuery("#sellercityid").tokenInput("remove", item);
                    return false;
            } else{
                var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
                    jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "city", task: "savetokeninputcity", citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                    if (data){
                    try {
                    var value = jQuery.parseJSON(data);
                            jQuery("#sellercityid").tokenInput("remove", item);
                            jQuery("#sellercityid").tokenInput("add", {id: value.id, name: value.name});
                    }
                    catch (err) {
                    jQuery("#sellercityid").tokenInput("remove", item);
                            alert(data);
                    }
                    }
                    });
                }
             },onDelete: function(item){
                    if(marker1 != undefined){
                        marker1.setMap(null);
                        jQuery("input#latitude1").val("");
                        jQuery("input#longitude1").val("");
                    }
                }
           });
    }

    function getTokenInputRegistrationCity(urlToAjaxCall){

        jQuery("#regcity").tokenInput(urlToAjaxCall, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo  esc_js(__("Type In A Search Term", "js-vehicle-manager")); ?>",
            noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager")); ?>",
            searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager")); ?>",
            tokenLimit: 1,
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
            onAdd: function(item) {
                if (item.id > 0){
                    return;
                }

            if (item.name.search(",") == - 1) {
            var input = jQuery("tester").text();
                    alert ("<?php echo esc_js(__("Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name", "js-vehicle-manager")); ?>");
                    jQuery("#regcity").tokenInput("remove", item);
                    return false;
            } else{
                var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
                    jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "city", task: "savetokeninputcity", citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                    if (data){
                    try {
                    var value = jQuery.parseJSON(data);
                            jQuery("#regcity").tokenInput("remove", item);
                            jQuery("#regcity").tokenInput("add", {id: value.id, name: value.name});
                    }
                    catch (err) {
                    jQuery("#regcity").tokenInput("remove", item);
                            alert(data);
                    }
                    }
                    });
                }
             } 
           });
    }

var cityname = '';
    function getTokenInputLocationCity(urlToAjaxCall){

        jQuery("#loccity").tokenInput(urlToAjaxCall, {
            theme: "jsvehiclemanager",
            preventDuplicates: true,
            hintText: "<?php echo  esc_js(__("Type In A Search Term", "js-vehicle-manager")); ?>",
            noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager")); ?>",
            searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager")); ?>",
            prePopulate: multicities1,
            tokenLimit: 1,
            onResult: function(item) {
                if (jQuery.isEmptyObject(item)){
                    return [{id:0, name: jQuery("tester").text()}];
                } else {
                    //add the item at the top of the dropdown
                    item.unshift({id:0, name: jQuery("tester").text()});
                    return item;
                }
            },
            onAdd: function(item) {
                if (item.id > 0){
                    addMarkerOnMap(item.name);
                    cityname = item.name;
                    return;
                }

            if (item.name.search(",") == - 1) {
            var input = jQuery("tester").text();
                    alert ("<?php echo esc_js(__("Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name", "js-vehicle-manager")); ?>");
                    jQuery("#loccity").tokenInput("remove", item);
                    return false;
            } else{
                var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
                    jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "city", task: "savetokeninputcity", citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                    if (data){
                    try {
                    var value = jQuery.parseJSON(data);
                            jQuery("#loccity").tokenInput("remove", item);
                            jQuery("#loccity").tokenInput("add", {id: value.id, name: value.name});
                    }
                    catch (err) {
                    jQuery("#loccity").tokenInput("remove", item);
                            alert(data);
                    }
                    }
                    });
                }
             },onDelete: function(item){
                    if(marker != undefined){
                        marker.setMap(null);
                        jQuery("input#latitude").val("");
                        jQuery("input#longitude").val("");
                    }
                }
           });
    }

    /* Map Functions */

    function loadMap() {
        var default_latitude = document.getElementById("jsvm_default_latitude").value;
        var default_longitude = document.getElementById("jsvm_default_longitude").value;
        var latlng = new google.maps.LatLng(default_latitude, default_longitude);
        var zoom = 10;
        var myOptions = {
            zoom: zoom,
            center: latlng,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_container"), myOptions);
        if(jQuery("input#jsvm_addmarker").val() == 1){
            addMarker(latlng);
        }
        google.maps.event.addListener(map, "click", function (e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"latLng": latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addMarker(results[0].geometry.location);
            } else {
                alert("<?php esc_js(__("Geocode was not successful for the following reason", "js-vehicle-manager")); ?>" + status);
            }
            });
        });
    }

     function addMarker (latlang){
        if (marker) {
            //if marker already was created change positon
            marker.setPosition(latlang);
            map.setCenter(latlang);
            if(marker.map == null){
                marker = new google.maps.Marker({
                    position: latlang,
                    map: map,
                    center: latlang,
                    draggable: true,
                    scrollwheel: false,
                });

                marker.setMap(map);
                map.setCenter(latlang)
                marker.addListener("dblclick", function() {
                    marker.setMap(null);
                    jQuery("input#latitude").val("");
                    jQuery("input#longitude").val("");
                });
            }
        }else{
            marker = new google.maps.Marker({
                position: latlang,
                map: map,
                draggable: true,
                scrollwheel: false,
            });
            marker.setMap(map);
             map.setCenter(latlang);
            marker.addListener("dblclick", function() {
                marker.setMap(null);
                jQuery("input#latitude").val("");
                jQuery("input#longitude").val("");
            });
        }
        jQuery("input#latitude").val(marker.position.lat());
        jQuery("input#longitude").val(marker.position.lng());
    }

    function addMarkerFromAddress(){
        var location_str = jQuery("input#streetaddress").val();
        location_str = location_str + " " +cityname;
        addMarkerOnMap(location_str);
    }

    function addMarkerOnMap(location){
        var geocoder =  new google.maps.Geocoder();
        geocoder.geocode( { "address": location}, function(results, status) {
            var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
            if (status == google.maps.GeocoderStatus.OK) {
                if(map != null ){
                    addMarker(latlng);
                    map.setCenter(latlng);
                }
                if(document.map != null ){
                    document.addMarker(latlng);
                    document.map.setCenter(latlng);
                }
            } else {
                
            }
        });
    }

    function addMarkerOnMap1(location){
        var geocoder =  new google.maps.Geocoder();
        geocoder.geocode( { "address": location}, function(results, status) {
            var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
            if (status == google.maps.GeocoderStatus.OK) {
                if(map1 != null){
                    addMarker1(latlng);
                    map1.setCenter(latlng);
                }
                if(document.map1 != null ){
                    document.addMarker1(latlng);
                    document.map1.setCenter(latlng);
                }
            } else {
                
            }
        });
    }

    function loadMap1() {
        var default_latitude1 = document.getElementById("jsvm_default_latitude1").value;
        var default_longitude1 = document.getElementById("jsvm_default_longitude1").value;
        var latlng = new google.maps.LatLng(default_latitude1, default_longitude1);
        var zoom = 10;
        var myOptions = {
            zoom: zoom,
            center: latlng,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map1 = new google.maps.Map(document.getElementById("jsvm_map_container1"), myOptions);
        google.maps.event.addListener(map1, "click", function (e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"latLng": latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addMarker1(results[0].geometry.location);
            } else {
                alert("<?php esc_js(__("Geocode was not successful for the following reason", "js-vehicle-manager")); ?>" + status);
            }
            });
        });
    }

    function addMarker1(latlang){
        if (marker1) {
            //if marker already was created change positon
            marker1.setPosition(latlang);
            map1.setCenter(latlang);
        }else{
            marker1 = new google.maps.Marker({
                position: latlang,
                map: map1,
                draggable: true,
                scrollwheel: false,
            });
            marker1.setMap(map1);
            map1.setCenter(latlang);
        }
        jQuery("input#latitude1").val(marker1.position.lat());
        jQuery("input#longitude1").val(marker1.position.lng());
    }

    /*  speed meter label changing funciton */

    function speedmeterchange(obj) {
         var selectedValue = jQuery(obj).val();
        if(selectedValue != null){
           var mileagesSymbols = jQuery(obj).attr("data-symbols");
                var array = mileagesSymbols.split(",");
                for (var i = 0; i < array.length; i++) {
                    var arr = array[i].split(":");
                    if(arr[0] == selectedValue){
                        // Update fields label
                        jQuery("div.jsvehiclemanager-speedometer").find("input").addClass("jsvehiclemanager-lenghtless");
                        jQuery("div.jsvehiclemanager-speedometer").find("span.jsvehiclemanager-speedometer").css("display","inline-block");
                        jQuery("div.jsvehiclemanager-speedometer").find("span.jsvehiclemanager-speedometer").html(arr[1]);
                        break;
                    }
                }
            }
    }

    /* upload images functions */

    function makeImageDefault(imgnum) {
        var imageexist = jQuery("img#jsvm_src_"+imgnum).attr("data-replaced");
        if(imageexist == 1){
            var imgsrc2 = jQuery("img#jsvm_src_"+imgnum).attr("src");
            jQuery("img#jsvehiclemanager_ve_main_image").attr("src",imgsrc2);
            var filename = jQuery("img#jsvm_src_"+imgnum).attr("data-filename");
            if(filename != ""){// new images case
                jQuery("img#jsvehiclemanager_ve_main_image").attr("data-filename",filename);
                jQuery("input#jsvm_default_image_name").val(filename);
                jQuery("input#jsvm_default_image_url").val(0);
            }else{
                // to handle edit case
                filename = jQuery("img#jsvm_src_"+imgnum).attr("src");
                jQuery("input#jsvm_default_image_name").val(filename);
                jQuery("input#jsvm_default_image_url").val(1);
            }
        }
    }

    var filearrayinal;
    jQuery(document).ready(function(){
        jQuery.validate({
            onError : function(){
                jsvm_hideloading();
            }
        });

        var isMSIE = false;
        if(navigator.appName === "Microsoft Internet Explorer") isMSIE = true;
        if(!isMSIE && /(MSIE|Trident\/|Edge\/)/i.test(navigator.userAgent || userAgent))    isMSIE = true;
        if(isMSIE){
            jQuery(".jsvehiclemanager-upload-choose-button").hide();
            jQuery("#jsvehiclemanager-uploadBtn").show();
        }
        
        jQuery("#jsvm_brochure").change(function(){
            var isMSIE = false;
            if(navigator.appName === "Microsoft Internet Explorer") isMSIE = true;
            if(!isMSIE && /(MSIE|Trident\/|Edge\/)/i.test(navigator.userAgent || userAgent))    isMSIE = true;
            if(isMSIE){
                return true;
            }
            var file = jQuery(this).get(0).files[0];

            var fileext = file.name.split(".").pop();
            var filesize = (file.size / 1024);
            var filename = file.name;

            var allowedsize = <?php echo JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("allowed_file_size"); ?>;
            var allowedExt = "<?php echo JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("file_file_type"); ?>";
            allowedExt = allowedExt.split(",");
            for(var i = 0; i < allowedExt.length; i++){
                allowedExt[i] = allowedExt[i].trim();
            }
            var resetfield = true;
            if (jQuery.inArray(fileext, allowedExt) != - 1){
                if (allowedsize > filesize){
                    resetfield = false;
                } else{
                    alert("<?php echo esc_js(__("File size is greater then allowed file size", "js-vehicle-manager")); ?>");
                }
            } else{
                alert("<?php echo esc_js(__("File ext. is mismatched", "js-vehicle-manager")); ?>");
            }
            if(resetfield == true){
                jQuery(this).val("");
            }
        });       
        
        jQuery("#jsvm_profilephoto").change(function(){
            var isMSIE = false;
            if(navigator.appName === "Microsoft Internet Explorer") isMSIE = true;
            if(!isMSIE && /(MSIE|Trident\/|Edge\/)/i.test(navigator.userAgent || userAgent))    isMSIE = true;
            if(isMSIE){
                return true;
            }
            var file = jQuery(this).get(0).files[0];

            var fileext = file.name.split(".").pop();
            var filesize = (file.size / 1024);
            var filename = file.name;

            var allowedsize = <?php echo JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("allowed_file_size"); ?>;
            var allowedExt = "<?php echo JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("image_file_type"); ?>";
            allowedExt = allowedExt.split(",");
            for(var i = 0; i < allowedExt.length; i++){
                allowedExt[i] = allowedExt[i].trim();
            }
            var resetfield = true;
            if (jQuery.inArray(fileext, allowedExt) != - 1){
                if (allowedsize > filesize){
                    resetfield = false;
                } else{
                    alert("<?php echo esc_js(__("File size is greater then allowed file size", "js-vehicle-manager")); ?>");
                }
            } else{
                alert("<?php echo esc_js(__("File ext. is mismatched", "js-vehicle-manager")); ?>");
            }
            if(resetfield == true){
                jQuery(this).val("");
            }
        });

    })
    jQuery(document).delegate("#jsvehiclemanager-uploadBtn","change",function(){
        var isMSIE = false;
        if(navigator.appName === "Microsoft Internet Explorer") isMSIE = true;
        if(!isMSIE && /(MSIE|Trident\/|Edge\/)/i.test(navigator.userAgent || userAgent))    isMSIE = true;
        if(isMSIE){
            return true;
        }else{        
            var files = jQuery(this).get(0).files;
            filearrayinal = files;
            var replaced;
            for (var i = 0;i < files.length ;i++) {
                var fileext = files[i].name.split(".").pop();
                var filesize = (files[i].size / 1024);
                var filename = files[i].name;

                var allowedsize = <?php echo JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("allowed_file_size"); ?>;
                var allowedExt = "<?php echo JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("image_file_type"); ?>";
                allowedExt = allowedExt.split(",");
                if (jQuery.inArray(fileext, allowedExt) != - 1){
                    if (allowedsize > filesize){
                        var reader = new FileReader();
                        reader.onload = (function(theFile){
                            var fileName = theFile.name;
                            return function(e){
                                var srcimage = jQuery("div[data-images=\"images\"]").find("img[data-replaced=\"0\"]:first");
                                jQuery(srcimage).attr("src", e.target.result);
                                jQuery(srcimage).attr("data-replaced",1);
                                jQuery(srcimage).attr("data-filename",fileName);
                                jQuery(srcimage).parents("div.jsvehiclemanager-vehicle-upload").prepend("<img  class=\"jsvehiclemanager-cross_img\" src=\"<?php echo JSVEHICLEMANAGER_PLUGIN_URL."/includes/images/cancel-icon.png"; ?>\" /><div class=\"jsvehiclemanager-backgroud-overlay-for-img\" > </div>");
                                jQuery(srcimage).parents("div.jsvehiclemanager-vehicle-upload").find("div.jsvm_backgroud-overlay-for-img").hide();
                                if(jQuery("img#jsvehiclemanager_ve_main_image").attr("data-defaultimage") != 1){
                                    jQuery("img#jsvehiclemanager_ve_main_image").attr("src", e.target.result).attr("data-defaultimage",1);
                                }
                            };
                        })(files[i]);
                        reader.readAsDataURL(files[i]);
                    } else{
                        alert("<?php echo esc_js(__("File size is greater then allowed file size", "js-vehicle-manager")); ?>");
                    }
                } else{
                    alert("<?php echo esc_js(__("File ext. is mismatched", "js-vehicle-manager")); ?>");
                }
            }
        }

        jQuery("div.jsvehiclemanager-vehicle-upload-img-right").append("<input id=\"jsvehiclemanager-uploadBtn\" type=\"file\" class=\"jsvehiclemanager-upload\" name=\"images[]\"  style=\"display:none;\" multiple />");

    });
    // code to remove image
    jQuery(document).delegate("img.jsvehiclemanager-cross_img","click",function(){
        if(jQuery(this).hasClass("jsvehiclemanager-uploaded-img")){
            var vehimgid = jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").children("input.delimg").attr("data-atr-vehicleid");
            jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").children("input.delimg").val(vehimgid);
            jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").find("img").attr("data-replaced",0);

        }else{// code to remove image from filelist before upload
            var filename = jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").find("img[data-filename]").attr("data-filename");
            jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").find("img").attr("data-replaced",0);
            jQuery("input#jsvm_removefile").val(jQuery("input#jsvm_removefile").val() +","+ filename);
        }
        jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").children("div.jsvehiclemanager-backgroud-overlay-for-img").remove();
        jQuery(this).next().attr('src','<?php echo JSVEHICLEMANAGER_PLUGIN_URL."includes/images/default-images/vehicle-image.png" ?>');
        jQuery(this).parents("div.jsvehiclemanager-vehicle-upload").children("img.jsvehiclemanager-cross_img").remove();
    });



    
     
    jQuery(document).ready(function(){
        getTokenInput();
        jQuery(".custom_date").datepicker({dateFormat: "<?php echo $js_scriptdateformat; ?>"});
        jQuery("select").select2();
        setTimeout(function(){
            var slectedtype = jQuery("select#speedmetertypeid");
            speedmeterchange(slectedtype);
        },1000)
        

        var map_flag = Number( jQuery('#map_flag').val() );
        var map_flag1 = Number( jQuery('#map_flag').val() );

        if( map_flag == 1 ) {
            loadMap();
        }

        <?php if( !jsvehiclemanager::$_error_flag_message ){ ?>
                if( <?php echo jsvehiclemanager::$_data['sellerflag']; ?> == 0 &&  map_flag1 == 1 ) {
                    loadMap1();
                }
        <?php } ?>

        jQuery("div.jsvehiclemanager-vehicle-upload").hover(
            function() {
                jQuery(this).children("img.jsvehiclemanager-cross_img").show();
                jQuery(this).children("div.jsvehiclemanager-backgroud-overlay-for-img").show();
            }, function() {
                if(jQuery(this).children("img.jsvehiclemanager-cross_img").length > 0){
                    jQuery(this).children("img.jsvehiclemanager-cross_img").hide();
                    jQuery(this).children("div.jsvehiclemanager-backgroud-overlay-for-img").hide();
                }
            }
        );

        // jQuery("form#adminForm").submit(function (e) {
        //     try{
        //         var termsandcondtions = document.getElementById("termsconditions1").checked;
        //         if( !termsandcondtions ){
        //             alert(common.terms_conditions);
        //             return false;
        //         }
        //     }
        //     catch(e){
        //     }
        // });

    });

    <?php
    if( JSVEHICLEMANAGERincluder::getObjectClass('user')->isguest() == true ){
    ?>
        jQuery(document).delegate('form#adminForm','submit',function(){
            try{
                var termsandcondtions = document.getElementById("termsconditions1").checked;
                if( !termsandcondtions ){
                    alert(common.terms_conditions);
                    return false;
                }
            }
            catch(e){
            }            
            return true;
        });
    <?php
    }
    ?>
    function getmodels(src, val){
        jQuery("img#makemodelloading-gif").show();
            var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
            jQuery.post(ajaxurl, {action: 'jsvehiclemanager_ajax', jsvmme: 'model', task: 'getVehiclesModelsbyMake', makeid: val,wpnoncecheck:common.wp_vm_nonce}, function(data){
            if (data){
//                jQuery("#" + src).html(data); //retuen value
                jQuery("#" + src).select2('destroy'); 
                jQuery("#" + src).html(data); //retuen value
                jQuery("#" + src).select2();
            }
            jQuery("img#makemodelloading-gif").hide();
        });
    }
</script>
