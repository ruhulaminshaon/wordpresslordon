<?php
/**
 * vendor-setup-wizard Controller class
 *
 * @author VTGroup
 */
 if (!class_exists('VendorSetupWizard_Controller'))
 {
	class VendorSetupWizard_Controller {
		static  $_instances = Array();
		private $_scripts   = Array();
		private $_styles    = Array();
		private $_db        = null;
		public function __construct($db)
		{
			$this->_db = $db;
		}
		public static function getInstance($key = 'new', $db = null)
		{
			if (!isset(self::$_instances[$key])){
				self::$_instances[$key] = new self($db);
			}
			return self::$_instances[$key];
		}
		function get_current_user_id()
		{
			$user = wp_get_current_user();
			if (is_object($user) && isset($user->data->ID)){
				return $user->data->ID;
			}
			return 0;
		}
		function get_user_config($field)
		{
			return get_user_meta( $this->get_current_user_id(), $field, true);
		}
		function get_user_dokan_config($field)
		{
			$store_info = dokan_get_store_info($this->get_current_user_id());
			if (isset($store_info[$field])){
				return $store_info[$field];
			}
			return '';
		}
		function save_user_config($field, $value)
		{
			return update_user_meta($this->get_current_user_id(), $field, $value);
		}
		protected function splitQueries($query)
		{
			$buffer    = array();
			$queries   = array();
			$in_string = false;
			// Trim any whitespace.
			$query     = trim($query);
			// Remove comment lines.
			$query     = preg_replace("/\n\#[^\n]*/", '', "\n" . $query);
			// Remove PostgreSQL comment lines.
			$query     = preg_replace("/\n\--[^\n]*/", '', "\n" . $query);
			// Find function.
			$funct     = explode('CREATE OR REPLACE FUNCTION', $query);
			// Save sql before function and parse it.
			$query     = $funct[0];
			// Parse the schema file to break up queries.
			for ($i = 0; $i < strlen($query) - 1; $i++)
			{
				if ($query[$i] == ';' && !$in_string){
					$queries[] = substr($query, 0, $i);
					$query     = substr($query, $i + 1);
					$i         = 0;
				}
				if ($in_string && ($query[$i] == $in_string) && $buffer[1] != "\\"){
					$in_string = false;
				}elseif (!$in_string && ($query[$i] == '"' || $query[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\")){
					$in_string = $query[$i];
				}
				if (isset ($buffer[1])){
					$buffer[0] = $buffer[1];
				}
				$buffer[1] = $query[$i];
			}
			// If the is anything left over, add it to the queries.
			if (!empty($query)){
				$queries[] = $query;
			}
			// Add function part as is.
			for ($f = 1, $fMax = count($funct); $f < $fMax; $f++)
			{
				$queries[] = 'CREATE OR REPLACE FUNCTION ' . $funct[$f];
			}
			return $queries;
		}
		function installSamples($filter = 'sample')
		{		
			/*
			 * Import all SQLs file from sql folder
			 */
			require_once(dirname(__FILE__).'/files.php');
			$basePath = wallabb_path.'/datas/sql/';
			$files = wallabb_files::files($basePath, '\.sql$');
			if (empty($files)){
				return false;
			}
			foreach ($files as $file)
			{
				if (strpos(strtolower(trim($file)), strtolower(trim($filter))) !== false)
				{
					// Get the contents of the schema file.
					$buffer  = file_get_contents($basePath.$file);
					// Get an array of queries from the schema and process them.
					$queries = $this->splitQueries($buffer);
					foreach ($queries as $query)
					{
						// Trim any whitespace.
						$query = trim($query);
						// If the query isn't empty and is not a MySQL or PostgreSQL comment, execute it.
						if (!empty($query) && ($query{0} != '#') && ($query{0} != '-')){
							$query = $this->convertUtf8mb4QueryToUtf8($query);
							$query = str_replace('#__', $this->_db->prefix, $query);
							$this->_db->query($query);
						}
					}
				}
			}
		}
		public function convertUtf8mb4QueryToUtf8($query)
		{
			return str_replace('utf8mb4', 'utf8', $query);
		}
		function do_install() {
			$install_file = vendor_setup_wizard_path.'/datas/sql/install.sql';
			$buffer       = file_get_contents($install_file);
			$queries      = $this->splitQueries($buffer);
			foreach ($queries as $query)
			{
				// Trim any whitespace.
				$query = trim($query);
				// If the query isn't empty and is not a MySQL or PostgreSQL comment, execute it.
				if (!empty($query) && ($query{0} != '#') && ($query{0} != '-')){
					$query = $this->convertUtf8mb4QueryToUtf8($query);
					$query = str_replace('#__', $this->_db->prefix, $query);
					$this->_db->query($query);
				}
			}
			return true;
		}
		function do_uninstall() {
			$uninstall_file = vendor_setup_wizard_path.'/datas/sql/uninstall.sql';
			$buffer         = file_get_contents($uninstall_file);
			$queries        = $this->splitQueries($buffer);
			foreach ($queries as $query)
			{
				// Trim any whitespace.
				$query = trim($query);
				// If the query isn't empty and is not a MySQL or PostgreSQL comment, execute it.
				if (!empty($query) && ($query{0} != '#') && ($query{0} != '-')){
					$query = $this->convertUtf8mb4QueryToUtf8($query);
					$query = str_replace('#__', $this->_db->prefix, $query);
					$this->_db->query($query);
				}
			}
			return true;
		}
		function add_menus() 
		{
			add_menu_page('Dokan Wizard Setup', __('Dokan Wizard Setup', 'Dokan Wizard Setup'), 'manage_options', 'DokanWizardSetup', array(&$this, 'action_admin_menu'), vendor_setup_wizard_url.'/datas/assets/images/main.png');
		}
		function loadView($viewName = 'default', $mod = 'html')
		{
			if (empty($viewName)){
				$viewName = 'default';
			}
			if (is_admin()){
				$viewName = vendor_setup_wizard_path.'datas/views/admin/'.$viewName.'.php';
			}else{
				$viewName = vendor_setup_wizard_path.'datas/views/site/'.$viewName.'.php';
			}
			if (file_exists($viewName)){
				ob_start();
				include($viewName);
				$contents = ob_get_clean();
				echo $contents;
			}
			if ($mod == 'rawmode'){
				$this->exist();
			}
		}
		function action_admin_menu()
		{
			$this->loadView($_REQUEST['view']);
		}
		function backend_do_tasks() 
		{
			//DO tasks
			$task = @$_REQUEST['vendor_setup_wizard_task'];
			switch ($task)
			{			
				case 'save_configs':
					$this->save_config_fields();
					break;
			}
		}
		function save_config_fields()
		{
			$_fields = $_REQUEST['config_fields'];
			if (count($_fields) > 0){
				foreach ($_fields as $key => $val){
					if (isset($val['name']) && isset($val['value'])){
						update_option($val['name'], sanitize_text_field($val['value']));
					}
				}
			}
			$this->exist();
		}
		function getDokanStateDwopdown( $options, $selected = '', $everywhere = false ) {
			printf( '<option value="">%s</option>', __( '- Select a State -', 'dokan-lite' ) );

			if ( $everywhere ) {
				echo '<optgroup label="--------------------------">';
				printf( '<option value="everywhere" %s>%s</option>', selected( $selected, 'everywhere', true ), __( 'Everywhere Else', 'dokan-lite' ) );
				echo '</optgroup>';
			}

			echo '<optgroup label="------------------------------">';
			foreach ($options as $key => $value) {
				printf( '<option value="%s" %s>%s</option>', $key, selected( $selected, $key, true ), $value );
			}
			echo '</optgroup>';
		}
		function getDokanState()
		{
			$country_obj   = new WC_Countries();
			$states        = $country_obj->states;
			$address = $this->get_user_config('dokan_address');
			$this->getDokanStateDwopdown($states[$_REQUEST['country']], $address['state']);
			$this->exist();
		}
		function frontend_do_tasks()
		{
			$task = @$_REQUEST['vendor_setup_wizard_task'];
			switch ($task)		
			{
				case 'get-dokan-state':
					$this->getDokanState();
					break;
				case 'vendor-setup-step':
					if (current_user_can('administrator')){
						$this->loadView('admin-views/load-step-setup', 'rawmode');
					}else{
						$this->loadView('vendor-views/load-step-setup', 'rawmode');
					}
					break;
				case 'vendor-setup-save':
					$options = get_option( $_REQUEST['dokan-step'], Array() );
					if (!is_array($options) || $_REQUEST['dokan-step'] == 'dokan_withdraw'){
						$options = Array();
					}
					if ($_REQUEST['dokan-step'] == 'dokan_withdraw')
					{
						$dokan_settings = dokan_get_store_info( $this->get_current_user_id() );
						if ( isset( $_POST['settings']['bank'] ) ) {						
							$bank = $_POST['settings']['bank'];

							$dokan_settings['payment']['bank'] = array(
								'ac_name'        => sanitize_text_field( $bank['ac_name'] ),
								'ac_number'      => sanitize_text_field( $bank['ac_number'] ),
								'bank_name'      => sanitize_text_field( $bank['bank_name'] ),
								'bank_addr'      => sanitize_text_field( $bank['bank_addr'] ),
								'routing_number' => sanitize_text_field( $bank['routing_number'] ),
								'iban'           => sanitize_text_field( $bank['iban'] ),
								'swift'          => sanitize_text_field( $bank['swift'] ),
							);
						}

						if ( isset( $_POST['settings']['paypal'] ) ) {
							$dokan_settings['payment']['paypal'] = array(
								'email' => filter_var( $_POST['settings']['paypal']['email'], FILTER_VALIDATE_EMAIL )
							);
						}

						if ( isset( $_POST['settings']['skrill'] ) ) {
							$dokan_settings['payment']['skrill'] = array(
								'email' => filter_var( $_POST['settings']['skrill']['email'], FILTER_VALIDATE_EMAIL )
							);
						}
						$this->save_user_config('dokan_profile_settings', $dokan_settings);
						foreach($_POST as $key => $val){
							if (strpos($key, 'dokan_option_') !== false){
								if (is_array($val)){
									$options[str_replace('dokan_option_', '', $key)]    = ! empty( $val ) ? $val : Array();
								}else{
									$options[str_replace('dokan_option_', '', $key)]    = ! empty( $val ) ? sanitize_text_field($val) : '';
								}
							}
						}
					}elseif($_REQUEST['dokan-step'] == 'dokan_general'){
						$dokan_settings = dokan_get_store_info( $this->get_current_user_id());
						if (!is_array($dokan_settings)){
							$dokan_settings = Array();
						}
						
						$dokan_settings['address'] = Array();
						$dokan_settings['dokan_address'] = Array();
						foreach($_POST['dokan_address'] as $key => $val){
							$dokan_settings['address'][$key] = $_POST['dokan_address'][$key];
							$dokan_settings['dokan_address'][$key] = $_POST['dokan_address'][$key];
							
						}
						foreach($_POST as $key => $val){
							if (strpos($key, 'dokan_option_') !== false){
								if (is_array($val)){
									$options[str_replace('dokan_option_', '', $key)]    = ! empty( $val ) ? $val : Array();
								}else{
									$options[str_replace('dokan_option_', '', $key)]    = ! empty( $val ) ? sanitize_text_field($val) : '';
								}
							}else{
								$dokan_settings[$key] = $val;
							}
						}
						$this->save_user_config('dokan_profile_settings', $dokan_settings);
					}else{
						$dokan_settings = dokan_get_store_info( $this->get_current_user_id() );
						foreach($_POST as $key => $val){
							if (strpos($key, 'dokan_option_') !== false){
								if (is_array($val)){
									$options[str_replace('dokan_option_', '', $key)]    = ! empty( $val ) ? $val : Array();
								}else{
									$options[str_replace('dokan_option_', '', $key)]    = ! empty( $val ) ? sanitize_text_field($val) : '';
								}
							}else{
								$dokan_settings[$key] = $val;
							}
						}
						$this->save_user_config('dokan_profile_settings', $dokan_settings);
					}
					if ($_REQUEST['dokan-step'] != ''){
						update_option( $_REQUEST['dokan-step'], $options);
					}
					$this->exist();
					break;
			}
			$this->loadView(@$_REQUEST['view']);
		}
		function setting_up_dokan()
		{
			global $post;
			if ($post->post_content == '[dokan-dashboard]'){
				$googleMapApi = get_option('vendor_setup_wizard_googlemapapikey', '');
				$map_location = $this->get_user_dokan_config('location');
				$locations = explode( ',', $map_location );
				$def_lat = isset( $locations[0] ) ? $locations[0] : 90.40714300000002;
				$def_long = isset( $locations[1] ) ? $locations[1] : 23.709921;
				$this->add_custom_javascript("
					var def_zoomval = 12;
					var def_longval = '".$def_long."';
					var def_latval = '".$def_lat."';
					var curpoint,geocoder,map_area,input_area,input_add,find_btn;
					function updatePositionInputInject( lat, lng ) {
						jQuery('input[placeholder=\"Street address\"]').val(jQuery('input#dokan-map-add').val());
						jQuery('input[placeholder=\"Apartment, suite, unit etc. (optional)\"]').val(jQuery('input#dokan-map-add').val());
						var url = '//maps.googleapis.com/maps/api/geocode/json?latlng=' + lat + ',' + lng + '&sensor=true&key=".$googleMapApi."';
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
										if (jQuery('input[placeholder=\"Town / City\"]').length > 0){
											jQuery('input[placeholder=\"Town / City\"]').val(city);
										}
										if (jQuery('input#dokan_address_state').length > 0){
											jQuery('input#dokan_address_state').val(state);
										}
										if (jQuery('select#dokan_address_country').length > 0){
											jQuery('select#dokan_address_country').val(country);
										}
									}
									jQuery.each(searchAddressComponents, function(){
										if(this.types[0] == \"postal_code\"){
											post_code = this.long_name;
										}
									});
									if (jQuery('input[placeholder=\"Postcode / Zip\"').length > 0){
										jQuery('input[placeholder=\"Postcode / Zip\"').val(post_code);
									}
								}						
							}
						});
					}
					jQuery(document).ready(function(){
						if (jQuery('input#dokan-map-add').length > 0)
						{
							var current_map = jQuery('input#dokan-map-add').parents('div.dokan-form-group');
							var map_to_top = current_map.clone(true);
							jQuery('input#dokan_store_ppp').parents('div.dokan-form-group').after(map_to_top);
							current_map.remove();
							jQuery('label[for=\"setting_map\"]').html('Store Location');
							try{
								curpoint = new google.maps.LatLng(def_latval, def_longval);
								geocoder   = new window.google.maps.Geocoder();
								map_area = jQuery('#dokan-map');
								input_area = jQuery( '#dokan-map-lat' );
								input_add = jQuery( '#dokan-map-add' );
								find_btn = jQuery( '#dokan-location-find-btn' );

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
									updatePositionInput(event.latLng );
									updatePositionInputInject(event.latLng.lat(), event.latLng.lng());
								} );

								window.google.maps.event.addListener( marker, 'drag', function ( event ) {
									updatePositionInput(event.latLng );
									updatePositionInputInject(event.latLng.lat(), event.latLng.lng());
								});
							}catch(e){
								console.log( 'Google API not found.' );
							}
							jQuery( '#dokan-map-add' ).autocomplete({
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
									jQuery( '#dokan-map-lat' ).val(ui.item.latitude + ',' + ui.item.longitude );
									var location = new window.google.maps.LatLng(ui.item.latitude, ui.item.longitude);									
									gmap.setCenter(location);
									// Drop the Marker
									var marker = new window.google.maps.Marker({
										position: curpoint,
										map: gmap,
										draggable: true
									});
									setTimeout( function(){
										marker.setValues({
											position    : location,
											animation   : window.google.maps.Animation.DROP
										});
									}, 1500);
									updatePositionInputInject(ui.item.latitude, ui.item.longitude);
								}
							});
						}
					});
				")->burn_media();
			}
		}
		function add_script($script_file, $key = null, $external = false)
		{
			if ($external){
				$this->_scripts[$key] = '<script type="text/javascript" src="'.$script_file.'"></script>';
			}else{
				$this->_scripts[$key] = '<script type="text/javascript" src="'.vendor_setup_wizard_url.$script_file.'"></script>';
			}
			
			return $this;
		}
		function wp_enqueue_script($key)
		{
			wp_enqueue_script($key);
			return $this;
		}
		function add_enqueue_script($script_file, $key, $external = false)
		{
			if ($external){
				wp_register_script($key, $script_file);
			}else{
				wp_register_script($key, vendor_setup_wizard_url.$script_file);
			}
			$this->wp_enqueue_script($key);
			return $this;
		}
		function add_style($style_file, $key = null, $external = false)
		{
			if ($external){
				$this->_styles[$key] = '<link type="text/css" href="'.$style_file.'" rel="stylesheet"  media="all"/>';
			}else{
				$this->_styles[$key] = '<link type="text/css" href="'.vendor_setup_wizard_url.$style_file.'" rel="stylesheet"  media="all"/>';
			}
			return $this; 
		}
		function wp_enqueue_style($key)
		{
			wp_enqueue_style($key);
			return $this;
		}
		function add_enqueue_style($style_file, $key, $external = false)
		{
			if ($external){
				wp_register_style($key, $style_file);
			}else{
				wp_register_style($key, vendor_setup_wizard_url.$style_file);
			}
			$this->wp_enqueue_style($key);
			return $this; 
		}
		function add_custom_javascript($js_code, $key = null)
		{
			$this->_scripts[$key] = '
			<script type="text/javascript">
			'.$js_code.'
			</script>';
			return $this;
		}
		function add_custom_style($style_code, $key = null)
		{
			$this->_styles[$key] = '
			<style type="text/css">
			'.$style_code.'
			</style>';
			return $this;
		}
		function burn_media()
		{
			echo implode(PHP_EOL, $this->_styles).PHP_EOL;
			echo implode(PHP_EOL, $this->_scripts);
			$this->_styles  = Array();
			$this->_scripts = Array();
			return $this;
		}
		function load_default_media()
		{
			if (is_admin()){
				$this->wp_enqueue_script('jquery')
					 ->add_enqueue_style('/datas/assets/css/admin-style.css', 'admin-style');
			}
			$this->add_enqueue_script('/datas/assets/js/funcs.js', 'jquery-funcs');
			if (is_admin()){
				$this->add_custom_javascript("
					 jQuery.noConflict();
				  ", 'conflict');
			}else{
				$this->add_enqueue_style('/datas/assets/css/site-style.css', 'site-style');
				$this->add_enqueue_script('/datas/assets/js/beautifully-step.js', 'beautifully-step');
				$googleMapApi = get_option('vendor_setup_wizard_googlemapapikey', '');
				$this->add_script('https://maps.googleapis.com/maps/api/js?v=3.exp&key='.$googleMapApi, 'google', true);
			}
			if (!is_admin()){
				$this->add_custom_javascript("
					var vendor_setup_wizard_baseUrl = '".$this->getAppURL()."';
					var vendor_setup_wizard_base_url = '".vendor_setup_wizard_url."';
				", 'base-variable');
			}else{
				$this->add_custom_javascript("
					var vendor_setup_wizard_baseUrl = '".get_site_url()."/wp-admin/';
					var vendor_setup_wizard_base_url = '".vendor_setup_wizard_url."';
				", 'base-variable');
			} 
			return $this;
		}
		function load_languages()
		{
			load_plugin_textdomain('vendor-setup-wizard', false, vendor_setup_wizard_path.'/datas/i18n/languages');
		}
		function vendor_setup_wizard_main()
		{
			if(!is_user_logged_in()){
			   auth_redirect();
			}
			if (current_user_can('administrator')){
				$this->loadView('admin');
			}else{
				$this->loadView('vendor');
			}
		}
		function get_url_shortcode()
		{
			$query = "SELECT ID FROM ".$this->_db->prefix."posts WHERE post_content LIKE '%[vendor_setup_wizard_main]%'";
			$rows = $this->_db->get_results($query, OBJECT);
			if (count($rows) > 0){
				return get_permalink($rows[0]->ID);
			}else{
			}
			return get_site_url();
		}
		function do_shortcodes()
		{
			add_shortcode('vendor_setup_wizard_main', array($this, 'vendor_setup_wizard_main'));
		}
		function is_ajax()
		{
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
				return true; 
			}
			return false;
		}
		function cleanUrl($currentUrl)
		{
			$parsed = parse_url($currentUrl);
			$query = $parsed['query'];
			parse_str($query, $params);
			unset($params['page_number']);
			if (count($params) > 0){
				return $parsed['scheme'].'://'.$parsed['host'].$parsed['path'].'?'.http_build_query($params);
			}
			return $parsed['scheme'].'://'.$parsed['host'].$parsed['path'];
		}
		function makeUrlRawmode($query)
		{
			if (strpbrk($query, 'rawmode') !== true){
				$query .= '&mod=rawmode';
			}
			return $this->cleanUrl($this->getAppURL().'/?'.$query);
		}
		function makeFullUrl($query = '')
		{
			$app_url = $this->getAppURL();
			if (strpos($app_url, '?') !== false){
				return $this->cleanUrl($app_url.'&'.$query);
			}
			return ($query != ''?$this->cleanUrl($app_url.'?'.$query):$this->cleanUrl($app_url));
		}
		function getAppURL($query = null, $use_forwarded_host = false)
		{	    
			return $this->get_url_shortcode();
		}
		function compile()
		{
			$this->frontend_do_tasks();
			$this->wp_enqueue_script('jquery-ui-dialog');
			if (!$this->is_ajax()){
				$this->load_default_media();
				add_action('wp_footer', array(&$this, 'burn_media'), 100);
			}
		}
		function exist($msg = '')
		{
			die($msg);
		}	
	}
 }