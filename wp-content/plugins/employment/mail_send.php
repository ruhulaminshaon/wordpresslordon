<?php
include '../../../wp-load.php';
function mail_send()
{
	
	global $wpdb;
	$tbl1 = $wpdb->prefix . "gdlr_hotel_booking";
	$tbl2 = $wpdb->prefix . "gdlr_hotel_payment";
	$tbl3 = $wpdb->prefix . "survay_mail_check";
	
	$sql = "SELECT * FROM ".$tbl1." INNER JOIN ".$tbl2." ON ".$tbl1.".payment_id = ".$tbl2.".id LEFT JOIN ".$tbl3." ON ".$tbl1.".id = ".$tbl3.".booking_id WHERE ".$tbl3.".mail_status IS NULL";
	$check_out_check = $wpdb->get_results($sql, ARRAY_A);
	
	$mail_content = get_option('mail_tamplate_content');
	
	$image_path = plugins_URLPATH."admin/images/";
	
	
	for($i=0; $i<count($check_out_check); $i++)
	{
	    
	   		$check_out_time = strtotime($check_out_check[$i]['end_date']);
    		$start_date_time = strtotime($check_out_check[$i]['start_date']);
    		$booking_time = strtotime($check_out_check[$i]['booking_date']);
    		
    		//if($check_out_time < time() && (time() - 86400) <= $check_out_time)
    		if($check_out_time < time() )
    		{
    	        $string = 'palmbeachgreathotelsurvayformlink///'.$check_out_check[$i]['id'].'$$$';
    			$encoded = base64_encode($string);
    			$location = get_bloginfo('url').'/survey-form/?review_id='.$encoded;
    			
    			$contact_client_info = unserialize($check_out_check[$i]['contact_info']);
    			
    			$headers = "From: Palm Beach Singer Island Resort & Spa Luxury Suites <info@palmbeachluxurysuites.com>". "\r\n";
    			$headers .= "Content-type: text/html";
    			
    			$to = $contact_client_info['email'];
    			//$to = 'chartanalystposition@gmail.com';
    			//$to = 'shattique@gmail.com';
    			//$to = 'robyn.ramus@561WebsiteDesign.com';
    			$subject = "Review your recent stay at Palm Beach Singer Island Resort & Spa Luxury Suites";
    			$message = '
    				<!DOCTYPE html>
    <html>
    
    <head>
    <meta charset="utf-8">
    <title>::Newsletter::</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
    body{
    	margin:0;
    	font-family:helvetica,arial,sans-serif;
    	line-height:23px;
    	font-size:12px;
    	color:#888;
    }
    table a{color:#bc9b4c}
    table a:hover{text-decoration:none;color:#00F}
    img{max-width:100%;height:auto !important}
    @media screen and (max-width: 639px){
    table,td{
    width:100% !important;
    box-sizing:border-box;
    display:block;
    }
    #footer td{text-align:center !important}
    }  
    </style>
    </head>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
            <tbody>
                <tr>
                    <td align="center" valign="middle" bgcolor="#E4E4E4">
                        <table width="640" cellpadding="0" cellspacing="0" border="0">
                            <tbody>
                                <tr>
                                    <td id="header" width="640" align="center" bgcolor="#000">
                                    	<img id="logo" src="' . $image_path .'logo.jpeg" border="0" align="top" style="width:300px;margin:30px auto;display:block">
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="640" bgcolor="#fff">
                                        <table width="640" cellpadding="0" cellspacing="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="padding:20px 15px 10px" align="center" valign="top" bgcolor="#fafafa">
                                                    	<span style="font-size:18px;color:#222">Please Submit A Review!  It\'s Quick And Easy!<br /><br />
    												 Hi ' . $contact_client_info['first_name'] ." " .$contact_client_info['last_name'] . ',<br /><br />
    												 Please take a minute to answer three quick questions about your recent stay at Palm Beach Singer Island Resort &amp; Spa Luxury Suites:<br /><br />
    												 Your feedback helps other travelers. Your photos do too - be sure to include them with your review! </span>
                                                    </td>
                                                </tr>
                                               <tr>
                                               <tr>
                                                    <td style="padding:0 15px" align="center" valign="middle" bgcolor="#fafafa">
                                                        <table style="border:1px solid #ccc" width="100%" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:30px 15px 0;border-top:5px solid #ffdd00" bgcolor="#fff" align="center">
                                                                        <a style="color:#0088c2;font-size:22px;font-weight:bold;line-height:25px;text-decoration:none" href="'.$location.'" target="_blank">Rate your overall experience</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:23px 0 30px;font-size:47px;color:#dcdcdc" bgcolor="#fff" align="center">
                                                                        <table width="300" height="55" cellspacing="0" cellpadding="0" border="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding-right:6px;padding-left:6px" width="305" height="55">
                                                                                    	<a href="'.$location.'" target="_blank">
                                                                                        	<img src="' . $image_path .'star.png" alt="Rate Your Stay" width="320" height="53">
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:0 0 30px;font-weight:bold;font-size:14px;" bgcolor="#fff" align="center">
                                                                    	<a style="width:300px;margin:auto;background:#00A877;color:#fff;line-height:50px;display:block;text-decoration:none" href="'.$location.'" target="_blank">Leave your feedback</a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding:0 15px 20px;line-height:25px;font-size:14px;color:#484848" bgcolor="#f5f5f5">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" style="border-top:1px solid #e7e7e7">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td style="padding:20px 0 0" align="center">
                                                                                        <img src="' . $image_path .'calendar.png" alt="Calendar" width="15" height="15">
                                                                                        <span>&nbsp;&nbsp; <b>Your booking on</b> <span>'. date("l j M, Y",$start_date_time) . ' - '. date("l j M, Y",$check_out_time) . '</span><br><br>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-weight:bold" align="center"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:30px 15px" align="center" valign="top" bgcolor="#fafafa">
                                                    	'.apply_filters('the_content',$mail_content).'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding:30px 15px" align="center" valign="top" bgcolor="#f5f5f5">
                                                    	<span><b>Important Notice</b><br><br></span>
                                                        <span>If you have had a specific problem which needs to be addressed, please contact <a href="http://www.561websitedesign.com/palmbeachsingerislandresortandspa/contact-page/" target="_blank">PALM BEACH SINGER ISLAND RESORT &amp; SPA LUXURY SUITES </a> directly.<br><br>It is our policy not to distribute any information for any reason that users have not specifically made public.</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
    
                                <tr>
                                    <td width="640" style="padding:20px 15px;border-top:2px solid #ffdd00" bgcolor="#fff">
                                        <table id="footer" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                	<td align="left" width="100">
                                                    	<img src="' . $image_path .'logo.jpeg" alt="Logo" width="100">
                                                    </td>
                                                    <td style="color:#484848;font-weight:bold;" align="right">PALM BEACH SINGER ISLAND RESORT &amp; SPA LUXURY SUITES <br> <a href="https://www.google.com/maps/place/3800+N+Ocean+Dr,+Singer+Island,+FL+33404,+USA/@26.792435,-80.0351237,17z/data=!3m1!4b1!4m5!3m4!1s0x88d8d4eb643b72a9:0xaed4d3b2fc147510!8m2!3d26.792435!4d-80.032935" target="_blank">3800 North Ocean Drive Singer Island, Florida 33404</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
    </html>
    			';
    			
    			
    			$mail_sent = mail( $to, $subject, $message , $headers );
    	
            	if($mail_sent) {
            	    $sql = "INSERT INTO  ".$tbl3." (`booking_id`, `mail_status`) VALUES ('" .$check_out_check[$i]['id']."','Success')";
				    $survay_mail_status = $wpdb->query($sql);
            		echo $message = "Mail Send Sucessfully!";
            	}
            	else {
            		echo $message = "Mail Cannot Send";
            	}
    			
    			
    		}//// Close If


	}//// Close For
	

}

mail_send();

?>