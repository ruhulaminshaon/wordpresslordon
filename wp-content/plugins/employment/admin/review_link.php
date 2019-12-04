<?php

/*
	Function Name : Creat Review Link
*/

function review_info(){
	
		
	
	  ?>
      		
            <form id="hur-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=review-link" enctype="multipart/form-data">
      		 
              <table border="2" class="wp-list-table widefat fixed striped comments">
                  <tr>
                    <td width="160"><strong>Hotel Booking Id : </strong></td>
                    <td width="340" colspan="3"><input type="text" name="bokking_id" value="" required="required" /></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="3">
                    <input name="review_link_submit" type="submit" value="Submit" class="backBtn" >
                  </tr>
                </table>
                
               </form>
      
      
      <?php		  
		  
	  } 

?>