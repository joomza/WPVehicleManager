<tr id="<?php echo esc_attr( sanitize_title( $addon_slug . '_transaction_key_row' ) ); ?>" class="active plugin-update-tr jsvm-updater-licence-key-tr">
	<td class="plugin-update" colspan="3">
		<div class="jsvm-updater-licence-key">
			<label for="<?php echo sanitize_title( $addon_slug ); ?>_transaction_key"><?php _e( 'transaction Key' ); ?>:</label>
			<input type="text" id="<?php echo sanitize_title( $addon_slug ); ?>_transaction_key" name="<?php echo esc_attr( $addon_slug ); ?>_transaction_key" placeholder="XXXXXXXXXXXXXXXX" />
			<input type="submit" id="<?php echo sanitize_title( $addon_slug ); ?>_submit_button" name="<?php echo esc_attr( $addon_slug ); ?>_submit_button" value="Authenticate" />
			<input type="hidden" name="jsvm_addon_array_for_token[]" value="<?php echo esc_attr( $addon_slug ); ?>" />
			<div>
				<span class="description"><?php _e( 'Enter your license key and hit authenticate. A valid key is required for updates.' ); ?> <?php printf( 'Lost your key? <a href="%s">Retrieve it here</a>.', esc_url( 'https://jshelpdesk.com/' ) ); ?></span>
			</div>
		</div>
	</td>
</tr>
<tr>
	<?php
	/*
	$latest_version = get_option('jsticketdsknotifwp_latest_version');
	if ($latest_version != false && version_compare( $latest_version, $this->plugin_data['Version'], '>' ) ) {
	?>
		<td class="plugin-update plugin-update colspanchange" colspan="3">
			<div class="update-message notice inline notice-warning notice-alt"><p>There is a new version of WP Ticket Notification available. Insert key to update plugin </p></div>
		</td>
	<?php }
	*/ ?>
</tr>
