<?php 
/**
 * The main template file
 * Template Name: Index Page
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage lordon
 * @since 1.0
 * @version 1.0
 */
get_header(); 
?>
    <!--header end--> 
	<!--slider section start-->
	<?php get_template_part('slider');?>
	<!--slider section end-->
	<!--shop online promo section start -->
	 <section class="shopOnlinePromoSection padding-top-77 padding-left-right-83">
		<div class="shpOnProLeftCon pull-left">
			<div class="shpOnProLeftImgCon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/shpOnProLeftImg.png" class="width100P" alt="Image" title="Image" />
			</div>
		</div>
		<div class="shpOnProRightCon pull-left">
			<div class="shpOnProRigContent padding-top-75">
				<h2 class="capitalTxt fntSize-49-87 color-232323 shpOnProRigTitle line-height-auto title_bg_img_1">SHOP ONLINE</h2>
				<p class="shpOnProRigPeragraph">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis lobortis aliquet lectus eget dictum.</p>
				<div class="shpOnProRigButtonsCon">
					<a href="inner_shop.html" class="active priBtn bg-fff">SHOP NOW</a>
					<a href="#" class="priBtn bg-ba8b3e">SPECIALS</a>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	 </section>
	<!--shop online promo section end -->
	<!-- New Lines Promo Section start -->
	 <section class="newLinesPromoSection padding-left-right-83 padding-top-33">
		<div class="newLinePromoCon shed-000-45 padding-top-105 padding-bottom-75">
			<div class="txt-center  width620P autoMargin newLinePromoCont">
				<h2 class="capitalTxt fntSize-49-87 color-fff  line-height-auto title_bg_img_1">NEW LINES</h2>
				<p class="text-left color-fff">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis lobortis aliquet lectus eget dictum.</p>
				<div class="shpOnProRigButtonsCon">
					<a href="blog.html" class="priBtn bg-ba8b3e">BROWSE</a>
				</div>
			</div>
		</div>
	 </section>
	<!-- New Lines Promo Section End -->
	<!-- blog Archive section start -->
	<section class="homeBlogArchiveSection">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="homeBlogArcContent">
						<div class="homeBlogSingle text-center">
							<h2 class="capitalTxt fntSize-49-87 color-ba8b3e line-height-auto brder-ba8b3e homeBlogSinTitle">POST 1 HEADLINe</h2>
							<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent faucibus viverra viverra. Nunc auctor justo id diam fermentum, at sollicitudin.</p>
							<a href="blog_post.html" class="capitalTxt color-ba8b3e brder-ba8b3e">READ MORE</a>
						</div>
						<div class="homeBlogSingle text-center">
							<h2 class="capitalTxt fntSize-49-87 color-ba8b3e line-height-auto brder-ba8b3e homeBlogSinTitle">POST 1 HEADLINe</h2>
							<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent faucibus viverra viverra. Nunc auctor justo id diam fermentum, at sollicitudin.</p>
							<a href="blog_post.html" class="capitalTxt color-ba8b3e brder-ba8b3e">READ MORE</a>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="blogAddsSidebar shed-000-75">
						<div class="blogAddsSidebarImgCon">
							<img src="<?php echo get_template_directory_uri(); ?>/images/blogAddsSidebarImg.png" class="width100P blogAddsSidebarImg" title="image" alt="image" />
						</div>
						 <div class="txt-center autoMargin blogAddsSidebarCont">
							<h2 class="capitalTxt fntSize-49-87 color-fff  line-height-auto title_bg_img_1">NEW LINES</h2>
							<p class="text-left color-fff">Read more posts for the latest fashion news and discussion.</p>
							<div class="shpOnProRigButtonsCon">
								<a href="<?php the_permalink();?>" class="priBtn bg-ba8b3e">read more</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- blog archive section end-->
	<!-- footer section start-->
<?php get_footer(); ?>