<?php
/**
* @author 	Roni
*/
class wpPalam {
	function show_error($message) {
		echo '<div class="wrap"><h2></h2><div class="error" id="error"><p>' . $message . '</p></div></div>' . "\n";
	}
	
	function show_message($message) {
		echo '<div class="wrap"><h2></h2><div class="updated fade" id="message"><p>' . $message . '</p></div></div>' . "\n";
	}
}


function survay_form(){
	ob_start();
	
			//$string = 'palmbeachgreathotelsurvayformlink///2$$$';
			//echo $encoded = base64_encode($string);
			//localhost/palmbeach/survey-form/?review_id=cGFsbWJlYWNoZ3JlYXRob3RlbHN1cnZheWZvcm1saW5rLy8vMiQkJA==
			
			$massage_r = '';
			$massage_s = '';
			global $wpdb;
			$tbl = $wpdb->prefix . "employee_table";
		
			if($_REQUEST['survay_submit'])
			{
				$client_id = $_REQUEST['client_id'];
			}
			elseif($_REQUEST['review_id'] != '')
			{
				$string_main = base64_decode($_REQUEST['review_id']);
				$temp_id = explode("///",$string_main);
				$client_id = rtrim($temp_id[1], "$$$");
			}
			else
			{
				$massage_r = 'Invalid Url';
			}
			
			if($massage_r == '')
			{
				$sql = "SELECT survay_id FROM ". $tbl." WHERE client_id = '".$client_id."'";
				$survay_check = $wpdb->get_results($sql, ARRAY_A);
				
				if(!empty($survay_check))
					$massage_r = 'You have already submitted a review';
			}
			
			if($_REQUEST['survay_submit'] && $massage_r == '')
			{
				
				
				if($_FILES['trip_photo_survay']['size'][0] != 0 && $_FILES['trip_photo_survay']['error'][0] == 0)
				{
    				$uploads = wp_upload_dir();
    				$target_dir = $uploads['basedir'].'/trip_image/';
    				
    				//$target_dir = TEMPLATEPATH.'/trip_image/';
    				$lenght_file = count($_FILES["trip_photo_survay"]["name"]);
    				
    				$trip_photo_survay = '';
    				
    				for($i=0; $i<$lenght_file; $i++)
    				{
    					if($i<6 && $_FILES["trip_photo_survay"]["size"][$i] <= 5242880)
    					{
        					$target_file = $target_dir . basename($_FILES["trip_photo_survay"]["name"][$i]);
        					if(file_exists($target_file))
        					{
        						 $image_name = $client_id."_".$_FILES["trip_photo_survay"]["name"][$i];
        						 $target_file = $target_dir . basename($image_name);
        					}
        					else
        						$image_name = $_FILES["trip_photo_survay"]["name"][$i];
        					
        					$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        					if(!move_uploaded_file($_FILES["trip_photo_survay"]["tmp_name"][$i], $target_file))
        						$massage = "Cannt Upload File<br />";
        					$trip_photo_survay = $trip_photo_survay.$image_name.'///';
    					}
    				}
				}
				
				if($massage == '')
				{
				
					
					if($_REQUEST['get_most_review_survay'] == 'Other')
						$get_most_review_survay = $_REQUEST['otherText'];
					else
						$get_most_review_survay = $_REQUEST['get_most_review_survay'];
					
					$overall_rating 			= $_REQUEST['overall_rating'];
					$hotel_location_rating 		= $_REQUEST['hotel_location_rating'];
					$hotel_service_rating 		= $_REQUEST['hotel_service_rating'];
					$hotel_facilities_rating 	= $_REQUEST['hotel_facilities_rating'];
					$room_cleanliness_rating 	= $_REQUEST['room_cleanliness_rating'];
					$room_comfort_rating 		= $_REQUEST['room_comfort_rating'];
					$recommend_rating 			= $_REQUEST['recommend_rating'];
					$title_of_your_survay 		= $_REQUEST['title_of_your_survay'];
					$your_experience_survay		= $_REQUEST['your_experience_survay'];
					$like_about_hotel_survay 	= $_REQUEST['like_about_hotel_survay'];
					$improved_survay			= $_REQUEST['improved_survay'];
					$nearby_location_survay 	= $_REQUEST['nearby_location_survay'];
					$trip_photo_survay 			= $trip_photo_survay;
					$get_most_review_survay 	= $get_most_review_survay;
					$first_name 				= $_REQUEST['first_name'];
					$last_initial 				= $_REQUEST['last_initial'];
					$location_your 				= $_REQUEST['location_your'];
					$survay_date 				= $_REQUEST['survay_date'];
					
					
					$sql = "INSERT INTO ". $tbl ." (`client_id`, `overall_rating`, `hotel_location_rating`,`hotel_service_rating`,`hotel_facilities_rating`, `room_cleanliness_rating`, `room_comfort_rating`, `recommend_rating`, `title_of_your_survay`, `your_experience_survay`, `like_about_hotel_survay`, `improved_survay`,`nearby_location_survay`,`trip_photo_survay`,`get_most_review_survay`,`first_name`,`last_initial`,`location_your`,`survay_date`) VALUES ( '".$client_id."','".$overall_rating."','".$hotel_location_rating."','".$hotel_service_rating."','".$hotel_facilities_rating."','".$room_cleanliness_rating."','".$room_comfort_rating."','".$recommend_rating."','".$title_of_your_survay."','".$your_experience_survay."','".$like_about_hotel_survay."','".$improved_survay."','".$nearby_location_survay."','".$trip_photo_survay."','".$get_most_review_survay."','".$first_name."','".$last_initial."','".$location_your."','".$survay_date."')";
					
						$survay_inset = $wpdb->query($sql);
						
						if(!empty($survay_inset))
						$massage_s = 'Thank You For Your Review.';
				}
					
					
			}
			

?> 
    	
    	<div class="gdlr-item-title-wrapper gdlr-item pos-center ">
            <div class="gdlr-item-title-head">
            <h3 class="gdlr-item-title gdlr-skin-title gdlr-skin-border">RATE PALM BEACH SINGER ISLAND RESORT & SPA LUXURY SUITES <br />- IT’S QUICK AND EASY</h3>
            </div>
        </div>
    	
    	<div class="reviewSubmission">
                        
                            
                            <?php 
							
							if($massage_r != '' || $massage_s != '')
							{
								if($massage_r != ''){
							?>
                            
                            	<p class="error_massage"><strong><?php echo $massage_r; ?></strong></p>
                            
                            <?php 
								}
							   else if($massage_s != '') {
							?>
                            
                            
                            <p class="successes_massage"><strong><?php echo $massage_s; ?></strong></p>
                            
                            <?php
							   }
							}
							
							else
							{						
							
							?>
                            
                            
                            <form id="hur-form" method="post" action="<?php bloginfo('siteurl'); ?>/survey-form/" enctype="multipart/form-data">
                                <div class="box">
                                    <div class="boxTop">
                                        <h3>1. Rate Your Experience</h3>
                                    </div>
                                    <div class="boxMid">
                                        <div class="rateYourHotel">
                                            <label class="question-text">Overall rating</label>
                                            <div class="answer-container" tabindex="0" data-question-id="102" data-answer-type="">
                                                <div class="rating-container clearfix">
                                                    <div class="rating-bar-container">
                                                        <div class="rating">
                                                            <span id="102ratingvalue" class="rating-value"></span>
                                                            <span id="102ratingdesc" class="rating-desc"></span>
                                                        </div>
                                                        <ul id="102" class="rating-bar clearfix">
                                                            <li class="individual-rating" data-rating="1" data-desc="Terrible"></li>
                                                            <li class="individual-rating" data-rating="2" data-desc="Disappointing"></li>
                                                            <li class="individual-rating" data-rating="3" data-desc="OK"></li>
                                                            <li class="individual-rating" data-rating="4" data-desc="Pleasing"></li>
                                                            <li class="individual-rating" data-rating="5" data-desc="Excellent"></li>
                                                        </ul>
                                                        <span class="explanation-text pull-left">Terrible</span>
                                                        <span class="explanation-text pull-right">Excellent</span>
                                                    </div>
                                                    <input id="overall_rating" name="overall_rating" value="" required="required" data-selected-index="-1" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="rateYourHotel">
                                            <label class="question-text">Cleanliness</label>
                                            <div class="answer-container " tabindex="0" data-question-id="105" data-answer-type="">
                                                <div class="rating-container clearfix">
                                                    <div class="rating-bar-container pull-left">
                                                        <div class="rating">
                                                            <span id="105ratingvalue" class="rating-value"></span>
                                                            <span id="105ratingdesc" class="rating-desc"></span>
                                                        </div>
                                                        <ul id="105" class="rating-bar clearfix">
                                                            <li class="individual-rating" data-rating="1" data-desc="Terrible"></li>
                                                            <li class="individual-rating" data-rating="2" data-desc=" Disappointing"></li>
                                                            <li class="individual-rating" data-rating="3" data-desc=" OK"></li>
                                                            <li class="individual-rating" data-rating="4" data-desc=" Pleasing"></li>
                                                            <li class="individual-rating" data-rating="5" data-desc=" Excellent"></li>
                                                        </ul>
                                                        <span class="explanation-text pull-left">Terrible</span>
                                                        <span class="explanation-text pull-right">Excellent</span>
                                                    </div>
                                                    <input id="room_cleanliness_rating" name="room_cleanliness_rating" value="" required="required" data-selected-index="-1" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="rateYourHotel">
                                            <label class="question-text">Location</label>
                                            <div class="answer-container " tabindex="0" data-question-id="103" data-answer-type="">
                                                <div class="rating-container clearfix">
                                                    <div class="rating-bar-container pull-left">
                                                        <div class="rating">
                                                            <span id="103ratingvalue" class="rating-value"></span>
                                                            <span id="103ratingdesc" class="rating-desc"></span>
                                                        </div>
                                                        <ul id="103" class="rating-bar clearfix">
                                                            <li class="individual-rating" data-rating="1" data-desc="Terrible"></li>
                                                            <li class="individual-rating" data-rating="2" data-desc="Disappointing"></li>
                                                            <li class="individual-rating" data-rating="3" data-desc="OK"></li>
                                                            <li class="individual-rating" data-rating="4" data-desc="Pleasing"></li>
                                                            <li class="individual-rating" data-rating="5" data-desc="Excellent"></li>
                                                        </ul>
                                                        <span class="explanation-text pull-left">Terrible</span>
                                                        <span class="explanation-text pull-right">Excellent</span>
                                                    </div>
                                                    <input id="hotel_location_rating" name="hotel_location_rating" value="" required="required" data-selected-index="-1" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="rateYourHotel">
                                            <label class="question-text">Service</label>
                                            <div class="answer-container " tabindex="0" data-question-id="103" data-answer-type="">
                                                <div class="rating-container clearfix">
                                                    <div class="rating-bar-container pull-left">
                                                        <div class="rating">
                                                            <span id="103ratingvalue" class="rating-value"></span>
                                                            <span id="103ratingdesc" class="rating-desc"></span>
                                                        </div>
                                                        <ul id="103" class="rating-bar clearfix">
                                                            <li class="individual-rating" data-rating="1" data-desc="Terrible"></li>
                                                            <li class="individual-rating" data-rating="2" data-desc="Disappointing"></li>
                                                            <li class="individual-rating" data-rating="3" data-desc="OK"></li>
                                                            <li class="individual-rating" data-rating="4" data-desc="Pleasing"></li>
                                                            <li class="individual-rating" data-rating="5" data-desc="Excellent"></li>
                                                        </ul>
                                                        <span class="explanation-text pull-left">Terrible</span>
                                                        <span class="explanation-text pull-right">Excellent</span>
                                                    </div>
                                                    <input id="hotel_service_rating" name="hotel_service_rating" value="" required="required" data-selected-index="-1" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="rateYourHotel">
                                            <label class="question-text">Shared Facilities</label>
                                            <div class="answer-container " tabindex="0" data-question-id="104" data-answer-type="">
                                                <div class="rating-container clearfix">
                                                    <div class="rating-bar-container pull-left">
                                                        <div class="rating">
                                                            <span id="104ratingvalue" class="rating-value"></span>
                                                            <span id="104ratingdesc" class="rating-desc"></span>
                                                        </div>
                                                        <ul id="104" class="rating-bar clearfix">
                                                            <li class="individual-rating" data-rating="1" data-desc="Terrible"></li>
                                                            <li class="individual-rating" data-rating="2" data-desc="Disappointing"></li>
                                                            <li class="individual-rating" data-rating="3" data-desc="OK"></li>
                                                            <li class="individual-rating" data-rating="4" data-desc="Pleasing"></li>
                                                            <li class="individual-rating" data-rating="5" data-desc="Excellent"></li>
                                                        </ul>
                                                        <span class="explanation-text pull-left">Terrible</span>
                                                        <span class="explanation-text pull-right">Excellent</span>
                                                    </div>
                                                    <input id="hotel_facilities_rating" name="hotel_facilities_rating" value="" required="required" data-selected-index="-1" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="rateYourHotel">
                                            <label class="question-text">Comfort</label>
                                            <div class="answer-container " tabindex="0" data-question-id="106" data-answer-type="">
                                                <div class="rating-container clearfix">
                                                    <div class="rating-bar-container pull-left">
                                                        <div class="rating">
                                                            <span id="106ratingvalue" class="rating-value"></span>
                                                            <span id="106ratingdesc" class="rating-desc"></span>
                                                        </div>
                                                        <ul id="106" class="rating-bar clearfix">
                                                            <li class="individual-rating" data-rating="1" data-desc="Terrible"></li>
                                                            <li class="individual-rating" data-rating="2" data-desc="Disappointing"></li>
                                                            <li class="individual-rating" data-rating="3" data-desc="OK"></li>
                                                            <li class="individual-rating" data-rating="4" data-desc="Pleasing"></li>
                                                            <li class="individual-rating" data-rating="5" data-desc="Excellent"></li>
                                                        </ul>
                                                        <span class="explanation-text pull-left">Terrible</span>
                                                        <span class="explanation-text pull-right">Excellent</span>
                                                    </div>
                                                    <input id="room_comfort_rating" name="room_comfort_rating" value="" required="required" data-selected-index="-1" type="hidden">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="boxBtm">
                                        <label class="question-text">Would you recommend this hotel to a friend?</label>
                                        <ul class="twoOptions">
                                            <li>
                                                <input id="yes" type="radio" required="required" name="recommend_rating" value="Yes">
                                                <label for="yes">Yes</label>
                                            </li>
                                            <li>
                                                <input id="no" type="radio" name="recommend_rating" value="No">
                                                <label for="no">No</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="boxTop">
                                        <h3>2. Tell Us About Your Stay</h3>
                                    </div>
                                    <div class="boxMid">
                                        <div class="reviewContent">
                                            <label class="question-text">Title of your review.</label>
                                            <div class="answer-container" tabindex="0" data-question-id="107" data-answer-type="">
                                                <span class="textarea-char-limit" id="charlimit107"><span class="char-remaining" data-max-length="50">50</span> characters</span>
                                                <textarea class="textarea-box characters50" name="title_of_your_survay" required="required" placeholder="e.g., Nice hotel close to the beach" maxlength="50"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="reviewContent">
                                            <label class="question-text">Write about your experience.</label>
                                            <div class="answer-container " tabindex="0" data-question-id="108" data-answer-type="">
                                                <span class="textarea-char-limit" id="charlimit108"><span class="char-remaining" data-max-length="1,500">1,500 </span>characters</span>
                                                <textarea class="textarea-box characters1500" name="your_experience_survay" required="required" placeholder="Minimum 50 characters" maxlength="1500"></textarea>
                                            </div>
                                            <span class="explanation-text">Reviews containing insults, profanity, personal details, website addresses, or phone numbers will be removed by an automated filter.</span>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="boxMid">
                                        <div class="reviewContent">
                                            <label class="question-text-none">What did you like about this hotel?</label>
                                            <div class="answer-container " tabindex="0" data-question-id="109" data-answer-type="">
                                                <span class="textarea-char-limit" id="charlimit109"><span class="char-remaining" data-max-length="150">150 </span>characters</span>
                                                <textarea class="textarea-box characters150" name="like_about_hotel_survay" placeholder="" maxlength="150"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="reviewContent">
                                            <label class="question-text-none">What, if anything, could be improved?</label>
                                            <div class="answer-container " tabindex="0" data-question-id="1010" data-answer-type="">
                                                <span class="textarea-char-limit" id="charlimit1010"><span class="char-remaining" data-max-length="150">150 </span>characters</span>
                                                <textarea class="textarea-box characters150" name="improved_survay" placeholder="" maxlength="150"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="reviewContent">
                                            <label class="question-text-none">Tell us about the location and things to do nearby.</label>
                                            <div class="answer-container " tabindex="0" data-question-id="1011" data-answer-type="">
                                                <span class="textarea-char-limit" id="charlimit1011"><span class="char-remaining" data-max-length="150">150 </span>characters</span>
                                                <textarea class="textarea-box characters150" name="nearby_location_survay" placeholder="" maxlength="150"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="reviewContent">
                                            <label class="question-text-none">Share your trip photos</label>
                                            <span class="explanation-text">Reviews with room and hotel photos help other travelers the most.</span>                                
                                            <div class="fileBox">
                                                <label class="fileBtn" for="inputFile">Add Photos</label>
                                                <input type="file" id="inputFile" multiple="multiple" name="trip_photo_survay[]" accept="image/x-png,image/gif,image/jpeg" >
                                            </div>
                                            <div class="fileBox">
                                            	<div class="filePhoto" style="float:left;"><img id="fileImg0" name="trip_photo_show" src=""></div>
                                                <div class="filePhoto" style="float:left;"><img id="fileImg1" name="trip_photo_show" src=""></div>
                                                <div class="filePhoto" style="float:left;"><img id="fileImg2" name="trip_photo_show" src=""></div>
                                                <div class="filePhoto" style="float:left;"><img id="fileImg3" name="trip_photo_show" src=""></div>
                                                <div class="filePhoto" style="float:left;"><img id="fileImg4" name="trip_photo_show" src=""></div>
                                                <div class="filePhoto" style="float:left;"><img id="fileImg5" name="trip_photo_show" src=""></div>
                                            </div>
                                            <span class="explanation-text notShowOnMobile grayText999" style="clear:both;">Review Tip: Photos images must be in PNG, GIF or JPEG format File Sizes must be 5 MB or less Image must be at least 60 pixels tall</span>
                                        </div>
                                    </div>
                                    <div class="boxBtm">
                                        <label class="question-text">Who might get the most out of your review?</label>
                                        <ul class="radioOptions">
                                            <li>
                                                <input id="everyone" type="radio" name="get_most_review_survay" value="Everyone">
                                                <label for="everyone">Everyone</label>
                                            </li>
                                            <li>
                                                <input id="couples" type="radio" name="get_most_review_survay" value="Couples">
                                                <label for="couples">Couples</label>
                                            </li>
                                            <li>
                                                <input id="travelers" type="radio" name="get_most_review_survay" value="Business Travelers">
                                                <label for="travelers">Business Travelers</label>
                                            </li>
                                            <li>
                                                <input id="students" type="radio" name="get_most_review_survay" value="Students">
                                                <label for="students">Students</label>
                                            </li>
                                            <li>
                                                <input id="families" type="radio" name="get_most_review_survay" value="Families">
                                                <label for="families">Families</label>
                                            </li>
                                            <li>
                                                <input id="other" type="radio" name="get_most_review_survay" value="Other">
                                                <label for="other">Other</label>                                  
                                                <fieldset id="text6" class="radio-textbox" style="display:none">
                                                    <label class="text"><input name="otherText" value="" placeholder="e.g. Pet Lovers" class="txtBox" maxlength="25" type="text"></label>
                                                </fieldset>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="box">
                                    <div class="boxTop">
                                        <h3>3. Tell Us About Yourself</h3>
                                    </div>
                                    <div class="boxMid">
                                        <span class="explanation-text">Tell your fellow travelers a little about yourself. This will appear next to your review.</span>
                                        <ul class="tellUs">
                                            <li>
                                                <label class="question-text">First Name or Nickname</label>
                                                <input name="first_name" required="required" autocomplete="off" autocorrect="off" autocapitalize="off" placeholder="e.g., Jackie" class="txtBox" data-max-length="15" maxlength="15" value="" type="text">
                                            </li>
                                            <li>
                                                <label class="question-text-none">Last Initial</label>
                                                <input name="last_initial" autocomplete="off" autocorrect="off" autocapitalize="off" placeholder="Optional" class="txtBox" data-max-length="1" maxlength="1" value="" type="text">
                                            </li>
                                            <li>
                                                <label class="question-text-none">Your Location</label>
                                                <input name="location_your" autocomplete="off" autocorrect="off" autocapitalize="off" placeholder="e.g., New York, NY" class="txtBox" data-max-length="50" maxlength="50" value="" type="text">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            <div class="agreeWithTermsOfServiceContainer"><strong>Thanks for taking the time to complete your review!</strong>
                            <input name="survay_date" value="<?php echo time(); ?>" type="hidden">
                            <input name="client_id" value="<?php echo $client_id; ?>" type="hidden">
                            <input name="survay_submit" type="submit" class="submitYourReviewId">
                           
                            </div>
                            </form>
                            
						 <?php 
                            }
                         ?>
                        
                    </div> 
	
	<?php
	return ob_get_clean();
}

