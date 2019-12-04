<?php
/*
Plugin Name: vendor-wizard-setup
Plugin URI: http://www.wordpress.org
Description: vendor-wizard-setup - An integration with Dokan
Version: 1.0
Author: VTGroup
Author URI: http://www.vt-group.vn
License: Under Copy Rigth Licence
*/
global $wpdb, $vendor_setup_wizard_controller;
define('vendor_setup_wizard_path', plugin_dir_path(__FILE__));
define('vendor_setup_wizard_url', plugin_dir_url(__FILE__));
require_once(vendor_setup_wizard_path.'/classes/vendor_setup_wizard_controller.php');
$vendor_setup_wizard_controller = VendorSetupWizard_Controller::getInstance('global', $wpdb);
/**
 * Backend requests
 */
if (is_admin()){
	add_action('admin_menu', array(&$vendor_setup_wizard_controller, 'add_menus'));
	function activate_vendor_setup_wizard_plugin()
	{
		global $vendor_setup_wizard_controller;
	    $vendor_setup_wizard_controller->do_install();
	}
	function deactivate_vendor_setup_wizard_plugin()
	{
		global $vendor_setup_wizard_controller;
	    $vendor_setup_wizard_controller->do_uninstall();
	}
	function vendor_setup_wizard_add_media()
	{
		global $vendor_setup_wizard_controller;
		$vendor_setup_wizard_controller->load_default_media()->burn_media();
	    $vendor_setup_wizard_controller->wp_enqueue_script('jquery-ui-dialog');
	    $vendor_setup_wizard_controller->wp_enqueue_script('jquery-ui-tabs');
	}
	if (@$_REQUEST['mod'] == 'rawmode'){
		add_action('wp_loaded', array(&$vendor_setup_wizard_controller, 'backend_do_tasks'));
	}else{
		$vendor_setup_wizard_controller->backend_do_tasks();
		$vendor_setup_wizard_controller->wp_enqueue_script('jquery-ui-tabs');
	}
	
	register_activation_hook(__FILE__, ('activate_vendor_setup_wizard_plugin'));
	register_deactivation_hook(__FILE__, ('deactivate_vendor_setup_wizard_plugin'));
	add_action('admin_enqueue_scripts', 'vendor_setup_wizard_add_media');
}
/**
 * Front-end requests
 */
else
{
	function redirect_wizard_setup()
	{
		global $vendor_setup_wizard_controller;
		wp_redirect($vendor_setup_wizard_controller->get_url_shortcode());
		exit();
	}
	if (@$_REQUEST['mod'] == 'rawmode'){
		add_action('wp_loaded', array(&$vendor_setup_wizard_controller, 'frontend_do_tasks'));
	}else{		
		add_action('wp_loaded', array(&$vendor_setup_wizard_controller, 'compile'), 200);
		add_action('wp_footer', array(&$vendor_setup_wizard_controller, 'setting_up_dokan'));
	}
	if (!isset($_REQUEST['vendor_setup_wizard_task'])){
		add_action('wp_loaded', array(&$vendor_setup_wizard_controller, 'do_shortcodes'), 100);
	}
	add_action('woocommerce_registration_redirect', 'redirect_wizard_setup', 2);
}

add_action('widgets_init', array(&$vendor_setup_wizard_controller, 'load_languages'));
?>