<div class="step-view-container">
	<div class="step-header-name"><?php echo __('Selling', 'vendor-setup-wizard');?></div>
	<div class="step-container-field">
		<form id="vendor-setup-wizard-setup-form">
		<?php 
		$options = get_option( 'dokan_selling', [] );
        $new_seller_enable_selling = ! empty( $options['new_seller_enable_selling'] ) ? $options['new_seller_enable_selling'] : '';
        $seller_percentage         = ! empty( $options['seller_percentage'] ) ? $options['seller_percentage'] : '';
        $order_status_change       = ! empty( $options['order_status_change'] ) ? $options['order_status_change'] : '';
        $product_style             = ! empty( $options['product_style'] ) ? $options['product_style'] : '';
        $product_styles_list       = array(
            'old' => __( 'Tab View', 'vendor-setup-wizard' ),
            'new' => __( 'Flat View', 'vendor-setup-wizard' ),
        );
        ?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'New Vendor Enable Selling', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input type="checkbox" id="dokan_option_new_seller_enable_selling" name="dokan_option_new_seller_enable_selling" onClick="javascript:enableSelling(this);" class="input-checkbox" value="<?php echo ( $new_seller_enable_selling == 'on' ) ? 'on' : 'off';?>" <?php echo ( $new_seller_enable_selling == 'on' ) ? 'checked="checked"' : ''; ?>/>
				<label for="dokan_option_new_seller_enable_selling"><?php _e( 'Make selling status enable for new registred vendor', 'vendor-setup-wizard' ); ?></label>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Vendor Commission %', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input type="text" name="dokan_option_seller_percentage" value="<?php echo $seller_percentage; ?>" />
				<p class="description"><?php _e( 'How much amount (%) a vendor will get from each order', 'vendor-setup-wizard' ); ?></p>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Order Status Change', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input type="checkbox" id="dokan_option_order_status_change" name="dokan_option_order_status_change" onClick="javascript:enableSelling(this);" class="input-checkbox" value="<?php echo ( $order_status_change == 'on' ) ? 'on' : 'off';?>" <?php echo ( $order_status_change == 'on' ) ? 'checked="checked"' : ''; ?>/>
				<label for="dokan_option_order_status_change"><?php _e( 'Vendor can change order status', 'vendor-setup-wizard' ); ?></label>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Add/Edit Product Style', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<select name="dokan_option_product_style">
					<?php
						foreach ( $product_styles_list as $key => $value ) {
							$selected = ( $product_style == $key ) ? ' selected="true"' : '';
							echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
						}
					?>
				</select>
				<p class="description"><?php _e( 'The style you prefer for vendor to add or edit products.', 'vendor-setup-wizard' ); ?></p>
			</div>
		</div>
		</form>
	</div>
	<div class="step-bottom-action">
		<button class="step-action-prev" onClick="javascript:prev();" title="<?php echo __('Prev', 'vendor-setup-wizard');?>">&nbsp;</button>
		<button class="step-action" onClick="javascript:save_form_setup('dokan_selling');"><?php echo __('Next', 'vendor-setup-wizard');?></button>
		<!--<button class="step-action" onClick="javascript:skip();"><?php echo __('Skip this step', 'vendor-setup-wizard');?></button>-->
	</div>
</div>