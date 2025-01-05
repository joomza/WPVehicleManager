<?php

$google_recaptcha = false;
$recaptcha_flag_offer = 0;

$recaptcha_flag_friend = 0;
$config_array = JSVEHICLEMANAGERincluder::getJSModel('configuration')->getConfigByFor('recaptcha'); ?>
<!-- popup start -->

<div id="jsvehiclemanager-pop-transparent" onclick="closePopupFromOverlay(event);">


	<div class="jsvehiclemanager-pop-wrapper">

		<!-- loading div, to show when save button is clicked -->
		<div class="jsvehiclemanager-pop-loading">
			<img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL.'includes/images/load.gif'; ?>">
		</div>
		<!-- end loading div -->

		<span id="jsvehiclemanager-pop-wrapper-close" onclick="closePopup();">
			<img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL."includes/images/popup-close.png" ?>">
		</span>
		<div class="jsvehiclemanager-pop-body">
			<!-- Tell a Friend content start, Make an offer, Vehicle alert, Shortlist, test drive,finance plan -->
			<?php
			$vlay = JSVEHICLEMANAGERrequest::getLayout('jsvmlt', null, 'vehicles');
			if($vlay != 'vehicledetail')
				$vehicle = '';
			do_action('jsvm_vehicledetail_popups',$vehicle);?>
			<!-- Hook calling end -->
		</div>
	</div>
</div>

<!-- popup end -->

<?php
if(isset($google_recaptcha) && $google_recaptcha) {
wp_enqueue_script('jsvm-repaptcha-scripti','https://www.google.com/recaptcha/api.js?onload=renderAllRecaptcha&render=explicit');
	?>
 	<script type="text/javascript">
 	var recaptcha_friend = null;
 	var recaptcha_offer = null;
 	var recaptcha_drive = null;
 	var recaptcha_key = '<?php echo $config_array['recaptcha_publickey']; ?>';

 	var renderAllRecaptcha = function(){
	 	if( jQuery('#recaptcha-friend').length > 0 ){
	 		recaptcha_friend = grecaptcha.render('recaptcha-friend',{'sitekey' : recaptcha_key});
	 	}
	 	if( jQuery('#recaptcha-offer').length > 0 ){
	 		recaptcha_offer = grecaptcha.render('recaptcha-offer',{'sitekey' : recaptcha_key});
	 	}
	 	if( jQuery('#recaptcha-drive').length > 0 ){
	 		recaptcha_drive = grecaptcha.render('recaptcha-drive',{'sitekey' : recaptcha_key});
	 	}
 	};


 	</script>

 	<?php
 }
 ?>
