<?php
/**
 * Attendance Manager - Admin Section Attendance Manager
 * 
 * @package 
 * @author shaon
 */
class palamAdminPanel{
	var $user_level = 'manage_options';
	
	function palamAdminPanel() {
		add_action( 'admin_menu', array(&$this, 'add_menu') );
	}

	function add_menu()  {
		add_menu_page(__( 'Employment Information' ),__( 'Employee Info' ), $this->user_level, pluginsFOLDER, array(&$this, 'show_menu'), plugin_dir_url( __FILE__ ).'images/survay.png',80;
				add_submenu_page(pluginsFOLDER, __('Create Department Link'), __('Department Link'), $this->user_level,'department',array(&$this,'show_menu') );
				add_submenu_page(pluginsFOLDER, __('Create Designation Link'), __('designation Link'), $this->user_level,'designation',array(&$this,'show_menu') );
				add_submenu_page(pluginsFOLDER, __('Create Employee Link'), __('Employee Link'), $this->user_level,'employee',array(&$this,'show_menu') );		
	}
	

	function show_menu() {
  		switch ($_GET['page']){
			case "employee":
				include_once(dirname(__FILE__).'/employee.php');
				//employee_info();
				break;
			case "department":
				include_once(dirname(__FILE__).'/department.php');
				//department_info();
				break;
			case "designation":
				include_once(dirname(__FILE__).'/designation.php');
				//designation_info();
				break;
			default:
				include_once(dirname(__FILE__).'/suvay_information.php');
				survay_info();
				break;
		}
	}
	
}
?>