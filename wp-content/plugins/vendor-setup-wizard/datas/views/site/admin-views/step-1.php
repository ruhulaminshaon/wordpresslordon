<?php 
$map_location   = $this->get_user_dokan_config('location');
$locations = explode( ',', $map_location );
$def_lat = isset( $locations[0] ) ? $locations[0] : 90.40714300000002;
$def_long = isset( $locations[1] ) ? $locations[1] : 23.709921;
$this->add_custom_javascript("
	var def_zoomval = 12;
	var def_longval = '".$def_long."';
	var def_latval = '".$def_lat."';

	try {
		var curpoint = new google.maps.LatLng(def_latval, def_longval);
		var geocoder   = new window.google.maps.Geocoder();
		var map_area = jQuery('#dokan-map');
		var input_area = jQuery('#dokan-map-lat');
		var input_add = jQuery('#dokan-map-add');
		var find_btn = jQuery('#dokan-location-find-btn');

		find_btn.on('click', function(e) {
			e.preventDefault();
			geocodeAddress( input_add.val() );
		});

		var gmap = new google.maps.Map( map_area[0], {
			center: curpoint,
			zoom: def_zoomval,
			mapTypeId: window.google.maps.MapTypeId.ROADMAP
		});

		var marker = new window.google.maps.Marker({
			position: curpoint,
			map: gmap,
			draggable: true
		});

		window.google.maps.event.addListener( gmap, 'click', function ( event ) {
			marker.setPosition( event.latLng );
			updatePositionInput( event.latLng );
		} );

		window.google.maps.event.addListener( marker, 'drag', function ( event ) {
			updatePositionInput(event.latLng );
		} );

	} catch( e ) {
		console.log( 'Google API not found.' );
	}

	autoCompleteAddress();

	function updatePositionInput( latLng ) {
		input_area.val( latLng.lat() + ',' + latLng.lng() );
	}

	function updatePositionMarker() {
		var coord = input_area.val(),
			pos, zoom;

		if ( coord ) {
			pos = coord.split( ',' );
			marker.setPosition( new window.google.maps.LatLng( pos[0], pos[1] ) );

			zoom = pos.length > 2 ? parseInt( pos[2], 10 ) : 12;

			gmap.setCenter( marker.position );
			gmap.setZoom( zoom );
		}
	}

	function geocodeAddress( address ) {
		geocoder.geocode( {'address': address}, function ( results, status ) {
			if ( status == window.google.maps.GeocoderStatus.OK ) {
				updatePositionInput( results[0].geometry.location );
				marker.setPosition( results[0].geometry.location );
				gmap.setCenter( marker.position );
				gmap.setZoom( 15 );
			}
		} );
	}

	function autoCompleteAddress(){
		if (!input_add) return null;

		input_add.autocomplete({
			source: function(request, response) {
				// TODO: add 'region' option, to help bias geocoder.
				geocoder.geocode( {'address': request.term }, function(results, status) {
					response(jQuery.map(results, function(item) {
						return {
							label     : item.formatted_address,
							value     : item.formatted_address,
							latitude  : item.geometry.location.lat(),
							longitude : item.geometry.location.lng()
						};
					}));
				});
			},
			select: function(event, ui) {

				input_area.val(ui.item.latitude + ',' + ui.item.longitude );

				var location = new window.google.maps.LatLng(ui.item.latitude, ui.item.longitude);

				gmap.setCenter(location);
				// Drop the Marker
				setTimeout( function(){
					marker.setValues({
						position    : location,
						animation   : window.google.maps.Animation.DROP
					});
				}, 1500);
			}
		});
	}")->burn_media();
?>
<div class="step-view-container">
	<div class="step-header-name"><?php echo __('Your Store Details', 'vendor-setup-wizard');?></div>
	<div class="step-container-field">
		<form id="vendor-setup-wizard-setup-form">
		<?php 
		$options             = get_option( 'dokan_general', [] );
        $custom_store_url    = ! empty( $options['custom_store_url'] ) ? $options['custom_store_url'] : 'store';
        $extra_fee_recipient = ! empty( $options['extra_fee_recipient'] ) ? $options['extra_fee_recipient'] : 'seller';
        $recipients = array(
            'seller' => __( 'Vendor', 'vendor-setup-wizard' ),
            'admin'  => __( 'Admin', 'vendor-setup-wizard' ),
        );
        ?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Vendor Store URL', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input type="text" name="dokan_option_custom_store_url" value="<?php echo $custom_store_url; ?>" />
				<p class="description"><?php _e( 'Define vendor store URL', 'dokan-lite' ); ?> (<?php echo site_url(); ?>/[this-text]/<?php echo $this->get_user_dokan_config('store_name');?>)</p>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Extra Fee Recipient', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<select name="dokan_option_extra_fee_recipient">
					<?php
						foreach ( $recipients as $key => $value ) {
							$selected = ( $extra_fee_recipient == $key ) ? ' selected="true"' : '';
							echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Store Name', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $this->get_user_dokan_config('store_name');?>" name="store_name" placeholder="<?php _e( 'Store name', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
				<p class="description"><?php _e( 'Define vendor store URL', 'dokan-lite' ); ?> (<?php echo site_url(); ?>/<?php echo $custom_store_url; ?>/[this-text])</p>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Store Product Per Page', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $this->get_user_dokan_config('dokan_store_ppp'); ?>" name="dokan_store_ppp" placeholder="<?php _e( 'Store Product Per Page', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<?php $address = $this->get_user_dokan_config('dokan_address');?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Street 1', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['street_1'] ?>" name="dokan_address[street_1]" placeholder="<?php _e( 'Street', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Street 2', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['street_2'] ?>" name="dokan_address[street_2]" placeholder="<?php _e( 'Street 2', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Zip', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['zip'] ?>" name="dokan_address[zip]" placeholder="<?php _e( 'Zip', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<?php
		$country_obj   = new WC_Countries();
        $countries     = $country_obj->countries;
        $states        = $country_obj->states;
		?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Country', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<select  name="dokan_address[country]" class="country_to_state dokan-form-control" onchange="javascript:getDokanState(this.value)">
                    <?php dokan_country_dropdown( $countries, $address['country'], false ); ?>
                </select>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'State', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<select name="dokan_address[state]" class="dokan-form-control" id="dokan_address_state">
                    <?php $this->getDokanStateDwopdown( $states[$address['country']], $address['state'] ) ?>
                </select>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Phone No', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $this->get_user_dokan_config('setting_phone'); ?>" name="setting_phone" placeholder="<?php _e( 'Phone No', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Email', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<label>
					<input type="checkbox" onClick="javascript:choiseShowEmail(this);" name="setting_show_email" value="<?php echo $this->get_user_dokan_config('setting_show_email');?>" <?php checked( $this->get_user_dokan_config('setting_show_email'), 'yes' ); ?>> <?php _e( 'Show email address in store', 'vendor-setup-wizard' ); ?>
				</label>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'More product', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<label>
					<input type="checkbox" onClick="javascript:choiseMoreProduct(this);" name="setting_show_more_ptab" value="<?php echo $this->get_user_dokan_config('setting_show_more_ptab');?>" <?php checked( $this->get_user_dokan_config('setting_show_more_ptab'), 'yes' ); ?>> <?php _e( 'Enable tab on product single page view', 'vendor-setup-wizard' ); ?>
				</label>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Dokan user Map', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
                <input id="dokan-map-lat" type="hidden" name="location" value="<?php echo $map_location; ?>" size="30" />
                <div class="dokan-map-wrap">
                    <div class="dokan-map-search-bar">
                        <input id="dokan-map-add" type="text" class="dokan-map-search" value="<?php echo $map_address; ?>" name="find_address" placeholder="<?php _e( 'Type an address to find', 'vendor-setup-wizard' ); ?>" size="30" />
                        <a href="#" class="dokan-map-find-btn" id="dokan-location-find-btn" type="button"><?php _e( 'Find Address', 'vendor-setup-wizard' ); ?></a>
                    </div>

                    <div class="dokan-google-map" id="dokan-map" style="width: 100%; height: 300px;margin-top: 20px;"></div>
                </div>
            </div>
		</div>
		<?php $tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );?>
		<?php if ( $tnc_enable == 'on' ) :?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Terms and Conditions', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<label>
					<input type="checkbox" onClick="javascript:choiseTerm(this);" value="<?php echo enable_tnc;?>" <?php echo $enable_tnc == 'on' ? 'checked':'' ; ?> name="dokan_store_tnc_enable" ><?php _e( 'Show terms and conditions in store page', 'vendor-setup-wizard' ); ?>
				</label>
			</div>
		</div>
		<?php endif;?>
		
		</form>
	</div>
	<div class="step-bottom-action">
		<button class="step-action" onClick="javascript:save_form_setup('dokan_general');"><?php echo __('Next', 'vendor-setup-wizard');?></button>
		<!--<button class="step-action" onClick="javascript:skip();"><?php echo __('Skip this step', 'vendor-setup-wizard');?></button>-->
	</div>
</div>