<div class="step-view-container">
	<div class="step-header-name"><?php echo __('How you would like to be paid?', 'vendor-setup-wizard');?></div>
	<div class="step-container-field">
		<form id="vendor-setup-wizard-setup-form">
		<div class="field-item">
			<table class="form-table" style="width: 100%;">
                <?php
				$methods    = dokan_withdraw_get_active_methods();
				$store_info = dokan_get_store_info( $this->get_current_user_id() );
                    foreach ( $methods as $method_key ) {
                        $method = dokan_withdraw_get_method( $method_key );
                ?>
                    <tr>
                        <th scope="row" style="width: 40%;" valign="top"><label><?php echo $method['title']; ?></label></th>
                        <td>
                            <?php
                                if ( is_callable( $method['callback'] ) ) {
                                    call_user_func( $method['callback'], $store_info );
                                }
                            ?>
                        </td>
                    </tr>
                <?php
                    }
                    do_action( 'dokan_seller_wizard_payment_setup_field', $this );
                ?>
            </table>
		</div>
		<?php 
		$options = get_option( 'dokan_withdraw', [] );
		if (!is_array($options)){
			$options = Array();
		}
        $withdraw_methods      = ! empty( $options['withdraw_methods'] ) ? $options['withdraw_methods'] : [];
        $withdraw_limit        = ! empty( $options['withdraw_limit'] ) ? $options['withdraw_limit'] : 0;
        $withdraw_order_status = ! empty( $options['withdraw_order_status'] ) ? $options['withdraw_order_status'] : [];
        ?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Withdraw Methods', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<ul class="vendor-dokan-wizard-payment-gateways">
					<li class="wc-wizard-gateway">
						<div class="wc-wizard-gateway-enable">
							<input type="checkbox" id="dokan_option_withdraw_methods_paypal" name="dokan_option_withdraw_methods[paypal]" class="input-checkbox" value="paypal" <?php echo ( array_key_exists( 'paypal', $withdraw_methods ) ) ? 'checked="true"' : ''; ?>/>
							<label for="dokan_option_withdraw_methods_paypal"><?php echo __('Paypal', 'vendor-setup-wizard' ); ?></label>
						</div>
					</li>
					<li class="wc-wizard-gateway">
						<div class="wc-wizard-gateway-enable">
							<input type="checkbox" id="dokan_option_withdraw_methods_bank" name="dokan_option_withdraw_methods[bank]" class="input-checkbox" value="bank" <?php echo ( array_key_exists( 'bank', $withdraw_methods ) ) ? 'checked="true"' : ''; ?>/>
							<label for="dokan_option_withdraw_methods_bank"><?php echo __('Bank Transfer', 'vendor-setup-wizard' ); ?></label>
						</div>
					</li>
					<li class="wc-wizard-gateway">
						<div class="wc-wizard-gateway-enable">
							<input type="checkbox" id="dokan_option_withdraw_methods_skrill" name="dokan_option_withdraw_methods[skrill]" class="input-checkbox" value="skrill" <?php echo ( array_key_exists( 'skrill', $withdraw_methods ) ) ? 'checked="true"' : ''; ?>/>
							<label for="dokan_option_withdraw_methods_skrill"><?php echo __('Skrill', 'vendor-setup-wizard' ); ?></label>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Minimum Withdraw Limit', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input type="text" name="withdraw_limit" value="<?php echo $withdraw_limit; ?>" />
                <p class="description"><?php _e( 'Minimum balance required to make a withdraw request ( Leave it blank to set no limits )', 'vendor-setup-wizard' ); ?></p>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Order Status for Withdraw', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input type="checkbox" class="input-checkbox id="dokan_option_withdraw_order_status_wc-completed" name="dokan_option_withdraw_order_status[wc-completed]" value="<?php echo ( array_key_exists( 'wc-completed', $withdraw_order_status ) ) ? 'wc-completed' : ''; ?>" <?php echo ( array_key_exists( 'wc-completed', $withdraw_order_status ) ) ? 'checked="true"' : ''; ?>><label for="dokan_option_withdraw_order_status_wc-completed"> <?php _e( 'Completed', 'vendor-setup-wizard' ); ?></label><br />
				<input type="checkbox" id="dokan_option_withdraw_order_status_wc-processing" class="input-checkbox" name="dokan_option_withdraw_order_status[wc-processing]" value="<?php echo ( array_key_exists( 'wc-processing', $withdraw_order_status ) ) ? 'wc-processing' : ''; ?>" <?php echo ( array_key_exists( 'wc-processing', $withdraw_order_status ) ) ? 'checked="true"' : ''; ?>><label for="dokan_option_withdraw_order_status_wc-processing"> <?php _e( 'Processing', 'vendor-setup-wizard' ); ?></label><br />
				<input type="checkbox" id="dokan_option_withdraw_order_status_wc-on-hold" class="input-checkbox" name="dokan_option_withdraw_order_status[wc-on-hold]" value="<?php echo ( array_key_exists( 'wc-on-hold', $withdraw_order_status ) ) ? 'wc-on-hold' : ''; ?>" <?php echo ( array_key_exists( 'wc-on-hold', $withdraw_order_status ) ) ? 'checked="true"' : ''; ?>><label for="dokan_option_withdraw_order_status_wc-on-hold"> <?php _e( 'On-hold', 'vendor-setup-wizard' ); ?></label>

				<p class="description"><?php _e( 'Order status for which vendor can make a withdraw request.', 'vendor-setup-wizard' ); ?></p>
			</div>
		</div>		
		</form>
	</div>
	<div class="step-bottom-action">
		<button class="step-action-prev" onClick="javascript:prev();" title="<?php echo __('Prev', 'vendor-setup-wizard');?>">&nbsp;</button>
		<button class="step-action" onClick="javascript:save_form_setup('dokan_withdraw');"><?php echo __('Continue', 'vendor-setup-wizard');?></button>
		<!--<button class="step-action" onClick="javascript:skip();"><?php echo __('Skip this step', 'vendor-setup-wizard');?></button>-->
	</div>
</div>