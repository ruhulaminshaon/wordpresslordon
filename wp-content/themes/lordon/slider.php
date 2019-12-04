<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  

  <!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
  	<?php
  	$slider=get_field('slider','option');
    
    $x=0;
    foreach($slider as $row)
    {
      $x++;
  	?>
	    <div class="slide item <?php if($x==1){echo 'active';} ?> ">
	      	<img src="<?php echo $row['slider_image'];?>" class="width100P sliderImgSingle" alt="Image" title="<?php echo $row['slider_title'];?>" />
		      	<div class="sliderSinContent bg-000-75 ">
					<h2 class="sliderTitle text-center fntSize-80 color-fff capitalTxt line-height-auto">
						<?php echo $row['slider_title'];?>
					</h2>
					<p class="sliderConTxt color-ba8b3e fntSize-18 txt-center capitalTxt line-height-auto">
						<?php echo $row['slider_description']; ?>
					</p>
				</div>
	    </div>
    <?php
    	}
     
    ?>
    </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
<!--end-->
<!-- <section class="sliderSection">
	<div class="sliderSingleCon">
		<div class="sliderImgCon width100P shed-000-45">
			<img src="<?php //echo get_template_directory_uri(); ?>/images/slider_img1.png" class="width100P sliderImgSingle" alt="Image" title="image" />
		</div>
		<div class="sliderSinContent bg-000-75 ">
			<h2 class="sliderTitle text-center fntSize-80 color-fff capitalTxt line-height-auto">
				SLIDER HEADLINE
			</h2>
			<p class="sliderConTxt color-ba8b3e fntSize-18 txt-center capitalTxt line-height-auto">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			</p>
		</div>
	</div>
</section> -->