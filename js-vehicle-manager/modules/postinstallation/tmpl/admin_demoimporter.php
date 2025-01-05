<div id="jsvehiclemanageradmin-wrapper">
	<div id="jsvehiclemanageradmin-data">
		<?php
			$over_write = array(
							(object) array('id'=>1,'text'=>'Remove and insert'),
							(object) array('id'=>0,'text'=>'Ignore and insert')
			);
		$demo_flag = get_option('car_manager_demno_id');
		//$demo_flag = false;
		if(!$demo_flag){
			$demo_flag = -1;
		}else{
			if(is_numeric($demo_flag)){
				switch ($demo_flag) {
					case 0:
						$demo_flag = 'demo0';
					break;
					case 1:
						$demo_flag = 'demo1';
					break;
					case 2:
						$demo_flag = 'demo2';
					break;
					case 3:
						$demo_flag = 'demo3';
					break;
					case 4:
						$demo_flag = 'demo4';
					break;
					case 5:
						$demo_flag = 'demo5';
					break;
					case 6:
						$demo_flag = 'demo6';
					break;
					default:
						$demo_flag = -1;
						break;
				}
			}
		}

		if(get_option( 'vehicles_sample_data', '' ) == 1){ ?>
			<div class="frontend updated"><p><?php echo __("Vehicles data has been successfully imported","js-vehicle-manager"); ?></p></div>
		<?php
		delete_option( 'vehicles_sample_data' );
		}
		?>
		<div id="jsvehiclemanageradmin-wrapper">
			<div class="jsvehiclemanager-temp-sample-data-wrapper" >
				<div class="jsvehiclemanager-temp-sample-data-content" >
					<form method="post" action="<?php echo esc_url(admin_url("admin.php?page=jsvm_postinstallation&task=getdemocode&action=jsvmtask")); ?>" id="sample_data_form" >
						<div class="jsvehiclemanager-temp-sample-data-content-left" >
							<div class="jsvehiclemanager-temp-sample-data-content-demo-title" >
								<?php echo __('Select the demo data to import','js-vehicle-manager').'&nbsp;!';?>
							</div>
							<div class="jsvehiclemanager-temp-sample-data-content-demo-combo" ><?php
								if(isset(jsvehiclemanager::$_data[0]) && !empty(jsvehiclemanager::$_data[0])){
									echo wp_kses(JSVEHICLEMANAGERformfield::select('demoid', jsvehiclemanager::$_data[0], $demo_flag, __('Select demo', 'js-vehicle-manager'), array('class' => 'jsvm_inputbox', 'data-validation' => 'required', 'onchange' => 'demoChanged(this.options[this.selectedIndex].value);')), JSVEHICLEMANAGER_ALLOWED_TAGS);
								}?>
							</div>
							<div class="jsvehiclemanager-temp-sample-data-content-demo-desc" id="demo_desc" >
								&nbsp;
							</div>
							<div class="jsvehiclemanager-temp-sample-data-content-demo-overwrite" id="demo_overwrite_wrap" style="display: none;">
								<label for="demo_overwrite"><?php echo __('What to do with previous demo data','js-vehicle-manager');?></label>
								<?php echo wp_kses(JSVEHICLEMANAGERformfield::select('demo_overwrite', $over_write, 0, '', array('class' => 'jsvm_inputbox', 'onchange' => 'showMessage(this.options[this.selectedIndex].value);')), JSVEHICLEMANAGER_ALLOWED_TAGS); ?>
								<div id="demo_warning">
									&nbsp;
								</div>
							</div>
							<div class="jsvehiclemanager-temp-sample-data-content-demo-button">
								<input type="submit" name="submitbutton" value="Get Demo" id="submit_button">
							</div>
						</div>
						<div class="jsvehiclemanager-temp-sample-data-content-right" >
							<div class="jsvehiclemanager-temp-sample-data-content-image-wrapper" id="demo_section" style="display: none;">
								<img id="demo_image"  src="<?php echo jsvehiclemanager::$_data[1][0]['imagepath'];?>">
							</div>
						</div>
						<input type="hidden" name="foldername" value="" id="demo_foldername">
					</form>
				</div>
			</div>
			<div class="jsvehiclemanager-sample-data-loading" id="jsvm_sample_loading" style="display: none;" >
				<img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/loading.gif';?>">
			</div>
		</div>
	</div>
</div>
<script>
	var images = new Array();
	var names = new Array();
	var descs = new Array();
	var folders = new Array();
	var demo_flag_js = '<?php echo $demo_flag;?>';
	<?php
		foreach (jsvehiclemanager::$_data[1] as $key => $value) {
			echo 'images["'.$value['foldername'].'"] = "'.$value['imagepath'].'";';
			echo 'names["'.$value['foldername'].'"] = "'.$value['name'].'";';
			echo 'descs["'.$value['foldername'].'"] = "'.$value['desc'].'";';
			echo 'folders["'.$value['foldername'].'"] = "'.$value['foldername'].'";';
		}
	?>
	if(demo_flag_js != -1){
		jQuery( document ).ready(function() {
		    demoChanged(demo_flag_js);
		});
	}
	function demoChanged(demoid){
		if(demoid == ''){
			jQuery('#submit_button').prop('disabled', true);
			return;
		}
		jQuery('#demo_image').attr('src',"<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/loading.gif'; ?>");
		// image loading
		var $image = jQuery("#demo_image");
		var $downloadingImage = jQuery("<img>");
		$downloadingImage.load(function(){
			$image.attr("src", jQuery(this).attr("src"));
		});
		$downloadingImage.attr("src",images[demoid]);
		jQuery('#demo_name').html(names[demoid]);
		jQuery('#demo_desc').html(descs[demoid]);
		jQuery('input#demo_foldername').val(folders[demoid]);
		jQuery('#demo_section').show();
		if(demo_flag_js != -1){
			if(demo_flag_js != demoid){
				jQuery('#demo_overwrite_wrap').show();
				jQuery('#submit_button').prop('disabled', false);
			}else{
				jQuery('#demo_overwrite_wrap').hide();
				jQuery('#submit_button').prop('disabled', true);
			}
		}
	}

	function showMessage(optionid){
		if(optionid == 1){
			jQuery('#demo_warning').html('<?php echo __('All the content of previus demo data will be deleted.','js-vehicle-manager');?>');
		}else{
			jQuery('#demo_warning').html('&nbsp;');
		}
	}

jQuery(document).ready(function() {
	if(demo_flag_js != -1){
		jQuery('#submit_button').prop('disabled', true);
	}
	 jQuery("form#sample_data_form").on("submit", function(){
	   jQuery("#jsvm_sample_loading").show();
	   return true;
   	});
});
</script>
