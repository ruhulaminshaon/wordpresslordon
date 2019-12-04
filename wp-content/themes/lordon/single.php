<?php get_header(); ?>
     <!--header end--> 
     <!--header end-->
<?php
if(have_posts()){
 	while (have_posts()) {
 		the_post();
?>
	 <section class="newLinesPromoSection padding-left-right-83">
		<div class="newLinePromoCon shed-000-45 padding-top-226 padding-bottom-200" style="background: transparent url(<?php 
			if(current_theme_supports('post-thumbnails') && has_post_thumbnail($post->ID))
			{
			$page_bg_image=wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
			$page_bg_image_url=$page_bg_image[0];
			echo $page_bg_image_url;
			} 
			?>) repeat scroll left top/cover;">
			<div class=" width620P autoMargin newLinePromoCont">
				<h2 class="txt-center capitalTxt fntSize-49-87 color-fff  line-height-auto brder-ba8b3e padding-bottom-25 mrgn-btm-30"><?php the_title();?></h2>
			</div>
		</div>
	 </section>
	 <section class="blogSingleInnerContent padding-bottom-200">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="postInfoContent">
						<div class="blogPostInfoCon padding-top-33 color-000">
							<span class="blogPostInfoTxt capitalTxt fntSize-13 padding-right-30">
								<?php echo get_the_date('d/ m /Y'); ?>
							</span>
							<span class="blogPostInfoTxt capitalTxt fntSize-13 padding-right-30">POSTED BY <?php echo get_the_author();?>  </span>
							<span class="blogPostInfoTxt capitalTxt fntSize-13 padding-right-30">
								<i>SHARE</i>
								<a class="fntSize-18 color-3b5b99" href="#">
									<i class="fa fa-facebook-official"></i>
								</a>
								<a class="fntSize-18 color-28aae1" href="#">
									<i class="fa fa-twitter"></i>
								</a>
								<a class="fntSize-18 color-c9131d" href="#">
									<i class="fa fa-pinterest"></i>
								</a>
							</span>
						</div>
					</div>
					<div class="postTextCon  padding-bottom-25 brder-ba8b3e">
						<div class="postText fntSize-18">
							<?php the_content();?>
						</div>
						
					</div>
					<div class="postCommentsCon padding-top-33 padding-bottom-25">
						<a href="#" class="capitalTxt fntSize-18"><?php comments_popup_link('NO Comment','1 Comment','% Comment');?></a>
					</div>
				</div>
			</div>
		</div>
	 </section>
	 <section class="blogPostSIngle">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="blogPostSingleCon">
						<?php
						if(comments_open() || get_comments_number()):
							comments_template();
						endif;
						?>
					</div>
				</div>
			</div>
		</div>
	 </section>
<?php
 	}
}
?> 
<!-- footer section start-->
<?php get_footer(); ?>