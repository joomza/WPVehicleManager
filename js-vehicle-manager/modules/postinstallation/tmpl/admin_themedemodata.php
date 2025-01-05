<div id="jsvehiclemanageradmin-wrapper">
	
	<div class="jsvehiclemanager-temp-sample-data-wrapper" >
		<div class="jsvehiclemanager-temp-sample-data-heading" >
			<h1> <?php 
					if(jsvehiclemanager::$_data['flag'] == 1){
						echo __('Demo data has been successfully imported','js-vehicle-manager').'&nbsp;.'; 
					}else{
						echo __('Please select the right demo data to import','js-vehicle-manager').'&nbsp;!';  
					}
				?>
			</h1>
		</div>
		<div class="jsvehiclemanager-temp-sample-data-links" >
			<div class="jsvehiclemanager-temp-sample-data-top-links" >
				<?php if(jsvehiclemanager::$_data['flag'] != 1){ ?>
					<div class="jsvehiclemanager-temp-sample-link-wrap" >
						<img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/free.png" />
						<div class="jsvehiclemanager-temp-sample-link-bottom-portion" >
							<span class="jsvehiclemanager-temp-sample-text" >
								<?php echo __('Free Version','js-vehicle-manager'); ?>
							</span>
							<a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_postinstallation&action=jsvmtask&task=importtemplatesampledata&flag=f'));?>" >
								<?php echo __('Import Data','js-vehicle-manager'); ?>
							</a>
						</div>
					</div>
					<div class="jsvehiclemanager-temp-sample-link-wrap" >
						<img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/pro.png" />
						<div class="jsvehiclemanager-temp-sample-link-bottom-portion" >
							<span class="jsvehiclemanager-temp-sample-text" >
								<?php echo __('Pro Version','js-vehicle-manager'); ?>
							</span>
							<a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_postinstallation&action=jsvmtask&task=importtemplatesampledata&flag=p'));?>" >
								<?php echo __('Import Data','js-vehicle-manager'); ?>
							</a>
						</div>
					</div>
					<div class="jsvehiclemanager-temp-sample-link-wrap" >
						<img src="<?php echo JSVEHICLEMANAGER_PLUGIN_URL; ?>includes/images/postinstallation/freetopro.png" />
						<div class="jsvehiclemanager-temp-sample-link-bottom-portion" >
							<span class="jsvehiclemanager-temp-sample-text" >
								<?php echo __('Free To Pro Updated','js-vehicle-manager'); ?>
							</span>
							<a href="<?php echo esc_url(admin_url('admin.php?page=jsvm_postinstallation&action=jsvmtask&task=importtemplatesampledata&flag=ftp'));?>" >
								<?php echo __('Import Data','js-vehicle-manager'); ?>
							</a>
						</div>
					</div>
				<?php } ?>
			</div>
			<div class="jsvehiclemanager-temp-sample-data-bottom-links" >
				<a href="?page=jsvehiclemanager" >
					<?php echo __('Click Here To Go Control Panel','js-vehicle-manager'); ?>
				</a>
				<a href="?page=car_manager_options" >
					<?php echo __('Click Here To Go Template Options','js-vehicle-manager'); ?>
				</a>
			</div>
		</div>
	</div>

</div>