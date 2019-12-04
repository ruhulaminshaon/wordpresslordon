<?php get_header();?>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-2">
				<?php 
					if (have_posts()) {
						the_post();

						the_content();
					}
				?>
			</div>
		</div>
		
	</div>
		<!-- footer section start-->
<?php get_footer(); ?>

