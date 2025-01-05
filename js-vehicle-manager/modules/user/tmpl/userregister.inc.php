<script >
        var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php'));?>";
        <?php 
        if(isset(jsvehiclemanager::$_data[0]->cityid)){
            echo  'var multicities = '. jsvehiclemanager::$_data[0]->cityid .';';
        }else{
            echo ' var multicities = "";';

        }
        ?>
        function getTokenInput () {
            var vehicleArray = "<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname");?>";
            jQuery("#cityid").tokenInput(vehicleArray, {
                theme: "jsvehiclemanager",
                preventDuplicates: true,
                hintText: "<?php echo  esc_js(__("Type In A Search Term", "js-vehicle-manager"));?>",
                noResultsText: "<?php echo  esc_js(__("No Results", "js-vehicle-manager")) ;?>",
                searchingText: "<?php echo  esc_js(__("Searching", "js-vehicle-manager")) ;?>",
                prePopulate: multicities,
                tokenLimit:1,
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
                        return;
                    }
                    <?php 
                    $newtyped_cities = JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("newtyped_cities");
                    if ($newtyped_cities == 1) { 
                        ?>
                        if (item.name.search(",") == - 1) {
                        var input = jQuery("tester").text();
                                alert (<?php echo  esc_js(__("Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name", "js-vehicle-manager"));?>);
                                jQuery("#cityid").tokenInput("remove", item);
                                return false;
                        } else{
                        var ajaxurl = <?php echo esc_url(admin_url("admin-ajax.php")) ;?>;
                                jQuery.post(ajaxurl, {action: "jsvehiclemanager_ajax", jsvmme: "city", task: "savetokeninputcity", citydata: jQuery("tester").text(),wpnoncecheck:common.wp_vm_nonce}, function(data){
                                if (data){
                                try {
                                var value = jQuery.parseJSON(data);
                                        jQuery("#cityid").tokenInput("remove", item);
                                        jQuery("#cityid").tokenInput("add", {id: value.id, name: value.name});
                                }
                                catch (err) {
                                jQuery("#cityid").tokenInput("remove", item);
                                        alert(data);
                                }
                                }
                                });
                            }
                    <?php
                    } 
                    ?>
                    
                }

            });
        }

        function addMarkerOnMap (location){
            var geocoder =  new google.maps.Geocoder();
            geocoder.geocode( { "address": location}, function(results, status) {
                var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                if (status == google.maps.GeocoderStatus.OK) {
                    if(map != null){
                        addMarker(latlng);
                        map.setCenter(latlng);
                    }
                } else {
                    
                }
            });
        }
        <?php if( get_option('users_can_register') ){ ?>
        jQuery(document).ready(function(){
            jQuery.validate();
            getTokenInput();
            loadMap();

            jQuery("#jsvm_profilephoto").change(function(){
                var file = jQuery(this).get(0).files[0];

                var fileext = file.name.split(".").pop();
                var filesize = (file.size / 1024);
                var filename = file.name;

                var allowedsize = <?php echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("allowed_file_size"), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>;
                var allowedExt = "<?php echo wp_kses(JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("image_file_type"), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>";
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
        jQuery(document).delegate('#address','blur',function(){
            addMarkerOnMap(
                    jQuery(this).val()
                );
        });
        <?php } ?>
</script>
<?php
$google_api_key = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigValue('google_map_api_key');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://"; ?>

<input type="hidden" id="jsvm_default_longitude" name="default_longitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->longitude) && jsvehiclemanager::$_data[0]->longitude !='' ) ? jsvehiclemanager::$_data[0]->longitude : esc_attr(jsvehiclemanager::$_config['default_longitude']); ?>"/>
<input type="hidden" id="jsvm_default_latitude" name="default_latitude" value="<?php echo (isset(jsvehiclemanager::$_data[0]->latitude) && jsvehiclemanager::$_data[0]->latitude !='' ) ? jsvehiclemanager::$_data[0]->latitude : esc_attr(jsvehiclemanager::$_config['default_latitude']); ?>"/>
<?php 
wp_enqueue_script( 'mapAPI',$protocol.'maps.googleapis.com/maps/api/js?key='.$google_api_key);
?>
<script>
        var marker;
        function loadMap () {
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
            map = new google.maps.Map(document.getElementById("jsvm_map_container"), myOptions);
            google.maps.event.addListener(map, "click", function (e) {
                var latLng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({"latLng": latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    addMarker(results[0].geometry.location);
                } else {
                    alert("<?php echo  esc_js(__("Geocode was not successful for the following reason", "js-vehicle-manager"));?>" + status);
                }
                });
            });
        }

        function addMarker (latlang){
            if (marker) {
                //if marker already was created change positon
                marker.setPosition(latlang);
            }else{
                marker = new google.maps.Marker({
                    position: latlang,
                    center: latlang,
                    map: map,
                    draggable: true,
                    scrollwheel: false,
                });
                marker.setMap(map);
            }
            jQuery("input#latitude").val(marker.position.lat());
            jQuery("input#longitude").val(marker.position.lng());
        }

        function setMarkerUsingButton (){
            var lat = jQuery("input#latitude").val();
            var lng = jQuery("input#longitude").val();
            var latlng = new google.maps.LatLng(lat,lng);
            if(map != null){
                addMarker(latlng);
            }
        }
    
</script>
