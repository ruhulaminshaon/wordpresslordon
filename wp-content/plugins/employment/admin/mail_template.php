<?php

/*
	Function Name : Creat Mail Tamplate
*/

if(isset($_REQUEST['mail_content_submit']))
{
	
	if ( get_option( 'mail_tamplate_content' ) !== false ) 
	{
		update_option( 'mail_tamplate_content', $_REQUEST['custome_mail_content'] );
	} 
	else 
	{
		$deprecated = null;
		$autoload = 'no';
		add_option( 'mail_tamplate_content', $_REQUEST['custome_mail_content'] , $deprecated, $autoload );
	}
}

$mail_content = '';

function mail_info(){
	
		
	
	  ?>
      		
            <h1><strong>Mail Content</strong></h1><br />
            
            <form id="hur-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=mail-template" enctype="multipart/form-data">
      		 
              <table border="2" class="wp-list-table widefat fixed striped comments">
                  <tr>
                    <td width="90%"><strong>Write Here Your Mail Content : </strong></td>
                  </tr>
                  <tr>
                    <td><?php 
					if(get_option('mail_tamplate_content') != '') 
						$mail_content = get_option('mail_tamplate_content');
					wp_editor($mail_content,'custome_mail_content');
					 ?></td>
                  </tr>
                  <tr>
                    <td>
                    <input name="mail_content_submit" type="submit" value="Submit" class="backBtn" >
                  </tr>
                </table>
                
               </form>
      
      
      <?php		  
		  
	  } 

?>