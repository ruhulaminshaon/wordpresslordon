<?php

/*
	Function Name : Show Survay Information
*/


function survay_info(){
	
	  global $wpdb;
	  $tbl = $wpdb->prefix . "survay_table";
	  
	  if($_REQUEST['veiw_type']=='details')
	  { /// Start Of Suvay Detail Page
		  
		  if(isset($_REQUEST['replay_comment_submitted']))
		  {
			  if($_REQUEST['review_admin_comment'] != '')
			  {
				 $sql = "UPDATE ".$tbl." SET review_admin_comment = '".$_REQUEST['review_admin_comment']."', review_comment_time = '".$_REQUEST['review_comment_time']."' WHERE survay_id = '" .$_REQUEST['survay_id']."'";
				 $result_comment = $wpdb->get_results($sql, ARRAY_A);
				  
				  if(empty($result_comment))
				  {
					  $massage = "Thanks.... Successfully Submit You Reply.";
				  }
			  }
		  }
		  
		  
		  
		  $sql = "SELECT * FROM ". $tbl." WHERE survay_id = '".$_REQUEST['survay_id']."'";
		  $survay_details = $wpdb->get_results($sql, ARRAY_A);
		  
		  
		  $uploads = wp_upload_dir();
		  $trip_photo = '';
		  
		  if($survay_details[0]['trip_photo_survay'] != '')		  
		  	$trip_photo = explode('///', rtrim($survay_details[0]['trip_photo_survay'],"///"));
	  ?>
      		<h1><strong style="color:#093;"><?php if(isset($massage) && $massage != '') echo $massage; ?></strong></h1><br />
            <h1><strong>Review Detail</strong></h1><br />
      		
            <table border="2" class="wp-list-table widefat fixed striped comments">
                  <tr>
                    <td width="230"><strong><?php echo date("F d, Y",$survay_details[0]['survay_date']); ?></strong></td>
                    <td colspan="3" align="right"><a class="backBtn" href="<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey">Back</a></td>
                  </tr>
                  <tr>
                    <td><strong>Name</strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['first_name'] ." ". $survay_details[0]['last_initial'] ; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Location : </strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['location_your']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Status : </strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['approved_status']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Overall Rating : </strong></td>
                    <td colspan="3"><div class="reviewRating"><span style="width:<?php echo review_rating($survay_details[0]['overall_rating']); ?>%">&nbsp;</span></div></td>
                  </tr>
                  <tr>
                    <td><strong>Cleanliness : </td>
                    <td colspan="3"><div class="reviewRating"><span style="width:<?php echo review_rating($survay_details[0]['room_cleanliness_rating']); ?>%">&nbsp;</span></div></td>
                  </tr>
                  <tr>
                    <td><strong>Service : </strong></td>
                    <td colspan="3"><div class="reviewRating"><span style="width:<?php echo review_rating($survay_details[0]['hotel_service_rating']); ?>%">&nbsp;</span></div></td>
                  </tr>
                  <tr>
                    <td><strong>Comfort : </strong></td>
                    <td colspan="3"><div class="reviewRating"><span style="width:<?php echo review_rating($survay_details[0]['room_comfort_rating']); ?>%">&nbsp;</span></div></td>
                  </tr>
                  <tr>
                    <td><strong>Location : </strong></td>
                    <td colspan="3"><div class="reviewRating"><span style="width:<?php echo review_rating($survay_details[0]['hotel_location_rating']); ?>%">&nbsp;</span></div></td>
                  </tr>
                  <tr>
                    <td><strong>Shared Facilities : </strong></td>
                    <td colspan="3"><div class="reviewRating"><span style="width:<?php echo review_rating($survay_details[0]['hotel_facilities_rating']); ?>%">&nbsp;</span></div></td>
                  </tr>
                  <tr>
                    <td><strong>Recommend this hotel to a friend : </strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['recommend_rating'] ;?></td>
                  </tr>
                  <tr>
                    <td><strong>Title of review : </strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['title_of_your_survay'] ;?></td>
                  </tr>
                  <tr>
                    <td><strong>About experience : </strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['your_experience_survay'] ;?></td>
                  </tr>
                  <?php if($survay_details[0]['like_about_hotel_survay'] != ''){ ?>
                      <tr>
                        <td><strong>What did you like about this hotel?  </strong></td>
                        <td colspan="3"><?php echo $survay_details[0]['like_about_hotel_survay'] ;?></td>
                      </tr>
                  <?php }?>
                  <?php if($survay_details[0]['improved_survay'] != ''){ ?>
                      <tr>
                        <td><strong>What, if anything, could be improved? </strong></td>
                        <td colspan="3"><?php echo $survay_details[0]['improved_survay'] ;?></td>
                      </tr>
                  <?php }?>
                  <?php if($survay_details[0]['nearby_location_survay'] != ''){ ?>
                      <tr>
                        <td><strong>Tell us about the location and things to do nearby : </strong></td>
                        <td colspan="3"><?php echo $survay_details[0]['nearby_location_survay'] ;?></td>
                      </tr>
                  <?php }?>
                  <tr>
                    <td><strong>Who might get the most out of your review? </strong></td>
                    <td colspan="3"><?php echo $survay_details[0]['get_most_review_survay'] ;?></td>
                  </tr>
                  <tr>
                    <td><strong>Share your trip photos : </strong></td>
                    <?php 
						if($trip_photo != '')
						{
							 for($i=0; $i<count($trip_photo); $i++) { ?>
								<td width="120"><img src="<?php echo $uploads['baseurl'] . '/trip_image/' .$trip_photo[$i]; ?>" width="110" height="110" /></td>
						
						        <?php 
								if($i==2)
								{								
								?>
                                </tr>
                                <tr>
                    			<td>
                                </td>
						<?php 
								 }
							}
						}
					 ?>
                  </tr>
                </table>
                
                <form id="hur-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey" enctype="multipart/form-data">
                
                <h1><strong>Reply Review</strong></h1><br />
                <table border="2" class="wp-list-table widefat fixed striped comments">
                  <tr>
                    <td width="120"><strong>Place your Reply here...</strong></td>
                    <td width="340">
                    <textarea style="width:80%;" name="review_admin_comment" placeholder="Place Here Your Reply"><?php if($survay_details[0]['review_admin_comment']!='') echo $survay_details[0]['review_admin_comment']; ?></textarea>
                    </td>
                  </tr>
                  <tr>
                    <td>
                    	<?php echo date("F d, Y",$survay_details[0]['review_comment_time']); ?>
                        <input name="review_comment_time" value="<?php echo time(); ?>" type="hidden">
                        <input name="survay_id" value="<?php echo $_REQUEST['survay_id']; ?>" type="hidden">
                        <input name="veiw_type" value="<?php echo $_REQUEST['veiw_type']; ?>" type="hidden">
                    </td>
                    <td><input name="replay_comment_submitted" type="submit" value="Submit" class="backBtn" ></td>
                  </tr>
                </table>

      
      
      <?php		  
		  
	  } /// End Of Suvay Detail Page
	  
	  else
	  { /// Start Of Suvay List Page
		  
		  	  if($_GET['update_status'])
			  {
				  $sql = "UPDATE ".$tbl." SET approved_status = '".$_GET['update_status']."' WHERE survay_id = '" .$_GET['survay_id']."'";
				  $wpdb->get_results($sql);	
			  }
	
			 
			 $sql = "SELECT count(*) as total_servay FROM ". $tbl;
			 $all_survay = $wpdb->get_results($sql, ARRAY_A);
			
			 $sql = "SELECT count(*) as approve FROM ". $tbl." WHERE approved_status = 'approved'";
			 $approve_survay = $wpdb->get_results($sql, ARRAY_A);
			 
			 if($_GET['survay_status'] == 'pending' || $_GET['survay_status'] == 'approved')
			 {
				 $sql = "SELECT * FROM ". $tbl." WHERE approved_status = '".$_GET['survay_status']."' ORDER BY survay_id ASC ";
				 $show_survay = $wpdb->get_results($sql, ARRAY_A);
			 }
			 else
			 {
				 $sql = "SELECT * FROM ". $tbl." ORDER BY survay_id ASC ";
				 $show_survay = $wpdb->get_results($sql, ARRAY_A);
				 $_GET['survay_status'] = 'all';
			 }
			 
		?>
		
            <div class="wrap">
            <h1><strong>Review list</strong></h1><br />
            
            <ul class='subsubsub'>
                <li class='all'>
                    <a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey&survay_status=all' <?Php if($_GET['survay_status'] == 'all') { ?>class="current"<?php } ?>>All <span class="count">(<span class="all-count"><?php echo $all_survay[0]['total_servay'] ?></span>)</span></a> |
                 </li>
                <li class='moderated'>
                    <a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey&survay_status=pending' <?Php if($_GET['survay_status'] == 'pending') { ?>class="current"<?php } ?>>Pending <span class="count">(<span class="pending-count"><?php echo ($all_survay[0]['total_servay'] - $approve_survay[0]['approve']) ?></span>)</span></a> |
                </li>
                <li class='approved'>
                    <a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey&survay_status=approved' <?Php if($_GET['survay_status'] == 'approved') { ?>class="current"<?php } ?>>Approved <span class="count">(<span class="approved-count"><?php echo $approve_survay[0]['approve'] ?></span>)</span></a>
                </li>	
            </ul>
            
            
            
            <table class="wp-list-table widefat fixed striped comments">
                <thead>
                  <tr>
                        <th width="150" scope="col"><strong>Client Name</strong></th>
                        <th width="90" scope="col"><strong>Overall Rating</strong></th>
                        <th width="90" scope="col"><strong>Review Status</strong></th>
                        <th width="200" scope="col"><strong>Submitted Date</strong></th>	
                        <th width="60" scope="col"><strong>Detail</strong></th>
                  </tr>
                </thead>
                
                <?php
                    if(!empty($show_survay))
                    { 
                ?>
                      <tbody id="the-comment-list">
                      <?php
                            for($i=0; $i<count($show_survay); $i++)
                            {
                      ?>
                              <tr id='comment-1'>
                                  <td><?php echo $show_survay[$i]['first_name']; echo $all_survay[$i]['last_initial']; ?></td>
                                  <td><?php echo $show_survay[$i]['overall_rating']; ?></td>
                                  <td>
                                    <?php if($show_survay[$i]['approved_status'] == 'approved') { ?>
                                            <a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey&survay_id=<?php echo $show_survay[$i]['survay_id'] ?>&update_status=pending&survay_status=<?php echo $_GET['survay_status'] ?> '>Approved</a>
                                    <?php } else { ?>
                                        <a href='<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey&survay_id=<?php echo $show_survay[$i]['survay_id'] ?>&update_status=approved&survay_status=<?php echo $_GET['survay_status'] ?>'>Pending</a>
                                     
                                     <?php } ?>
                                   </td>
                                  <td><?php echo date("F d, Y",$show_survay[$i]['survay_date']) ; ?></td>
                                  <td><a class="backBtn" href='<?php echo $_SERVER['PHP_SELF']; ?>?page=hotelsurvey&veiw_type=details&survay_id=<?php echo $show_survay[$i]['survay_id'] ?> '>Detail</a></td>
                               </tr>
                      <?php } ?>
                      </tbody>
                                
                <?php
                    }
                    else
                    {
                 ?>
                        <tbody>
                            <tr class="no-items">
                                <td class="colspanchange" colspan="5">No Review found.</td>
                            </tr>	
                        </tbody>
                 <?php
                    }
                 ?>
            </table>
            </div>
		
		
		<?php
		} /// End Of Suvay List Page
	

}


?>