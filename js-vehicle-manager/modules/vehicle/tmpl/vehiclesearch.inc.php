<?php
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>


<?php if(isset(jsvehiclemanager::$_data[0]->latitude) && isset(jsvehiclemanager::$_data[0]->longitude) ){?>
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
    
var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";
var isPluginCall = true;
var multicities = "" ;
var multicities1 = "" ;
var map;
var marker;

function speedmeterchange(obj){
    var isPluginCall = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    if(isPluginCall == true){
        var selectedValue = jQuery(obj).val();
        var mileagesSymbols = jQuery(obj).attr("data-symbols");
        if(mileagesSymbols != undefined && mileagesSymbols != null){
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
        if(mileagesSymbols != undefined && mileagesSymbols != null){
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
                //abc = jQuery.parseJSON(data);
                jQuery("select[data-modelid=1]").select2('destroy'); 
                jQuery("select[data-modelid=1]").html(data); //retuen value
                jQuery("select[data-modelid=1]").select2();
            }
            jQuery("img#makemodelloading-gif").hide();
        });
}

function checkmapcooridnate() {
    if(document.getElementById("latitude") && document.getElementById("longitude")){
        var latitude = document.getElementById("latitude").value;
        var longitude = document.getElementById("longitude").value;
        var radius = document.getElementById("radius").value;
        var radiustype = document.getElementById("radiustype").value;
        if (latitude != "" && latitude != undefined && longitude != "" && longitude != undefined) {
            if (radiustype == "") {
               alert("<?php echo esc_js(__("Please Select The Coordinate Radius Type","js-vehicle-manager")); ?>");
                return false;
            }else if( radius == "") {
                 alert("<?php echo esc_js(__("Please Enter The Coordinate Radius","js-vehicle-manager")); ?>");
                return false;
            }else{
                return true;
            }
        }
    }
}

function loadMap() {
    var default_latitude = document.getElementById("default_latitude").value;
    var default_longitude = document.getElementById("default_longitude").value;
    var latlng = new google.maps.LatLng(default_latitude, default_longitude);
    var zoom = 10;
    var myOptions = {
        zoom: zoom,
        center: latlng,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    if(document.getElementById("map_container") != null){
        map = new google.maps.Map(document.getElementById("map_container"), myOptions);

        google.maps.event.addListener(map, "click", function (e) {
            var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"latLng": latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                addMarker(results[0].geometry.location);
            } else {
                alert("<?php echo esc_js(__("Geocode was not successful for the following reason", "js-vehicle-manager")); ?>: " + status);
            }
            });
        });
    }
}

function addMarker(latlang){
    if (marker) {
        //if marker already was created change positon
        marker.setPosition(latlang);
    }else{
        marker = new google.maps.Marker({
            position: latlang,
            map:map,
            draggable: true,
            scrollwheel: false,
        });
        marker.setMap(map);
    }
    jQuery("input#latitude").val(marker.position.lat());
    jQuery("input#longitude").val(marker.position.lng());
}
 


jQuery(document).ready(function(){
    var slectedtype = jQuery("select#mileagetype");
    speedmeterchange(slectedtype,isPluginCall);
    jQuery(".jsvm_cm_select2").select2();
    getTokenInput();
    loadMap();
});

</script>
