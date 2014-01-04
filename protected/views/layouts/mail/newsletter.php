<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
      
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      
       <title>Newsletter</title>
		
	<style type="text/css">
		#outlook a{
			padding:0;
		}
        #newsletterBody a {

            color: #222;
        }
		body{
			width:100% !important;
            color: #222;
            background-color: #dddddd;
		}
	
		body{
			-webkit-text-size-adjust:none;
		}
		body{
			margin:0;
			padding:0;
		}
		img{
			border:0;
			height:auto;
			line-height:100%;
			outline:none;
			text-decoration:none;
			display:inline;
			margin:0;
			padding:0;
		}
      	table td{
			border-collapse:collapse;
			font-family:Helvetica, Arial;
			font-weight:300;
		}
		#bgTable{
			height:100% !important;
			margin:0;
			padding:0;
			width:100% !important;
		}
		body,#bgTable{
			background-color:#dddddd;			
			background-repeat:repeat-x;
			background-position:left top;
		}
		#NContainer{
			
			margin:0;
			padding:0;			
		}		
		
</style>       
</head>
    
    <body leftmargin="0" topmargin="0" offset="0" style="-webkit-text-size-adjust: none;margin: 0;padding: 0;background-color: #dddddd; width: 100% !important;" marginheight="0" marginwidth="0">
    	<center>
        	<table id="bgTable" style="margin: 0;padding: 0;background-color:#dddddd; height: 100% !important;width: 100% !important;" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            	<tbody><tr>
                	<td style="border-collapse: collapse; font-family: Helvetica, Arial;font-weight: 300;" align="center" valign="top">
                       
                        <table id="NContainer" style="margin: 0;padding: 0; background-color: #ffffff; " border="0" cellpadding="0" cellspacing="0" width="650">
                        	<tbody>
                                <tr>
                            	<td style=" border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;" align="center" valign="top">
                                	<!-- // Begin Static Header \\ -->
                                	<table id="staticHeader" style="background-color:#dddddd;margin: 0;padding: 0;" border="0" cellpadding="0" cellspacing="0" width="650">
                                        <tbody>
                                          <?php /* ?>
                                            <tr><td><center style="color: #222;display: block;font-family: Helvetica, Arial, sans-serif; font-size: 12px;font-weight: normal;line-height: 130%; margin-top: 10px;margin-right: 0; margin-bottom: 0; margin-left: 0;text-align: center;">Ne vidite celotnega sporočila? <a style="color: #222; font-family: Helvetica, Arial, sans-serif; font-size: 12px;font-weight: normal;line-height: 130%; margin-top: 10px;margin-right: 0; margin-bottom: 0; margin-left: 0;" href="#"> Kliknite tukaj</a></center></td></tr>
                                             <tr height="10"><td><!-- divider --></td></tr>
                                             <?php */ ?>
                                        <tr>
                                        	<td bgcolor="#ffffff" style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;">
                                            	<table style="border-bottom: 3px solid #ddd;" id="logoLinks" border="0" cellpadding="0" cellspacing="0" width="650">
                                                	<tbody>
                                                        <tr>
                                                            <td align="left" valign="top"  bgcolor="#f1f69d" style="background-color:#FFF; padding:20px;">
                                                            <a href="http://www.cofinder.eu/" style="text-decoration: none;">
                                                            <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/mail-logo.png" alt="cofinder" title="cofinder" style="border: 0;height: auto;line-height: 100%;outline: none;text-decoration: none;display: inline;margin: 0;padding: 0; float:left; margin-top:10px;" border="0" height="38" width="40"></img>
                                                            <div style="color:#9a9a9a; font-weight: bold; text-decoration: none; font-size: 38px;  font-family:Sans,Helvetica,Arial,sans-serif; margin-top:9px;">co<span style="color:#89b561">finder</span>
                                                            </div>
                                                            </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        	<tr>
                            <td>
                             <!-- // Content \\ -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="650">
                                                    <tbody>
                                                                                                    
                                                        <tr height="10"> 
                                                             <td><!-- divider -->
                                                               
                                                             </td>
                                                       </tr>
                                                    

                                                      <!-- single Article -->    
                                                        <tr>
                                                        <td style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;" valign="top">
                                                            <table mc:repeatable="repeat_2" class="subContentContainer" mc:repeatindex="0" border="0" cellpadding="0" cellspacing="0" width="650">
                                                                <tbody>                                                                  
                                                                <tr>

                                                                    <td>
                                                                        <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/newsletter/divider.png" style="border: 0; height: 10px; width:15px; outline: none; text-decoration: none;display: inline;margin: 0;padding: 0;" height="10px" width="15">
                                                                    </td>
                                                                    
                                                                  
                                                                    <td style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300; font-size: 14px;" valign="top" width="100%">
                                                                   
                                                                        <!-- content goes here: -->
                                                                         
                                                                        <?php echo $content; ?>


                                                                    </td>
                                                                     <td>
                                                                        <img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/newsletter/divider.png" style="border: 0; height: 10px; width:15px; outline: none; text-decoration: none;display: inline;margin: 0;padding: 0;" height="10px" width="15">
                                                                    </td>

                                                                </tr>
                                                                                                                              
                                                            </tbody></table     


                                                        </td>
                                                    </tr> <!-- end single-Article -->
                                                       <tr height="20"> 
                                                             <td><!-- divider -->
                                                               
                                                             </td>
                                                       </tr>
                                                          <!-- single Article -->                                                          



                                                       <tr height="20"> 
                                                             <td><!-- divider --></td>
                                                       </tr>
                                                </tbody>


                                            </table><!-- end Content -->  
                            </td>
                          </tr>
                        	<tr>
                            	<td  style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;" align="center" valign="top">
                                    <!-- // Begin Wrap Footer \\ -->
                                	<table id="newsletterFooter" style="background-color: transparent;" border="0" cellpadding="10" cellspacing="0" width="650">
                                    	<tbody>
                                            <tr>
                                        	<td  bgcolor="#333333" class="footerContent" style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;padding: 10px 0;" valign="top">
                                            
                                                <!-- // BeginFooter \\ -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:10px 0;">
                                                    <tbody>
                                                        <tr>
                                                         <td>
                                                           
                                                         </td>
                                                        </tr>   
                                                        <tr>
                                                        	<td colspan="2" style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/newsletter/divider.png" style="border: 0;height: 10px; line-height: 100%;outline: none;text-decoration: none;display: inline;margin: 0;padding: 0;" height="10" width="100%"></td>

                                                    	
                                                        <td style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;">
                                                        	<div style="color: #89B561;font-family: Helvetica, Arial;font-size: 14px;line-height: 100%;text-align: right;">
                                                            	 <p style="margin-top: 3px; margin-bottom: 0;  font-family: Helvetica, Arial;font-size: 14px;line-height: 130%;text-align: left;">This email was sent from <a style="color: #ffffff; text-decoration: none;" href="http://www.cofiner.eu">www.cofinder.eu</a>  </p>
   														    </div>
                                                        </td>
                                                        <td>
																<p style="text-align:right;" >
										                          <a href="https://www.facebook.com/cofinder.eu"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/bottom-facebook.png"></a>
										                          <a href="https://www.linkedin.com/company/cofinder"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/bottom-linkedin.png"></a> 
										                          <a href="https://plus.google.com/+CofinderEu/posts"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/bottom-gplus.png"></a> 
										                        </p>
                                                        </td>
                                                        <td colspan="2" style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;"><img src="<?php echo Yii::app()->getBaseUrl(true); ?>/images/newsletter/divider.png" style="border: 0;height: 10px; line-height: 100%;outline: none;text-decoration: none;display: inline;margin: 0;padding: 0;" height="10" width="100%"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                                <!-- // End  Footer \\ -->
                                            
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // End newsletter Footer \\ -->
                                </td>
                            </tr>
                            <tr>
                            	<td  style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;" align="center" valign="top">
                                    <!-- // Begin Wrap after Footer \\ -->
                                	<table id="newsletterFooter" style="background-color: transparent;" border="0" cellpadding="10" cellspacing="0" width="650">
                                    	<tbody>
                                            <tr>
                                        	<td  bgcolor="#ddd" class="footerContent" style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;padding: 0px 0;" valign="top">
                                            
                                                <!-- // Begin after Footer \\ -->
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px 0;">
                                                    <tbody>
                                                        <tr>
                                                         <td>
                                                           
                                                         </td>
                                                        </tr>   
                                                        <tr>
                                                    	
                                                        <td style="border-collapse: collapse;font-family: Helvetica, Arial;font-weight: 300;">
                                                        	<div style="color: #89B561;font-family: Helvetica, Arial;font-size: 14px;line-height: 100%;text-align: right;">
                                                            	
                                                            <center>                                                            
                                                                <p class="links">
																		<a style="color: #333; text-decoration: none;" href="http://www.cofinder.eu/site/terms">Terms</a> |
																		<a style="color: #333; text-decoration: none;" href="http://www.cofinder.eu/site/terms#privacy">Privacy</a>
															              <?php if (isset($email) || isset($activkey)){ ?> |
															              <a style="color: #333; text-decoration: none;" href="<?php echo absoluteURL(); ?>/site/unbsucribeFromNews?<?php if (isset($email)) echo "email=".$email; else echo "id=".$activkey; ?>">Unsubscribe</a>
															              <?php } ?>
																</p>                                                                   
                                                        	</center>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                                <!-- // End after  Footer \\ -->
                                            
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <!-- // End newsletter after Footer \\ -->
                                </td>
                            </tr>
                        </tbody></table>
                        <br>
                    </td>
                </tr>
            </tbody></table>
        </center>
        

</body></html>