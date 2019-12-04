<?php 
/**
 * The main template file
 * Template Name: Home Page
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
<div class="container">
	<h2>
		Blog:
	</h2>
</div>
     <!--header end--> 
	 <!-- New Lines Promo Section start -->
	<?php
	$arg=array(
		'post_type'=>'post',
		'posts_per_page'=>1,
		'oder'=>'DEASC'
	);
	$all_post=new WP_Query($arg);
	if($all_post->have_posts())
	{
		$first_post=array($post->ID);
		while ($all_post->have_posts()) 
		{
			$all_post->the_post();
			$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), array('220','220'), true );
	?>
	 <section class="newLinesPromoSection padding-left-right-83 padding-top-33">
		<div class="newLinePromoCon bg-fixed shed-000-45 padding-top-130 padding-bottom-143" style="background:url('<?php echo $thumbnail_url[0];  ?>') repeat scroll left top / cover;" >
			<div class=" width620P autoMargin newLinePromoCont">
				<h2 class="txt-center capitalTxt fntSize-49-87  line-height-auto brder-ba8b3e padding-bottom-25 mrgn-btm-30"><a href="<?php the_permalink();?>" class="color-fff"><?php the_title();?></a></h2>
				<p class="text-left color-fff"><?php echo wp_trim_words( get_the_content(), 20, '...' );  ?></p>
				<div class="blogPostInfoCon padding-top-33">
					<span class="blogPostInfoTxt capitalTxt fntSize-13 padding-right-30 color-fff">
						<?php the_time('d/m/Y');?>
					</span>
					<span class="blogPostInfoTxt capitalTxt fntSize-13 padding-right-30 color-fff">POSTED BY <?php the_author();?>  </span>
					<span class="blogPostInfoTxt capitalTxt fntSize-13 padding-right-30 color-fff">
						<i>SHARE</i>
						<a href="#" class="fntSize-18 color-3b5b99">
							<i class="fa fa-facebook-official"></i>
						</a>
						<a href="#" class="fntSize-18 color-28aae1">
							<i class="fa fa-twitter"></i>
						</a>
						<a href="#" class="fntSize-18 color-c9131d">
							<i class="fa fa-pinterest"></i>
						</a>
					</span>
					<a href="<?php the_permalink();?>" class="capitalTxt fntSize-13 bg-fff priBtn pull-right">read more</a>
				</div>
			</div>
		</div>
	 </section>

	<?php
		}
	}
	?>
	 <!-- New Lines Promo Section End -->
	 <section class="blogArchiveSection padding-top-77">
		<div class="container">
			<div class="row">
				<?php
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				//$all_post=null;
				$args=array(
					'post_type'=>'post',
					'post__not_in'=>$first_post,
					'page'=>$paged
				);
				$all_post=new WP_Query($args);
				if($all_post->have_posts())
				{
					while ($all_post->have_posts()) 
					{
						$all_post->the_post();
				?>
				<div class="col-sm-6 padding-right-62">
					<div class="blogArcSinglePostCon padding-bottom-65">
						<div class="blogArcSinImg shed-000-25">
							<a href="<?php the_permalink(); ?>" class="blogSingImgLink">
								<?php the_post_thumbnail('post-thumbnail', ['class' => 'width100P width100'] );?>
								<!-- <img src="<?php //echo get_template_directory_uri();?>/images/blogArcSingleImg.png" alt="Image" title="Image" class="width100P" /> -->
							</a>
						</div>
						<div class="blogArcSinCon padding-top-40">
							<h2 class="txt-center capitalTxt fntSize-30 line-height-auto brder-ba8b3e padding-bottom-25 mrgn-btm-30"><a href="<?php the_permalink(); ?>" class="color-ba8b3e"><?php the_title();?></a></h2>
							<p class="text-left fntSize-13 "><?php echo wp_trim_words( get_the_content(), 10, '...' );?></p>
							<div class="blogPostInfoCon disFlex blogArcSinPostInfoCon">
								<span class="blogPostInfoTxt capitalTxt fntSize-13">
									<?php echo get_the_date('d/ m /Y'); ?>
								</span>
								<span class="blogPostInfoTxt capitalTxt fntSize-13">POSTED BY <?php echo get_the_author();?> </span>
								<span class="blogPostInfoTxt capitalTxt fntSize-13">
									<i>SHARE</i>
									<a href="#" class="fntSize-18 color-3b5b99">
										<i class="fa fa-facebook-official"></i>
									</a>
									<a href="#" class="fntSize-18 color-28aae1">
										<i class="fa fa-twitter"></i>
									</a>
									<a href="#" class="fntSize-18 color-c9131d">
										<i class="fa fa-pinterest"></i>
									</a>
								</span>
							</div>
							<a href="<?php the_permalink();?>" class="capitalTxt fntSize-13 color-fff bg-000 priBtn pull-right">read more</a>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<?php
					}//while end
					$args = array(
						'prev_text'          => __('« Previous'),
						'next_text'          => __('Next »'),
						'type'               => 'plain',
						'format' => '?paged=%#%',
						'current' => max( 1, get_query_var('paged') ),
						'total' => $all_post->max_num_pages
						
						);
					echo paginate_links( $args );
				}//if end
				wp_reset_postdata();
				?>
			</div>
		</div>
	 </section>
	<!-- footer section start-->
<?php get_footer(); ?>