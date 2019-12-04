<?php
$dashboard_url = dokan_get_navigation_url();
?>
<div class="step-view-container">
	<div class="step-container-field">
		<h1><?php _e( 'Your Store is Ready!', 'vendor-setup-wizard' ); ?></h1>
		<p><?php echo __('Congratulations! You have now setup your store on our system, you will have a complimentary 15 day free trial, you can upgrade at any time if you require more storage.','vendor-setup-wizard');?></p> 

		<p><?php echo __('Now you can continue to your Vendor Dashboard and begin adding items to your store.','vendor-setup-wizard');?></p>
		<a class="ready-step-action" href="<?php echo esc_url( $dashboard_url ); ?>"><?php _e( 'Go to Vendor Dashboard', 'dokan-lite' ); ?></a>
			<button class="step-action-prev" onClick="javascript:prev();" title="<?php echo __('Prev', 'vendor-setup-wizard');?>">&nbsp;</button>
	</div>
</div>