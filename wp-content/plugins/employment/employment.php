<?php
/*
Plugin Name: Employee Meannagement system
Plugin URI: http://www.561websitedesign.com
Description: Collect Review From Clent.
Author: Shaon
Version: 1.0

Author URI: http://www.561websitedesign.com

Copyright 2017-2018 by 561 Website Design

*/ 

if (!class_exists('wpPalam_Survay')) {
	class wpPalam_Survay {
		function wpPalam_Survay() {
			
			
			$this->define_constant();
			$this->load_dependencies();
			$this->plugin_name = plugin_basename(__FILE__);
			register_activation_hook( $this->plugin_name, array(&$this, 'activate') );
			register_deactivation_hook( $this->plugin_name, array(&$this, 'deactivate') );
			register_uninstall_hook( $this->plugin_name, array(&$this, 'uninstall') );
			add_action( 'plugins_loaded', array(&$this, 'start_plugin') );
		}
		
		function define_constant() {
		    //echo WP_PLUGIN_URL; die;
			define('pluginsFOLDER', plugin_basename( dirname(__FILE__)) );
			define('plugins_ABSPATH', trailingslashit( str_replace("\\","/", WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) ) ) );
			define('plugins_URLPATH', trailingslashit( plugins_url() . '/' . plugin_basename( dirname(__FILE__) ) ) );
		}
		
		function load_dependencies() {
			require_once (dirname (__FILE__) . '/admin/core.php');
			//require_once ( dirname( __FILE__ ) . '/admin/functions.php' );
			if ( is_admin() ) {				
				
				require_once (dirname (__FILE__) . '/admin/admin.php');
				$this->palamAdminPanel = new palamAdminPanel();
			} else {
				
			}
		}
		
		function activate() {
			include_once (dirname (__FILE__) . '/admin/install.php');
			wpPalam_install();
		}
		
		function deactivate() {
			include_once (dirname (__FILE__) . '/admin/install.php');
			wpPalam_deactivate();
		}
		
		function uninstall() {
			include_once (dirname (__FILE__) . '/admin/install.php');
			wpPalam_uninstall();
		}
		
		function start_plugin() {
			if ( is_admin() ) {
				// if(isset($_REQUEST['review_link_submit']))
				// {
				// 	$string = 'palmbeachgreathotelsurvayformlink///'.$_REQUEST['bokking_id'].'$$$';
				// 	$encoded = base64_encode($string);
				// 	$location = get_bloginfo('url').'/survey-form/?review_id='.$encoded;
					
				// 	wp_safe_redirect(get_bloginfo('url').'/survey-form/?review_id='.$encoded);
				// 	exit;
				// }
				
				wp_enqueue_style( 'custom-style', plugins_URLPATH . 'admin/css/bootstrap.css' );
				wp_enqueue_style( 'custom-style', plugins_URLPATH . 'admin/css/custom-style.css' );
				wp_enqueue_script( 'custom-script', plugins_URLPATH . 'admin/js/bootstrap.js', array('jquery'), '1.0.0', FALSE );
				wp_enqueue_script( 'custom-script', plugins_URLPATH . 'admin/js/custom-script.js', array('jquery'), '1.0.0', true );
			}else{
				wp_enqueue_style( 'custom-style', plugins_URLPATH . 'admin/css/custom-style.css' );
				wp_enqueue_style( 'custom-style', plugins_URLPATH . 'admin/css/fancybox.css' );
				wp_enqueue_style( 'custom-style', plugins_URLPATH . 'admin/css/font-awesome.min.css' );
				wp_enqueue_script( 'custom-script', plugins_URLPATH . 'admin/js/custom-script.js', array('jquery'), '1.0.0', FALSE );
				wp_enqueue_script( 'custom-script', plugins_URLPATH . 'admin/js/fancybox.js', array('jquery'), '1.0.0', FALSE );
				wp_enqueue_script( 'custom-script', plugins_URLPATH . 'admin/js/jquery.min.js', array('jquery'), '1.0.0', FALSE );
			}
		}
		
		
	}
	global $nPalam;
	$nPalam = new wpPalam_Survay();
		
}
?>