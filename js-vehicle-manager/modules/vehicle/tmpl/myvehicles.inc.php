<script type="text/javascript">

    var ajaxurl = "<?php echo esc_url(admin_url("admin-ajax.php")); ?>";

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
            }else{
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

</script>
