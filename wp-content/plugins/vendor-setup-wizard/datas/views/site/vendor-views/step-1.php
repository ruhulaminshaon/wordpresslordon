<?php 
$map_location   = $this->get_user_dokan_config('location');
$locations = explode( ',', $map_location );
$def_lat = isset( $locations[0] ) ? $locations[0] : 90.40714300000002;
$def_long = isset( $locations[1] ) ? $locations[1] : 23.709921;
$googleMapApi = get_option('vendor_setup_wizard_googlemapapikey', '');
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
			geocodeAddress(input_add.val());
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
		});
		window.google.maps.event.addListener( marker, 'drag', function ( event ) {
			updatePositionInput(event.latLng );
		});
	}catch(e){
		console.log( 'Google API not found.' );
	}

	autoCompleteAddress();

	function updatePositionInput( latLng ) {
		input_area.val( latLng.lat() + ',' + latLng.lng() );
		jQuery('input#dokan_address_street_1').val(jQuery('input#dokan-map-add').val());
		jQuery('input#dokan_address_street_2').val(jQuery('input#dokan-map-add').val());
		var url = '//maps.googleapis.com/maps/api/geocode/json?latlng=' + latLng.lat() + ',' + latLng.lng() + '&sensor=true&key=".$googleMapApi."';
		jQuery.getJSON(url, function(response){
			if(response.results){
				results = response.results;
				if (jQuery.isArray(results)) {
					var searchAddressComponents;
					if (typeof results[0] == undefined){
						for(k in results){
							searchAddressComponents = results[k].address_components;
							break;
						}
					}else{
						searchAddressComponents = results[0].address_components;
					}
					var city, state, country, post_code;
					if (jQuery.isArray(searchAddressComponents)){
						city = searchAddressComponents[4].long_name;
						state = searchAddressComponents[3].short_name;
						country = searchAddressComponents[6].short_name;
						jQuery('input#dokan_address_city').val(city);
						jQuery('input#dokan_address_state').val(state);
						jQuery('select#dokan_address_country').val(country);
					}
					jQuery.each(searchAddressComponents, function(){
						if(this.types[0] == \"postal_code\"){
							post_code = this.long_name;
						}
					});
					jQuery('#dokan_address_zip').val(post_code);
				}						
			}
		});
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
		<?php $address = $this->get_user_dokan_config('dokan_address');?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Store Location', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
                <input id="dokan-map-lat" type="hidden" name="location" value="<?php echo $map_location; ?>" size="30" />
                <div class="dokan-map-wrap">
                    <div class="dokan-map-search-bar">
                        <input id="dokan-map-add" type="text" class="dokan-map-search" title="Map" value="<?php echo $this->get_user_dokan_config('find_address'); ?>" name="find_address" placeholder="<?php _e( 'Please enter location ', 'vendor-setup-wizard' ); ?>" size="13" />
                        <a href="#" class="dokan-map-find-btn" id="dokan-location-find-btn" type="button"><?php _e( 'Search', 'vendor-setup-wizard' ); ?></a>
                    </div>

                    <div class="dokan-google-map" id="dokan-map" style="width: 100%; height: 300px;margin-top: 20px;"></div>
                </div>
            </div>
		</div>		
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Street 1', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['street_1'] ?>" name="dokan_address[street_1]" title="dokan_address_1" id="dokan_address_street_1" placeholder="<?php _e( 'Street', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Street 2', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['street_2'] ?>" name="dokan_address[street_2]" title="dokan_address_2" id="dokan_address_street_2" placeholder="<?php _e( 'Street 2', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Zip', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['zip'] ?>" name="dokan_address[zip]" title="dokan_address_zip" id="dokan_address_zip" placeholder="<?php _e( 'Zip', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'City', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['city'] ?>" name="dokan_address[city]" title="dokan_address_city" id="dokan_address_city" placeholder="<?php _e( 'City', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<?php
		$country_obj   = new WC_Countries();
        $countries     = $country_obj->countries;
		?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Country', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<select  name="dokan_address[country]" title="dokan_address_country" id="dokan_address_country" class="country_to_state dokan-form-control">
                    <?php dokan_country_dropdown( $countries, $address['country'], false ); ?>
                </select>
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'State', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $address['state'] ?>" name="dokan_address[state]" title="dokan_address_state" id="dokan_address_state" placeholder="<?php _e( 'state', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Phone No', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $this->get_user_dokan_config('phone'); ?>" title="setting_phone" name="phone" placeholder="<?php _e( 'Phone No', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Store Product Per Page', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<input value="<?php echo $this->get_user_dokan_config('dokan_store_ppp'); ?>" name="dokan_store_ppp" placeholder="<?php _e( 'Store Product Per Page', 'vendor-setup-wizard'); ?>" class="dokan-form-control" type="text">
			</div>
		</div>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'More product', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<label>
					<input type="checkbox" name="setting_show_more_ptab" value="<?php echo $this->get_user_dokan_config('setting_show_more_ptab');?>" <?php checked( $this->get_user_dokan_config('setting_show_more_ptab'), 'yes' ); ?>> <?php _e( 'Enable tab on product single page view', 'vendor-setup-wizard' ); ?>
				</label>
			</div>
		</div>
		<?php $tnc_enable = dokan_get_option( 'seller_enable_terms_and_conditions', 'dokan_general', 'off' );?>
		<?php if ( $tnc_enable == 'on' ) :?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Terms and Conditions', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<label>
					<input type="checkbox" onClick="javascript:choiseTerm(this);" title="term" value="" <?php checked( $this->get_user_dokan_config('enable_tnc'), 'on' ); ?> name="enable_tnc" ><?php _e(' Show terms and conditions in store page', 'vendor-setup-wizard'); ?>
				</label>
			</div>
		</div>
		<?php endif;?>
		<div class="field-item">
			<div class="field-lbl"><?php _e( 'Email', 'vendor-setup-wizard' ); ?></div>
			<div class="field-value">
				<label>
					<input type="checkbox" onClick="javascript:choiseShowEmail(this);" title="setting_show_email" name="show_email" value="" <?php checked( $this->get_user_dokan_config('show_email'), 'yes' ); ?>> <?php _e( 'Show email address in store', 'vendor-setup-wizard' ); ?>
				</label>
			</div>
		</div>
		</form>
	</div>
	<div class="step-bottom-action">
		<button class="step-action-next" onClick="javascript:save_form_setup('dokan_general');"><?php echo __('Next', 'vendor-setup-wizard');?></button>
		<!--<button class="step-action" onClick="javascript:skip();"><?php echo __('Skip this step', 'vendor-setup-wizard');?></button>-->
	</div>
</div>