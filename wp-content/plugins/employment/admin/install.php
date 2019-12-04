<?php
	function wpPalam_install () { 
		global $wpdb;
		
		if ( !current_user_can('activate_plugins') ) 
			return;
			
		if(!defined('DB_CHARSET') || !($db_charset = DB_CHARSET))
			$db_charset = 'utf8';
		$db_charset = "CHARACTER SET ".$db_charset;
		if(defined('DB_COLLATE') && $db_collate = DB_COLLATE) 
			$db_collate = "COLLATE ".$db_collate;
			
		//Employee table
		$employee = $wpdb->prefix . "employee";
		if($wpdb->get_var("SHOW TABLES LIKE '$employee'") != $employee) {
			$sql = "CREATE TABLE IF NOT EXISTS ".$employee." (
				 `id` int(11) NOT NULL AUTO_INCREMENT,
				 `name` varchar(250) NOT NULL,
				 `email` varchar(250) NOT NULL,
				 `phone` varchar(250) NOT NULL,
				 `address` text NOT NULL,
				 `image` varchar(250) NOT NULL,
				 `dep_id` int(11) NOT NULL,
				 `des_id` int(11) NOT NULL,
				 `status` varchar(250) NOT NULL,
				 PRIMARY KEY (`id`)
				) {$db_charset} {$db_collate};";
			
			$results = $wpdb->query( $sql );
		}
		
		//Department Table
		$department = $wpdb->prefix . "department";
		if($wpdb->get_var("SHOW TABLES LIKE '$department'") != $department) {
			$sql = "CREATE TABLE IF NOT EXISTS ".$department." (
				 `dep_id` int(11) NOT NULL AUTO_INCREMENT,
				 `dep_name` varchar(250) NOT NULL,
				 PRIMARY KEY (`dep_id`)
				) {$db_charset} {$db_collate};";
			
			$results = $wpdb->query( $sql );
		}
		// Mail Check
		$designation = $wpdb->prefix . "designation";
		if($wpdb->get_var("SHOW TABLES LIKE '$designation'") != $designation) {
			$sql = "CREATE TABLE IF NOT EXISTS ".$designation." (
				 `des_id` int(11) NOT NULL AUTO_INCREMENT,
				 `des_name` varchar(250) NOT NULL,
				 PRIMARY KEY (`des_id`)
				) {$db_charset} {$db_collate};";
			
			$results = $wpdb->query( $sql );
		}
		
		
		$uploads = wp_upload_dir();
		$target_dir = $uploads['basedir'].'/trip_image/';
		
		if (!is_dir($target_dir)) { 
				mkdir($target_dir);  
		}
		
		
		
	}
	
	function wpPalam_uninstall(){
		global $wpdb;
        $employee = $wpdb->prefix."employee";
       	$wpdb->query("DROP TABLE IF EXISTS $employee");	
       
       	$department = $wpdb->prefix."department";
       	$wpdb->query("DROP TABLE IF EXISTS $department");

       	$designation = $wpdb->prefix."designation";
       	$wpdb->query("DROP TABLE IF EXISTS $designation");
	}
	
	function wpPalam_deactivate(){
		global $wpdb;
	}

?>