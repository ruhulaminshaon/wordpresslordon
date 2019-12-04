<?php get_header(); ?>
     <!--header end--> 
	 <section class="shopInnerSection">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<div class="productfilterNavCon brder-ba8b3e padding-top-33 capitalTxt text-right">
						<span class="">FILTER BY:</span>
						<!-- <a href="#" class="productFilterNavLink color-ba8b3e">ALL</a> -->
						<span class="productFilterNavLink sort_by_cat color-ba8b3e" style="cursor: pointer;">ALL</span>
						<?php
							$cats=array(
								'post_type'=>'portfolio',
								'taxonomy'=>'category'
							);
							$categories=get_categories($cats);
							$i=0;
							foreach($categories as $category)
							{
						?>
							<span class="productFilterNavLink sort_by_cat color-ba8b3e" style="cursor: pointer;"><?php 
							echo $category->cat_name; 
							?></span>
						<?php
							}
							$i++;
						?>
					</div>
				</div>
				<div class="row">
				<div class="col-xs-12">
					<div class="productfilterNavCon brder-ba8b3e padding-top-33 capitalTxt text-right">
						
						<ul class="categories-filters">
							<?php
							$cat_args=array(
								'show_option_all'=>'All',
								'exclude'=>'1',
								'title_li'=>__('FILTER BY:')
							); 
							wp_list_categories($cat_args);
							?>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="shopInnerProductWrap padding-top-50">
				<?php
				$posts=array(
					'post_type'=>'portfolio',
					'posts_per_page'=>-1,
					'order'=>'DASC'
				);
				$all_posts=new WP_Query($posts);
				if($all_posts->have_posts())
				{ 
					while($all_posts->have_posts())
					{
						$all_posts->the_post();
						//echo the_title();
						
				?>
					<div class="col-sm-4">
						<div class="shopInnProSin capitalTxt padding-bottom-50 padding-left-right-40" id="inside">
							<div class="shopInProImg bg-dddde1">
								<a href="item_single.html">
									<?php the_post_thumbnail('post-thumbnail',['class'=>'width100P']);?>
									<!-- <img src="images/shopInProImg.png" alt="Image" title="Image" class="width100P"/> -->
								</a>
							</div>
							<h2 class="fntSize-49-87 brder-ba8b3e txt-center padding-top-40 padding-bottom-25 mrgn-btm-30"> <a class="color-ba8b3e" href="<?php the_permalink();?>"><?php echo the_title();?></a></h2>
							<div class="shopInnProInfo">
								<span class="proPriceTxt fntSize-25">$35</span>
								<a href="#" class="pull-right fntSize-15 color-fff bg-000 secondaryBtn">Add To cart</a>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				<?php
					}
				} 
				?>
				</div>
			</div>
		</div>
	 </section>
	
	<!-- footer section start-->
<?php get_footer(); ?>