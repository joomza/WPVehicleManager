<script type="text/javascript">

var isPluginCall = true;
var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
var multicities = '';
<?php if(isset(jsvehiclemanager::$_data['filter']['cityid'])){ ?>

    var multicities = <?php echo jsvehiclemanager::$_data['filter']['cityid']; ?>;

<?php } ?>
        
function getTokenInput() {
    var vehicleArray = "<?php echo admin_url("admin.php?page=jsvm_city&action=jsvmtask&task=getaddressdatabycityname"); ?>";
    jQuery("#cityid").tokenInput(vehicleArray, {
        theme: "jsvehiclemanager",
        preventDuplicates: true,
        hintText: "<?php echo esc_js(__("Type In A Search Term", "js-vehicle-manager")); ?>",
        noResultsText: "<?php echo esc_js(__("No Results", "js-vehicle-manager")); ?>",
        searchingText: "<?php echo esc_js(__("Searching", "js-vehicle-manager")); ?>",
        prePopulate: multicities,
        onResult: function(item) {
            if (jQuery.isEmptyObject(item)){
               // return [{id:0, name: jQuery("tester").text()}];
            } else {
                //add the item at the top of the dropdown
               // item.unshift({id:0, name: jQuery("tester").text()});
                return item;
            }
        },
    });
}

function restFrom(){
    var isPluginCall = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    if(isPluginCall == true){
        var form = jQuery("form#jsvehiclemanager_autoz_form");
        form.find("input[type=text], input[type=email], input[type=password], input[type=hidden], textarea").val("");
        form.find("input:checkbox").removeAttr("checked");
        form.find("select").val("");
        jQuery("#jsvmlt").val("sellerlist");
        form.find("input[type=\"radio\"]").prop("checked", false);
        form.submit();
    }
    else{
        var form = jQuery("form#jsvm_autoz_form");
        form.find("input[type=text], input[type=email], input[type=password], input[type=hidden], textarea").val("");
        form.find("input:checkbox").removeAttr("checked");
        form.find("select").val("");
        jQuery("#jsvmlt").val("sellerlist");//form was showing error of no record s
        form.find("input[type=\"radio\"]").prop("checked", false);
        form.submit();
    }
    
}

jQuery(document).ready(function(){
    getTokenInput();
});

</script>
