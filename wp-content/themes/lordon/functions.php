<?php
//define('THEME_URI',get_template_directory_uri());
//define('THEME_PATH',get_template_directory());
/*INCLUDE THEME FILES*/
//include( THEME_PATH .'/inc/theme-file.php');
/*HOOK*/
//add_action('wp_enqueue_script','xpent_scripts');

function lordon_theme(){
	add_theme_support( 'title-tag' );

	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'post-thumbnails' );
	
	//logo
	add_theme_support( 'custom-logo' );
	//search
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	//menu
	register_nav_menus( array(
	'main_menu' =>  __('Main Menu'),
	'social_menu'=> __('Social Share Button'),
	'footer_menu' => __('Footer Menu'),
	) );
}
add_action('init','lordon_theme');


//Wp enqueue scripts
function theme_lordon_style(){
	//style
	wp_enqueue_style('bootstrap-style',get_template_directory_uri().'/css/bootstrap.css');
	wp_enqueue_style('font-awesome-min',get_template_directory_uri().'/css/font-awesome.min.css');
	wp_enqueue_style('owl-carousel',get_template_directory_uri().'/css/owl.carousel.css');
	wp_enqueue_style('preset',get_template_directory_uri().'/scss/preset.css');
	wp_enqueue_style('lordon-style',get_template_directory_uri().'/scss/style.css');
	wp_enqueue_style('responsive',get_template_directory_uri().'/scss/responsive.css');
	wp_enqueue_style('mystyle',get_template_directory_uri().'/style.css');
	
	//theme javascript file	
	wp_enqueue_script('jquery',get_template_directory_uri().'/js/jquery.js');
	wp_enqueue_script('bootstrapjs',get_template_directory_uri().'/js/bootstrap.js','jquery', 'null', true);
	wp_enqueue_script('owljs',get_template_directory_uri().'/js/owl.carousel.min.js','jquery', 'null', true);
	wp_enqueue_script('themejs',get_template_directory_uri().'/js/theme.js','jquery', 'null', true);
	wp_enqueue_script('typekit','https://use.typekit.net/iut1smu.js','jquery', 'null', true);
	wp_enqueue_script('category_ajax',get_template_directory_uri().'/ajax.js','jquery', 'null', true);

}
add_action('wp_enqueue_scripts','theme_lordon_style');

function typekit_script(){
?>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>	
<?php
}
add_action('wp_footer','typekit_script','30');
/*
============================
new line post blog
============================
*/
//1st blog
add_action( 'init', 'newline_blog' );
function newline_blog() {
	$labels = array(
		'name'               => _x( 'NewLines', 'post type new line', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'NewLine', 'post type singular newline', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'NewLines', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'NewLine', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'newline', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Line', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Line', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit NewLine', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View NewLine', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All NewLines', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search NewLines', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent NewLines:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No newlines found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No newlines found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'newline' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'taxonomies'=>array('category','post_tag')
	);


	register_post_type( 'newline', $args );
}


//2nd blog
add_action( 'init', 'portfolio_blog' );
function portfolio_blog() {
	$labels = array(
		'name'               => _x( 'Portfolios', 'post type Portfolio', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Portfolio', 'post type singular Portfolio', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Portfolios', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Portfolio', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Portfolio', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Portfolio', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Portfolio', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Portfolio', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Portfolio', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Portfolios', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Portfolios', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Portfolios:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Portfolios found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Portfolios found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'portfolio' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'taxonomies'=>array('category','post_tag')
	);


	register_post_type( 'portfolio', $args );
}

/*
================================
acf option page(theme page)
================================
*/
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'HEADER',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Header Settings',
		'menu_title'	=> 'Slider',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Footer Settings',
		'menu_title'	=> 'Footer',
		'parent_slug'	=> 'theme-general-settings',
	));
}

?>