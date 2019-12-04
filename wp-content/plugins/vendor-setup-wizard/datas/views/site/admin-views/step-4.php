<?php
$dashboard_url = dokan_get_navigation_url();
?>
<div class="step-view-container">
	<div class="step-container-field">
		<h1><?php _e( 'Your Store is Ready!', 'vendor-setup-wizard' ); ?></h1>
		<p><?php echo __('Continue with an free account which has FIVE items uploads in your store, for upgrades packages
please go to subscriptions into dashboard panel.','vendor-setup-wizard');?></p> 

		<p><?php echo __('Start uploading your products now by clicking the button below.','vendor-setup-wizard');?></p>
		<a class="ready-step-action" href="<?php echo esc_url( $dashboard_url ); ?>"><?php _e( 'Go to your Store Dashboard!', 'dokan-lite' ); ?></a>
	</div>
	<div class="step-bottom-action">
		<button class="step-action-prev" onClick="javascript:prev();" title="<?php echo __('Prev', 'vendor-setup-wizard');?>">&nbsp;</button>
	</div>
</div>