<script>
        var ajaxurl = '<?php echo esc_url(admin_url("admin-ajax.php")); ?>';
        var marker;
        <?php
        if(isset(jsvehiclemanager::$_data[0]->cityid)){ ?>
             var multicities = <?php echo jsvehiclemanager::$_data[0]->cityid;?>;
             
        <?php }else{ ?>
            var multicities = '';
        <?php } ?>
        function getTokenInput(){
            var vehicleArray = '<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname");?>';
            
            jQuery("#cityid").tokenInput(vehicleArray, {
                theme: "jsvehiclemanager",
                preventDuplicates: true,
                hintText: "<?php echo esc_js(__("Type In A Search Term", "js-vehicle-manager"));?>",
                noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager"));?>",
                searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager"));?>",
                tokenLimit:1,
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
                        addMarkerOnMap(item.name);
                        return;
                    }
                    <?php 
                    $newtyped_cities = JSVEHICLEMANAGERincluder::getJSModel("configuration")->getConfigurationByConfigName("newtyped_cities");
                    if ($newtyped_cities == 1) { 
                    ?>
                        if (item.name.search(",") == - 1) {
                        var input = jQuery("tester").text();
                                alert ('<?php echo esc_js(__("Location Format Is Not Correct Please Enter City In This Format City Name Country Name Or City Name State Name Country Name", "js-vehicle-manager"));?>');
                                jQuery("#cityid").tokenInput("remove", item);
                                return false;
                        } else{
                        var ajaxurl = '<?php echo esc_url(admin_url("admin-ajax.php")); ?>';
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
                <?php } ?>
                },onDelete: function(item){
                    if(marker != undefined){
                        marker.setMap(null);
                        jQuery("input#latitude").val("");
                        jQuery("input#longitude").val("");
                    }
                }
            });
        }

        function addMarkerOnMap(location){
            var geocoder =  new google.maps.Geocoder();
            geocoder.geocode( { "address": location}, function(results, status) {
                var latlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
                if (status == google.maps.GeocoderStatus.OK) {
                    if(map != null){
                        addMarker(latlng);
                    }
                } else {
                    //Something got wrong""+status
                }
            });
        }
        
        function addMarkerFromAddress(){
            var location_str = jQuery("input#address").val();
            addMarkerOnMap(location_str);
        }

        jQuery(document).ready(function(){
            //Token Input
            getTokenInput();
            loadMap();
        })

    var marker;

    function loadMap(){
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
        if(jQuery("#jsvm_map_container").length == 0) {
            map = new google.maps.Map(document.getElementById("map_container"), myOptions);
        }else{
            map = new google.maps.Map(document.getElementById("jsvm_map_container"), myOptions);
        }

        if(jQuery("input#addmarker").val() == 1){
            addMarker(latlng);
        }
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

    function setMarkerUsingButton(){
        var lat = jQuery("input#latitude").val();
        var lng = jQuery("input#longitude").val();
        var latlng = new google.maps.LatLng(lat,lng);
        if(map != null){
            addMarker(latlng);
        }
    }

    function removePhoto (obj){
        jQuery("div.jsvm_profile-profileimg-overlay").show();
        jQuery("input#deleteimage").val(1);
        jQuery(obj).hide();
    }
</script>
