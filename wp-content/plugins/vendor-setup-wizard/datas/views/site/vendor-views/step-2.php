<div class="step-view-container">
	<div class="step-header-name"><?php echo __('Connect with Stripe as your payment gateway', 'vendor-setup-wizard');?></div>
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
		</form>
	</div>
	<div class="step-bottom-action">
		<button class="step-action-prev" onClick="javascript:prev();" title="<?php echo __('Prev', 'vendor-setup-wizard');?>">&nbsp;</button>
		<button class="step-action" onClick="javascript:save_form_setup('dokan_withdraw');"><?php echo __('Next', 'vendor-setup-wizard');?></button>
		<!--<button class="step-action" onClick="javascript:skip();"><?php echo __('Skip this step', 'vendor-setup-wizard');?></button>-->
	</div>
</div>