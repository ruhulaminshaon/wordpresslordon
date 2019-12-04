<?php
/*
Plugin Name: Footer Title section
Plugin URI: http://www.561websitedesign.com
Description: Collect Review From Clent.
Author: Shaon
Version: 0.01

Author URI: http://www.561websitedesign.com

Copyright 2017-2018 by 561 Website Design

*/ 
add_action('admin_menu','my_admin_menu');
function my_admin_menu(){
	add_menu_page('Footer Text title','Footer Settings','manage_options','footer_setting_page','mt_settings_page');
	add_submenu_page('footer_setting_page','page title','sub-menu title','manage_options','child-submenu-handle','my_magic_function');
}
function footer_text_admin_page(){
	echo 'this is where we will edit the variable';
}
function mt_settings_page(){
	echo "<h2>".__('Footer Settings Configurations','menu-test')."</h2>";
	include_once('footer_settings_page.php');
}
?>