add_shortcode( 'survay_f', 'survay_form' );

///////////////////////////// Survay Review ////////////////////

function rating_filter($total_rev,$ind_rev){
	
	$rating_percent = ($ind_rev/$total_rev)*100;
	
	return $rating_percent;
}

function review_rating($review_star){
	
	$start_percent = ($review_star/5)*100;
	
	return $start_percent;
}


function survay_review(){
	ob_start();
	
	$massage = '';
	global $wpdb;
	$tbl1 = $wpdb->prefix . "survay_table";
	$tbl2 = $wpdb->prefix . "gdlr_hotel_booking";
	$tbl3 = $wpdb->prefix . "gdlr_hotel_payment";
	
	$sql = "SELECT * FROM ".$tbl1." INNER JOIN ".$tbl2." ON ".$tbl1.".client_id = ".$tbl2.".id INNER JOIN ".$tbl3." ON ".$tbl2.".payment_id = ".$tbl3.".id WHERE ".$tbl1.".approved_status = 'approved' ORDER BY ".$tbl1.".survay_date DESC";
	$survay_review_all = $wpdb->get_results($sql, ARRAY_A);
	
	$sql = "SELECT AVG(overall_rating) as overall, AVG(hotel_location_rating) as location, AVG(hotel_service_rating) as service, AVG(hotel_facilities_rating) as facilities, AVG(room_cleanliness_rating) as cleanliness, AVG(room_comfort_rating) as comfort FROM ".$tbl1." WHERE approved_status = 'approved'";
	$avg_review = $wpdb->get_results($sql, ARRAY_A);
	
	$sql = "SELECT recommend_rating FROM ".$tbl1." WHERE recommend_rating = 'Yes' AND approved_status = 'approved'";
	$recommend_review = $wpdb->get_results($sql, ARRAY_A);
	
	$recomended_percent = (count($recommend_review)/count($survay_review_all))*100;
	
	
	$sql = "SELECT count(overall_rating) as overall_r, overall_rating  FROM ".$tbl1." WHERE approved_status = 'approved' GROUP BY overall_rating";
	$review_ratting = $wpdb->get_results($sql, ARRAY_A);
	
	for($j=0; $j<count($review_ratting); $j++) 
	{
		if($review_ratting[$j]['overall_rating'] == 1 ) 
			$rating_bar[1]['rating_point'] = $review_ratting[$j]['overall_r']; 
		elseif($review_ratting[$j]['overall_rating'] == 2 ) 
			$rating_bar[2]['rating_point'] = $review_ratting[$j]['overall_r'];  
		elseif($review_ratting[$j]['overall_rating'] == 3 ) 
			$rating_bar[3]['rating_point'] = $review_ratting[$j]['overall_r'];  
		elseif($review_ratting[$j]['overall_rating'] == 4 ) 
			$rating_bar[4]['rating_point'] = $review_ratting[$j]['overall_r'];  
		elseif($review_ratting[$j]['overall_rating'] == 5 ) 
			$rating_bar[5]['rating_point'] = $review_ratting[$j]['overall_r']; 
	}
	

	?> 
	
	<script type="text/javascript">
		var ajax_url = '<?php echo admin_url('admin-ajax.php');?>';
	</script>
    
    
    
    <div class="reviewCont">
        
        <div class="gdlr-item-title-wrapper gdlr-item pos-center ">
            <div class="gdlr-item-title-head">
                <h3 class="gdlr-item-title gdlr-skin-title gdlr-skin-border">Reviews</h3>
            </div>
            <div class="gdlr-item-title-caption gdlr-title-font gdlr-skin-info">Valuable input after a confirmed stay</div>
        </div>
            <div class="summaryBox">
                <div class="summaryBoxLft">            		
                    <table class="summaryBoxLftTop">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="reviewRating reviewRatingLg"><span style="width:<?php echo review_rating($avg_review[0]['overall']); ?>%">&nbsp;</span></div>
                                </td>
                                <td>
                                    <div class="normalOutOf">
                                        <span><?php echo number_format($avg_review[0]['overall'],1); ?></span>
                                        <span class="separatorText">out of&nbsp;</span>
                                        <span>5.0</span>
                                    </div>
                                    <div class="nonZeroCount">based on <span><?php echo count($survay_review_all); ?></span> guest reviews</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h6>Rating Summary</h6>
                    <ul class="summaryBoxLftBtm">
                        <li>
                            <span class="normalLabel">Cleanliness</span>
                            <div class="reviewRating"><span style="width:<?php echo review_rating($avg_review[0]['cleanliness']); ?>%">&nbsp;</span></div>
                            <div class="normalOutOf"><span><?php echo number_format($avg_review[0]['cleanliness'],1); ?></span></div>
                        </li>
                        <li>
                            <span class="normalLabel">Location</span>
                            <div class="reviewRating"><span style="width:<?php echo review_rating($avg_review[0]['location']); ?>%">&nbsp;</span></div>
                            <div class="normalOutOf"><span><?php echo number_format($avg_review[0]['location'],1); ?></span></div>
                        </li>
                        <li>
                            <span class="normalLabel">Service</span>
                            <div class="reviewRating"><span style="width:<?php echo review_rating($avg_review[0]['service']); ?>%">&nbsp;</span></div>
                            <div class="normalOutOf"><span><?php echo number_format($avg_review[0]['service'],1); ?></span></div>
                        </li>
                        <li>
                            <span class="normalLabel">Shared Facilities</span>
                            <div class="reviewRating"><span style="width:<?php echo review_rating($avg_review[0]['facilities']); ?>%">&nbsp;</span></div>
                            <div class="normalOutOf"><span><?php echo number_format($avg_review[0]['facilities'],1); ?></span></div>
                        </li>
                        <li>
                            <span class="normalLabel">Comfort</span>
                            <div class="reviewRating"><span style="width:<?php echo review_rating($avg_review[0]['comfort']); ?>%">&nbsp;</span></div>
                            <div class="normalOutOf"><span><?php echo number_format($avg_review[0]['comfort'],1); ?></span></div>
                        </li>
                    </ul>
                </div>
                <div class="summaryBoxRgt">
                    <div class="buyAgainContainer"><span class="buyAgainPercentage"><?php echo number_format($recomended_percent,2); ?>%</span> of guests recommend Palm Beach Singer Island Resort & Spa Luxury Suites</div>
                    <h6>This hotel is recommended by guests for:</h6>
                    <ul class="quickTakeList">
                        <li>Families</li>
                        <li>Leisure</li>
                        <li>Beach</li>
                        <li>Couples</li>
                    </ul>
                </div>
            </div>
            
            <div class="filterReviews">
                <h3>Filter Reviews By</h3>
                <table class="filterReviewTbl">
                    <tbody>
                        <tr>
                            <td>
                                <h6>Ratings</h6>
                                <ul class="ratingList">
                                    <?php 
										for($j=5; $j>0; $j--) 
										{
											if($rating_bar[$j]['rating_point'])
											{
												$rating_count = $rating_bar[$j]['rating_point'];
												$rating_perc = rating_filter(count($survay_review_all),$rating_bar[$j]['rating_point']);
											}
											
											else
											{
												$rating_count = 0;
												$rating_perc = 0;
											}
									?>
                                    
                                     <li>
                                        <div class="ratingCheck">
                                            <input id="rating_<?php echo $j ?>" class="rating" name="rating" value="<?php echo $j ?>" type="checkbox">
                                            <label for="rating"><?php echo $j ?> (<?php echo $rating_count;?>)</label>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $rating_perc;?>%"></div>
                                        </div> 
                                    </li>
                                    
                                    <?php } ?>
                                </ul>
                            </td>
                            <td>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="displayHeaderContent">
                <span class="nonZeroCount"><span><?php echo count($survay_review_all); ?></span> Reviews</span>
                <?php if(!empty($survay_review_all)){ ?>
                <select name="sort_review" id="sort_review">
                    <option value="" selected="selected">Sort by </option>
                    <option value="date_newest">Date - Newest </option>
                    <option value="date_oldest">Date - Oldest </option>
                    <option value="high_low">Rating - High to low </option>
                    <option value="low_high">Rating - Low to high </option>
                </select>
                <?php } ?>
            </div>
            
            <div class="review_part">
            
            <?php 
			  for($k=0; $k<count($survay_review_all); $k++) 
			  {
				  
				  $uploads = wp_upload_dir();
				  
				  if($survay_review_all[$k]['trip_photo_survay'] != '')
				  	$trip_photo = explode('///', rtrim($survay_review_all[$k]['trip_photo_survay'],"///"));
			?>
            
            <div class="displayContentReview">
                <div class="bodyUser">
                    <div class="userAvatar"><img src="<?php echo plugins_URLPATH; ?>admin/images/noAvatar.gif" alt="Customer avatar" title="Customer avatar"></div>
                    <span itemprop="author" class="nickName"><?php echo $survay_review_all[$k]['first_name']." ".$survay_review_all[$k]['last_initial']; ?></span>
                    <span itemprop="author"><?php echo $survay_review_all[$k]['location_your']; ?></span>
                </div>
                <div class="displayReviewInner">
                    <div class="reviewDate">
                        <div class="reviewRating reviewRatingLg"><span style="width:<?php echo review_rating($survay_review_all[$k]['overall_rating']); ?>%">&nbsp;</span></div> <?php echo date("F d, Y",$survay_review_all[$k]['survay_date']) ?> 
                    </div>
                    <h6>“<?php echo $survay_review_all[$k]['title_of_your_survay']; ?>”</h6>
                    <div class="displayReviewBody">                
                        <ul class="summaryBoxLftBtm">
                            <li>
                                <span class="normalLabel">Cleanliness</span>
                                <div class="reviewRating"><span style="width:<?php echo review_rating($survay_review_all[$k]['room_cleanliness_rating']); ?>%">&nbsp;</span></div>
                                <div class="normalOutOf"><span><?php echo $survay_review_all[$k]['room_cleanliness_rating']; ?></span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Location</span>
                                <div class="reviewRating"><span style="width:<?php echo review_rating($survay_review_all[$k]['hotel_location_rating']); ?>%">&nbsp;</span></div>
                                <div class="normalOutOf"><span><?php echo $survay_review_all[$k]['hotel_location_rating']; ?></span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Service</span>
                                <div class="reviewRating"><span style="width:<?php echo review_rating($survay_review_all[$k]['hotel_service_rating']); ?>%">&nbsp;</span></div>
                                <div class="normalOutOf"><span><?php echo $survay_review_all[$k]['hotel_service_rating']; ?></span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Shared Facilities</span>
                                <div class="reviewRating"><span style="width:<?php echo review_rating($survay_review_all[$k]['hotel_facilities_rating']); ?>%">&nbsp;</span></div>
                                <div class="normalOutOf"><span><?php echo $survay_review_all[$k]['hotel_facilities_rating']; ?></span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Comfort</span>
                                <div class="reviewRating"><span style="width:<?php echo review_rating($survay_review_all[$k]['room_comfort_rating']); ?>%">&nbsp;</span></div>
                                <div class="normalOutOf"><span><?php echo $survay_review_all[$k]['room_comfort_rating']; ?></span></div>
                            </li>
                        </ul>
                        <div class="displayReviewBodyIn">
                            <p><?php echo $survay_review_all[$k]['your_experience_survay']; ?></p>
                            
                            <?php if($survay_review_all[$k]['like_about_hotel_survay'] != '' || $survay_review_all[$k]['improved_survay'] != '' || $survay_review_all[$k]['nearby_location_survay'] != '') {  ?>
                            
                                <ul class="accordion">
                                    <?php if($survay_review_all[$k]['like_about_hotel_survay'] != '') {  ?>
                                        <li>
                                            <div class="accorTitle">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                                <h3>What did you like about this hotel?</h3>
                                            </div>
                                            <div class="accorConte">
                                               <?php echo $survay_review_all[$k]['like_about_hotel_survay']; ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($survay_review_all[$k]['improved_survay'] != '') {  ?>
                                        <li>
                                            <div class="accorTitle">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                                <h3>What, if anything, could be improved?</h3>
                                            </div>
                                            <div class="accorConte">
                                                <?php echo $survay_review_all[$k]['improved_survay']; ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($survay_review_all[$k]['nearby_location_survay'] != '') {  ?>
                                        <li>
                                            <div class="accorTitle">
                                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                                <h3>Tell us about the location and things to do nearby</h3>
                                            </div>
                                            <div class="accorConte">
                                                <?php echo $survay_review_all[$k]['nearby_location_survay']; ?>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            
                            
                            <div class="review-photo">
                                <?php
									if($trip_photo != '')
									{ 
								?>
                                    <ul>
                                        <?php
											for($i=0; $i<count($trip_photo); $i++) {
										?>
                                            <li>
                                                <a href="<?php echo $uploads['baseurl']. '/trip_image/' .$trip_photo[$i]; ?>" data-fancybox-group="review-photo">
                                                    <img src="<?php echo $uploads['baseurl'] . '/trip_image/' .$trip_photo[$i]; ?>" alt="review photo">
                                                </a>
                                            </li>
                                         <?php
											}
										?>
                                    </ul>
                                 <?php
									}
									
								if($survay_review_all[$k]['review_admin_comment'] != '')
								{
								?>
                                    <div class="management-response">
                                        <p><?php echo $survay_review_all[$k]['review_admin_comment']; ?></p>
                                        <p>Replied on <?php echo date("j M Y",$survay_review_all[$k]['review_comment_time']); ?></p>
                                    </div>
                                
                                <?php } ?>
                            </div>
                            
                            
                            
                            
                            <?php if($survay_review_all[$k]['recommend_rating'] == 'Yes'){ ?>
                            <br />
                            <span class="recommendedContainerYes"><span>Yes</span>, I recommend this hotel.</span>
                            <?php } ?>
                            
                            <?php if($survay_review_all[$k]['get_most_review_survay'] != ''){ ?>
                            <span class="tagsPrefix">I recommend this hotel for:</span>
                            <span class="tagsBox"><span class="tag"><?php echo $survay_review_all[$k]['get_most_review_survay'] ?></span></span>
                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            
             <?php 
			  }
			?>
			</div>
            
            <div class="ajax_box" style="display:none; width:100%;" align="center"><img src="<?php echo plugins_URLPATH; ?>admin/images/ajax-loader.gif" alt="Customer avatar" title="Customer avatar"></div>
    </div>
    
    
    
	
	<?php
	return ob_get_clean();
}
add_shortcode( 'survay_r', 'survay_review' );


function header_rating(){
	ob_start();
	
	global $wpdb;
	$tbl1 = $wpdb->prefix . "survay_table";
	$tbl2 = $wpdb->prefix . "gdlr_hotel_booking";
	$tbl3 = $wpdb->prefix . "gdlr_hotel_payment";
	
	$sql = "SELECT * FROM ".$tbl1." INNER JOIN ".$tbl2." ON ".$tbl1.".client_id = ".$tbl2.".id INNER JOIN ".$tbl3." ON ".$tbl2.".payment_id = ".$tbl3.".id WHERE ".$tbl1.".approved_status = 'approved'";
	$survay_review_all = $wpdb->get_results($sql, ARRAY_A);
	
	$sql = "SELECT AVG(overall_rating) as overall FROM ".$tbl1." WHERE approved_status = 'approved'";
	$avg_review = $wpdb->get_results($sql, ARRAY_A);
	
	
	
	?>
    
    <a href="<?php echo get_bloginfo('url')?>/reviews/"><div class="reviewRating"><span style="width:<?php echo review_rating($avg_review[0]['overall']); ?>%">&nbsp;</span></div>
    <span><?php echo count($survay_review_all); ?> Reviews</span></a>
    
    <?php
	
	return ob_get_clean();
}
add_shortcode( 'header_r', 'header_rating' );


add_action('wp_ajax_update_sort_by', 'update_sort_by');
add_action('wp_ajax_nopriv_update_sort_by', 'update_sort_by');

function update_sort_by(){ 
	    global $wpdb;
	  	$tbl1 = $wpdb->prefix . "survay_table";
		$tbl2 = $wpdb->prefix . "gdlr_hotel_booking";
		$tbl3 = $wpdb->prefix . "gdlr_hotel_payment";
		
		$sort_by_data = '';
		
		if($_POST['sort_by_rating']!='')
			$sort_by_rating = ' AND '.rtrim($_POST['sort_by_rating']," OR");
		
		if($_POST['sort_by'] == 'date_newest') 
			$sort_by = 'survay_date DESC';
		elseif($_POST['sort_by'] == 'date_oldest')
			$sort_by = 'survay_date ASC';
		elseif($_POST['sort_by'] == 'high_low')
			$sort_by = 'overall_rating DESC';
		elseif($_POST['sort_by'] == 'low_high')
			$sort_by = 'overall_rating ASC';
		else	
			$sort_by = 'survay_date DESC';
		
		$sql = "SELECT * FROM ".$tbl1." INNER JOIN ".$tbl2." ON ".$tbl1.".client_id = ".$tbl2.".id INNER JOIN ".$tbl3." ON ".$tbl2.".payment_id = ".$tbl3.".id WHERE ".$tbl1.".approved_status = 'approved' ".$sort_by_rating." ORDER BY ".$tbl1.".".$sort_by;
		$survay_review_all = $wpdb->get_results($sql, ARRAY_A);
		
		for($k=0; $k<count($survay_review_all); $k++) 
			  {
				  
				  $uploads = wp_upload_dir();
				  
				  if($survay_review_all[$k]['trip_photo_survay'] != '')
				  	$trip_photo = explode('///', rtrim($survay_review_all[$k]['trip_photo_survay'],"///"));
					
					if($trip_photo != '')
					{ 
					$image_trip = '<ul>';
					
					  for($i=0; $i<count($trip_photo); $i++) {
					  	$image_trip = $image_trip .'<li>
						  <a href="'.$uploads['baseurl']. '/trip_image/' .$trip_photo[$i].'" data-fancybox-group="review-photo">
							  <img src="'.$uploads['baseurl'] . '/trip_image/' .$trip_photo[$i].'" alt="review photo">
						  </a>
					  </li>';
					  }
					$image_trip = $image_trip .'</ul>';
					}
					
					
					
					
		$sort_by_data = $sort_by_data . '<div class="displayContentReview">
                <div class="bodyUser">
                    <div class="userAvatar"><img src="'.plugins_URLPATH.'admin/images/noAvatar.gif" alt="Customer avatar" title="Customer avatar"></div>
                    <span itemprop="author" class="nickName">'.$survay_review_all[$k]['first_name'].' '.$survay_review_all[$k]['last_initial'].'</span>
                    <span itemprop="author">'. $survay_review_all[$k]['location_your'].'</span>
                </div>
				<div class="displayReviewInner">
                    <div class="reviewDate">
                        <div class="reviewRating reviewRatingLg"><span style="width:'.review_rating($survay_review_all[$k]['overall_rating']).'%">&nbsp;</span></div>'.date("F d, Y",$survay_review_all[$k]['survay_date']).' 
                    </div>
                    <h6>“'.$survay_review_all[$k]['title_of_your_survay'].'”</h6>
                    <div class="displayReviewBody">                
                        <ul class="summaryBoxLftBtm">
                            <li>
                                <span class="normalLabel">Cleanliness</span>
                                <div class="reviewRating"><span style="width:'.review_rating($survay_review_all[$k]['room_cleanliness_rating']).'%">&nbsp;</span></div>
                                <div class="normalOutOf"><span>'.$survay_review_all[$k]['room_cleanliness_rating'].'</span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Location</span>
                                <div class="reviewRating"><span style="width:'.review_rating($survay_review_all[$k]['hotel_location_rating']).'%">&nbsp;</span></div>
                                <div class="normalOutOf"><span>'.$survay_review_all[$k]['hotel_location_rating'].'</span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Service</span>
                                <div class="reviewRating"><span style="width:'.review_rating($survay_review_all[$k]['hotel_service_rating']).'%">&nbsp;</span></div>
                                <div class="normalOutOf"><span>'.$survay_review_all[$k]['hotel_service_rating'].'</span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Shared Facilities</span>
                                <div class="reviewRating"><span style="width:'. review_rating($survay_review_all[$k]['hotel_facilities_rating']).'%">&nbsp;</span></div>
                                <div class="normalOutOf"><span>'. $survay_review_all[$k]['hotel_facilities_rating'].'</span></div>
                            </li>
                            <li>
                                <span class="normalLabel">Comfort</span>
                                <div class="reviewRating"><span style="width:'.review_rating($survay_review_all[$k]['room_comfort_rating']).'%">&nbsp;</span></div>
                                <div class="normalOutOf"><span>'.$survay_review_all[$k]['room_comfort_rating'].'</span></div>
                            </li>
                        </ul>
                        <div class="displayReviewBodyIn">
                            <p>'.$survay_review_all[$k]['your_experience_survay'].'</p>';
                            if($survay_review_all[$k]['like_about_hotel_survay'] != '' || $survay_review_all[$k]['improved_survay'] != '' || $survay_review_all[$k]['nearby_location_survay'] != '') { 
							
                            $sort_by_data = $sort_by_data . '<ul class="accordion">';
							
							if($survay_review_all[$k]['like_about_hotel_survay'] != '') { 
                                $sort_by_data = $sort_by_data . '<li>
                                    <div class="accorTitle">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                        <h3>What did you like about this hotel?</h3>
                                    </div>
                                    <div class="accorConte">
                                       '.$survay_review_all[$k]['like_about_hotel_survay'].'
                                    </div>
                                </li>';
							}
                                
							if($survay_review_all[$k]['improved_survay'] != '') {
								$sort_by_data = $sort_by_data . '<li>
									<div class="accorTitle">
										<i class="fa fa-plus-circle" aria-hidden="true"></i>
										<i class="fa fa-minus-circle" aria-hidden="true"></i>
										<h3>What, if anything, could be improved?</h3>
									</div>
									<div class="accorConte">
										'.$survay_review_all[$k]['improved_survay'].'
									</div>
								</li>';
							}
							if($survay_review_all[$k]['nearby_location_survay'] != '') {
								$sort_by_data = $sort_by_data . '<li>
									<div class="accorTitle">
										<i class="fa fa-plus-circle" aria-hidden="true"></i>
										<i class="fa fa-minus-circle" aria-hidden="true"></i>
										<h3>Tell us about the location and things to do nearby</h3>
									</div>
									<div class="accorConte">
										'.$survay_review_all[$k]['nearby_location_survay'].'
									</div>
								</li>';
							}
                            $sort_by_data = $sort_by_data . '</ul>';
							
							}
							
							$sort_by_data = $sort_by_data . '<div class="review-photo">'.$image_trip;
                                
							if($survay_review_all[$k]['review_admin_comment'] != '')
							{
								$sort_by_data = $sort_by_data . '
								<div class="management-response">
									<p>'.$survay_review_all[$k]['review_admin_comment'].'</p>
									<p>Replied on '. date("j M Y",$survay_review_all[$k]['review_comment_time']).'</p>
								</div>';
							
							}
							
							if($survay_review_all[$k]['recommend_rating'] == 'Yes'){ 
                            $sort_by_data = $sort_by_data . '<br />
                            <span class="recommendedContainerYes"><span>Yes</span>, I recommend this hotel.</span>';
                            }
                            
                            if($survay_review_all[$k]['get_most_review_survay'] != ''){
                            $sort_by_data = $sort_by_data . '<span class="tagsPrefix">I recommend this hotel for:</span>
                            <span class="tagsBox"><span class="tag">'.$survay_review_all[$k]['get_most_review_survay'].'</span></span>';
                            } 
							
                           $sort_by_data = $sort_by_data . ' </div>
                        </div>
                    </div>
                </div>
				</div>';			
	  }
	  
	  echo json_encode(array('update_status' => $sort_by_data, 'update_value' => count($survay_review_all)));
	  
	  exit();
 }

?>