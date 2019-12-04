<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo();?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- <link href="<?php //echo get_template_directory_uri();?>/css/bootstrap.css" rel="stylesheet">
    <link href="<?php //echo get_template_directory_uri();?>/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php //echo get_template_directory_uri();?>/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php //echo get_template_directory_uri();?>/scss/preset.css" rel="stylesheet">
    <link href="<?php //echo get_template_directory_uri();?>/scss/style.css" rel="stylesheet">
    <link href="<?php //echo get_template_directory_uri();?>/scss/responsive.css" rel="stylesheet"> -->
    <?php wp_head();?>
  </head>
  <body <?php body_class();?>>
     <!--header start -->
	 <header class="header">
		<div class="container">
			<div class="row rowOfHeaderTop">
				<div class="col-sm-4">
					<div class="socialIcon headerSocialIcon">
						<?php
							if( have_rows('social_icon','option') ):
							    while ( have_rows('social_icon','option') ) : the_row();
						?>
						<a href="<?php the_sub_field('social_link');?>" class="socialLink">
							<img src="<?php the_sub_field('social_icon');?>">
						</a>
							        
						<?php
							    endwhile;
							endif;
						?>
						<!-- <a href="#" class="socialLink">
							<img src="images/fbLogo.png" />
						</a>
						<a href="#" class="socialLink">
							<img src="images/twitterLogo.png" />
						</a>
						<a href="#" class="socialLink">
							<img src="images/linkDnLogo.png" />
						</a> -->
					</div>
				</div>
				<div class="col-sm-4">
					<?php
					$logo=get_field('header_logo','option');
					// echo"<pre>";
					// print_r($logo);
					// echo"</pre>";
					foreach($logo as $log)
					{
						
					?>
					<div class="header_logo">
						<a href="<?php bloginfo('home'); ?>">
							<img src="<?php echo $log['header_image']; ?>" alt="logo" title="logo" class="width100P" />
						</a>
					</div>
					<?php 
						
					}
					?>
				</div>
				<div class="col-sm-offset-1 col-sm-3">
					<div class="headerAddToCartCon">
						<a href="#" class="cartLink">
							<img src="<?php echo get_template_directory_uri();?>/images/header_cart_img.png" />
							<span>(0)</span>
							<div class="clearfix"></div>
						</a>
					</div>
					<div class="headerSearchFormCon">
						<form class="form" role="search" action="<?php echo home_url('/');?>" method="get" >
							<input type="text" name="s" placeholder="SEARCH" value="<?php echo get_search_query();?>" class="searchForminputTxt color-ba8b3e brder-2f2f2f capitalTxt width100P" />
						</form>
					</div>
				</div>
			</div>
			<div class="row rowOfHeaderMenu">
				<div class="col-sm-12">
					<div class="headerMenuCon">
						<div class="mobileMenu">
							<a href="#" class="mobileMenuTxt text-center">Menu</a>
							<span></span>
						</div>
						<?php 
						$args=array(
							'theme_location'=>'main_menu',
							'container'=>'ul',
							'menu_class'=>'hMenu'
						);
							wp_nav_menu($args); 
						?>
						<!-- <ul class="hMenu">
							<li><a href="">SHOP ONLINE</a></li>
							<li><a href="#">SPECIALS</a></li>
							<li><a href="">NEW LINES</a></li>
							<li><a href="">BLOG</a></li>
							<li><a href="#">CONTACT</a></li>
						</ul> -->
					</div>
				</div>
			</div>
		</div>
	 </header>