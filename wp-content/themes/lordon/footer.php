	<footer class="footer bg_Like_footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-4">
					<div class="footerLeftContent">
						<div class="footerlogo">
							<a href="#">
								<img src="<?php echo get_template_directory_uri();?>/images/footerlogo.png" alt="image" title="image" class="width100P" />
							</a>
						</div>
						<div class="footerMenuCon">
							<?php
							$footer=array(
								'theme_location'=>'footer_menu',
								'container'=>'ul',
								'menu_class'=>'footerMenu'
							);
							wp_nav_menu($footer);
							?>
							<!-- <ul class="footerMenu">
								<li><a href="inner_shop.html">SHOP ONLINE</a></li>
								<li><a href="#">SPECIALS</a></li>
								<li><a href="blog.html">NEW LINES</a></li>
								<li><a href="blog_post.html">BLOG</a></li>
								<li><a href="#">CONTACT</a></li>
							</ul> -->
						</div>
						<div class="socialIcon headerSocialIcon footerSocial">
							<a href="#" class="socialLink">
								<img src="<?php echo get_template_directory_uri();?>/images/fbLogo.png" />
							</a>
							<a href="#" class="socialLink">
								<img src="<?php echo get_template_directory_uri();?>/images/twitterLogo.png" />
							</a>
							<a href="#" class="socialLink">
								<img src="<?php echo get_template_directory_uri();?>/images/linkDnLogo.png" />
							</a>
						</div>
						<div class="footerCopyRightCon">
							<p class="capitalTxt line-height-auto margin-5P">Copyright 2016<a href="#"> Lordon</a></p>
							<p class="capitalTxt line-height-auto">Web design by ICS CREATIVE AGENCY</p>
						</div> 

					</div>
				</div>
				<div class="col-sm-4 col-sm-offset-4">
					<div class="footerContentRight">
						<div class="footerAddressCon">
							<h2 class="capitalTxt line-height-40  color-ba8b3e fntSize-25">ADDRESS</h2>
							<p class="">20 King street</p>
							<p class="">Saint John, NB E2L 1G2</p>
							<p class="">(506) 696-9266</p>
						</div>
						<div class="footerAddressCon">
							<h2 class="capitalTxt line-height-40  color-ba8b3e fntSize-25">OPEN</h2>
							<p class="">M-W 10:00AM - 6:00PM</p>
							<p class="">T-F 10:00AM - 7:00PM</p>
							<p class="">Sat 10:00AM - 6:00PM</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	
	<!-- footer section end -->
  
    <!-- <script src="<?php //echo get_template_directory_uri();?>/js/jquery.js"></script>
    <script src="<?php //echo get_template_directory_uri();?>/js/bootstrap.js"></script>
    <script src="<?php //echo get_template_directory_uri();?>/js/owl.carousel.min.js"></script>
    <script src="<?php //echo get_template_directory_uri();?>/js/theme.js"></script> -->
	<!-- <script src="https://use.typekit.net/iut1smu.js"></script> -->
	<!-- <script>try{Typekit.load({ async: true });}catch(e){}</script> --> 
	<script>
		jQuery(document).ready(function(){
			$('.sort_by_cat').click(function(e){
				var cat_by=this.innerText;
					$('.ajaxloader').css('display','block');
					$('.shopInnerProductWrap').fadeOut();
					var info={
						action:'shortby_category',
						cat_type:cat_by,
					}
			});
		});
	</script>
	<?php wp_footer(); ?>
  </body>
</html>